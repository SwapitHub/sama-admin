<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\Banner;
	use Validator;
	
	class BannerController extends Controller
	{
		public function index()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';
			
			$data = Banner::orderBy('id','desc')->where('status','true')->get();	
			foreach($data as $banner){
			  $banner->banner = url('/').'/storage/app/public/'.$banner->banner;	
			}
			$output['data'] = $data;
			return response()->json($output, 200);
		}
	}
