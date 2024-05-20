<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use App\Models\RingMetal;
	use App\Models\MetalColor;
	class RingMetalController extends Controller
	{
		//
		public function index()
		{
			$data = [
			"title"=>'Customer list',
			"viewurl" => 'admin.addringmetal',
			"editurl" =>'admin.editringmetal',
			'list'=> RingMetal::orderBy('id','desc')->get(),
			];
			return view('admin.metalList',$data);	
			
		}
		
		public function ringmetal()
		{	$data = [
			'url_action' => route('admin.createringmetal'),
			'backtrack'=> 'admin.ringmetal',
			'title'=>'Add Ring Metal',
			"obj"=>'',
			];
			return view('admin.ringmetal',$data);	
			
		}
		
		public function createMetal(Request $request)
		{
			$this->validate($request, [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
			], [
            'title.required' => 'The shape field is required.',
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            'image.max' => 'The image size must not exceed 5 MB.',
			]);
			
			if ($request->file('image') != NULL) {
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "ring_style_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/ringMetal', $fileName);
				$imagepath = 'images/ringMetal/' . $fileName;
			}
			$ring = new RingMetal;
			$ring->metal = $request->title;
			$uniqueslug = $request->slug ?? $request->title;
			$slug = $ring->generateUniqueSlug($uniqueslug);
			$ring->slug = $slug;
			$ring->order_number = $request->order_number;
			$ring->icon = $imagepath;
			$ring->status = $request->status ?? 'false';
			$ring->save();
			return redirect()->back()->with('success', 'Ring metal added successfully');
		}
		
		public function editMetal($id)
		{
			$editdata = RingMetal::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatemetal',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.ringmetal',
			'title'=>'Edit Ring Metal',
			'obj'=>$editdata,
			];
			return view('admin.ringmetal',$data);
		}
		
		public function postEdit(Request $request,$id)
		{
            $obj = RingMetal::find($id);
			$this->validate($request, [
            'title' => 'required',
			], [
            'title.required' => 'The shape field is required.',
			]);
			
			if ($request->file('image') != NULL) { 
				$oldImagePath = 'public/' . $obj->icon; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "ring_style_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/ringMetal', $fileName);
				$imagepath = 'images/ringMetal/' . $fileName;
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
			
			$obj->metal = $request->title;
			$obj->slug = $slug;
			$obj->order_number = $request->order_number;
			$obj->icon = $imagepath;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Ring metal updated successfully');
		}
		
		public function deleteMetal($id)
		{
			if ($id) {
				$obj = RingMetal::find($id);
				$oldImagePath = 'public/' . $obj->icon; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'RingMetal Id Required';
			}
			echo json_encode($output);
		}
		
		########## ring metal color ##############
		
		public function metalColorList()
		{
			$data = [
			"title"=>'Metal Color list',
			"viewurl" => 'admin.metalcolor.view',
			"editurl" =>'admin.metalcolor.edit',
			'list'=> MetalColor::orderBy('id','desc')->get(),
			];
			return view('admin.metalcolorList',$data);	
		}
		
		public function createColor()
		{
			$data = [
			'url_action' => route('admin.metalcolor.add'),
			'backtrack'=> 'admin.metal.color',
			'title'=>'Add Metal color',
			"obj"=>'',
			];
			return view('admin.metalcolor',$data);	
		}
		
		public function postcreateColor(Request $request)
		{
		// dd($request->all());
			$this->validate($request, [
            'name' => 'required',
            'color' => 'required',
			], [
            'name.required' => 'The Name field is required.',
            'color.required' => 'The Color field is required.'
			]);
			
			
			$MetalColor = new MetalColor;
			$MetalColor->name = $request->name;
			$MetalColor->color = $request->color;
			$MetalColor->value = $request->value;
			$MetalColor->order_number = (int)$request->order_number;
			$MetalColor->status = $request->status ?? 'false';
			$MetalColor->save();
			return redirect()->back()->with('success', 'Metal color added successfully');
		}
		
		public function editMetalColor($id)
		{
			$editdata = MetalColor::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.update.metalcolor',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.metal.color',
			'title'=>'Edit Metal Color',
			'obj'=>$editdata,
			];
			return view('admin.metalcolor',$data);
		}
		
		public function postEditMetalColor(Request $request ,$id)
		{
			$obj = MetalColor::find($id);
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The name field is required.',
			]);
			
			$obj->name = $request->name;
			$obj->color = $request->color;
			$obj->value = $request->value;
			$obj->order_number = $request->order_number;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Ring metal color updated successfully');
		}
		
		
		public function deleteMetalColor($id)
		{
			if ($id) {
				$obj = MetalColor::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Metal color Id Required';
			}
			echo json_encode($output);
		}
		
		
		
		
		########## ring metal color ##############
		
	}
