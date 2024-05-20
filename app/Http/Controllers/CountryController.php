<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Http\Request;
	use App\Models\Country;
	
	class CountryController extends Controller
	{
		public function index()
		{
			$data = [
			'title'=>'Country list',
			'viewurl' =>route('admin.countryadd'),
			'editurl'=>'admin.editcountry',
			'list'=> Country::orderBy('id','desc')->get(),
			];
			return view('admin.countryList',$data);	
		}
		
		public function create()
		{
			$data = [
		    'title'=>'Add New Country',
			'backtrack'=> 'admin.country',
			'url_action' => route('admin.addcountry'),
			"obj"=>'',
			];
			return view('admin.country',$data);	
		}
		
		public function postCreate(Request $request)
		{
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The name field is required.',
			]);
			
			$country = new Country;
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $country->generateUniqueSlug($uniqueslug);
			$country->name = $request->name;
			$country->slug = $slug;
			$country->order_number = $request->order_number;
			$country->status = $request->status??'false';
			$country->save();
			return redirect()->back()->with('success', 'Country added successfully');
		}
		
		public function editCustomer($id)
		{
			$editdata = Country::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatecountry',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.country',
			'title'=>'Edit Country',
			'obj'=>$editdata,
			];
			return view('admin.country',$data);
		}
		
		public function postEdit(Request $request,$id)
		{
			$obj = Country::find($id);
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The name field is required.',
			]);
			$slug = empty($request->slug)?$obj->slug: $obj->generateUniqueSlug($request->slug);
			$obj->name = $request->name;
			$obj->slug = $slug;
			$obj->order_number = $request->order_number;
			$obj->status = $request->status??'false';
			$obj->save();
			return redirect()->back()->with('success', 'Customer updated successfully');
		}
		
		public function deleteCountry($id)
		{
			if ($id) {
				$country = Country::find($id);
				$country->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Country Id Required';
			}
			echo json_encode($output);
		}
		
		
	}
