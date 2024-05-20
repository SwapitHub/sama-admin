<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class CategoryController extends Controller
{
	public function index(Request $request)
	{
		if(isset($request->filter))
		{
			$keyword = trim($request->filter);
			$categoryWithMenu = DB::table('categories')
				->join('menus', 'categories.menu', '=', 'menus.id')
				->where('categories.name', 'LIKE', "%$keyword%")
				->orWhere('menus.name', 'LIKE', "%$keyword%")
				->orderBy('categories.id', 'desc')
				->select('categories.*', 'menus.name as menu_name')
				->paginate(10);
		}else{
			$categoryWithMenu = DB::table('categories')
			->join('menus', 'categories.menu', '=', 'menus.id')
			->orderBy('categories.id', 'desc')
			->select('categories.*', 'menus.name as menu_name')
			->paginate(10);
		}
		
		$data['categories'] = $categoryWithMenu;
		return view('admin.catList', $data);
	}

	public function addCatView()
	{
		$data['menulist'] =  Menu::orderBy('id', 'desc')->where('status', 'true')->get();
		return view('admin.addcategory', $data);
	}

	public function postCategory(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'menu' => 'required',
		], [
			'name.required' => 'The category title field is required.',
			'menu.required' => 'The menu field is required.',
		]);
		$category = new Category;
		$category->name = $request->name;
		$category->menu = $request->menu;
		$category->keyword = $request->keyword;
		$category->description = $request->description;
		$category->order_number = $request->order_number;
		$category->status = $request->status ?? 'false';
		$uniqueslug = $request->slug ?? $request->name;
		$slug = $category->generateUniqueSlug($uniqueslug);
		$category->alias = $request->alias;
		$category->slug = $slug;
		$category->meta_title = $request->meta_title;
		$category->meta_keyword = $request->meta_keyword;
		$category->meta_description = $request->meta_description;
		$category->save();
		return redirect()->back()->with('success', 'Category added successfully');
	}

	public function editCategory($id)
	{
		$data['catdata'] = Category::find($id);
		$data['menulist'] = Menu::orderBy('id', 'desc')->where('status', 'true')->get();
		return view('admin.editcat', $data);
	}

	public function updateCategory(Request $request)
	{
		$this->validate($request, [
			'id' => 'required',
			'name' => 'required',
			'menu' => 'required',
		], [
			'id.required' => 'The category id field is required.',
			'name.required' => 'The category title field is required.',
			'menu.required' => 'The menu field is required.',
		]);
		$category = Category::find($request->id);
		$category->name = $request->name;
		$category->menu = $request->menu;
		$category->keyword = $request->keyword;
		$category->description = $request->description;
		$category->order_number = $request->order_number;
		$category->status = $request->status ?? 'false';
		if ($request->slug) {
			$slug = $category->generateUniqueSlug($request->slug);
		} else {
			$slug = $category->slug;
		}
		$category->slug = $slug;
		$category->alias = $request->alias;
		$category->meta_title = $request->meta_title;
		$category->meta_keyword = $request->meta_keyword;
		$category->meta_description = $request->meta_description;
		$category->save();
		return redirect()->back()->with('success', 'Category updated successfully');
	}
	public function deleteCategory($id)
	{
		if ($id) {
			$catdata = Category::find($id);
			$catdata->delete();
			$output['res'] = 'success';
			$output['msg'] = 'Data Deleted';
		} else {
			$output['res'] = 'error';
			$output['msg'] = 'Category Id Required';
		}
		echo json_encode($output);
	}

	public function getCategory($id)
	{
		$categories = Category::orderBy('id', 'desc')->where('status', 'true')->where('menu', $id)->get();
		$count = count($categories);
		if ($count > 0) {
			$htmloption = '';
			$htmloption = '<option selected disabled>select category</option>';
			foreach ($categories as $cat) {
				$htmloption .= '<option value=' . $cat->id . '>' . $cat->name . '</option>';
			}
			echo $htmloption;
		} else {
			echo '<option selected disabled>no category found!</option>';
		}
	}
	public function getSelectedCategory($menuid, $selected_cat)
	{
		$categories = Category::orderBy('id', 'desc')->where('menu', $menuid)->get();
		// $categories = Category::orderBy('id','desc')->where('status','true')->where('menu',$menuid)->get();
		$count = count($categories);
		if ($count > 0) {
			$htmloption = '';
			$htmloption = '<option selected disabled>select category</option>';
			foreach ($categories as $cat) {
				$selected = $cat->id == $selected_cat ? 'selected' : '';
				$htmloption .= '<option value="' . $cat->id . '" ' . $selected . '>' . $cat->name . '</option>';
			}
			echo $htmloption;
		} else {
			echo '<option selected disabled>no category found!</option>';
		}
	}

	public function getSelectedCategories(Request $request,$menuid)
	{
		$query = Category::orderBy('id', 'desc')->where('menu', $menuid);
		if ($query->exists()) {
			$res = $query->get();
			$htmloption = '';
			$htmloption = '<option selected disabled>select category</option>';
			$selected_cat = explode(',',$request->data);
			foreach ($res as $cat) {
				// $selected = $cat->id == $selected_cat ? 'selected' : '';
				$selected = in_array($cat->id, $selected_cat) ? 'selected' : '';
				$htmloption .= '<option value="' . $cat->id . '" ' . $selected . '>' . $cat->name . '</option>';
			}
			echo $htmloption;
		} else {
			echo '<option selected disabled>no category found!</option>';
		}
	}
}
