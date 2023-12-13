<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'status' => 'required|string',
            'raw_response' => 'required|string',
            'order_id' => 'required|integer',
            'payment_type' => 'required|string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $order = Payment::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }
}
