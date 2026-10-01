```php
<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $message = trim($request->message);

        /*
        |--------------------------------------------------------------------------
        | STEP 1 — GEMINI PROMPT
        |--------------------------------------------------------------------------
        */

        $prompt = <<<PROMPT
You are MarketLink AI Assistant.

MarketLink is a farmer marketplace website.

The customer can:

1. Open pages
2. Search products
3. Add products to cart
4. View cart

Understand:
- English
- Urdu
- Roman Urdu

IMPORTANT:
For page opening commands, return ONLY the command.

Allowed page commands:

OPEN_MARKETS
OPEN_PRODUCTS
OPEN_CART
OPEN_CHECKOUT
OPEN_ORDERS

Examples:

"market kholo"
"markets dikhao"
"market page open karo"

=> OPEN_MARKETS

"products kholo"
"products page open karo"

=> OPEN_PRODUCTS

"cart kholo"
"mera cart dikhao"

=> OPEN_CART

"checkout kholo"
"checkout page kholo"

=> OPEN_CHECKOUT

"orders dikhao"
"meri orders dikhao"

=> OPEN_ORDERS


IMPORTANT FOR PRODUCT SEARCH:

If the user wants to search for a product, return:

SEARCH_PRODUCT|product name

Examples:

"tomato search karo"

=> SEARCH_PRODUCT|tomato

"mujhe potato chahiye"

=> SEARCH_PRODUCT|potato


IMPORTANT FOR ADDING TO CART:

If the user wants to add a product to cart, return:

ADD_TO_CART|quantity|product name

Examples:

"2 kg tomato cart mein add karo"

=> ADD_TO_CART|2|tomato

"3 tomato cart mein dalo"

=> ADD_TO_CART|3|tomato

"1 kg potato add karo"

=> ADD_TO_CART|1|potato

If quantity is not mentioned, use:

ADD_TO_CART|1|product name


IMPORTANT:

Do NOT add explanations when returning commands.

For normal questions, answer normally.

User message:
$message
PROMPT;

        try {

            /*
            |--------------------------------------------------------------------------
            | GEMINI API KEY
            |--------------------------------------------------------------------------
            */

            $apiKey = config('services.gemini.key');

            if (!$apiKey) {

                Log::error('MarketLink AI: Gemini API key missing.');

                return response()->json([
                    'success' => false,
                    'message' => 'Gemini API key configure nahi hai.',
                ], 500);
            }


            /*
            |--------------------------------------------------------------------------
            | GEMINI URL
            |--------------------------------------------------------------------------
            */

            $url =
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent';


            /*
            |--------------------------------------------------------------------------
            | GEMINI REQUEST
            |
            | IMPORTANT:
            | 429 ko retry nahi karna.
            | Quota exceeded hone par retry karne se koi faida nahi.
            |--------------------------------------------------------------------------
            */

            $response = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)
                ->retry(
                    2,
                    1000,
                    function ($exception, $request) {

                        /*
                        |----------------------------------------------------------
                        | Sirf temporary server/network errors retry honge.
                        | 429 quota error retry nahi hoga.
                        |----------------------------------------------------------
                        */

                        if ($exception instanceof \Illuminate\Http\Client\RequestException) {

                            $status = $exception->response
                                ? $exception->response->status()
                                : null;

                            return in_array($status, [
                                502,
                                503,
                                504,
                            ]);
                        }

                        return true;
                    }
                )
                ->post($url, [

                    'contents' => [

                        [
                            'parts' => [

                                [
                                    'text' => $prompt
                                ]

                            ]
                        ]

                    ]

                ]);


            /*
            |--------------------------------------------------------------------------
            | GEMINI API ERROR
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                $status = $response->status();

                Log::error('Gemini API Error', [
                    'status' => $status,
                    'body' => $response->body(),
                ]);


                /*
                |--------------------------------------------------------------
                | 429 — QUOTA EXCEEDED
                |--------------------------------------------------------------
                */

                if ($status === 429) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'AI ki API quota/limit khatam ho gayi hai. Gemini API billing ya quota check karo, phir dobara try karo.',
                    ], 429);
                }


                /*
                |--------------------------------------------------------------
                | 503 — SERVER BUSY
                |--------------------------------------------------------------
                */

                if ($status === 503) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'AI server abhi busy hai. Thori der baad dobara try karo.',
                    ], 503);
                }


                /*
                |--------------------------------------------------------------
                | 502 / 504
                |--------------------------------------------------------------
                */

                if ($status === 502 || $status === 504) {

                    return response()->json([
                        'success' => false,
                        'message' =>
                            'AI server temporarily unavailable hai. Dobara try karo.',
                    ], $status);
                }


                /*
                |--------------------------------------------------------------
                | OTHER API ERRORS
                |--------------------------------------------------------------
                */

                return response()->json([
                    'success' => false,
                    'message' =>
                        'AI service se response nahi aa raha.',
                ], 500);
            }


            /*
            |--------------------------------------------------------------------------
            | GET GEMINI RESPONSE
            |--------------------------------------------------------------------------
            */

            $data = $response->json();

            $aiText =
                $data['candidates'][0]['content']['parts'][0]['text']
                ?? null;


            if (!$aiText) {

                Log::error('Gemini Empty Response', [
                    'response' => $data
                ]);

                return response()->json([
                    'success' => false,
                    'message' =>
                        'AI ne empty response diya.',
                ], 500);
            }


            $aiText = trim($aiText);


            /*
            |--------------------------------------------------------------------------
            | STEP 2 — PAGE COMMANDS
            |--------------------------------------------------------------------------
            */

            $command = strtoupper($aiText);


            if (str_contains($command, 'OPEN_MARKETS')) {

                return response()->json([
                    'success' => true,
                    'message' => 'OPEN_MARKETS',
                ]);
            }


            if (str_contains($command, 'OPEN_PRODUCTS')) {

                return response()->json([
                    'success' => true,
                    'message' => 'OPEN_PRODUCTS',
                ]);
            }


            if (str_contains($command, 'OPEN_CART')) {

                return response()->json([
                    'success' => true,
                    'message' => 'OPEN_CART',
                ]);
            }


            if (str_contains($command, 'OPEN_CHECKOUT')) {

                return response()->json([
                    'success' => true,
                    'message' => 'OPEN_CHECKOUT',
                ]);
            }


            if (str_contains($command, 'OPEN_ORDERS')) {

                return response()->json([
                    'success' => true,
                    'message' => 'OPEN_ORDERS',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 3 — SEARCH PRODUCT
            |--------------------------------------------------------------------------
            */

            if (
                str_starts_with(
                    strtoupper($aiText),
                    'SEARCH_PRODUCT|'
                )
            ) {

                $parts = explode('|', $aiText, 2);

                $productName = trim($parts[1] ?? '');


                if ($productName === '') {

                    return response()->json([
                        'success' => true,
                        'message' =>
                            'Kaunsa product search karna hai?',
                    ]);
                }


                $products = Product::with('user.farmer')
                    ->where('status', 'available')
                    ->whereHas(
                        'user.farmer',
                        function ($query) {

                            $query->where(
                                'status',
                                'active'
                            );
                        }
                    )
                    ->where(
                        'name',
                        'LIKE',
                        '%' . $productName . '%'
                    )
                    ->get();


                if ($products->isEmpty()) {

                    return response()->json([
                        'success' => true,
                        'message' =>
                            "Sorry, {$productName} available nahi mila.",
                    ]);
                }


                $messageText =
                    "Ye products available hain:\n\n";


                foreach ($products as $product) {

                    $messageText .=
                        "• {$product->name} — Rs. {$product->price} / {$product->unit}\n";
                }


                return response()->json([
                    'success' => true,
                    'message' => $messageText,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 4 — ADD PRODUCT TO CART
            |--------------------------------------------------------------------------
            */

            if (
                str_starts_with(
                    strtoupper($aiText),
                    'ADD_TO_CART|'
                )
            ) {

                $parts = explode('|', $aiText);

                $quantity =
                    (int) ($parts[1] ?? 1);

                $productName =
                    trim($parts[2] ?? '');


                /*
                |--------------------------------------------------------------
                | INVALID QUANTITY
                |--------------------------------------------------------------
                */

                if ($quantity <= 0) {
                    $quantity = 1;
                }


                if ($productName === '') {

                    return response()->json([
                        'success' => true,
                        'message' =>
                            'Kaunsa product cart mein add karna hai?',
                    ]);
                }


                /*
                |--------------------------------------------------------------
                | FIND PRODUCT
                |--------------------------------------------------------------
                */

                $product = Product::with('user.farmer')
                    ->where('status', 'available')
                    ->whereHas(
                        'user.farmer',
                        function ($query) {

                            $query->where(
                                'status',
                                'active'
                            );
                        }
                    )
                    ->where(
                        'name',
                        'LIKE',
                        '%' . $productName . '%'
                    )
                    ->first();


                /*
                |--------------------------------------------------------------
                | PRODUCT NOT FOUND
                |--------------------------------------------------------------
                */

                if (!$product) {

                    return response()->json([
                        'success' => true,
                        'message' =>
                            "Sorry, {$productName} available nahi mila.",
                    ]);
                }


                /*
                |--------------------------------------------------------------
                | STOCK CHECK
                |--------------------------------------------------------------
                */

                $cart = session()->get(
                    'cart',
                    []
                );


                $currentQuantity =
                    isset($cart[$product->id])
                    ? (int) $cart[$product->id]['quantity']
                    : 0;


                $newQuantity =
                    $currentQuantity + $quantity;


                if (
                    $newQuantity >
                    $product->stock_quantity
                ) {

                    return response()->json([
                        'success' => true,
                        'message' =>
                            "Sirf {$product->stock_quantity} {$product->unit} {$product->name} available hain.",
                    ]);
                }


                /*
                |--------------------------------------------------------------
                | ADD / UPDATE CART
                |--------------------------------------------------------------
                */

                if (
                    isset($cart[$product->id])
                ) {

                    $cart[$product->id]['quantity'] =
                        $newQuantity;

                } else {

                    $cart[$product->id] = [

                        'id' =>
                            $product->id,

                        'name' =>
                            $product->name,

                        'quantity' =>
                            $quantity,

                        'price' =>
                            $product->price,

                        'unit' =>
                            $product->unit,

                        'image' =>
                            $product->image,
                    ];
                }


                /*
                |--------------------------------------------------------------
                | SAVE CART
                |--------------------------------------------------------------
                */

                session()->put(
                    'cart',
                    $cart
                );

                session()->save();


                /*
                |--------------------------------------------------------------
                | CART COUNT
                |--------------------------------------------------------------
                */

                $cartCount = 0;


                foreach ($cart as $item) {

                    $cartCount +=
                        (int) (
                            $item['quantity']
                            ?? 0
                        );
                }


                /*
                |--------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------
                */

                return response()->json([

                    'success' => true,

                    'message' =>
                        "{$quantity} {$product->unit} {$product->name} cart mein add kar diya. 🛒",

                    'action' =>
                        'OPEN_CART',

                    'cartCount' =>
                        $cartCount,

                    'product' => [

                        'id' =>
                            $product->id,

                        'name' =>
                            $product->name,

                        'quantity' =>
                            $newQuantity,

                        'price' =>
                            $product->price,

                        'unit' =>
                            $product->unit,
                    ],

                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | STEP 5 — NORMAL AI RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'message' => $aiText,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | UNEXPECTED EXCEPTION
        |--------------------------------------------------------------------------
        */

        catch (\Throwable $e) {

            Log::error(
                'MarketLink AI Exception',
                [
                    'message' =>
                        $e->getMessage(),

                    'file' =>
                        $e->getFile(),

                    'line' =>
                        $e->getLine(),
                ]
            );


            return response()->json([
                'success' => false,
                'message' =>
                    'AI assistant mein error aa gaya. Thori der baad try karo.',
            ], 500);
        }
    }
}

