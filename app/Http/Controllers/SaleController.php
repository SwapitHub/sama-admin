<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function report()
    {
        return view('admin.report');
    }

    public function transactions()
    {
        return view('admin.transactions');
    }

    public function invoices()
    {
        return view('admin.invoices');
    }

    public function orders()
    {
        return view('admin.orders');
    }
	public function ordersDetail()
	{
	   return view('admin.order-detail');
	}

    public function shipments()
    {
        return view('admin.shipments');
    }
}
