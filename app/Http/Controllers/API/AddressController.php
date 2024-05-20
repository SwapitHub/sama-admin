<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\AddresModel;
	use Validator;
	
	class AddressController extends Controller
	{
		public function index(Request $request)
		{
			$rules = [
            'user_id' => 'required',
            'address_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address_line1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => 'required',
            'country' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
			];
			$messages = [
            'user_id.required' => 'User id is required.',
            'address_type.required' => 'Address type id is required.',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'address_line1.required' => 'Address line 1 is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'zipcode.required' => 'Zip code is required',
            'country.required' => 'Country  is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
			];
			$validator = Validator::make($request->all(), $rules, $messages);
			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				$output['res'] = 'error';
				$output['msg'] = $errors;
				return response()->json($output, 401);
			}
            $matchData = [
                'user_id'=>$request->user_id,
                'address_type'=>$request->address_type
            ];
			// $address = AddresModel::create($request->all());
            $address = AddresModel::updateOrCreate($matchData,$request->all());
			if($address)
			{
				$output['res'] = 'success';
				$output['msg'] = 'Address Saved.';
				$output['data'] = AddresModel::latest()->first();
				return response()->json($output, 200);
			}
			
		}

        public function getUserAddress(Request $request)
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
			}
            $address = AddresModel::where('user_id',$request->user_id)->get();
			if($address)
			{
				$output['res'] = 'success';
				$output['msg'] = 'Address Saved.';
				$output['data'] = $address;
				return response()->json($output, 200);
			}
        }
	}
