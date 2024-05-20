<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $data['currency'] = Currency::orderBy('id', 'desc')->get();
        return view('admin.currency',$data);
    }

    public function addCurrencyView()
    {
        return view('admin.addcurrency');
    }

    public function addCurrency(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'symbol' => 'required',
        ], [
            'name.required' => 'The currency name field is required.',
            'code.required' => 'The currency code required.',
            'symbol.required' => 'The currency symbol required.',
        ]);

        $currency = new Currency;
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->symbol = $request->symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status ?? 'false';
        $currency->order_number = $request->order_number;
        $currency->save();
        return redirect()->back()->with('success', 'Currency added successfully');

    }

    public function editCurrency($id)
    {
        $data['currencydata'] = Currency::find($id);
        return view('admin.editcurrency',$data);
    }

    public function postEditCurrency(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'code' => 'required',
            'symbol' => 'required',
        ], [
            'id.required' => 'The currency id field is required.',
            'name.required' => 'The currency name field is required.',
            'code.required' => 'The currency code required.',
            'symbol.required' => 'The currency symbol required.',
        ]);
        $currency = Currency::find($request->id);
        $currency->name = $request->name;
        $currency->code = $request->code;
        $currency->symbol = $request->symbol;
        $currency->exchange_rate = $request->exchange_rate;
        $currency->status = $request->status ?? 'false';
        $currency->order_number = $request->order_number;
        $currency->save();
        return redirect()->back()->with('success', 'Currency updated successfully');
    }

    public function deleteCurrency($id)
    {
        if ($id) {
            $currency = Currency::find($id);
            $currency->delete();
            $output['res'] = 'success';
            $output['msg'] = 'Data Deleted';
        } else {
            $output['res'] = 'error';
            $output['msg'] = 'Currency Id Required';
        }
        echo json_encode($output);
    }

}
