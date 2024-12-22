<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\ValidationException;

class CreateOrderController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.price' => 'required|numeric',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $validatedData['user_id'],
                'total_price' => $validatedData['total_price'],
                'status' => 'pending',
            ]);

            foreach ($validatedData['products'] as $product) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ]);
            }

            DB::commit();

            $newOrder =
                Order::where('id', $order->id)
                ->with('orderProducts.product')
                ->get();


            $cartKey = "cart:{$validatedData['user_id']}";
            Redis::del($cartKey);

            return response()->json(['message' => 'Order created successfully', 'order' => $newOrder], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function list($user_id)
    {
        $orders = Order::where('user_id', $user_id)
            ->with('orderProducts.product')
            ->get();

        return response()->json(['orders' => $orders], 200);
    }


    public function update($order_id, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'status' => 'required|in:pending,paid,cancelled',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        $order = Order::find($order_id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $validatedData['status'];
        $order->save();

        return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
    }
    public function delete($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
