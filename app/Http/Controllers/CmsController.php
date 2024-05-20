<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Http\Request;
	use App\Models\Cmscategory;
	use App\Models\Cmscontent;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	
	
	
	class CmsController extends Controller
	{
		public function index()
		{	
			$contentsWithCategory = DB::table('cms_content')
			->join('cms_category', 'cms_content.cms_category', '=', 'cms_category.id')
			->orderBy('cms_content.id', 'desc')
			->select('cms_content.*', 'cms_category.name as category_name')
			->paginate(10);
			$data['cmscontents'] = $contentsWithCategory;
			return view('admin.cmscontent',$data);
		}
		
		// add cmd content view 
		public function addcmsContent()
		{
			$data['cms_category'] = Cmscategory::where('status', 'true')->orderBy('id', 'desc')->get();
			return view('admin.addcmscontent',$data);
		}
		
		public function postAddCmsContent(Request $request)
		{
			$this->validate($request, [
            'name' => 'required',
            'category' => 'required',
			], [
            'name.required' => 'The content name field is required.',
            'category.required' => 'The content category field is required.',
			]);
			if ($request->file('image') != NULL) {
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "cms_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/cms', $fileName);
				$cmspath = 'images/cms/' . $fileName;
			}
			$Cmscontent = new Cmscontent;	
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $Cmscontent->generateUniqueSlug($uniqueslug);
			
			$Cmscontent->name = $request->name;
			$Cmscontent->cms_category = $request->category;
			$Cmscontent->keyword = $request->keyword;
			$Cmscontent->description = $request->description;
			$Cmscontent->content = $request->content;
			$Cmscontent->supported_variables = $request->supported_variables;
			$Cmscontent->slug = $slug;
			$Cmscontent->image = $cmspath??'';
			$Cmscontent->status = $request->status ?? 'false';
			$Cmscontent->order_number = $request->order_number;
			$Cmscontent->meta_title = $request->meta_title;
			$Cmscontent->meta_keyword = $request->meta_keyword;
			$Cmscontent->meta_description = $request->meta_description;
			$Cmscontent->save();
			return redirect()->back()->with('success', 'Cmscontent added successfully');
			
		}
		
		
		public function editCmsContent($id)
		{
		    $data['cms_category'] = Cmscategory::where('status', 'true')->orderBy('id', 'desc')->get();
			$data['editdata'] = Cmscontent::find($id);
			return view('admin.editcmscontent',$data);	
		}
		
		
		// edit content view 
		public function updateCmsContent(Request $request)
		{
			$this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'category' => 'required',
			], [
            'id.required' => 'The content id field is required.',
            'name.required' => 'The content name field is required.',
            'category.required' => 'The content category field is required.',
			]);
			$Cmscontent = Cmscontent::find($request->id);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $Cmscontent->image; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "cms_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/cms', $fileName);
				$cmspath = 'images/cms/' . $fileName;
			}
			else
			{
			  	$cmspath = $Cmscontent->image;
			}	
			if($request->slug)
			{
				$slug = 	$Cmscontent->generateUniqueSlug($request->slug);
			}
			else{
				$slug = 	$Cmscontent->slug;
			}
			
			$Cmscontent->name = $request->name;
			$Cmscontent->cms_category = $request->category;
			$Cmscontent->keyword = $request->keyword;
			$Cmscontent->description = $request->description;
			$Cmscontent->content = $request->content;
			$Cmscontent->Supported_variables = $request->supported_variables;
			$Cmscontent->slug = $slug;
			$Cmscontent->image = $cmspath;
			$Cmscontent->status = $request->status ?? 'false';
			$Cmscontent->order_number = $request->order_number;
			$Cmscontent->meta_title = $request->meta_title;
			$Cmscontent->meta_keyword = $request->meta_keyword;
			$Cmscontent->meta_description = $request->meta_description;
			$Cmscontent->save();
			return redirect()->back()->with('success', 'Cmscontent updated successfully');
		}
		
		public function deleteCmsContent($id)
		{
			if ($id) {
				$cmsdata = Cmscontent::find($id);
				$oldImagePath = 'public/' . $cmsdata->image; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$cmsdata->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Content Id Required';
			}
			echo json_encode($output);
		}
		
		
		public function cmsCategory()
		{
			$data['category'] = Cmscategory::orderBy('id', 'desc')->get();
			return  view('admin.cmscategory',$data);
		}
		
		public function addCmsCategory()
		{
			$data = [
			'category'=> Cmscategory::orderBy('id', 'desc')->get()
			];
			return view('admin.addcmscategory',$data);
		}
		
		public function postCmsCategory(Request $request)
		{
			$cmscategory = new Cmscategory;
			$this->validate($request, [
			'name' => 'required',
			], [
			'name.required' => 'The category title field is required.',
			]);
			
			$cmscategory->name = $request->name;
			$cmscategory->keyword = $request->keyword;
			$cmscategory->description = $request->description;
			$cmscategory->order_number = $request->order_number;
			$cmscategory->status = $request->status ?? 'false';
			$cmscategory->category = $request->category ;
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $cmscategory->generateUniqueSlug($uniqueslug);
			$cmscategory->slug = $slug;
			$cmscategory->meta_title = $request->meta_title;
			$cmscategory->meta_keyword = $request->meta_keyword;
			$cmscategory->meta_description = $request->meta_description;
			$cmscategory->save();
			return redirect()->back()->with('success', 'Category added successfully');
		}
		
		public function editCmsCategory($id)
		{
			$data['categorydata'] = Cmscategory::find($id);
			$data['category']= Cmscategory::orderBy('id', 'desc')->get();
			return view('admin.editcmscategory',$data);
		}
		
		public function updateCmsCategory(Request $request)
		{
			$this->validate($request, [
			'name' => 'required',
			], [
			'name.required' => 'The category title field is required.',
			]);
			$cmscategory = Cmscategory::find($request->id);
			$cmscategory->name = $request->name;
			$cmscategory->keyword = $request->keyword;
			$cmscategory->description = $request->description;
			$cmscategory->order_number = $request->order_number;
			$cmscategory->status = $request->status ?? 'false';
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $cmscategory->generateUniqueSlug($uniqueslug);
			$cmscategory->slug = $slug;
			$cmscategory->meta_title = $request->meta_title;
			$cmscategory->meta_keyword = $request->meta_keyword;
			$cmscategory->meta_description = $request->meta_description;
			$cmscategory->save();
			return redirect()->back()->with('success', 'Category updated successfully');
		}
		
		public function deleteCmsCategory($id)
		{
			if ($id) {
				$currency = Cmscategory::find($id);
				$currency->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Category Id Required';
			}
			echo json_encode($output);   
			}
			}
						