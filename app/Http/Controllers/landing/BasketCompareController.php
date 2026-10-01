<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Farmer;
use App\Models\Market;
use Illuminate\Http\Request;

class BasketCompareController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Compare Shopping Page
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('compare-shopping', compact('categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Get Products By Category
    |--------------------------------------------------------------------------
    */
    public function productsByCategory(Request $request)
    {
        $request->validate([
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],
        ]);

        $products = Product::where('category_id', $request->category_id)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'price',
                'unit',
                'stock_quantity',
                'image',
            ]);

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Compare Complete Basket Across Markets
    |--------------------------------------------------------------------------
    */
    public function compare(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id'
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],
        ]);

        $items = collect($request->items);

        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate products
        |--------------------------------------------------------------------------
        */
        $productIds = $items
            ->pluck('product_id')
            ->unique();

        if ($productIds->count() !== $items->count()) {
            return response()->json([
                'success' => false,
                'message' => 'A product cannot be added more than once.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Selected Products
        |--------------------------------------------------------------------------
        */
        $selectedProducts = Product::whereIn('id', $productIds)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->get()
            ->keyBy('id');


        if ($selectedProducts->count() !== $items->count()) {
            return response()->json([
                'success' => false,
                'message' => 'Some selected products are no longer available.'
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Validate Stock
        |--------------------------------------------------------------------------
        */
        foreach ($items as $item) {

            $product = $selectedProducts->get($item['product_id']);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], 422);
            }

            if ($item['quantity'] > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => $product->name .
                        ' only has ' .
                        $product->stock_quantity .
                        ' ' .
                        $product->unit .
                        ' available.'
                ], 422);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Get All Markets
        |--------------------------------------------------------------------------
        */
        $markets = Market::orderBy('name')->get();

        $results = collect();


        foreach ($markets as $market) {

            $marketTotal = 0;

            $marketItems = [];

            $allAvailable = true;


            /*
            |--------------------------------------------------------------------------
            | Farmers of this market
            |--------------------------------------------------------------------------
            */
            $farmerUserIds = Farmer::where(
                'market_id',
                $market->id
            )->pluck('user_id');


            if ($farmerUserIds->isEmpty()) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Check every selected product
            |--------------------------------------------------------------------------
            */
            foreach ($items as $item) {

                $selectedProduct =
                    $selectedProducts->get(
                        $item['product_id']
                    );


                $productName =
                    strtolower(
                        trim($selectedProduct->name)
                    );


                $unit =
                    strtolower(
                        trim($selectedProduct->unit)
                    );


                /*
                |--------------------------------------------------------------------------
                | Find same product inside this market
                |--------------------------------------------------------------------------
                */
                $marketProduct = Product::whereIn(
                    'user_id',
                    $farmerUserIds
                )
                    ->whereRaw(
                        'LOWER(TRIM(name)) = ?',
                        [$productName]
                    )
                    ->whereRaw(
                        'LOWER(TRIM(unit)) = ?',
                        [$unit]
                    )
                    ->where('status', 'available')
                    ->where('stock_quantity', '>', 0)
                    ->orderBy('price', 'asc')
                    ->first();


                /*
                |--------------------------------------------------------------------------
                | Product doesn't exist in this market
                |--------------------------------------------------------------------------
                */
                if (!$marketProduct) {

                    $allAvailable = false;

                    break;
                }


                $quantity =
                    (int) $item['quantity'];


                /*
                |--------------------------------------------------------------------------
                | Stock check
                |--------------------------------------------------------------------------
                */
                if (
                    $marketProduct->stock_quantity
                    < $quantity
                ) {

                    $allAvailable = false;

                    break;
                }


                /*
                |--------------------------------------------------------------------------
                | Calculate subtotal
                |--------------------------------------------------------------------------
                */
                $subtotal =
                    (float) $marketProduct->price
                    * $quantity;


                $marketTotal += $subtotal;


                $marketItems[] = [

                    'product_id' =>
                    $marketProduct->id,

                    'name' =>
                    $marketProduct->name,

                    'quantity' =>
                    $quantity,

                    'price' =>
                    (float) $marketProduct->price,

                    'unit' =>
                    $marketProduct->unit,

                    'subtotal' =>
                    $subtotal,

                    'image' =>
                    $marketProduct->image,

                    'stock' =>
                    $marketProduct->stock_quantity,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | Only complete markets
            |--------------------------------------------------------------------------
            */
            if ($allAvailable) {

                $results->push([

                    'market_id' =>
                    $market->id,

                    'market_name' =>
                    $market->name,

                    'market_location' =>
                    $market->location,

                    'market_days' =>
                    $market->days,

                    'market_timing' =>
                    $market->timing,

                    'total' =>
                    round($marketTotal, 2),

                    'items' =>
                    $marketItems,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Cheapest first
        |--------------------------------------------------------------------------
        */
        $results = $results
            ->sortBy('total')
            ->values();


        if ($results->isEmpty()) {

            return response()->json([

                'success' => false,

                'message' =>
                'No market has all your selected products available together.'

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Cheapest price
        |--------------------------------------------------------------------------
        */
        $cheapest =
            $results->first()['total'];


        /*
        |--------------------------------------------------------------------------
        | Calculate savings
        |--------------------------------------------------------------------------
        */
        $results = $results->map(
            function ($market) use ($cheapest) {

                $market['saving'] = max(
                    0,
                    round(
                        $market['total'] - $cheapest,
                        2
                    )
                );

                return $market;
            }
        );


        return response()->json([

            'success' => true,

            'markets' => $results,

            'cheapest' => $cheapest,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Select Market And Add Basket To Cart
    |--------------------------------------------------------------------------
    */
    public function selectMarket(Request $request)
    {
        $request->validate([

            'market_id' => [
                'required',
                'integer',
                'exists:markets,id'
            ],

            'items' => [
                'required',
                'array',
                'min:1'
            ],

            'items.*.product_id' => [
                'required',
                'integer',
                'exists:products,id'
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],

        ]);


        $market =
            Market::findOrFail(
                $request->market_id
            );


        $items =
            collect($request->items);


        $cart =
            session()->get(
                'cart',
                []
            );


        /*
        |--------------------------------------------------------------------------
        | Farmers
        |--------------------------------------------------------------------------
        */
        $farmerUserIds =
            Farmer::where(
                'market_id',
                $market->id
            )->pluck('user_id');


        foreach ($items as $item) {

            $selectedProduct =
                Product::find(
                    $item['product_id']
                );


            if (!$selectedProduct) {
                continue;
            }


            $productName =
                strtolower(
                    trim(
                        $selectedProduct->name
                    )
                );


            $unit =
                strtolower(
                    trim(
                        $selectedProduct->unit
                    )
                );


            /*
            |--------------------------------------------------------------------------
            | Find product from selected market
            |--------------------------------------------------------------------------
            */
            $marketProduct =
                Product::whereIn(
                    'user_id',
                    $farmerUserIds
                )
                ->whereRaw(
                    'LOWER(TRIM(name)) = ?',
                    [$productName]
                )
                ->whereRaw(
                    'LOWER(TRIM(unit)) = ?',
                    [$unit]
                )
                ->where(
                    'status',
                    'available'
                )
                ->where(
                    'stock_quantity',
                    '>',
                    0
                )
                ->orderBy(
                    'price',
                    'asc'
                )
                ->first();


            if (!$marketProduct) {

                return response()->json([

                    'success' => false,

                    'message' =>
                    $selectedProduct->name .
                        ' is no longer available in ' .
                        $market->name,

                ], 422);
            }


            $quantity =
                (int) $item['quantity'];


            if (!$marketProduct) {

                return response()->json([

                    'success' => false,

                    'message' =>
                    $selectedProduct->name .
                        ' is no longer available in ' .
                        $market->name,

                ], 422);
            }


            $productId =
                $marketProduct->id;


            /*
            |--------------------------------------------------------------------------
            | Add to existing cart
            |--------------------------------------------------------------------------
            */
            if (
                isset(
                    $cart[$productId]
                )
            ) {

                $cart[$productId]['quantity']
                    += $quantity;
            } else {

                $cart[$productId] = [

                    'id' =>
                    $marketProduct->id,

                    'name' =>
                    $marketProduct->name,

                    'quantity' =>
                    $quantity,

                    'price' =>
                    (float)
                    $marketProduct->price,

                    'unit' =>
                    $marketProduct->unit,

                    'image' =>
                    $marketProduct->image,

                ];
            }
        }


        session()->put(
            'cart',
            $cart
        );


        return response()->json([

            'success' => true,

            'message' =>
            $market->name .
                ' selected. Your basket has been added to cart.',

            'redirect' =>
            route('cart.index'),

        ]);
    }
}
