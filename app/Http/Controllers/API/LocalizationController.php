<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Validator;
	use App\Models\Language;
	
	class LocalizationController extends Controller
	{
		public function index()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';
			
			$data = Language::orderBy('id','desc')->where('status','true')->get();
			foreach($data as $lang){
				$lang->icon  = url('/').'/'.'storage/app/public/'.$lang->icon;
			}
			$output['data'] = $data;
			return response()->json($output, 200);	
		}
	}
