<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\OrderModel;
use App\Models\TransactionModel;
use Validator;

class CheckOutController extends Controller
{
    private function generateOrderID($length = 5)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'ORDER_' . date('YmdHis') . '_' . $randomString;
    }
    //first make payment then create order
    public function checkout(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'order_data' => 'required',
        ];
        $messages = [
            'user_id.required' => 'User id is required.',
            'order_data.required' => 'Order data is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $output['res'] = 'error';
            $output['msg'] = $errors;
            return response()->json($output, 401);
        } else {
            $is_valid = json_decode($request->order_data);
            if(empty(get_object_vars($is_valid)))
            {
                $output['res'] = 'error';
                $output['msg'] = 'Order Data is empty please add some order first.';
                 return response()->json($output, 401);
            }
            $order = new OrderModel();
            $order->order_id = $this->generateOrderID();
            $order->user_id = $request->user_id;
            $order->method = "CARD PAYMENT";
            $order->address = $request->address;
            $order->status = 'PROCESSING';
            if ($order->save()) {
                $orderItme = new OrderItem();
                $order_data = json_decode($request->order_data);
                $total_amount = 0;
                $stat = 'true';
                foreach ($order_data as $item) {
                    ## fetch data from cart and add into cart item db
                    $cart_data =  Cart::find($item);
                    $all_amount = $cart_data['ring_price'] + $cart_data['diamond_price'] + $cart_data['gemstone_price'];
                    $order_data1 = json_encode($cart_data);
                    $orderIremArr = [
                        'order_id' => $order->order_id,
                        'order_data' => $order_data1,
                        'total_amount' => $all_amount,
                        'status' => 'true',
                    ];
                    //  $saveOrder = OrderItem::create($orderIremArr);
                    $response = $this->saveOrderItem($orderIremArr);
                    if ($response != 'true') {
                        $stat = 'false';
                    }
                    $total_amount += $all_amount;
                }
                if ($stat == 'true') {
                    $update_price = OrderModel::find($order->id);
                    $update_price->amount = $total_amount;
                    $update_price->save();
                    ## make transaction after order
                    $order_data = [
                        'transaction_id' => uniqid() . date('YmdHis'),
                        'user_id' => $request->user_id,
                        'order_id' => $order->order_id,
                        'amount' => $total_amount,
                        'paymanet_method' => "CARD PAYMENT",
                        ## its order status gateway will return order data and status
                        'status' => 'SUCCESS',
                    ];
                    $transaction = $this->callPaymentGateway($order_data);
                    if ($transaction == 'true') {
                        $update_status = OrderModel::find($order->id);
                        $update_status->status = 'SUCCESS';
                        $update_status->save();
                    }
                }
            }

            $output['res'] = 'success';
            $output['msg'] = 'order successfully created.';
            $output['data'] = OrderModel::latest()->first();;
            return response()->json($output, 200);
        }
    }

    ## make Transaction
    public function callPaymentGateway($orderData)
    {
        $transaction = TransactionModel::create($orderData);
        if ($transaction) {
            return 'true';
        }
    }

    ## Save OrderItem in orderItem table 
    private function saveOrderItem($orderIremArr)
    {
        $saveOrder = OrderItem::create($orderIremArr);
        if ($saveOrder) {
            return 'true';
        }
    }
}
