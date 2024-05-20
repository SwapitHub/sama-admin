<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use App\Models\RingProng;
	
	class RingProngController extends Controller
	{
		public function index()
		{
			$data = [
			"title"=>'Customer list',
			"viewurl" => 'admin.addringprong',
			"editurl" =>'admin.editringprong',
			'list'=> RingProng::orderBy('id','desc')->get(),
			];
			return view('admin.prongList',$data);	
		}
		
		public function createProng()
		{
			$data = [
			'url_action' => route('admin.ringprongadd'),
			'backtrack'=> 'admin.ringprong',
			'title'=>'Add Ring Prong Type',
			"obj"=>'',
			];
			return view('admin.prong',$data);	
		}
		
		public function postCreateProng(Request $request)
		{
			$this->validate($request, [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
			], [
            'name.required' => 'The Name field is required.',
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            'image.max' => 'The image size must not exceed 5 MB.',
			]);
			
			if ($request->file('image') != NULL) {
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "ring_prong_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/ringProng', $fileName);
				$imagepath = 'images/ringProng/' . $fileName;
			}
			$prong = new RingProng;
			$prong->name = $request->name;
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $prong->generateUniqueSlug($uniqueslug);
			$prong->slug = $slug;
			$prong->order_number = $request->order_number;
			$prong->icon = $imagepath;
			$prong->status = $request->status ?? 'false';
			$prong->save();
			return redirect()->back()->with('success', 'Ring prong type added successfully');
		}
		
		public function editProng($id)
		{
			$editdata = RingProng::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updateringprong',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.ringprong',
			'title'=>'Edit Ring Prong',
			'obj'=>$editdata,
			];
			return view('admin.prong',$data);
		}
		
		public function postEditProng(Request $request ,$id)
		{
			$obj = RingProng::find($id);
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The name field is required.',
			]);
			
			if ($request->file('image') != NULL) { 
				$oldImagePath = 'public/' . $obj->icon; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "ring_prong_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/ringProng', $fileName);
				$imagepath = 'images/ringProng/' . $fileName;
			}
			else
			{
			   	$imagepath = $obj->icon;
			}
			
			if($request->slug)
			{
			   	$slug = $obj->generateUniqueSlug($request->slug);
			}
			else
			{
				$slug = $obj->slug;
			}
			
			$obj->name = $request->name;
			$obj->slug = $slug;
			$obj->order_number = $request->order_number;
			$obj->icon = $imagepath;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Ring prong updated successfully');
		}
		
		
		public function deleteProng($id)
		{
			if ($id) {
				$obj = RingProng::find($id);
				$oldImagePath = 'public/' . $obj->icon; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Prong Id Required';
			}
			echo json_encode($output);
		}
		
		
	}
