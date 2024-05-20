<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Http\Request;
	use App\Models\ProductModel;
	use App\Models\Menu;
	use App\Models\MetalColor;
	use App\Models\RingMetal;
	use App\Models\Category;
	use App\Models\Subcategory;
	use App\Models\Carat;
	use App\Models\DiamondShape;
	use App\Imports\ProductImport;
	use App\Exports\ProductExport;
	use Maatwebsite\Excel\Facades\Excel;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Str;
	
	class ProductController extends Controller
	{
		
		public function customPagination($items, $perPage, $currentPage, $options = [])
		{
			// Create a collection from the items
			$collection = new Collection($items);
			
			// Calculate the total number of items
			$total = $collection->count();
			
			// Create a paginator instance
			$paginator = new LengthAwarePaginator(
			$collection->forPage($currentPage, $perPage),
			$total,
			$perPage,
			$currentPage,
			$options
			);
			
			return $paginator;
		}
		
		public function index(Request $request)
		{
			
			$collect = [];
			$page = $request->query('page');
			if (isset($page)) {
				$page =  $request->query('page');
				} else {
				$page = 1;
			}
			$url = 'https://www.overnightmountings.com/api/rest/itembom?page_number=' . $page . '&number_of_items=30&category_id=134&oauth_consumer_key=bbae36baea2ef8dcd1f9a8a88cc59f06&oauth_token=819dc5826cd08cca9c57d392ba2b305e&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1699937564&oauth_nonce=z5TFanXZZQL&oauth_version=1.0&oauth_signature=jUUpgqm9J%2BSRoTgIx4UB6ZZxddA%3D';
			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
			'Cookie: PHPSESSID=419c3c9bb4c7b3168d87f5ce267928c5'
			),
			));
			$responsex = curl_exec($curl);
			curl_close($curl);
			$data = json_decode($responsex,true);
			$product = new ProductModel;
			$products = [];
			$i = 1;
			foreach ($data as $pro) {
				if ($i == 1) {
					$collect['totalcount'] = $pro['totalcount'];
				}
				
				// here we are crerating category subcategiryof that manu 
				$catvalues = $this->getCategoryValue($pro['categoryvalue']);
				$pro['menu'] = $catvalues['menu'];
				$pro['category'] = $catvalues['category'];
				$pro['sub_category'] = $catvalues['sub_category'];
				$pro['slug'] = $product->generateUniqueSlug($pro['name']);
				$pro['metalType_id'] = $this->getMetalType($pro['metalType']);
				$pro['metalColor_id'] = $this->getMetalColor($pro['metalColor']);
				$pro['finalprice'] = json_encode($pro['finalprice']);
				$postData = [
                'finishLevel' => $pro['finishLevel'],
				'metalType' => $pro['metalType'],
				'metalColor' => $pro['metalColor'],
				'sku' => $pro['sku'],
				'diamondQuality' => $pro['diamondQuality']
				];
				$response = $this->getColorsPrice($postData);
				$colorsPrice =  explode(',',$response);
				$pro['white_gold_price'] =  $colorsPrice[0];
				$pro['yellow_gold_price'] =  $colorsPrice[1];
				$pro['rose_gold_price'] =  $colorsPrice[2];
				// sorting images 
				$pro['images'] = json_encode(array_values((array)$pro['images']));
				
				// sorting videos 
				$colors = ['rose', 'white', 'yellow'];
				$colorVideoMapping = [];
				foreach ($pro['videos'] as $video) {
					// Extract color name from the video URL
					preg_match('/\.video\.(\w+)\.mp4/', $video, $matches);
					
					if (isset($matches[1])) {
						$colorName = $matches[1];
						// Check if the color is in the defined colors array
						if (in_array($colorName, $colors)) {
							// Assign the video URL to the corresponding color key
							$colorVideoMapping[$colorName] = $video;
						}
					}
				}
				// Convert the array to an object
				$videos = json_encode($colorVideoMapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
				$pro['videos'] = $videos;
				array_push($products, $pro);
				$i++;
				if (!ProductModel::where('entity_id', $pro['entity_id'])->exists()) {
					$pro['api_response'] = json_encode($pro);
					unset($pro['totalcount']);
					$product::create($pro);
					try {
						$product::create($pro);
						} catch (\Exception $e) {	
						var_dump($e->getMessage());
					}
					
				}
			}
			// exit;
			$collect['list'] = $products;
			return view('admin.products', $collect);
		}
		
		
		public function dbProduct(Request $request)
		{
			$products = ProductModel::orderBy('id', 'desc')->paginate(30);
			if(isset($request->filter))
			{
				$keyword = trim($request->filter);
				$products = ProductModel::orderBy('id', 'desc')
				->where('sku',$keyword)
				->orWhere('name',$keyword)
				->orWhere('entity_id',$keyword)
				->paginate(30);
			}
			$data = [];
			$data['action_url'] = route('admin.product.import');
			$data['create_url'] = route('admin.product.create');
			
			$data['list'] = $products;
			$data['menus'] = Menu::orderBy('id','desc')
			->where('status','true')
			->where('name','!=','BRAND')
			->get();
			
			$data['carats'] = Carat::orderBy('id','desc')
			->where('status','true')
			->get();
			return view('admin.db-product', $data);
		}
		
		
		public function exportProduct()
		{
			return Excel::download(new ProductExport, 'products.xlsx');
		}
		
		
		
		public function productCreate(Request $request)
		{
			$rules = [
			'type' => 'required',
			'sku' => 'required|unique:products',
			];
			$messages = [
			'type.required' => 'The Type field is required.',
			'sku.required' => 'The SKU field is required.',
			'sku.unique' => 'The SKU must be unique.',
			];
			$validator = Validator::make($request->all(), $rules, $messages);
			if ($validator->fails()) {
				$errors = $validator->errors()->all();
				$output['res'] = 'error';
				$output['msg'] = $errors;
				return response()->json($output, 200);
			}
			else
			{
				if($request->type == 'Configurable')
				{
					// $this->addConfigurableProduct();
					// create this product parent product and others child
					$output['res'] = 'success';
					$output['msg'] = 'load_model';
					$output['sku'] = $request->sku;
					$output['its_type'] = $request->type; 
					$output['is_redirect'] = 'false';
					$output['redirect_to'] = '';
					return response()->json($output, 200);	
				}
				else
				{
					$postData = [
					'type'=>$request->type,
					'sku'=>$request->sku,
					];
					$redirect_to =	$this->addSimpleProduct($postData);
					// add product into db and redirect to edit it 
					$output['res'] = 'success';
					$output['msg'] = 'create_product';
					$output['is_redirect'] = 'true';
					$output['redirect_to'] = $redirect_to;
					return response()->json($output, 200);	
				}
			}
		}
		
		// function for adding simple (single) product 
		public function addSimpleProduct($postData)
		{
			$product = new ProductModel;
			$product->type = $postData['type'];
			$product->sku = $postData['sku'];
			$product->save();
			$insertedId = $product->id;
			return url('/db-product-list/edit') .'/'. $insertedId;
		}
		
		// function for create parent and sub products
		public function addConfigurableProduct(Request $request)
		{
			$this->validate($request, [
            'its_type' => 'required',
            'parent_sku' => 'required',
            'carat' => 'required', 
			], [
            'its_type.required' => 'The Type field is required.',
            'parent_sku.required' => 'The Sku field  is required.',
            'carat.required' => 'The Carat field  is required.',
			]);
			
			$data['carat'] = $request->carat;
			$skuCaratMap = [];
			foreach ($data['carat'] as $carat) {
				$sku = $request->parent_sku . '-' . $carat;
				$skuCaratMap[$carat] = $sku;
			}
			
			$product = new ProductModel;
			$product->type = $request->its_type;
			$product->sku = $request->parent_sku;
			if($product->save())
			{
				foreach ($skuCaratMap as $carat => $childSku) {
					$childProduct = new ProductModel;
					$childProduct->type = 'Simple';
					$childProduct->sku = $childSku;
					$childProduct->parent_sku = $request->parent_sku;;
					$childProduct->carat = $carat . " CT"; 
					$childProduct->save();
				}
				$insertedId = $product->id;
				return redirect('/db-product-list/edit/' . $insertedId);
			}
		}
		
		
		
		
		public function editProduct($id)
		{
			$product = ProductModel::find($id);
			$category = $product['category'];
			$subcategory = $product['sub_category'];
			
			$similar_products = $product['similar_products'];
			if(!empty($similar_products))
			{
				$similar_collection = [];
				foreach(array_filter(explode(',',$similar_products)) as $similar_product)
				{
					$sproduct = ProductModel::where('id',$similar_product)
					->select('id','sku','name')
					->first();
					
					if ($product) {
						$similar_collection[] = [
						'id' => $sproduct->id,
						'sku' => $sproduct->sku,
						'name' => $sproduct->name
						];
					}
				}
			}
			else
			{
				$similar_collection = [];	
			}
			
			
			//if menu exist then return cat data with menu
			if(!empty($product->menu)){
				$catdata = Category::orderBy('id','desc')->where('menu',$product->menu)->where('status','true')->get();	
			}else
			{
				$catdata = [];	
			}
			
			// if menu and category exist then return cat data with menu
			if(!empty($product->menu) && !empty($product->category)){
				$subcatdata = Subcategory::orderBy('id','desc')
				->where('menu_id', $product->menu)
				->where('status', 'true')
				->where(function ($query) use ($product) {
					$categoryIds = explode(',', $product->category);
					$query->whereIn('category_id', $categoryIds);
				})
				->get();	
				}else{
				$subcatdata = [];	
			}								
			$data = [
			'action_url' => route('admin.product.update', ['id' => $id]),
			'product' => ProductModel::find($id),
			'Menus' => Menu::where('status', 'true')->whereRaw('LOWER(name) != LOWER(?)', ['brand'])->get(),
			'centerShapes' => DiamondShape::where('status','true')->get(),
			'metalType' => RingMetal::where('status', 'true')->get(),
			'metalColor' => MetalColor::where('status', 'true')->get(),
			'similar_products'=>$similar_collection,
			'categories'=>$catdata,
			'sub_categories'=>$subcatdata,
			];
			
			if($product['type'] =='Configurable' || $product['type'] =='parent_product')
			{
				$data['variations'] = ProductModel::orderBy('id','asc')->where('status','true')->where('parent_sku',$product['sku'])->get();
			}
			else
			{
				$data['variations'] = '';
				
			}
			return view('admin.configurable-product', $data);
		}
		
		public function postUpdateProduct(Request $request, $id)
		{
			$obj = ProductModel::find($id);
			if ($request->slug) {
				$slug = $obj->generateUniqueSlug($request->slug);
				} else {
				$slug = $obj->slug;
			}
			if($request->status){
				$status = $request->status;
				}else{
				$status = 'false';
			}
			if($request->is_newest){
				$is_newest = $request->is_newest;
				}else{
				$is_newest = '0';
			}
			if($request->is_bestseller){
				$is_bestseller = $request->is_bestseller;
				}else{
				$is_bestseller = '0';
			}
			$obj->menu = $request->menu;
			$obj->category = implode(',', $request->category);
			$obj->sub_category = ($request->subcategory != null) ? implode(',', $request->subcategory) : null;
			$obj->name = $request->name;
			$obj->internal_sku = $request->internal_sku;
			$obj->slug = $slug;
			$obj->description = $request->description;
			$obj->metalType_id = $request->metalType;
			$obj->metalColor_id = $request->metal_color;
			$obj->platinum_price = $request->platinum_price;
			$obj->rose_gold_price = $request->rose_gold_price;
			$obj->yellow_gold_price = $request->yellow_gold_price;
			$obj->white_gold_price = $request->white_gold_price;
			$obj->similar_products = ($request->similar_products != null) ? implode(',', $request->similar_products) : null;
			$obj->status = $status;
			$obj->is_bestseller = $is_bestseller;
			$obj->is_newest = $is_newest;
			$obj->save();
			return redirect()->back()->with('success', 'Product updated successfully');
		}
		
		
		public function importProducts(Request $request)
		{
			//old working code 
			
			// $res = Excel::import(new ProductImport, $request->file('excel_file'));
			// if($res == 'true')
			// {
			// 	return redirect()->route('admin.product.dblist')->with('success', 'Product imported successfully');
			// }
			// else
			// {
			// 	return redirect()->route('admin.product.dblist')->with('error', 'Something went wrong');
			// }	
			
			//modifyed code 
			if(!empty($request->menu))
			{
				$productImport = new ProductImport($request->menu);
				$res = Excel::import($productImport, $request->file('excel_file'));
				// Get the imported data from the ProductImport instance
				// Get the imported data and import status
				// $importedData = $productImport->getImportedData();
				// $importStatus = $productImport->getImportStatus();
				// var_dump($importStatus);
				// if($importStatus['is_updated'] =='true'){
				// return redirect()->route('admin.product.dblist')->with('success', 'Product imported successfully');
				// }
				// return redirect()->route('admin.product.dblist')->with('error', 'Something went wrong');
				// if($res == 'true')
				// {
				// return redirect()->route('admin.product.dblist')->with('success', 'Product imported successfully');
				// }
				// else
				// {
				// return redirect()->route('admin.product.dblist')->with('error', 'Something went wrong');
				// }
			}else
			{
				return "choose menu";
			}
			
			
		}
		
		// for make category and subcategory for products 
		public function getCategoryValue($arr)
		{
			$menu = "ENGAGEMENT RINGS";
			$catval = explode(',', $arr);
			$values = $catval[0];
			$data = explode('/', $values);
			
			$category = trim($data[0]);
			$subcategory = (isset($data[1]) ? $data[1] : null);
			
			$menudata = Menu::where('name', $menu)->first();
			$menu_id = $menudata['id'];
			
			// check category is exit or not, if not create one
			$query =  Category::where('menu', $menu_id)->where('name', $category);
			if ($query->exists()) {
				$catdata = $query->first();
				$cat_id = $catdata['id'];
				} else {
				// insert into category table where menu = $menu
				$insertData = new Category;
				$insertData->menu = $menu_id;
				$insertData->name = $category;
				$insertData->slug = $insertData->generateUniqueSlug($category);
				$insertData->order_number = 0;
				$insertData->status = 'false';
				$insertData->save();
				$cat_id = $insertData->id;
			}
			
			if (isset($subcategory)) {
				// check subcategory exist in table if not then create one 
				$check_subcat = Subcategory::where('menu_id', $menu_id)->where('category_id', $cat_id)->where('name', $subcategory);
				if ($check_subcat->exists()) {
					$subcatdata = $check_subcat->first();
					$subcat_id = $subcatdata['id'];
					} else {
					// insert into subcategory table where menu = $menu && category_id = cat_id
					$subcatInsert = new Subcategory;
					$subcatInsert->menu_id = $menu_id;
					$subcatInsert->category_id = $cat_id;
					$subcatInsert->name = $subcategory;
					$subcatInsert->slug = $subcatInsert->generateUniqueSlug($subcategory);
					$subcatInsert->status = 'false';
					$subcatInsert->order_number = 0;
					$subcatInsert->save();
					$subcat_id = $subcatInsert->id;
				}
				}else{
				$subcat_id = null;
			}
			
			
			return ['category' => $cat_id, 'sub_category' => $subcat_id, 'menu' => $menu_id];
		}
		
		
		public function getMetalType($metalType)
		{
			$metal =  RingMetal::where('metal', trim($metalType));
			if ($metal->exists()) {
				// get the id 
				$metaldata =  $metal->first();
				$metal_id = $metaldata['id'];
				} else {
				// insert into metal 
				$metal = new RingMetal;
				$metal->metal = trim($metalType);
				$metal->status = 'true';
				$metal->order_number = 0;
				$metal->save();
				$metal_id = $metal->id;
			}
			
			return $metal_id;
		}
		
		public function getMetalColor($color)
		{
			$metalcolor =  MetalColor::where('name', trim($color));
			if ($metalcolor->exists()) {
				// get the id 
				$metalcolordata =  $metalcolor->first();
				$metalcolor_id = $metalcolordata['id'];
				} else {
				// insert into metal 
				$metalcolor = new MetalColor;
				$metalcolor->name = trim($color);
				$metalcolor->status = 'true';
				$metalcolor->order_number = 0;
				$metalcolor->save();
				$metalcolor_id = $metalcolor->id;
			}
			
			return $metalcolor_id;
		}
		
		public function getColorsPrice($postData)
		{
			$metal = strtolower($postData["metalType"]);
			$mt = explode('kt', $metal);
			$metalType = $mt['0'] . 'kt';;
			$quality = $postData['diamondQuality'];
			$qualityWithPercent = trim(urlencode($quality));
			$postData["finishLevel"] = $this->fetchMatchedLevel($postData["finishLevel"]);
			
			$colors = ['White','Yellow','Pink'];
			
			$colorPrice = [];
			foreach($colors as $key=>$color)
			{
				$url = 'http://www.overnightmountings.com/priceapi/service.php?action=pricecalculation&type=json&level=' . $postData["finishLevel"] . '&metaltype=' . $metalType . '&metalcolor=' . $color . '&stylenumber=' . $postData["sku"] . '&quality='.$qualityWithPercent.'&sizevalue=0&fingersizevalue=Stock';
				$curl = curl_init();
				curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
				'Cookie: PHPSESSID=e239b0b67e96acd2bf27901dff8fd5ca; frontend=5769fc16c0729213eabc540cf9ddfcee'
				),
				));
				$response = curl_exec($curl);
				curl_close($curl);
				$data = json_decode($response);
				
				array_push($colorPrice,$data->price);
			}
			return implode(',',$colorPrice);
			
			
		}
		
		public function fetchMatchedLevel($level)
		{
			$allowedValues = array("Complete", "Polished", "Semi-mount");
			$finishLevel = $level;
			$extractedValue = '';
			foreach ($allowedValues as $allowedValue) {
				// If the allowed value is found in "finishLevel", print it and exit the loop
				if (stripos($finishLevel, $allowedValue) !== false) {
					$extractedValue = $allowedValue;
					break;
				}
			}
			return $extractedValue;
		}
		
		
		
		public function Testing()
		{
		   // echo "OK";
			//$IMAGES = "{"rose": "https://www.overnightmountings.com/gemfind/library/Images_And_Videos/50088-E/50088-E.video.rose.mp4", "white": "https://www.overnightmountings.com/gemfind/library/Images_And_Videos/50088-E/50088-E.video.white.mp4", "yellow": "https://www.overnightmountings.com/gemfind/library/Images_And_Videos/50088-E/50088-E.video.yellow.mp4"}";
			
			//print_r($IMAGES);
			
			
			// $products = ProductModel::orderBy('id', 'asc')
			// ->offset(3500)
			// ->limit(500)
			// ->get();
			// Initialize an array to store grouped SKUs
			// $groupedSKUs = [];
			
			// foreach ($products as $product) {
				// echo "<pre>";
				// var_dump($product['id']);
				##Extract the prefix before the hyphen
				// $parts = explode('-', $product->sku);
				// $prefix = $parts[0];
				
				##Check if the prefix already exists in the grouped SKUs array
				// if (!isset($groupedSKUs[$prefix])) {
					##If not, add it as a new group with the current SKU as the parent
					// $groupedSKUs[$prefix] = [
					// 'parent' => $product->sku,
					// 'variants' => []
					// ];
					// } else {
					##If the prefix already exists, add the current SKU as a variant under the parent SKU
					// $groupedSKUs[$prefix]['variants'][] = $product->sku;
					
					##Update the parent_sku column for the current product
					// $product->parent_sku = $groupedSKUs[$prefix]['parent'];
				    // $product->save();
					
				// }
			// }
			
			//Print the grouped SKUs
			##echo "<pre>";
			##print_r($groupedSKUs);
		} 
		
		
		
		
		
	}
