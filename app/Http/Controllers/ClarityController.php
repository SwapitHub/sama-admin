<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	use App\Models\DiamondClarity;
	
	
	class ClarityController extends Controller
	{
		public function index()
		{
			$data = [
			"title"=>'Diamond Clarity list',
			"viewurl" => 'admin.adddiamondclarity',
			"editurl" =>'admin.editdiamondclarity',
			'list'=> DiamondClarity::orderBy('id','desc')->get(),
			];
			return view('admin.diamondclarityList',$data);
		}
		
		public function addClarity()
		{
			$data = [
			'url_action' => route('admin.diamondclarityadd'),
			'backtrack'=> 'admin.diamondclarity',
			'title'=>'Add Diamond clarity',
			"obj"=>'',
			];
			return view('admin.diamondclarity',$data);		
		}
		
		public function postAddClarity(Request $request)
		{
		  	$this->validate($request, [
            'diamond_clarity' => 'required',
			], [
            'diamond_clarity.required' => 'The diamond clarity field is required.',
			]);
			$clarity = new DiamondClarity;
			$clarity->clarity = $request->diamond_clarity;
			$clarity->status = $request->status ?? 'false';
			$clarity->save();
			return redirect()->back()->with('success', 'Diamond clarity added successfully');	
		}
		
		public function editClarity($id)
		{
			$editdata = DiamondClarity::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatediamondclarity',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.diamondclarity',
			'title'=>'Edit Diamond Clarity',
			'obj'=>$editdata,
			];
			return view('admin.diamondclarity',$data);
		}
		
		public function PostEditClarity(Request $request , $id)
		{
			
			$obj = DiamondClarity::find($id);
			$this->validate($request, [
            'diamond_clarity' => 'required',
			], [
            'diamond_clarity.required' => 'The diamond clarity field is required.',
			]);
			$obj->clarity = $request->diamond_clarity;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Diamond clarity updated successfully');
		}
		
		public function deleteClarity($id)
		{
			if ($id) {
				$obj = DiamondClarity::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Diamond Clarity Id Required';
			}
			echo json_encode($output);	
		}
	}
