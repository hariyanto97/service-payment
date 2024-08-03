<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'food_id' => 'required|integer',
            'user_id' => 'required|integer',
            'amount' => 'required|integer',
            'status' => 'required|string',
            'transaction_code' => 'required|string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $order = Order::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }
    public function index(Request $request)
    {
        $status = $request->input('status');
        $userId = $request->input('user_id');
        $ordersQuery = Order::query();
        if ($userId) {
            $ordersQuery->where('user_id', $userId);
        }
        if ($status === 'Pending') {
            $ordersQuery->where('status', $status);
        }else {
            $ordersQuery->whereIn('status', ['completed', 'canceled']);
        }
    
        $ordersQuery->orderBy('created_at', 'desc');
        $orders = $ordersQuery->get();

        foreach ($orders as $order) {
            $order->food = getFood($order->food_id);
        }

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ]);
    }
    
    public function show($id)
    {
        $order = Order::find($id);
        if(!$order){
            return response()->json([
                'status' => 'error',
                'data' => 'order not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $data = $request->all();
        if(!$order){
            return response()->json([
                'status' => 'error',
                'data' => 'order not found'
            ], 404);
        }
        $order->fill($data)->save();
        
        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

}
