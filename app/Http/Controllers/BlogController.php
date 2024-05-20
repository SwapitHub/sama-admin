<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\File;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\DB;
	use App\Models\BlogCatModel;
	use App\Models\BlogTypeModel;
	use App\Models\BlogModel;


	class BlogController extends Controller
	{
		public function __construct()
		{
			$this->blogs = DB::table('blogs')
			->select('blogs.*', 'blog_type.name as type_name', 'blog_category.name as category_name')
			->join('blog_type', 'blogs.type', '=', 'blog_type.id')
			->join('blog_category', 'blogs.category', '=', 'blog_category.id')
			->get();
		}
		################## blog ###########################
		public function index()
		{
			$data = [
			"title"=>'Blog list',
			"viewurl" => 'admin.blog.add',
			"editurl" =>'admin.blog.edit',
			'list'=> $this->blogs,
			];
			return view('admin.blog_list',$data);

		}

		public function addBlog()
		{
			$data = [
			'url_action' => route('admin.blog.postadd'),
			'categories'=>BlogCatModel::where('status','true')->get(),
			'types'=>BlogTypeModel::where('status','true')->get(),
			'backtrack'=> 'admin.blog',
			'title'=>'Add Blog',
			"obj"=>'',
			];
			return view('admin.blog',$data);
		}

		public function postAddBlog(Request $request)
		{
			$this->validate($request, [
            'category' => 'required',
            'type' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048', // Adjust mime types and max size as needed
			], [
            'category.required' => 'The Category field is required.',
            'type.required' => 'The Type field is required.',
            'title.required' => 'The Title field is required.',
            'sub_title.required' => 'The Sub title field is required.',
            'content.required' => 'The Blog content field is required.',
            'image.required' => 'An image is required.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, WEBP or GIF file.',
            'image.max' => 'The image size must not exceed 5 MB.',
			]);

			if ($request->file('image') != NULL) {
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "blogs_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/blog', $fileName);
				$imagepath = 'images/blog/' . $fileName;
			}
			$blog = new BlogModel;
			$blog->category = $request->category;
			$blog->type = $request->type;
			$blog->title = $request->title;
			$blog->sub_title = $request->sub_title;
			$uniqueslug = $request->slug ?? $request->title;
			$slug = $blog->generateUniqueSlug($uniqueslug);
			$blog->slug = $slug;
			$blog->content = $request->content;
			$blog->order_number = $request->order_number;
			$blog->image = $imagepath;
			$blog->status = $request->status ?? 'false';
			$blog->save();
			return redirect()->back()->with('success', 'Blog added successfully');
		}

		public function editBlog($id)
		{
			$editdata = BlogModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.blog.postedit',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.blog',
			'title'=>'Edit Blog ',
			'categories'=>BlogCatModel::where('status','true')->get(),
			'types'=>BlogTypeModel::where('status','true')->get(),
			'obj'=>$editdata,
			];
			return view('admin.blog',$data);
		}

		public function postEditBlog(Request $request, $id)
		{
		    $obj = BlogModel::find($id);
            $this->validate($request, [
            'category' => 'required',
            'type' => 'required',
            'title' => 'required',
            'sub_title' => 'required',
            'content' => 'required',
			], [
            'category.required' => 'The Category field is required.',
            'type.required' => 'The Type field is required.',
            'title.required' => 'The Title field is required.',
            'sub_title.required' => 'The Sub title field is required.',
            'content.required' => 'The Blog content field is required.',
			]);
			if ($request->file('image') != NULL) {
				$oldImagePath = 'public/' . $obj->icon; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "blogs_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/images/blog', $fileName);
				$imagepath = 'images/blog/' . $fileName;
			}
			else
			{
			   	$imagepath = $obj->image;
			}

			if($request->slug)
			{
			   	$slug = $obj->generateUniqueSlug($request->slug);
			}
			else
			{
				$slug = $obj->slug;
			}

			$obj->category = $request->category;
			$obj->type = $request->type;
			$obj->title = $request->title;
			$obj->sub_title = $request->sub_title;
			$obj->slug = $slug;
			$obj->content = $request->content;
			$obj->order_number = $request->order_number;
			$obj->image = $imagepath;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Blog updated successfully');
		}

		public function deleteBlog($id)
		{
			if ($id) {
				$obj = BlogModel::find($id);
				$oldImagePath = 'public/' . $obj->image; // Replace with the actual path
				if (Storage::exists($oldImagePath)) {
					Storage::delete($oldImagePath);
				}
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Blog Id Required';
			}
			echo json_encode($output);
		}

		################## blog ###########################

		// blog catagegory
		public function blogCategoryList()
		{
			$data = [
			"title"=>'Blog Category list',
			"viewurl" => 'admin.blog.cat',
			"editurl" =>'admin.blog.editcat',
			'list'=> BlogCatModel::orderBy('id','desc')->get(),
			];
			return view('admin.blogCategoryList',$data);
		}
		public function blogCategory()
		{
			$data = [
			'url_action' => route('admin.blog.cat'),
			'backtrack'=> 'admin.blog.catlist',
			'title'=>'Add blog category',
			"obj"=>'',
			];
			return view('admin.blogcategory',$data);
		}

		public function postBlogCategory(Request $request)
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
				$fileName = "blog_category_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/storage/images/blog_category', $fileName, 's3');
				$imagepath = 'images/blog_category/' . $fileName;
                Storage::disk('s3')->setVisibility($path, 'public');
			}
			$blogcat = new BlogCatModel;
			$blogcat->name = $request->name;
			$uniqueslug = $request->slug ?? $request->name;
			$slug = $blogcat->generateUniqueSlug($uniqueslug);
			$blogcat->slug = $slug;
			$blogcat->order_number = $request->order_number;
			$blogcat->icon = $imagepath;
			$blogcat->status = $request->status ?? 'false';
			$blogcat->save();
			return redirect()->back()->with('success', 'Blog added successfully');
		}

		public function editBlogCategory($id)
		{
			$editdata = BlogCatModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.blog.updatecat',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.blog.catlist',
			'title'=>'Edit Blog Category',
			'obj'=>$editdata,
			];
			return view('admin.blogcategory',$data);
		}

		public function updateBlogCategory(Request $request ,$id)
		{

			$obj = BlogCatModel::find($id);
			$this->validate($request, [
			'name' => 'required',
			], [
			'name.required' => 'The name field is required.',
			]);

			if ($request->file('image') != NULL) {
				$oldImagePath = $obj->icon; // Replace with the actual path
				if ($oldImagePath) {
                    $oldImagePath = 'public/storage/'.$oldImagePath;
                    Storage::disk('s3')->delete($oldImagePath);
				}
				$extension = $request->file('image')->getClientOriginalExtension();
				$fileName = "blog_category_" . time() . '.' . $extension;
				$path = $request->file('image')->storeAs('public/storage/images/blog_category', $fileName,'s3');
				$imagepath = 'images/blog_category/' . $fileName;
                Storage::disk('s3')->setVisibility($path, 'public');
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
			return redirect()->back()->with('success', 'Blog category updated successfully');
		}

		// blog categoey end ####################################

		######################### blog type start #########################

		public function blogTypeList()
		{
			$data = [
			"title"=>'Bloh Type list',
			"viewurl" => 'admin.blogtype.add',
			"editurl" =>'admin.blogtype.edit',
			'list'=> BlogTypeModel::orderBy('id','desc')->get(),
			];
			return view('admin.blog_type_list',$data);
		}

		public function addBlogType()
		{
			$data = [
			'url_action' => route('admin.blogtype.postadd'),
			'backtrack'=> 'admin.blogtype.list',
			'title'=>'Add blog type',
			"obj"=>'',
			];
			return view('admin.blogtype',$data);
		}

		public function postAddBlogType(Request $request)
		{
			$this->validate($request, [
			'name' => 'required'
			]);
			$blogtype = new BlogTypeModel;
			$blogtype->name = $request->name;
			$blogtype->order_number = $request->order_number;
			$blogtype->status = $request->status ?? 'false';
			$blogtype->save();
			return redirect()->back()->with('success', 'Blog type added successfully');
		}

		public function editBlogType($id)
		{
			$editdata = BlogTypeModel::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.blogtype.update',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.blogtype.list',
			'title'=>'Edit Blog Type',
			'obj'=>$editdata,
			];
			return view('admin.blogtype',$data);
		}
		public function postEditBlogType(Request $request ,$id)
		{
			$obj = BlogTypeModel::find($id);
			$this->validate($request, [
			'name' => 'required',
			], [
			'name.required' => 'The name field is required.',
			]);

			$obj->name = $request->name;
			$obj->order_number = $request->order_number;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Blog type updated successfully');
		}
	}
