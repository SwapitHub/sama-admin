<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItem;
use App\Models\TransactionModel;
use App\Models\InvoiceModel;
use App\Models\Cart;
use App\Models\User;
use App\Models\AddresModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function makeInvoice($order_id)
    {
        $orderData = OrderModel::where('order_id', $order_id)->first();
        if ($orderData) {
            $invoice = new InvoiceModel();
            $invoice->order_id = $orderData->order_id;
            $invoice->amount = $orderData->amount;
            $invoice->status = 'true';
            if ($invoice->save()) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }


    public function orders()
    {

        $cacheKey = 'orders_data';
        $orders = Cache::get($cacheKey);
        // Cache::forget($cacheKey);
        // exit;
        // if (!$orders) {
        $orders = DB::table('orders')
            ->orderBy('orders.id', 'desc')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.first_name', 'users.last_name', 'users.email', 'orders.*')
            ->paginate(10);
        // Cache::put($cacheKey, $orders, $minutes = 60);
        // }
        return view('admin.orders', ['orders' => $orders]);
    }


    public function ordersDetail($id)
    {
        $order_data = DB::table('orders')
            ->where('orders.id', $id)
            ->orWhere('orders.order_id', $id)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.first_name', 'users.first_name', 'users.last_name', 'users.last_name', 'users.email', 'users.email', 'orders.*')
            ->first();
        $address_ = explode(',', $order_data->address);
        $address_collection = [];
        foreach ($address_ as $address) {
            $address_collection[] = AddresModel::where('id', $address)->first();
        }
        if ($address_collection[0] == NULL) {
            $address_collection = [];
        }

        $data['address'] = $address_collection;
        $data['order'] = $order_data;
        $invoiceData = InvoiceModel::where('order_id', $order_data->order_id);
        $data['invoice_count'] = $invoiceData->count();
        $data['invoice'] = $invoiceData->first();


        return view('admin.order-detail', $data);
    }
}
