<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Validator;
	use App\Models\Faq;
	use App\Models\ContactUs;
	
	class FaqController extends Controller
	{
		public function index()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';
			
			$data = Faq::orderBy('id','desc')->where('status','true')->where('faq_category','!=',6)->get();
			$output['data'] = $data;
			return response()->json($output, 200);	
		}

		public function contactUs(Request $request)
		{
			$validator = Validator::make($request->all(), [
				'first_name' => 'required',
				'last_name' => 'required',
				'email' => 'required|email',
				'type' => 'required',
				'product_id' => $request->type == 'product_enquiry' ? 'required' : '',
				'product_color' => $request->type == 'product_enquiry' ? 'required' : '',
				]);
				if($validator->fails())
				{
					$output['res'] = 'error';  
					$output['msg'] = $validator->errors();	
					$output['data'] =[];
					return response()->json($output, 400);	
				}
				else
				{
                     $contact = new ContactUs;
					 $contact->type = $request->type;
					 $contact->product_id = $request->product_id;
					 $contact->product_color = $request->product_color;
					 $contact->first_name = $request->first_name;
					 $contact->last_name = $request->last_name;
					 $contact->email = $request->email;
					 $contact->phone = $request->phone;
					 $contact->message = $request->message;
					 $contact->send_updates = $request->send_updates??'false';
					 $contact->status = 'true';
					 $contact->save();
					 $output['res'] = 'success';  
					 $output['msg'] = 'You message have been submitted';	
					 $output['data'] =[];
					 return response()->json($output, 200);
				}
		}
	}
