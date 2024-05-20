<?php
	
	namespace App\Http\Controllers\API;
	
	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use App\Models\DiamondShape;
	use Validator;
	use Illuminate\Support\Facades\File;
    use Illuminate\Pagination\LengthAwarePaginator;
	use Illuminate\Support\Facades\Cache;
	
	class DiamondController extends Controller
	{
		public function diamondShape()
		{
			$output['res'] = 'success';  
			$output['msg'] = 'data retrieved successfully';

			$cacheKey = 'diamond_shape';
			$diamond_shape = Cache::get($cacheKey);
			if(!$diamond_shape)
			{
				$data = DiamondShape::orderBy('order_number')->where('status','true')->get();	
				foreach($data as $shape)
				{
				   $shape->icon = env('AWS_URL').'public/storage/'.$shape->icon;
				}
				Cache::put($cacheKey, $data, $minutes = 60);
				$output['data'] = $data;
				$output['from'] = 'db';
				return response()->json($output, 200);
			}else{
				$output['data'] = $diamond_shape;
				$output['from'] = 'cache';
				return response()->json($output, 200);
			}
			
			
			
		}

		public function getDiaminds(Request $request)
		{
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://apiservices.vdbapp.com//v2/diamonds/inventory_url?type=Diamond&file_type=0',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Token token=iltz_Ie1tN0qm-ANqF7X6SRjwyhmMtzZsmqvyWOZ83I, api_key=_eTAh9su9_0cnehpDpqM9xA'
			),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$res =  json_decode($response);
			$values = $res->response;
			$jsonData = file_get_contents($values->diamond_inventory_url);

			// Check if the file was downloaded successfully
			if ($jsonData === false) {
				// Handle the error, such as by throwing an exception or logging it
				echo "Error: Unable to download the JSON file.";
			} else {
				// The JSON file contents are now stored in the $jsonData variable
				// You can process it further as needed
				 $d = json_decode($jsonData);
				$jsonData =  json_encode($d->response->body->diamonds);


									// Parse JSON data
						$data = json_decode($jsonData);

										// Filter data based on query parameters
					if ($request->has('shapes')) {
						$shapes = $request->input('shapes');

						// Filter data to include items with shapes in the provided shapes array
						$data = array_filter($data, function ($item) use ($shapes) {
							return in_array($item->shape, $shapes);
						});
					}

					if ($request->has('min_price')) {
						$data = array_filter($data, function ($item) use ($request) {
							return isset($item->total_sales_price) && $item->total_sales_price >= $request->input('min_price');
						});
					}

					if ($request->has('max_price')) {
						$data = array_filter($data, function ($item) use ($request) {
							return isset($item->total_sales_price) && $item->total_sales_price <= $request->input('max_price');
						});
					}
					if ($request->has('cut')) {
						$cut = $request->input('cut');
						// Filter data to include items with the provided cut
						$data = array_filter($data, function ($item) use ($cut) {
							return $item->cut === $cut;
						});
					}
				
					if ($request->has('clarity')) {
						$clarity = $request->input('clarity');
				
						// Filter data to include items with clarities in the provided clarities array
						 $data = array_filter($data, function ($item) use ($clarity) {
							return $item->clarity === $clarity;
						});
					}
				
					if ($request->has('color')) {
						$colors = $request->input('color');
				
						// Filter data to include items with the provided color
						$data = array_filter($data, function ($item) use ($colors) {
							return $item->color === $colors;
						});
					}
				

					// Paginate the filtered data
					$perPage = $request->input('perPage', 20); // Number of items per page, default 20
					$currentPage = $request->input('page', 1); // Current page, default 1

					$offset = ($currentPage - 1) * $perPage;
					$pagedData = array_slice($data, $offset, $perPage);

					// Return paginated JSON response with pagination information
					
					return response()->json([
						'res'=>'seccess',
						'msg'=>'data retrieved successfully',
						'data' => $pagedData,
						'pagination' => [
							'total' => count($data),
							'perPage' => $perPage,
							'currentPage' => $currentPage,
							'lastPage' => ceil(count($data) / $perPage),
						],
					]);
						
			}



		}


	}
