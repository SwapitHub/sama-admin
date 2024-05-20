<?php
	namespace App\Http\Controllers\API;
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Validator;
	use Auth;
	use App\Models\User;
	use App\Models\Cart;
	
	class RegisterController extends BaseController
	{
		public function registerUser(Request $request)
		{
			$validator = Validator::make($request->all(), [
			'first_name' => 'required',
			'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
			]);
			if($validator->fails())
			{
				$output['res'] = 'error';  
				$output['msg'] = $validator->errors();	
				$output['data'] =[];
				return response()->json($output, 400);	
			}
			$input = $request->all();
			$input['password'] = bcrypt($input['password']);
			$user = User::create($input);
			$output['res'] = 'success';  
			$output['msg'] = 'User register successfully.';
			$output['data'] = ['user_id'=>$user->id,'user_name'=>$user->first_name,'user_email'=>$user->email];
			return response()->json($output, 200);	
		}
		
		public function login(Request $request)
		{
			if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
				$user = Auth::user(); 
				if($user->status !='false')
				{
			        //  fetch cart data and send with output data 
					$output['res'] = 'success';  
					$output['msg'] = 'User login successfully.';
					$output['data'] = ['user_id'=>$user->id,'user_name'=>$user->first_name,'user_email'=>$user->email,'cart_item'=>Cart::where('user_id',$user->id)->where('status','true')->count()];
					return response()->json($output, 200);
				}
				else
				{
					$output['res'] = 'error';  
					$output['msg'] = 'Unauthorised User';
					$output['data'] = [];  
					return response()->json($output,401);	
				}
			} 
			else
			{  
				$output['res'] = 'error';  
				$output['msg'] = 'Unauthorised';
				$output['data'] = []; 
				return response()->json($output,401);	
			} 
		}
	}
