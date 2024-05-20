<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderModel;
use App\Models\OrderItem;
use App\Models\TransactionModel;
use App\Models\AddresModel;
use App\Models\ProductModel;
use Validator;

class OrdersController extends Controller
{

    // order history
    public function index(Request $request)
    {
        $rules = [
            'user_id' => 'required',
        ];
        $messages = [
            'user_id.required' => 'User id is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $output['res'] = 'error';
            $output['msg'] = $errors;
            return response()->json($output, 401);
        } else {
            $user_id = $request->user_id;
            $orders = OrderModel::orderBy('id','desc')->where('user_id', $user_id)->paginate(5);
            $output['res'] = 'success';
            $output['msg'] = 'Orders are ..';
            $output['data'] = $orders;
            $output['total_page'] =  $orders->lastPage();;
            return response()->json($output, 200);
        }
    }

    public function historyDetail(Request $request)
    {
        $rules = [
            'order_id' => 'required',
        ];
        $messages = [
            'order_id.required' => 'Order id is required.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $output['res'] = 'error';
            $output['msg'] = $errors;
            return response()->json($output, 401);
        } else {

            if(!OrderModel::where('order_id',$request->order_id)->first())
            {
                $output['res'] = 'error';
                $output['msg'] = 'Invalid OrderId';
                $output['data'] = [];
                return response()->json($output, 401);
            }
            

            $collection_arr = [];
            $orders = OrderItem::where('order_id', $request->order_id)->get();
            foreach ($orders as $order) 
            {
                $order_data = json_decode($order->order_data);
                // fetch ring details for order
                if(!empty($order_data->ring_id))
                {
                    $ring_details_arr = [];
                    $ring_data = ProductModel::find($order_data->ring_id);
                    $ring_details_arr['ring_name'] = $ring_data['name'];
                    $ring_details_arr['ring_style'] = $ring_data['sku'];
                    $ring_details_arr['ring_size'] = $order_data->ring_size;
                    $ring_details_arr['ring_price'] = $order_data->ring_price;
                    // get product Image
                    $ring_details_arr['ring_image'] = getProductImages($order_data->ring_id,$order_data->ring_color);

                    $order->ring_detail = json_encode($ring_details_arr);
                }else{
                    $order->ring_detail = null;
                }
                // fetch diamond details for order
                if(!empty($order_data->diamond_id))
                {
                   $diamond_details_arr = [];
                   $diamond_details =  getDiamondImages($order_data->diamond_id);
                   $diamond_details_arr['diamond_image'] = $diamond_details->image_url;
                   $diamond_details_arr['stock_number']  = $order_data->diamond_id;
                   $diamond_details_arr['diamond_carat'] = $diamond_details->size.' Carat'; 
                   $diamond_details_arr['diamond_shape'] = $diamond_details->shape; 
                   $diamond_details_arr['diamond_color']  = $diamond_details->color; 
                   $diamond_details_arr['diamond_clarity'] = $diamond_details->clarity; 
                   $diamond_details_arr['diamond_cut'] = $diamond_details->cut; 
                   $diamond_details_arr['diamond_price'] = $order_data->diamond_price;
                   $order->diamond_detail = json_encode($diamond_details_arr);
                }
                else{
                    $order->diamond_detail = null;
                }
                // fetch gemstone details for order
                if(!empty($order_data->gemstone_id))
                {
                    $gemstone_details_arr = [];
                    $gemstone_details = getGemStoneImages($order_data->gemstone_id);
                    $gemstone_details_arr['gemstone_image'] = $gemstone_details->image_url;
                    $gemstone_details_arr['stock_number'] = $order_data->gemstone_id;
                    $gemstone_details_arr['gemstone_name'] = $gemstone_details->short_title;
                    $gemstone_details_arr['gemstone_price'] = $order_data->gemstone_price;

                    $order->gemstone_detail = json_encode($gemstone_details_arr);
                }
                else{
                    $order->gemstone_detail = null;
                }

                $collection_arr[] = $order;
                
            }
            $initial_order = OrderModel::where('order_id',$request->order_id)->first();
            $address_count = $initial_order->address;
            $address_ =  explode(',',$address_count);
            $addressToSend = [];
            foreach($address_ as $adr)
            {
                $adr = AddresModel::where('id',$adr)->first();
                $addressToSend[] = $adr;
            }
            $address = AddresModel::where('user_id',$initial_order->user_id)->where('address_type','both')->first();
            $order = [
                'order_id'=> $request->order_id,
                'order_status'=> $initial_order->status,
                'order_date'=> date('M d , Y',strtotime($initial_order->created_at)),
                'order_method'=>$initial_order->method,
                'total_amount'=>$initial_order->amount,
                'address'=>$addressToSend,
            ];

            $output['res'] = 'success';
            $output['msg'] = 'success';
            $output['order_details'] = $order;
            $output['data'] = $collection_arr;
            return response()->json($output, 200);

        }
    }
}
