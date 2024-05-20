<?php
	
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Validator;
	use App\Models\FaqCategory;
	use App\Models\Faq;
	use App\Models\Widget;
	
	class FaqController extends Controller
	{
		
	    public function index()
		{
			
			$faqWithCategory = DB::table('faq')
			->join('faq_categories', 'faq.faq_category', '=', 'faq_categories.id')
			->orderBy('faq.id', 'desc')
			->select('faq.*', 'faq_categories.faq_category as category_name')
			->get();
			$data = [
			"title"=>'Faqs',
			"viewurl" => 'admin.addfaq',
			"editurl" =>'admin.editfaq',
			'list'=> $faqWithCategory
			];
			return view('admin.faq',$data);
		}
		/*  ### faq categorey start ### */
		public function deleteFaqCat($id)
		{
			if ($id) {
				$obj = FaqCategory::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Faq Id Required';
			}
			echo json_encode($output);
		}
		public function categories()
		{
			$data = [
			"title"=>'Faq categories',
			"viewurl" => 'admin.addfaqcategories',
			"editurl" =>'admin.editfaqcategories',
			'list'=> FaqCategory::orderBy('id','desc')->get(),
			];
			return view('admin.faqcategory',$data);
		}
		
		public function addCategory()
		{
			$data = [
			'url_action' => route('admin.postaddfaqcategories'),
			'backtrack'=> 'admin.faqcategories',
			'title'=>'Add Faq Category',
			"obj"=>'',
			];
			return view('admin.addfaq_category',$data);	
		}
		
		public function postAddCategory(Request $request)
		{
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The Category name field is required.',
			]);
			$cat = new FaqCategory;
			$cat->faq_category = $request->name;
			$cat->order_number = $request->order_number;
			$cat->status = $request->status ?? 'false';
			$cat->save();
			return redirect()->back()->with('success', 'Faq caytegory added successfully');
		}
		
		public function editCategory($id)
		{
			$editdata = FaqCategory::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.updatefaqcategories',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.faqcategories',
			'title'=>'Edit Faq Category',
			'obj'=>$editdata,
			];
			return view('admin.addfaq_category',$data);
		}
		
		public function updateCategory(Request $request ,$id)
		{
			$obj = FaqCategory::find($id);
			$this->validate($request, [
            'name' => 'required',
			], [
            'name.required' => 'The Category name field is required.',
			]);
			$obj->faq_category = $request->name;
			$obj->order_number = $request->order_number;
			$obj->status = $request->status ?? 'false';
			$obj->save();
			return redirect()->back()->with('success', 'Category updated successfully');
		}
		
		public function deleteCategory($id)
		{
			if ($id) {
				$obj = FaqCategory::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Category Id Required';
			}
			echo json_encode($output);
		}
		/*  ### faq categorey end ### */
		
	    public function create()
		{
			$data = [
			'categories'=>FaqCategory::orderBy('id','desc')->where('status','true')->get(),
			'url_action' => route('admin.postaddfaq'),
			'backtrack'=> 'admin.faqs',
			'title'=>'Add Faq',
			"obj"=>'',
			];
			return view('admin.addfaq',$data);	
		}
		
		public function postAddFaq(Request $request)
		{
			$this->validate($request, [
            'faq_category' => 'required',
            'question' => 'required',
            'answer' => 'required',
			], [
            'faq_category.required' => 'The Category field is required.',
            'question.required' => 'The Question field is required.',
            'answer.required' => 'The Answer field is required.',
			]);
			$faq = new Faq;
			$faq->faq_category = $request->faq_category;
			$faq->question = $request->question;
			$faq->answer = $request->answer;
			$faq->order_number = $request->order_number;
			$faq->status = $request->status ?? 'false';
			$faq->save();
			return redirect()->back()->with('success', 'Faq added successfully');
		}
		
		public function editFaq($id)
		{
			$editdata = Faq::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'categories'=>FaqCategory::orderBy('id','desc')->where('status','true')->get(),
			'url_action'=> route('admin.updatefaq',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.faqs',
			'title'=>'Edit Faq',
			'obj'=>$editdata,
			];
			return view('admin.addfaq',$data);
		}
		
		public function updateFaq(Request $request,$id)
		{
			$faq = Faq::find($id);
			$this->validate($request, [
            'faq_category' => 'required',
            'question' => 'required',
            'answer' => 'required',
			], [
            'faq_category.required' => 'The Category field is required.',
            'question.required' => 'The Question field is required.',
            'answer.required' => 'The Answer field is required.',
			]);
			$faq->faq_category = $request->faq_category;
			$faq->question = $request->question;
			$faq->answer = $request->answer;
			$faq->order_number = $request->order_number;
			$faq->status = $request->status ?? 'false';
			$faq->save();
			return redirect()->back()->with('success', 'Faq updated successfully');
		}
		
		public function deleteFaq($id)
		{
			if ($id) {
				$obj = Faq::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Faq Id Required';
			}
			echo json_encode($output);
		}

		public function widgetList(Request $request)
		{
			$data = [
			"title"=>'widget',
			"viewurl" => 'admin.widget.create',
			"editurl" =>'admin.editfaq',
			'list'=> Widget::orderBy('id','desc')->get()
			];
			return view('admin.widget',$data);
		}

		public function createwidget()
		{
			$data = [
				'url_action' => route('admin.widget.postcreate'),
				'backtrack'=> 'admin.widget.list',
				'title'=>'Add Widgt',
				"obj"=>'',
				];
				return view('admin.addwidget',$data);	
		}

		public function postCreatewidget(Request $request)
		{
			$this->validate($request, [
				'name' => 'required',
				'content' => 'required',
				], [
				'name.required' => 'The Name field is required.',
				'content.required' => 'The Contant  field is required.',
				]);
				$Widget = new Widget;
				$Widget->name = $request->name;
				$Widget->description = $request->content;
				$Widget->url = $request->url;
				$Widget->keyword = $request->keyword;
				$Widget->order_number = $request->order_number;
				$Widget->status = $request->status ?? 'false';
				$Widget->save();
				return redirect()->back()->with('success', 'Widget added successfully');
		}

		public function editWidget($id)
		{
			$editdata = Widget::find($id);
			if($editdata == null)
			{
				return 'no data';
			}
			$data = [
			'url_action'=> route('admin.update.widget',['id'=>$editdata['id']]),
			'backtrack'=> 'admin.widget.list',
			'title'=>'Edit Widget',
			'obj'=>$editdata,
			];
			return view('admin.addwidget',$data);
		}

		public function postEditWidget(Request $request,$id)
		{
			$widget = Widget::find($id);
			$this->validate($request, [
				'name' => 'required',
				'content' => 'required',
				], [
				'name.required' => 'The Name field is required.',
				'content.required' => 'The Content  field is required.',
				]);
				$widget->name = $request->name;
				$widget->description = $request->content;
				$widget->url = $request->url;
				$widget->keyword = $request->keyword;
				$widget->order_number = $request->order_number;
				$widget->status = $request->status ?? 'false';
				$widget->save();
			return redirect()->back()->with('success', 'Widget updated successfully');
		}

		public function deleteWidget($id)
		{
			if ($id) {
				$obj = Widget::find($id);
				$obj->delete();
				$output['res'] = 'success';
				$output['msg'] = 'Data Deleted';
				} else {
				$output['res'] = 'error';
				$output['msg'] = 'Widget Id Required';
			}
			echo json_encode($output);
		}
	}
