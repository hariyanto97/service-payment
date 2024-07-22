<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

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
        // Retrieve the "status" parameter from the request
        $status = $request->input('status');
        $userId = $request->input('user_id');
        // Initialize the query for the Order model
        $ordersQuery = Order::query();
        if ($userId) {
            $ordersQuery->where('user_id', $userId);
        }
        // Apply the "where" clause to filter orders by userId
        if ($status) {
            $ordersQuery->where('status', $status);
        }
    
        // Fetch the orders based on the applied filters
        $orders = $ordersQuery->get();
    
        // Return a JSON response with success status and data
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
