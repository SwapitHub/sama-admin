<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    private function generateOrderID($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'ORDER_' . date('YmdHis') . '_' . $randomString;
    }

     //first make order and then make transaction and update order status in order
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
         if($validator->fails())
         {
             $errors = $validator->errors()->all();
             $output['res'] = 'error';
             $output['msg'] = $errors;
             return response()->json($output, 401);
         }
         else
         {
             $order = new OrderModel();
             $order->order_id = $this->generateOrderID();
             $order->user_id = $request->user_id;
             $order->statue = 'PROCESSING';
            //  var_dump($request->order_data);
             // if($order->save())
             // {
             //      $order_data =
             // }
            //  $output['res'] = 'success';
            //  $output['msg'] = 'success';
             return response()->json($this->generateOrderID(), 200);
 
         }
     }
}
