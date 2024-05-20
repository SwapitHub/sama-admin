<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use App\Models\Category;
	use App\Models\Subcategory;
	use App\Models\Menu;
	
	class SubcategoryController extends Controller
	{
		public function index(Request $request)
		{
			if(isset($request->filter))
			{
				$keyword = trim($request->filter);
				$subCategoryWithMenu = DB::table('subcategories')
					->join('menus', 'subcategories.menu_id', '=', 'menus.id')
					->join('categories', 'subcategories.category_id', '=', 'categories.id')
					->where('subcategories.name', 'LIKE', "%$keyword%")
					->orWhere('menus.name', 'LIKE', "%$keyword%")
					->orWhere('categories.name', 'LIKE', "%$keyword%")
					->orderBy('subcategories.id', 'desc')
					->select('subcategories.*', 'menus.name as menu_name', 'categories.name as catname')
					->paginate(20);
			
			}else{
				$subCategoryWithMenu = DB::table('subcategories')
				->join('menus', 'subcategories.menu_id', '=', 'menus.id')
				->join('categories', 'subcategories.category_id', '=', 'categories.id')
				->orderBy('subcategories.id', 'desc')
				->select('subcategories.*', 'menus.name as menu_name','categories.name as catname')
				->paginate(20);
			}
			// Append the filter parameter to pagination links
			$subCategoryWithMenu->appends(['filter' => $request->filter]);
			$data['subcategories'] = $subCategoryWithMenu;
			return view('admin.subcategories',$data);
		}
		
		public function createSubcategoryView()
		{
			$data['menus'] = Menu::orderBy('id','desc')->where('status','true')->get();
			return view('admin.createsubcategory',$data);	
		}
		
		public function addSubcategory(Request $request)
		{
			$this->validate($request, [
            'menu_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
			], [
            'menu_id.required' => 'The menu field is required.',
            'category_id.required' => 'The category  field is required.',
            'name.required' => 'The name field is required.',
            // 'image.required' => 'An image is required.',
            // 'image.image' => 'The uploaded file must be an image.',
            // 'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            // 'image.max' => 'The image size must not exceed 5 MB.',
			]);
			
			if ($request->file('image') != NULL) {
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "subcat_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/subcategory', $fileName);
				$subcatpath = 'images/subcategory/' . $fileName;
			}else
			{
			  $subcatpath = '';	
			}
			$subcat = new Subcategory;
			$subcat->name = $request->name;
			$subcat->menu_id = $request->menu_id;
			$subcat->category_id = $request->category_id;
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $subcat->generateUniqueSlug($uniqueslug);
			$subcat->alias = $request->alias;
			$subcat->slug = $slug;
			$subcat->image = $subcatpath;
			$subcat->img_status = (isset($request->img_status))?'true':'false';
			$subcat->keyword = $request->description;
			$subcat->description = $request->description;
			$subcat->order_number = $request->order_number;
			$subcat->status = $request->status ?? 'false';
			$subcat->meta_title = $request->meta_title;
			$subcat->meta_keyword = $request->meta_keyword;
			$subcat->meta_description = $request->meta_description;
			$subcat->save();
			return redirect()->back()->with('success', 'Subcategory added successfully');
		}
		
		public function editSubcategory($id)
		{
		    $data = [
			'subcat'=>Subcategory::find($id),
			'menus' => Menu::orderBy('id','desc')->where('status','true')->get()
			];	
			return view('admin.editsubcat',$data);
		}
		
		public function updateSubcategory(Request $request)
		{
		    $this->validate($request, [
            'id' => 'required',
            'menu_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
			], [
            'id.required' => 'The id field is required.',
            'menu_id.required' => 'The menu field is required.',
            'category_id.required' => 'The category  field is required.',
            'name.required' => 'The name  field is required.',
			]);
			
			$subcat = Subcategory::find($request->id);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $subcat->image; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "subcat_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/subcategory', $fileName);
				$subcatpath = 'images/subcategory/' . $fileName;
			}
			else
			{
				$subcatpath = $subcat->image;
			}
			if($request->slug)
			{
				$slug = $subcat->generateUniqueSlug($request->slug);
			}
			else
			{
				$slug = $subcat->slug;
			}
			$subcat->name = $request->name;
			$subcat->menu_id = $request->menu_id;
			$subcat->category_id = $request->category_id;
			$subcat->alias = $request->alias;
			$subcat->slug = $slug;
			$subcat->image = $subcatpath;
			$subcat->img_status = (isset($request->img_status))?'true':'false';
			$subcat->keyword = $request->description;
			$subcat->description = $request->description;
			$subcat->order_number = $request->order_number;
			$subcat->status = $request->status ?? 'false';
			$subcat->meta_title = $request->meta_title;
			$subcat->meta_keyword = $request->meta_keyword;
			$subcat->meta_description = $request->meta_description;
			$subcat->save();
			return redirect()->back()->with('success', 'Subcategory added successfully');	
		}
		
		
		public function deleteSubcategory($id)
		{
			if ($id) {
				$Subcategory = Subcategory::find($id);
				$oldImagePath = 'public/' . $Subcategory->image; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$Subcategory->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Subcategory Id Required';
			}
			echo json_encode($output);
		}

		public function getSubcategories(Request $request,$menuid)
		{
			$categoryIds = $request->all()['data']['categories'];
			$selectedsubcat = $request->all()['data']['selectedsubcat'];
			// $categoryIds = explode(',', $request->data);
			$query = Subcategory::orderBy('id', 'desc')->where('menu_id', $menuid)->whereIn('category_id',explode(',',$categoryIds));
			if ($query->exists()) {
				$res = $query->get();
				$htmloption = '';
			    $htmloption = '<option selected disabled>select subcategory</option>';
			    $selected_subcat = explode(',',$selectedsubcat);
				foreach ($res as $subcat) {
						// $selected = $cat->id == $selected_cat ? 'selected' : '';
					$selected = in_array($subcat->id, $selected_subcat) ? 'selected' : '';
					$htmloption .= '<option value="' . $subcat->id . '" ' . $selected . '>' . $subcat->name . '</option>';
				}
				echo $htmloption;
			}
			else {
				echo '<option selected disabled>no subcategory found!</option>';
				}
		} 
			// 	$res = $query->get();
			// 	$htmloption = '';
			// 	$htmloption = '<option selected disabled>select category</option>';
			// 	$selected_subcat = explode(',',$request->data);
			// 	foreach ($res as $subcat) {
			// 		// $selected = $cat->id == $selected_cat ? 'selected' : '';
			// 		$selected = in_array($subcat->id, $selected_subcat) ? 'selected' : '';
			// 		$htmloption .= '<option value="' . $subcat->id . '" ' . $selected . '>' . $subcat->name . '</option>';
			// 	}
			// 	echo $htmloption;
			// } else {
			// 	echo '<option selected disabled>no subcategory found!</option>';
			// }
		// }
		
	}
