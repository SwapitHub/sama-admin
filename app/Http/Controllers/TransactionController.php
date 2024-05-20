<?php

namespace App\Http\Controllers;
use App\Models\TransactionModel;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $data['transactions'] = TransactionModel::orderBy('id','desc')->paginate(20);
        return view('admin.transactions', $data);

    }
}
