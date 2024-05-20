<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use App\Models\ProductPrecentageDiscount;
	use Illuminate\Support\Facades\Validator;
	class ProductPriceDiscount extends Controller
	{
		public function index()
		{
			$data['obj'] = ProductPrecentageDiscount::first();
			$data['title'] = 'Price discount';
			$data['backtrack'] = 'Price discount';
			$data['url_action'] = route('price.discount.update');
			return view('admin.price_discount',$data);
		}
		
		public function update(Request $request)
		{
			$this->validate($request, [
            'amount' => 'required',
			], [
            'amount.required' => 'The discount amount required'
			]);
			$obj = ProductPrecentageDiscount::find(1);
			if($obj)
			{
		        $obj->amount = $request->amount;
				$obj->save();
				return redirect()->back()->with('success', 'Data update successfully');
			}
		}
	}
