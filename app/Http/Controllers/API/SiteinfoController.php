<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteInfo;
use App\Models\HomeContent;
use App\Models\MetalColor;
use App\Models\Widget;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class SiteinfoController extends Controller
{
	public function index()
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';

		$data = SiteInfo::first();
		$data->logo = env('AWS_URL').'public/storage/'.$data->logo;
		$data->favicon =  env('AWS_URL').'public/storage/'.$data->favicon;
		$output['data'] = $data;
		return response()->json($output, 200);
	}

	// public function homeContent()
	// {
	// 	$output['res'] = 'success';
	// 	$output['msg'] = 'data retrieved successfully';

	// 	$cacheKey = 'site_info';
	// 	$siteinfo = Cache::get($cacheKey);
	// 	if (!$siteinfo) {
	// 		$data = HomeContent::first();
	// 		$data->main_banner = env('AWS_URL') . 'public/storage/' . $data->main_banner;;
	// 		$data->sale_banner = env('AWS_URL') . 'public/storage/' . $data->sale_banner;
	// 		$data->ring_promotion_banner_desktop_1 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_1;
	// 		$data->ring_promotion_banner_mobile_1 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_1;
	// 		$data->ring_promotion_banner_desktop_2 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_2;
	// 		$data->ring_promotion_banner_mobile_2 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_2;
	// 		$data->ring_promotion_banner_desktop_3 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_3;
	// 		$data->ring_promotion_banner_mobile_3 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_3;
	// 		$data->ring_promotion_banner_last = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_last;
	// 		Cache::put($cacheKey, $data, $minutes = 60);
	// 		$output['data'] = $data;
	// 	}
	// 	return response()->json($output, 200);
	// }

	public function homeContent()
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';

		$cacheKey = 'site_info';
		$siteinfo = Cache::get($cacheKey);

		if (!$siteinfo) {
			// Data not found in cache, fetch from database
			$data = HomeContent::first();

			// Process the data as needed
			$data->main_banner = env('AWS_URL') . 'public/storage/' . $data->main_banner;;
			$data->sale_banner = env('AWS_URL') . 'public/storage/' . $data->sale_banner;
			$data->ring_promotion_banner_desktop_1 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_1;
			$data->ring_promotion_banner_mobile_1 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_1;
			$data->ring_promotion_banner_desktop_2 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_2;
			$data->ring_promotion_banner_mobile_2 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_2;
			$data->ring_promotion_banner_desktop_3 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_desktop_3;
			$data->ring_promotion_banner_mobile_3 = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_mobile_3;
			$data->ring_promotion_banner_last = env('AWS_URL') . 'public/storage/' . $data->ring_promotion_banner_last;
			// Process other fields similarly...

			// Store the processed data in cache
			
			Cache::put($cacheKey, $data, $minutes = 14400);

			// Add the data to output if needed
			$output['data'] = $data;
			$output['check_from'] = 'from db';
		} else {
			// Cache::forget('site_info');
			// Data found in cache, use it directly
			$output['data'] = $siteinfo;
			$output['check_from'] = 'from cache';
			
		}


		// Return JSON response with output
		return response()->json($output, 200);
	}



	public function metalColor()
	{

		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';
        $cacheKey = 'metal_color';
		$metalColor  = Cache::get($cacheKey);
        if(!$metalColor) {
            $data =  MetalColor::orderBy('id', 'asc')->where('status', 'true')->get();
            Cache::put($cacheKey, $data, $minutes = 120);
            $output['from'] = 'db';
            $output['data'] = $data;
            return response()->json($output, 200);
      
        }else
        {
            $output['from'] = 'cache';
            $output['data'] = $metalColor;
            return response()->json($output, 200);
        }
        
		
	}

	public function otherHomeData()
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';
		$collection = [];
		$collection['ready_to_ship_rings'] = Widget::where('name', 'Ready to ship rings')->first();
		$collection['lab_diamond_ring'] = Widget::where('name', 'Lab diamond rings')->first();
		$collection['three_stone_rings'] = Widget::where('name', 'Three stone rings')->first();
		$collection['nature_inspired_rings'] = Widget::where('name', 'Nature inspired rings')->first();
		$collection['hidden_Halo_rings'] = Widget::where('name', 'Hidden Halo rings')->first();
		$collection['Bridal_sets'] = Widget::where('name', 'Bridal sets')->first();
		$collection['classic_rings'] = Widget::where('name', 'Classic rings')->first();

		$output['data'] = $collection;
		return response()->json($output, 200);
	}
}
