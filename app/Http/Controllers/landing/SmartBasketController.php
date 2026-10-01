<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartBasketController extends Controller
{
    /**
     * Show Smart Basket page
     */
    public function index()
    {
        return view('smart-basket');
    }

    /**
     * Generate Smart Basket
     */
    public function generate(Request $request)
    {
        $request->validate([
            'people' => 'required|integer|min:1|max:20',
            'days' => 'required|integer|min:1|max:30',
            'budget' => 'required|numeric|min:100|max:1000000',
            'types' => 'nullable|array',
            'types.*' => 'string',
            'preference' => 'required|in:normal,cheapest,premium',
        ]);

        $people = (int) $request->people;
        $days = (int) $request->days;
        $budget = (float) $request->budget;

        $types = $request->types ?? [];
        $preference = $request->preference;

        /*
        |--------------------------------------------------------------------------
        | Get available products
        |--------------------------------------------------------------------------
        */

        $productsQuery = Product::with(['user.farmer', 'category'])
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->whereHas('user.farmer', function ($query) {
                $query->where('status', 'active');
            });

        /*
        |--------------------------------------------------------------------------
        | Filter by selected type/category
        |--------------------------------------------------------------------------
        */

        if (!empty($types)) {
            $productsQuery->whereHas('category', function ($query) use ($types) {
                $query->whereIn('name', $types);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Preference sorting
        |--------------------------------------------------------------------------
        */

        if ($preference === 'cheapest') {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($preference === 'premium') {
            $productsQuery->orderBy('price', 'desc');
        } else {
            $productsQuery->inRandomOrder();
        }

        $products = $productsQuery->get();

        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, no suitable products are available right now.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Build basket
        |--------------------------------------------------------------------------
        */

        $basket = [];
        $total = 0;

        /*
         * Number of products depends on family size and duration.
         *
         * Example:
         * 1-2 people = around 4 products
         * 3-5 people = around 5-6 products
         * 6+ people = around 6-8 products
         */

        if ($people <= 2) {
            $targetProducts = 4;
        } elseif ($people <= 5) {
            $targetProducts = 6;
        } else {
            $targetProducts = 8;
        }

        /*
         * Longer duration allows more quantity,
         * but we still keep the basket within budget.
         */
        $quantityMultiplier = max(1, ceil($days / 3));

        foreach ($products as $product) {

            if (count($basket) >= $targetProducts) {
                break;
            }

            $price = (float) $product->price;
            $stock = (int) $product->stock_quantity;

            if ($price <= 0 || $stock <= 0) {
                continue;
            }

            /*
             * Start with quantity based on people/days.
             */
            $quantity = 1;

            if ($people >= 4) {
                $quantity = 2;
            }

            if ($days >= 7) {
                $quantity++;
            }

            $quantity = min($quantity, $stock);

            $subtotal = $price * $quantity;

            /*
             * Don't exceed budget.
             */
            if (($total + $subtotal) > $budget) {

                $remaining = $budget - $total;

                if ($remaining >= $price) {
                    $quantity = min(
                        floor($remaining / $price),
                        $stock
                    );

                    if ($quantity < 1) {
                        continue;
                    }

                    $subtotal = $price * $quantity;
                } else {
                    continue;
                }
            }

            $basket[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => round($price, 2),
                'unit' => $product->unit,
                'quantity' => (int) $quantity,
                'subtotal' => round($subtotal, 2),
                'image' => $product->image,
                'stock' => $stock,
            ];

            $total += $subtotal;

            if ($total >= $budget) {
                break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | If nothing could be added
        |--------------------------------------------------------------------------
        */

        if (empty($basket)) {
            return response()->json([
                'success' => false,
                'message' => 'Your budget is too low for the currently available products. Try increasing your budget.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Save basket temporarily in session
        |--------------------------------------------------------------------------
        */

        session([
            'smart_basket' => [
                'people' => $people,
                'days' => $days,
                'budget' => $budget,
                'preference' => $preference,
                'types' => $types,
                'items' => $basket,
                'total' => round($total, 2),
                'remaining' => round(max(0, $budget - $total), 2),
            ]
        ]);

        return response()->json([
            'success' => true,
            'basket' => session('smart_basket'),
        ]);
    }

    /**
     * Update Smart Basket
     */
    public function update(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:0',
        ]);

        $smartBasket = session('smart_basket');

        if (!$smartBasket) {
            return response()->json([
                'success' => false,
                'message' => 'Smart Basket expired. Please generate it again.'
            ], 422);
        }

        $budget = (float) $smartBasket['budget'];

        $productIds = collect($request->items)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->toArray();

        $products = Product::whereIn('id', $productIds)
            ->where('status', 'available')
            ->where('stock_quantity', '>', 0)
            ->get()
            ->keyBy('id');

        $newItems = [];
        $total = 0;

        foreach ($request->items as $requestedItem) {

            $productId = (int) $requestedItem['id'];
            $quantity = (int) $requestedItem['quantity'];

            if ($quantity <= 0) {
                continue;
            }

            if (!isset($products[$productId])) {
                continue;
            }

            $product = $products[$productId];

            $quantity = min(
                $quantity,
                (int) $product->stock_quantity
            );

            $subtotal = (float) $product->price * $quantity;

            /*
             * Don't allow edited basket to exceed budget.
             */
            if (($total + $subtotal) > $budget) {

                $remaining = $budget - $total;

                if ($remaining < (float) $product->price) {
                    continue;
                }

                $quantity = min(
                    floor($remaining / (float) $product->price),
                    (int) $product->stock_quantity
                );

                if ($quantity < 1) {
                    continue;
                }

                $subtotal = (float) $product->price * $quantity;
            }

            $newItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => round((float) $product->price, 2),
                'unit' => $product->unit,
                'quantity' => $quantity,
                'subtotal' => round($subtotal, 2),
                'image' => $product->image,
                'stock' => (int) $product->stock_quantity,
            ];

            $total += $subtotal;
        }

        if (empty($newItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Basket cannot be empty.'
            ], 422);
        }

        $smartBasket['items'] = $newItems;
        $smartBasket['total'] = round($total, 2);
        $smartBasket['remaining'] = round(
            max(0, $budget - $total),
            2
        );

        session([
            'smart_basket' => $smartBasket
        ]);

        return response()->json([
            'success' => true,
            'basket' => $smartBasket,
        ]);
    }

    /**
     * Add entire Smart Basket to existing cart
     */
    public function addToCart(Request $request)
    {
        $smartBasket = session('smart_basket');

        if (!$smartBasket || empty($smartBasket['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'No Smart Basket found.'
            ], 422);
        }

        $cart = session('cart', []);

        foreach ($smartBasket['items'] as $item) {

            $product = Product::where('id', $item['id'])
                ->where('status', 'available')
                ->where('stock_quantity', '>', 0)
                ->whereHas('user.farmer', function ($query) {
                    $query->where('status', 'active');
                })
                ->first();

            if (!$product) {
                continue;
            }

            $productId = $product->id;

            $quantity = min(
                (int) $item['quantity'],
                (int) $product->stock_quantity
            );

            if ($quantity < 1) {
                continue;
            }

            /*
             * Existing cart item
             */
            if (isset($cart[$productId])) {

                $newQuantity =
                    (int) $cart[$productId]['quantity']
                    + $quantity;

                $newQuantity = min(
                    $newQuantity,
                    (int) $product->stock_quantity
                );

                $cart[$productId]['quantity'] = $newQuantity;

            } else {

                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => (float) $product->price,
                    'unit' => $product->unit,
                    'image' => $product->image,
                ];
            }
        }

        session([
            'cart' => $cart
        ]);

        /*
         * Keep basket for viewing/history in current session,
         * but mark it as added.
         */
        $smartBasket['added_to_cart'] = true;

        session([
            'smart_basket' => $smartBasket
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Smart Basket added to your cart successfully!',
            'cart_count' => collect($cart)
                ->sum(fn ($item) => (int) $item['quantity']),
            'redirect' => route('cart.index'),
        ]);
    }

    /**
     * Remove Smart Basket from session
     */
    public function clear()
    {
        session()->forget('smart_basket');

        return response()->json([
            'success' => true
        ]);
    }
}