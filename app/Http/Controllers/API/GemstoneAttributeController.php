<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Validator;
	use App\Models\gemstoneModel;
    use App\Models\gemstoneShapeModel;
    use App\Models\gemstoneColorModel;
	use Illuminate\Support\Facades\Cache;
	
	class GemstoneAttributeController extends Controller
	{
		public function index()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';

			$cacheKey = 'gemstone_attr';
			$gemstone_attr = Cache::get($cacheKey);
			if(!$gemstone_attr)
			{
				$stones = gemstoneModel::where('status','true')->get();
				foreach($stones as $stone)
				{	
					$stone->image = env('AWS_URL').'public/storage/'.$stone->image;
				}
	
				$shapes = gemstoneShapeModel::where('status','true')->get();
				foreach($shapes as $shape)
				{	
					$shape->image = env('AWS_URL').'public/storage/'.$shape->image;
				}
	
				$colors = gemstoneColorModel::where('status','true')->get();
				foreach($colors as $color)
				{	
					$color->image = env('AWS_URL').'public/storage/'.$color->image;
				}

				$attributes = ['gemstones'=>$stones,'gemstone_shape'=>$shapes,'gemstone_color'=>$colors];
             	Cache::put($cacheKey, $attributes, $minutes = 60);
				 $output['from'] = 'db';
				$output['data'] = $attributes;
				return response()->json($output, 200);
				
			}else
			{
				$output['from'] = 'cache';
				$output['data'] = $gemstone_attr;
				return response()->json($output, 200);
			}
				
		}

	}
