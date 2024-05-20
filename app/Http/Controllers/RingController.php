<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\Http;
	use App\Models\Ring;
	
	class RingController extends Controller
	{
		
		
		public function index()
		{
		    $data['shapeList'] = Ring::orderBy('id','desc')->get();
			return view('admin.ringstyle',$data);
		}

		public function addRingStyle()
		{
			return view('admin/addringstyle');
		}
		
		public function postAddRingstyle(Request $request)
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
				$path = $request->file('image')->storeAs('public/images/ringStyle', $fileName);
				$imagepath = 'images/ringStyle/' . $fileName;
			}
			$ring = new Ring;
			$ring->title = $request->title;
			$uniqueslug = $request->slug ?? $request->title;
			$slug = $ring->generateUniqueSlug($uniqueslug);
			$ring->slug = $slug;
			$ring->order_number = $request->order_number;
			$ring->icon = $imagepath;
			$ring->status = $request->status ?? 'false';
			$ring->save();
			return redirect()->back()->with('success', 'Ring style added successfully');
		}
		
		public function editRingStyleView($id)
		{
			$data['ringdata'] = Ring::find($id);
			return view('admin/editringstyle',$data);
		}
		
		public function PosteditRingStyle(Request $request)
		{
			$this->validate($request, [
            'id' => 'required',
		'title' => 'required',
		], [
		'id.required' => 'The ring id is required.',
		'title.required' => 'The ring field is required.',
		]);
		
		$ring = Ring::find($request->id);
		if ($request->file('image') != NULL) {
		$oldImagePath = 'public/' . $ring->icon; // Replace with the actual path
		if (Storage::exists($oldImagePath)) {
		Storage::delete($oldImagePath);
		}
		$extension = $request->file('image')->getClientOriginalExtension();
		$fileName = "ring_style_" . time() . '.' . $extension;
		$path = $request->file('image')->storeAs('public/images/ringStyle', $fileName);
		$imagepath = 'images/ringStyle/' . $fileName;
		}
		else
		{
		$imagepath = $ring->icon;
		}
		
		$ring->title = $request->title;
		if($request->slug){ $slug = $ring->generateUniqueSlug($request->slug); }else{ $slug= $ring->slug;}
		$ring->slug = $slug;
		$ring->order_number = $request->order_number;
		$ring->icon = $imagepath;
		$ring->status = $request->status ?? 'false';
		$ring->save();
		return redirect()->back()->with('success', 'Ring style updated successfully');	
		}
		
		public function deleteRingStyle($id)
		{
		if ($id) {
		$ring = Ring::find($id);
		$oldImagePath = 'public/' . $ring->icon; // Replace with the actual path
		if (Storage::exists($oldImagePath)) {
		Storage::delete($oldImagePath);
		}
		$ring->delete();
		$output['res'] = 'success';
		$output['msg'] = 'Data Deleted';
		} else {
		$output['res'] = 'error';
		$output['msg'] = 'Ring style Id Required';
		}
		echo json_encode($output);
		}
		
		
		}
				