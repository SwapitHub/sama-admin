<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	use App\Models\DiamondColor;
	
	
	
	class DiamondColorController extends Controller
	{
		public function index()
		{
			$data = [
			"title"=>'Diamond color list',
			"viewurl" => 'admin.adddiamondcolor',
			"editurl" =>'admin.editdiamondcolor',
			'list'=> DiamondColor::orderBy('id','desc')->get(),
			];
			return view('admin.diamondcolorList',$data);
		}
		
		public function addColor()
		{
			$data = [
			'url_action' => route('admin.diamondcoloradd'),
			'backtrack'=> 'admin.diamondcolor',
			'title'=>'Add Diamond diamondcolor',
			"obj"=>'',
			];
			return view('admin.diamondcolor',$data);		
		}
		
		public function postAddColor(Request $request)
		{
		  	$this->validate($request, [
            'diamond_color' => 'required',
			], [
            'diamond_color.required' => 'The diamond color field is required.',
			]);
			$cut = new DiamondColor;
			$cut->diamond_color = $request->diamond_color;
			$cut->status = $request->status ?? 'false';
			$cut->save();
			return redirect()->back()->with('success', 'Diamond color added successfully');	
		}
		
		public function editColor($id)
		{
			$editdata = DiamondColor::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatediamondcolor',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.diamondcolor',
			'title'=>'Edit Diamond color',
			'obj'=>$editdata,
			];
			return view('admin.diamondcolor',$data);
		}
		
		public function PostEditColor(Request $request , $id)
		{
			
			$obj = DiamondColor::find($id);
			$this->validate($request, [
            'diamond_color' => 'required',
			], [
            'diamond_color.required' => 'The diamond color field is required.',
			]);
			$obj->diamond_color = $request->diamond_color;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Diamond color updated successfully');
		}
		
		public function deleteColor($id)
		{
			if ($id) {
				$color = DiamondColor::find($id);
				$color->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Diamond Color Id Required';
			}
			echo json_encode($output);	
		}
	}
