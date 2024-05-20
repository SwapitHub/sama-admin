<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\Subcategory;
use App\Models\DiamondShape;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

	public function fetchProductPriceing(Request $request)
	{
		$rules = [
			'product_sku' => 'required',
			'metalType' => 'required',
			'metalColor' => 'required',
			'diamond_type' => 'required'
		];
		$messages = [
			'product_sku.required' => 'Product Sku is required.',
			'metalType.required' => 'Metal Type is required.',
			'metalColor.required' => 'Metal Color is required.',
			'diamond_type.required' => 'Diamond Type is required.',
		];
		$validator = Validator::make($request->all(), $rules, $messages);
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			$output['res'] = 'error';
			$output['msg'] = $errors;
		}
		try {
			if ($request->metalColor == 'rose') {
				$metalColor = "pink";
			} else {
				$metalColor = $request->metalColor;
			}
			$product_price  = ProductPrice::where('product_sku', $request->product_sku)
				->where('metalType', $request->metalType)
				->where('metalColor', $metalColor)
				->where('diamond_type', $request->diamond_type)
				->first();
			if ($product_price) {
				$output['res'] = 'success';
				$output['msg'] = 'product price is :';
				$output['data'] = $product_price;
			}else{
				$output['res'] = 'error';
				$output['msg'] = 'product price is :';
				$output['data'] = 'product price not found';
			}
			return response()->json($output, 200);
		} catch (Exception $e) {

			if ($product_price) {
				$output['res'] = 'error';
				$output['msg'] = 'product price is :';
				$output['data'] = $e->getMessage();
			}
			return response()->json($output, 500);
		}
	}

	public function index(Request $request)
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';
		
		
		$products = ProductModel::orderBy('entity_id', 'asc')->where('status', 'true')->whereNull('parent_sku');
		if($request->bridal_sets =='true')
		{
			$products->whereNotNull('matching_wedding_band');
		}
		if (!is_null($request->query('sortby'))) {
			$sortBy = $request->query('sortby');
			if ($sortBy == 'low_to_high') {
				$products = ProductModel::orderBy('white_gold_price', 'asc')->where('status', 'true');
			}
			if ($sortBy == 'high_to_low') {
				$products = ProductModel::orderBy('white_gold_price', 'desc')->where('status', 'true');
			}
			if ($sortBy == 'Newest') {
				$products->where('is_newest', '1');
			}
			if ($sortBy == 'best_seller') {
				$products->where('is_bestseller', '1');
			}
		}

		if (!is_null($request->query('shape'))) {
			$products->where('CenterShape', strtoupper(trim($request->query('shape'))));
		}
	
		if (!is_null($request->query('ring_style'))) {
			$subcatSlugs = explode(',', $request->query('ring_style'));

			// Fetch corresponding IDs based on slugs
			$subcatIds = Subcategory::whereIn('slug', $subcatSlugs)->pluck('id')->toArray();

			// If there are IDs, use them in the WHERE clause
			if (!empty($subcatIds)) {
				$products->where(function ($query) use ($subcatIds) {
					foreach ($subcatIds as $id) {
						$query->orWhereRaw("FIND_IN_SET(?, sub_category)", [$id]);
					}
				});
			}
		}
		if (!is_null($request->query('metal_color'))) {
			$metalcolor_id = $request->query('metal_color');
			$products->where('metalColor_id', $metalcolor_id);
		}
		if (!is_null($request->query('price_range'))) {
			$range = explode(',', $request->query('price_range'));
			$min = $range[0];
			$max = $range[1];
			$products->whereBetween('white_gold_price', [$min, $max]);
		}

		$actual_count = $products->get()->count();
		$productsList = $products->paginate(30);
		$count = $productsList->count();
		if ($count) {
			$productList = [];
			foreach ($productsList as $product) {

				$product->name = (!empty($product->product_browse_pg_name)) ? ucfirst(strtolower($product->product_browse_pg_name)) : ucfirst(strtolower($product->name));
				$product->description = ucfirst(strtolower($product->description));
				$product->images = json_decode($product->images);
				$product->videos = json_decode($product->videos);
				$name = strtolower($product->name);
				$product->name = ucwords($name);
				$product->white_gold_price = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'White')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product->yellow_gold_price = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'Yellow')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product->rose_gold_price = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'Pink')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product->platinum_price = ProductPrice::where('product_sku', $product['sku'])->where('metalType', 'Platinum')->where('metalColor', 'White')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				array_push($productList, $product);
			}

			$output['product_count'] = $actual_count;
			$output['data'] = $productList;
			return response()->json($output, 200);
		} else {
			$output['res'] = 'error';
			$output['msg'] = 'No product found!';
			$output['data'] = [];
			return response()->json($output, 200);
		}

		return response()->json($output, 200);
	}

	public function productDetails($entity_id)
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';

		$cacheKey = 'product_detail';
        $product_id = Cache::get($entity_id);
        $product_detail = Cache::get($cacheKey);
		if(!$product_id){
			if (!is_null($entity_id)) {
				$product =  ProductModel::where('entity_id', $entity_id)->orWhere('slug', $entity_id)->first();
				$product['name'] = ucfirst(strtolower(!empty($product['product_browse_pg_name'])?$product['product_browse_pg_name']:$product['name']));
				$product['description'] = ucfirst(strtolower($product['description']));
				$product['images'] = json_decode($product['images']);
				$product['videos'] = json_decode($product['videos']);
				$priceData = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'White')->where('diamond_type', 'natural')->first();
				$product['white_gold_price'] = $priceData['price'] ?? 0;
				$product['yellow_gold_price'] = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'Yellow')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product['rose_gold_price'] = ProductPrice::where('product_sku', $product['sku'])->where('metalType', '18kt')->where('metalColor', 'Pink')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product['platinum_price'] = ProductPrice::where('product_sku', $product['sku'])->where('metalType', 'Platinum')->where('metalColor', 'White')->where('diamond_type', 'natural')->first()['price'] ?? 0;
				$product['diamond_type'] = 'natural';
				$product['diamondQuality'] = $priceData['diamondQuality']??0;
				$product['metalType'] = '18KT Gold';
	
				if (!is_null($product['similar_products'])) {
					$product['similar_products'] = json_encode($this->getSimilarProducts($product['similar_products']));
				}
	
				if ($product['parent_sku'] != NULL) {
					$var = ProductModel::where('parent_sku', $product['parent_sku'])->get();
					if ($var->isNotEmpty()) {
						$collect_fractionsemimount = [];
						$vardata = [];
						foreach ($var as $variant) {
							if (!in_array($variant['fractionsemimount'], $collect_fractionsemimount)) { //check if current date is in the already_echoed array
								$variantData = [
									'name' => $variant['name'],
									'id' => $variant['id'],
									'slug' => $variant['slug'],
									'sku' => $variant['fractionsemimount']
								];
								$vardata[] = $variantData;
							}
							$collect_fractionsemimount[] = $variant['fractionsemimount'];
						}
					}
					$product['variants'] = $vardata;
				} else if ($product['parent_sku'] == NULL || empty($product['parent_sku'])) {
					$var = ProductModel::where('parent_sku', $product['sku'])->get();
					if ($var->isNotEmpty()) {
						$collect_fractionsemimount = [];
						$vardata = [];
						foreach ($var as $variant) {
							if (!in_array($variant['fractionsemimount'], $collect_fractionsemimount)) { //check if current date is in the already_echoed array
								$variantData = [
									'name' => ucfirst(strtolower(!empty($variant['product_browse_pg_name'])?$variant['product_browse_pg_name']:$variant['name'])),
									'id' => $variant['id'],
									'slug' => $variant['slug'],
									'sku' => $variant['fractionsemimount']
								];
								$vardata[] = $variantData;
							}
							$collect_fractionsemimount[] = $variant['fractionsemimount'];
						}
					} else {
						$vardata = [];
					}
					$product['variants'] = $vardata;
				}
			}
			Cache::put($cacheKey, $product, $minutes = 60);
			Cache::put($entity_id, $product, $minutes = 60);
			$output['from'] = 'db';
			$output['data'] = $product;
			return response()->json($output, 200);
		
		}else
		{	
			$output['from'] = 'cache';
			$output['data'] = $product_detail;
			return response()->json($output, 200);
		}

		
	}

	public function searhSuggestion(Request $request)
	{
		$output['res'] = 'success';
		$output['msg'] = 'suggestions are ...';
		$q = $request->input('q');
		if (!empty($q)) {
			$products = ProductModel::orderBy('entity_id', 'desc')
				->where('status', 'true')
				->where(function ($query) use ($q) {
					$query->where('name', 'like', "%$q%")
						->orWhere('sku', 'like', "%$q%")
						->orWhere('metalColor', 'like', "%$q%")
						->orWhere('diamondQuality', 'like', "%$q%")
						->orWhere('diamondQuality', 'like', "%$q%")
						->orWhere('CenterShape', 'like', "%$q%")
						->orWhere('white_gold_price', 'like', "%$q%")
						->orWhere('yellow_gold_price', 'like', "%$q%")
						->orWhere('rose_gold_price', 'like', "%$q%")
						->orWhere('fractioncomplete', 'like', "%$q%")
						->orWhere('metalType', 'like', "%$q%")
						->orWhere('metalWeight', 'like', "%$q%")
						->orWhere('finishLevel', 'like', "%$q%");
				})
				->select('name', 'slug', 'default_image_url', 'white_gold_price')
				->limit(5)
				->get();
			$searched_product = [];
			foreach ($products as $product) {
				$product->name = ucfirst(strtolower($product->name));
				$product->description = ucfirst(strtolower($product->description));
				$product->images = json_decode($product->images);
				$product->videos = json_decode($product->videos);
				$name = strtolower($product->name);
				$product->name = ucwords($name);
				array_push($searched_product, $product);
			}
		} else {
			$searched_product = [];
		}
		$output['data'] = $searched_product;
		return response()->json($output, 200);
	}

	public function globleSearch(Request $request)
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';
		$q = $request->input('q');
		if (!empty($q)) {
			$products = ProductModel::orderBy('entity_id', 'desc')
				->where('status', 'true')
				->where(function ($query) use ($q) {
					$query->where('name', 'like', "%$q%")
						->orWhere('sku', 'like', "%$q%")
						->orWhere('metalColor', 'like', "%$q%")
						->orWhere('diamondQuality', 'like', "%$q%")
						->orWhere('diamondQuality', 'like', "%$q%")
						->orWhere('CenterShape', 'like', "%$q%")
						->orWhere('white_gold_price', 'like', "%$q%")
						->orWhere('yellow_gold_price', 'like', "%$q%")
						->orWhere('rose_gold_price', 'like', "%$q%")
						->orWhere('fractioncomplete', 'like', "%$q%")
						->orWhere('metalType', 'like', "%$q%")
						->orWhere('metalWeight', 'like', "%$q%")
						->orWhere('finishLevel', 'like', "%$q%");
				});

			if (!is_null($request->query('shape'))) {
				$shapes = explode(',', strtoupper(trim($request->query('shape'))));
				$products->whereIn('CenterShape', $shapes);
			}

			if (!is_null($request->query('ring_style'))) {
				$subcatSlugs = explode(',', $request->query('ring_style'));

				// Fetch corresponding IDs based on slugs
				$subcatIds = Subcategory::whereIn('slug', $subcatSlugs)->pluck('id')->toArray();

				// If there are IDs, use them in the WHERE clause
				if (!empty($subcatIds)) {
					$products->where(function ($query) use ($subcatIds) {
						foreach ($subcatIds as $id) {
							$query->orWhereRaw("FIND_IN_SET(?, sub_category)", [$id]);
						}
					});
				}
			}

			if (!is_null($request->query('metal_color'))) {
				$metalcolor_ids = explode(',', $request->query('metal_color'));
				$products->whereIn('metalColor', $metalcolor_ids);
			}

			$count = $products->count();

			$products = $products->paginate(30);
			$searched_product = [];

			foreach ($products as $product) {
				$product->name = ucfirst(strtolower($product->name));
				$product->description = ucfirst(strtolower($product->description));
				$product->images = json_decode($product->images);
				$product->videos = json_decode($product->videos);
				$name = strtolower($product->name);
				$product->name = ucwords($name);
				array_push($searched_product, $product);
			}
		} else {
			$searched_product = [];
		}
		$output['product_count'] = isset($count) ? $count : 0;
		$output['data'] = $searched_product;
		return response()->json($output, 200);
	}
	public function productStyle(Request $request)
	{
		$output['res'] = 'success';
		$output['msg'] = 'data retrieved successfully';

		$cacheKey = 'ring_style';
        $ring_style = Cache::get($cacheKey);
		if(!$ring_style)
		{
			$ring_styles = Subcategory::orderBy('order_number', 'asc')->where('menu_id', 7)->where('category_id', 7)->where('status', 'true')->get();
			foreach ($ring_styles as $val) {
				if (!empty($val['image'])) {
					$val['image'] = env('AWS_URL').'public/storage/' . $val->image;
				}
			}
			Cache::put($cacheKey, $ring_styles, $minutes = 60);
			$output['from'] = 'db';
			$output['data'] = $ring_styles;
			return response()->json($output, 200);
		}
		else{
			$output['from'] = 'cache';
			$output['data'] = $ring_style;
			return response()->json($output, 200);
		}

	
	}

	public function getSimilarProducts($ids)
	{
		$products = [];
		$ids = explode(',', $ids);
		foreach ($ids as $product_id) {
			$pro = ProductModel::where('id', $product_id)->first();
			if ($pro) {
				$products[] = $pro;
			}
		}
		return $products;
	}
}
