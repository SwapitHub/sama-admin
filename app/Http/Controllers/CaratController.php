<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	use App\Models\Carat;
	
	class CaratController extends Controller
	{
		public function index()
		{
			$data = [
			"title"=>'Carat list',
			"viewurl" => 'admin.addcarat',
			"editurl" =>'admin.editcarat',
			'list'=> Carat::orderBy('id','desc')->get(),
			];
			return view('admin.caratList',$data);
		}
		
		public function addCarat()
		{
			$data = [
			'url_action' => route('admin.caratadd'),
			'backtrack'=> 'admin.carat',
			'title'=>'Add carat',
			"obj"=>'',
			];
			return view('admin.carat',$data);		
		}
		
		public function postAddCarat(Request $request)
		{
		  	$this->validate($request, [
            'carat' => 'required',
			], [
            'carat.required' => 'The Name field is required.',
			]);
			$carat = new Carat;
			$carat->carat = $request->carat;
			$carat->status = $request->status ?? 'false';
			$carat->save();
			return redirect()->back()->with('success', 'Diamond carat added successfully');	
		}
		
		public function editCarat($id)
		{
			$editdata = Carat::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatecarat',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.carat',
			'title'=>'Edit Carat',
			'obj'=>$editdata,
			];
			return view('admin.carat',$data);
		}
		
		public function PostEditCarat(Request $request , $id)
		{
			$obj = Carat::find($id);
			$this->validate($request, [
            'carat' => 'required',
			], [
            'carat.required' => 'The carat field is required.',
			]);
			$obj->carat = $request->carat;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Diamond carat updated successfully');
		}
		
		public function deleteCarat($id)
		{
		  if ($id) {
				$carat = Carat::find($id);
				$carat->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Carat Id Required';
			}
			echo json_encode($output);	
		}
	}
	
	
	
