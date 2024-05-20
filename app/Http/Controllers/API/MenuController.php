<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\Menu;
	use App\Models\Category;
	use App\Models\Subcategory;
	use Illuminate\Support\Facades\Cache;
	
	class MenuController extends Controller
	{

		public function index()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';

			$cacheKey = 'menu_list';
			$menu_list = Cache::get($cacheKey);
			if(!$menu_list)
			{
				$menus = Menu::orderBy('order_number','asc')->where('status','true')->get();
				foreach($menus as $menu)
				{
					$cat = Category::orderBy('order_number','asc')->where('status','true')->where('menu',$menu->id)->get();
					$menu['categories'] = $cat;
					foreach($menu['categories'] as $menucat)
					{
						$subcat = Subcategory::orderBy('order_number','asc')->where('status','true')->where('menu_id',$menucat->menu)->where('category_id',$menucat->id)->get();
						$subcategory_collection = [];
						foreach($subcat as $subcategory)
						{
						   if(($subcategory->image != null))	
						   {
							  if($subcategory->img_status =='true'){
								$subcategory->image = env('AWS_URL').'public/storage/'.$subcategory->image; 
							  }else{
								$subcategory->image = '';
							  }
							   
						   }
						   else
						   {
							   $subcategory->image ='';
						   }
							array_push($subcategory_collection,$subcategory);
						}
						$menucat['subcategories'] = $subcategory_collection;
					}
				}
				Cache::put($cacheKey, $menus, $minutes = 60);
				$output['data'] = $menus;
				$output['from'] = 'db';
			    return response()->json($output, 200);
			}else{
				$output['data'] = $menu_list;
				$output['from'] = 'cache';
			    return response()->json($output, 200);
			}

			
		}
		
		// public function index()
		// {
		// 	$output['res'] = 'success';  
		// 	$output['msg'] = 'data retrieved successfully';
		// 	$menus = Menu::orderBy('order_number','asc')->where('status','true')->get();
		// 	foreach($menus as $menu)
		// 	{
		// 		$cat = Category::orderBy('order_number','asc')->where('status','true')->where('menu',$menu->id)->get();
		// 		$menu['categories'] = $cat;
		// 		foreach($menu['categories'] as $menucat)
		// 		{
		// 			$subcat = Subcategory::orderBy('order_number','asc')->where('status','true')->where('menu_id',$menucat->menu)->where('category_id',$menucat->id)->get();
		// 			$subcategory_collection = [];
		// 			foreach($subcat as $subcategory)
		// 			{
		// 			   if(($subcategory->image != null))	
		// 			   {
		// 				  if($subcategory->img_status =='true')
		// 				  {
		// 					// $subcategory->image = url('/').'/storage/app/public/'.$subcategory->image; 
		// 					$subcategory->image = env('AWS_URL').'public/storage/'.$subcategory->image; 
		// 				  }
		// 				  else
		// 				  {
		// 					$subcategory->image = '';
		// 				  }
						   
		// 			   }
		// 			   else
		// 			   {
		// 				   $subcategory->image ='';
		// 			   }
		// 			    array_push($subcategory_collection,$subcategory);
		// 			}
		// 			$menucat['subcategories'] = $subcategory_collection;
		// 		}
		// 	}
		// 	$output['data'] = $menus;
		// 	return response()->json($output, 200);
		// }

		public function getMenuName($slug)
		{
           if(!is_null($slug))
		   {
			  $output['res'] = 'success';  
			  $output['msg'] = 'data retrieved successfully';
			  $data = Menu::where('slug',$slug)->first();
			  $output['name'] = $data['name'];
			  return response()->json($output, 200);
		   }
		}
		
		public function rings(Request $request)
		{
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://www.overnightmountings.com/api/rest/itembom',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
			'Cookie: PHPSESSID=e72b989033c638afeafefce1a81c066a; frontend=01e615915edbe48fb3853d6e606864be; frontend_cid=ndgBBtdWKeEuSQHW'
			),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			return $response;
		}
		
	}
