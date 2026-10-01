<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Farmer;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Show Cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('cart', compact('cart'));
    }


    /**
     * Add Product To Cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PRODUCT + ACTIVE FARMER CHECK
        |--------------------------------------------------------------------------
        */

        $product = Product::with('user.farmer')
            ->where('id', $request->product_id)
            ->where('status', 'available')
            ->whereHas('user.farmer', function ($query) {
                $query->where('status', 'active');
            })
            ->first();

        if (!$product) {

            $message =
                'Ye product ab available nahi hai ya farmer suspended hai.';

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 422);
            }

            return redirect()
                ->back()
                ->with('error', $message);
        }


        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$product->id])
            ? $cart[$product->id]['quantity']
            : 0;


        // =====================================================
        // STOCK CHECK
        // =====================================================

        if (($currentQty + 1) > $product->stock_quantity) {

            $message =
                "Stock kam hai! Sirf {$product->stock_quantity} items available hain.";

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'cartCount' => $this->getCartCount($cart),
                ], 422);
            }

            return redirect()
                ->back()
                ->with('error', $message);
        }


        // =====================================================
        // PRODUCT ALREADY IN CART
        // =====================================================

        if (isset($cart[$product->id])) {

            $cart[$product->id]['quantity']++;

        } else {

            // =================================================
            // NEW PRODUCT
            // =================================================

            $cart[$product->id] = [

                'id' => $product->id,

                'name' => $product->name,

                'quantity' => 1,

                'price' => $product->price,

                'unit' => $product->unit,

                'image' => $product->image,
            ];
        }


        // =====================================================
        // SAVE SESSION
        // =====================================================

        session()->put(
            'cart',
            $cart
        );

        session()->save();


        // =====================================================
        // CART COUNT
        // =====================================================

        $cartCount =
            $this->getCartCount($cart);


        // =====================================================
        // AJAX RESPONSE
        // =====================================================

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                    'Item successfully added to basket!',

                'cartCount' =>
                    $cartCount,
            ]);
        }


        // =====================================================
        // NORMAL RESPONSE
        // =====================================================

        return redirect()
            ->back()
            ->with(
                'success',
                'Item successfully added to basket!'
            );
    }


    /**
     * Get Total Cart Quantity
     */
    private function getCartCount($cart)
    {
        $count = 0;

        foreach ($cart as $item) {

            $count +=
                $item['quantity'] ?? 0;
        }

        return $count;
    }


    /**
     * Get Cart Total Price
     */
    private function getCartTotal($cart)
    {
        $total = 0;

        foreach ($cart as $item) {

            $price =
                $item['price'] ?? 0;

            $quantity =
                $item['quantity'] ?? 0;

            $total +=
                $price * $quantity;
        }

        return $total;
    }


    /**
     * Update Cart Quantity
     *
     * AJAX + Normal Request
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([

            'product_id' =>
                'required',

            'action' =>
                'required|in:increase,decrease',

        ]);

        $cart =
            session()->get('cart', []);

        $productId =
            $request->product_id;


        // =====================================================
        // PRODUCT NOT IN CART
        // =====================================================

        if (!isset($cart[$productId])) {

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' =>
                        'Product cart mein nahi hai.',

                ], 404);
            }

            return redirect()->back();
        }


        // =====================================================
        // FIND PRODUCT
        // =====================================================

        $product = Product::with('user.farmer')
            ->find($productId);


        // =====================================================
        // SUSPENDED FARMER / UNAVAILABLE PRODUCT CHECK
        // =====================================================

        if (
            !$product ||
            $product->status !== 'available' ||
            !$product->user ||
            !$product->user->farmer ||
            $product->user->farmer->status !== 'active'
        ) {

            unset($cart[$productId]);

            session()->put(
                'cart',
                $cart
            );

            session()->save();

            $message =
                'Ye product ab available nahi hai ya farmer suspended hai.';

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' => $message,

                    'removed' => true,

                    'quantity' => 0,

                    'item_total' => 0,

                    'cartCount' =>
                        $this->getCartCount($cart),

                    'total' =>
                        $this->getCartTotal($cart),

                ], 422);
            }

            return redirect()
                ->back()
                ->with('error', $message);
        }


        // =====================================================
        // INCREASE
        // =====================================================

        if ($request->action === 'increase') {

            if (
                $product &&
                (
                    $cart[$productId]['quantity'] + 1
                ) > $product->stock_quantity
            ) {

                $message =
                    "Stock limit reached! Maximum available: {$product->stock_quantity}";


                if ($request->expectsJson()) {

                    return response()->json([

                        'success' => false,

                        'message' => $message,

                        'quantity' =>
                            $cart[$productId]['quantity'],

                        'cartCount' =>
                            $this->getCartCount($cart),

                    ], 422);
                }


                return redirect()
                    ->back()
                    ->with(
                        'error',
                        $message
                    );
            }


            $cart[$productId]['quantity']++;
        }


        // =====================================================
        // DECREASE
        // =====================================================

        if ($request->action === 'decrease') {

            $cart[$productId]['quantity']--;


            // =================================================
            // QUANTITY 0 → REMOVE PRODUCT
            // =================================================

            if (
                $cart[$productId]['quantity'] <= 0
            ) {

                unset(
                    $cart[$productId]
                );


                session()->put(
                    'cart',
                    $cart
                );

                session()->save();


                if ($request->expectsJson()) {

                    return response()->json([

                        'success' => true,

                        'message' =>
                            'Item removed from basket.',

                        'removed' =>
                            true,

                        'quantity' =>
                            0,

                        'item_total' =>
                            0,

                        'cartCount' =>
                            $this->getCartCount($cart),

                        'total' =>
                            $this->getCartTotal($cart),

                    ]);
                }


                return redirect()->back();
            }
        }


        // =====================================================
        // SAVE SESSION
        // =====================================================

        session()->put(
            'cart',
            $cart
        );

        session()->save();


        // =====================================================
        // CURRENT QUANTITY
        // =====================================================

        $quantity =
            $cart[$productId]['quantity'];


        // =====================================================
        // PRICE
        // =====================================================

        $price =
            $cart[$productId]['price'] ?? 0;


        // =====================================================
        // ITEM TOTAL
        // =====================================================

        $itemTotal =
            $price * $quantity;


        // =====================================================
        // CART COUNT
        // =====================================================

        $cartCount =
            $this->getCartCount($cart);


        // =====================================================
        // CART TOTAL
        // =====================================================

        $total =
            $this->getCartTotal($cart);


        // =====================================================
        // AJAX RESPONSE
        // =====================================================

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                    'Cart updated successfully.',

                'removed' =>
                    false,

                'quantity' =>
                    $quantity,

                'item_total' =>
                    $itemTotal,

                'cartCount' =>
                    $cartCount,

                'total' =>
                    $total,

            ]);
        }


        // =====================================================
        // NORMAL RESPONSE
        // =====================================================

        return redirect()->back();
    }


    /**
     * Remove Product From Cart
     *
     * AJAX + Normal Request
     */
    public function removeFromCart(Request $request)
    {
        $productId =
            $request->product_id;

        $cart =
            session()->get('cart', []);


        // =====================================================
        // PRODUCT EXISTS
        // =====================================================

        if (
            $productId &&
            isset($cart[$productId])
        ) {

            unset(
                $cart[$productId]
            );


            session()->put(
                'cart',
                $cart
            );

            session()->save();
        }


        // =====================================================
        // CART COUNT
        // =====================================================

        $cartCount =
            $this->getCartCount($cart);


        // =====================================================
        // CART TOTAL
        // =====================================================

        $total =
            $this->getCartTotal($cart);


        // =====================================================
        // AJAX RESPONSE
        // =====================================================

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'message' =>
                    'Item removed successfully!',

                'removed' =>
                    true,

                'cartCount' =>
                    $cartCount,

                'total' =>
                    $total,

            ]);
        }


        // =====================================================
        // NORMAL RESPONSE
        // =====================================================

        return redirect()
            ->back()
            ->with(
                'success',
                'Item removed successfully!'
            );
    }


    /**
     * Checkout / Reservation
     *
     * Customer order ko automatically
     * us farmer ke paas bhejta hai
     * jiski product order hui hai.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Aapka basket khaali hai.'
                );
        }


        $products = [];

        foreach ($cart as $id => $details) {

            /*
            |--------------------------------------------------------------------------
            | ACTIVE FARMER + AVAILABLE PRODUCT CHECK
            |--------------------------------------------------------------------------
            */

            $product = Product::with('user.farmer')
                ->where('id', $id)
                ->where('status', 'available')
                ->whereHas('user.farmer', function ($query) {
                    $query->where('status', 'active');
                })
                ->first();


            /*
            |--------------------------------------------------------------------------
            | PRODUCT NOT AVAILABLE
            |--------------------------------------------------------------------------
            */

            if (!$product) {

                // Suspended farmer ka product cart se remove
                unset($cart[$id]);

                continue;
            }


            $products[] = [

                'id' =>
                    $product->id,

                'name' =>
                    $product->name,

                'price' =>
                    $product->price,

                'quantity' =>
                    $details['quantity'] ?? 1,

                'unit' =>
                    $product->unit,

                'image' =>
                    $product->image,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATED CART SAVE
        |--------------------------------------------------------------------------
        */

        session()->put(
            'cart',
            $cart
        );

        session()->save();


        /*
        |--------------------------------------------------------------------------
        | NO PRODUCTS LEFT
        |--------------------------------------------------------------------------
        */

        if (empty($products)) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Cart mein koi available product nahi hai.'
                );
        }


        return view(
            'checkout',
            compact('products')
        );
    }


    public function placeOrder(Request $request)
    {
        // =====================================================
        // VALIDATE CUSTOMER / PICKUP DETAILS
        // =====================================================

        $validated = $request->validate([

            'customer_name' =>
                'required|string|max:255',

            'customer_phone' =>
                'required|string|max:30',

            'customer_email' =>
                'nullable|email|max:255',

            'pickup_date' =>
                'required|date|after_or_equal:today',

            'time_slot' =>
                'required|string|max:100',

            'pickup_name' =>
                'required|string|max:255',
        ]);


        // =====================================================
        // GET CART
        // =====================================================

        $cart = session()->get('cart', []);


        if (empty($cart)) {

            return redirect()
                ->route('cart.index')
                ->with(
                    'error',
                    'Aapka basket khaali hai.'
                );
        }


        // =====================================================
        // CREATE ORDERS
        // =====================================================

        DB::transaction(function () use (
            $cart,
            $validated
        ) {

            foreach ($cart as $id => $details) {

                // =================================================
                // LOCK PRODUCT
                // =================================================

                $product = Product::with('user.farmer')
                    ->where('id', $id)
                    ->where('status', 'available')
                    ->whereHas('user.farmer', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->lockForUpdate()
                    ->first();


                if (!$product) {

                    throw new \Exception(
                        'Product available nahi hai ya farmer suspended hai.'
                    );
                }


                // =================================================
                // FIND FARMER
                //
                // products.user_id
                //        ↓
                // farmers.user_id
                // =================================================

                $farmer = Farmer::where(
                    'user_id',
                    $product->user_id
                )->first();


                if (!$farmer) {

                    throw new \Exception(
                        "{$product->name} ka farmer nahi mila."
                    );
                }


                // =================================================
                // EXTRA FARMER STATUS CHECK
                // =================================================

                if ($farmer->status !== 'active') {

                    throw new \Exception(
                        "{$product->name} ka farmer suspended hai."
                    );
                }


                // =================================================
                // QUANTITY
                // =================================================

                $quantity =
                    (int) ($details['quantity'] ?? 0);


                if ($quantity <= 0) {

                    throw new \Exception(
                        'Invalid quantity.'
                    );
                }


                // =================================================
                // STOCK CHECK
                // =================================================

                if (
                    $quantity >
                    $product->stock_quantity
                ) {

                    throw new \Exception(
                        "{$product->name} ka stock available nahi hai."
                    );
                }


                // =================================================
                // CURRENT PRICE
                // =================================================

                $price = $product->price;


                // =================================================
                // DECREASE STOCK
                // =================================================

                $product->decrement(
                    'stock_quantity',
                    $quantity
                );


                // =================================================
                // CREATE ORDER
                // =================================================

                Order::create([

                    // Logged-in ho to ID save hogi,
                    // guest ho to NULL save hoga.
                    'user_id' =>
                        auth()->id(),

                    // Product owner
                    'farmer_id' =>
                        $farmer->id,

                    // Product
                    'product_id' =>
                        $product->id,


                    // Customer details
                    'customer_name' =>
                        $validated['customer_name'],

                    'customer_phone' =>
                        $validated['customer_phone'],

                    'customer_email' =>
                        $validated['customer_email'] ?? null,

                    'pickup_date' =>
                        $validated['pickup_date'],

                    'time_slot' =>
                        $validated['time_slot'],

                    'pickup_name' =>
                        $validated['pickup_name'],


                    // Product details
                    'quantity' =>
                        $quantity,

                    'price' =>
                        $price,

                    'status' =>
                        'pending',
                ]);
            }
        });


        // =====================================================
        // CLEAR CART
        // =====================================================

        session()->forget('cart');

        session()->save();


        // =====================================================
        // SUCCESS
        // =====================================================

        return redirect()
            ->route('order.success')
            ->with(
                'success',
                'Pre-order successfully placed!'
            );
    }


    /**
     * Cancel / Reject Order
     */
    public function cancelOrRejectOrder(
        $orderId,
        Request $request
    ) {

        return DB::transaction(
            function () use (
                $orderId,
                $request
            ) {

                $order =
                    Order::findOrFail(
                        $orderId
                    );


                // =================================================
                // ALREADY CANCELLED / REJECTED
                // =================================================

                if (
                    in_array(
                        $order->status,
                        [
                            'cancelled',
                            'rejected'
                        ]
                    )
                ) {

                    return redirect()
                        ->back()
                        ->with(
                            'error',
                            'Order pehle se cancel ho chuka hai.'
                        );
                }


                // =================================================
                // NEW STATUS
                // =================================================

                $newStatus =
                    $request->input(
                        'status',
                        'cancelled'
                    );


                // =================================================
                // RESTORE STOCK
                // =================================================

                $order
                    ->product()
                    ->increment(
                        'stock_quantity',
                        $order->quantity
                    );


                // =================================================
                // UPDATE ORDER
                // =================================================

                $order->update([

                    'status' =>
                        $newStatus,

                ]);


                return redirect()
                    ->back()
                    ->with(
                        'success',
                        "Order {$newStatus} hogaya aur stock wapis restore hogaya!"
                    );
            }
        );
    }


    /**
     * Customer Orders
     */
    public function customerOrders()
    {
        $orders = Order::with([
            'product',
            'farmer',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'customer-orders',
            compact('orders')
        );
    }


    /**
     * Customer Cancel Order
     */
    public function cancelCustomerOrder($orderId)
    {
        $order = Order::where(
            'id',
            $orderId
        )
            ->where(
                'user_id',
                auth()->id()
            )
            ->firstOrFail();


        // Sirf pending order cancel ho sakta hai
        if ($order->status !== 'pending') {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Sirf pending order cancel kiya ja sakta hai.'
                );
        }


        DB::transaction(function () use ($order) {

            // Stock wapas add karo
            $order
                ->product()
                ->increment(
                    'stock_quantity',
                    $order->quantity
                );


            // Order cancel karo
            $order->update([

                'status' =>
                    'cancelled',

            ]);
        });


        return redirect()
            ->back()
            ->with(
                'success',
                'Your order has been cancelled successfully.'
            );
    }
}