<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	use App\Models\DiamonCut;
	
	
	class DiamonCutController extends Controller
	{
		public function index()
		{
			$data = [
			"title"=>'Diamond cut list',
			"viewurl" => 'admin.addcut',
			"editurl" =>'admin.editcut',
			'list'=> DiamonCut::orderBy('id','desc')->get(),
			];
			return view('admin.diamondcutList',$data);
		}
		
		public function addCut()
		{
			$data = [
			'url_action' => route('admin.cutadd'),
			'backtrack'=> 'admin.cut',
			'title'=>'Add Diamond cut',
			"obj"=>'',
			];
			return view('admin.diamondcut',$data);		
		}
		
		public function postAddCut(Request $request)
		{
		  	$this->validate($request, [
            'cut' => 'required',
			], [
            'cut.required' => 'The diamond cut field is required.',
			]);
			$cut = new DiamonCut;
			$cut->cut = $request->cut;
			$cut->status = $request->status ?? 'false';
			$cut->save();
			return redirect()->back()->with('success', 'Diamond cut added successfully');	
		}
		
		public function editCut($id)
		{
			$editdata = DiamonCut::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatecut',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.cut',
			'title'=>'Edit Diamond cut',
			'obj'=>$editdata,
			];
			return view('admin.diamondcut',$data);
		}
		
		public function PostEditCut(Request $request , $id)
		{
			
			$obj = DiamonCut::find($id);
			$this->validate($request, [
            'cut' => 'required',
			], [
            'carat.required' => 'The diamond cut field is required.',
			]);
			$obj->cut = $request->cut;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Diamond cut updated successfully');
		}
		
		public function deleteCut($id)
		{
			if ($id) {
				$cut = DiamonCut::find($id);
				$cut->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Diamond Cut Id Required';
			}
			echo json_encode($output);	
		}
	}
