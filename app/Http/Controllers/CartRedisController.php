<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartRedisController extends Controller
{

    // Add or update item in the cart
    public function addToCart(Request $request, $user_id)
    {
        $cartKey = "cart:{$user_id}";

        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        $itemId = $request->input('id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $name = $request->input('name');

        if (!$itemId || !$quantity || !$price || !$name) {
            return response()->json(['message' => 'Missing required fields'], 400);
        }

        if ($quantity <= 0) {
            if (isset($cart[$itemId])) {
                unset($cart[$itemId]);
            }
        } else {
            $cart[$itemId] = [
                'id' => $itemId,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
            ];
        }

        Redis::set($cartKey, json_encode($cart));

        return response()->json(['message' => 'Cart updated', 'cart' => $cart]);
    }

    public function getCart($user_id)
    {
        $cartKey = "cart:{$user_id}";

        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        return response()->json(['cart' => $cart]);
    }

    public function updateCart(Request $request, $user_id)
    {
        $cartKey = "cart:{$user_id}";

        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        $productId = $request->input('product_id');
        $change = $request->input('change');

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $change;

            if ($cart[$productId]['quantity'] < 1) {
                $cart[$productId]['quantity'] = 1;
            }
        }

        Redis::set($cartKey, json_encode($cart));

        return response()->json([
            'message' => 'Cart updated successfully',
            'cart' => $cart
        ]);
    }

    // Remove item from cart
    public function removeFromCart(Request $request, $user_id)
    {
        $cartKey = "cart:{$user_id}";

        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        $itemId = $request->input('productId');

        if (!isset($cart[$itemId])) {
            return response()->json(['message' => 'Item not found in cart'], 404);
        }

        unset($cart[$itemId]);

        Redis::set($cartKey, json_encode($cart));

        return response()->json(['message' => 'Item removed from cart', 'cart' => $cart]);
    }
}
