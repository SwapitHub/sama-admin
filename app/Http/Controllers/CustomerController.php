<?php

	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Http\Request;
	use App\Models\User;
	use App\Models\ContactUs;
	use App\Models\AddresModel;
	use App\Models\OrderModel;
	use App\Models\TransactionModel;
	use Illuminate\Validation\Rule;
	class CustomerController extends Controller
	{
		//
		public function index()
		{
			$data = [
			'title'=>'Customer list',
			'viewurl' =>route('admin.customeradd'),
			'editurl'=>'admin.editcustomer',
			'list'=> User::orderBy('id','desc')->paginate(10),
			];
			return view('admin.customerList',$data);
		}

		public function create()
		{
			$data = [
		    'title'=>'Add New Customer',
			'backtrack'=> 'admin.customer',
			'url_action' => route('admin.addcustomer'),
			"obj"=>'',
			];
			return view('admin.customer',$data);
		}

		public function postCreate(Request $request)
		{
			$this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric',
            'address' => 'required|min:5|max:255',
            'password' => 'required|min:5',
			], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'email.required' => 'The email field is required.',
			'email.email' => 'Please provide a valid email address.',
            'phone.required' => 'The phone no file is required.',
            'address.required' => 'The address field is required.',
            'password.required' => 'The password field is required.',
			'password.min' => 'The password must be at least :min characters.',
			]);

			$user = new User;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->email = $request->email;
			$user->phone = $request->phone;
			$user->address = $request->address;
			$user->password = Hash::make($request->password);;
			$user->status = $request->status??'false';
			$user->save();
			echo "OK";
			// return redirect()->back()->with('success', 'Customer added successfully');
		}

		public function viewCustomer($id)
		{
			$viewdata = User::find($id);
			if($viewdata == null)
			{
				return 'no data';
			}
			// get saved address
			$address = AddresModel::where('user_id',$id)->get();
			$orders = OrderModel::orderBy('id','desc')->where('user_id',$id)->get();
			$transactions = TransactionModel::orderBy('id','desc')->where('user_id',$id)->get();
			$data = [
			'url_action'=> route('admin.updatecustomer',['id'=>$viewdata['id']]),
			'backtrack'=> 'admin.customer',
			'backtrack'=> 'admin.customer',
			'title'=>'View Customer',
			'editurl'=>'admin.editcustomer',
			'address'=>$address,
			'orders'=>$orders,
			'transactions'=>$transactions,
			'obj'=>$viewdata,
			];
			return view('admin.customer-view',$data);
		}

		public function editCustomer($id)
		{
			$editdata = User::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatecustomer',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.customer',
			'title'=>'Edit Customer',
			'obj'=>$editdata,
			];
			return view('admin.customer',$data);
		}

		public function postEdit(Request $request,$id)
		{
			$obj = User::find($id);
			$this->validate($request, [
			'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
			],
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|min:5|max:255',
			], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
		'email.email' => 'Please provide a valid email address.',
		'email.unique' => 'This email address is already in use.',
		'phone.required' => 'The phone no file is required.',
		'address.required' => 'The address field is required.',
		]);

		$obj->first_name = $request->first_name;
		$obj->last_name = $request->last_name;
		$obj->email = $request->email;
		$obj->phone = $request->phone;
		$obj->address = $request->address;
		$obj->password = empty($request->password)? $obj->password : Hash::make($request->password);
		$obj->status = $request->status??'false';
		$obj->save();
		return redirect()->back()->with('success', 'Customer updated successfully');
		}

		public function deleteCustomer($id)
		{
		if ($id) {
		$user = User::find($id);
		$user->delete();
		$output['res'] = 'success';
		$output['msg'] = 'Data Deleted';
		} else {
		$output['res'] = 'error';
		$output['msg'] = 'User Id Required';
		}
		echo json_encode($output);
		}
		// customes contact messages and enquire

		public function contact()
		{
		$data = [
		'title'=>"Customer's Message list",
		'viewurl' =>'',
		'editurl'=>'admin.editcustomer',
		'list'=> ContactUs::orderBy('id','desc')->where('type','general')->paginate(10),
		];
		return view('admin.contact_list',$data);
		}
		public function deleteCustomerMsg($id)
		{
		if ($id) {
		$user = ContactUs::find($id);
		$user->delete();
		$output['res'] = 'success';
		$output['msg'] = 'Data Deleted';
		} else {
		$output['res'] = 'error';
		$output['msg'] = 'User Id Required';
		}
		echo json_encode($output);
		}

		}
