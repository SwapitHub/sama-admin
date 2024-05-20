<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImageModel;
use App\Models\ProductVideosModel;
use App\Models\MetalColor;
use App\Models\RingMetal;
use App\Models\ProductModel;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductImport implements ToCollection, WithHeadingRow
{
	/**
	 * @param Collection $collection
	 */

	protected $menu;
	protected $importedData;
	protected $importStatus;

	public function __construct($menu)
	{
		$this->menu = $menu;
		$this->menu_id = Menu::where('name', $menu)->first()['id'];
	}

	public function collection(Collection $collection)
	{
		$product = new ProductModel;
		$stat = 'true';
		foreach ($collection as $row) {
			if ($row->filter()->isNotEmpty()) {

				$input = $row->toArray();
				// dd($input);
				$subcat_id = $this->findSubcategory(trim($input['categoryvalue']));
				$input['name'] = $input['name'];
				$input['slug'] = $product->generateUniqueSlug($input['name']);
                // $input['videos'] = $product->sortVideos($input['videos']);
                $input['images'] = json_encode(explode(',',$input['images']));
				$input['metalType_id'] = $this->getMetalType($input['metaltype']);
                $input['metalColor_id'] = $this->getMetalColor($input['metalcolor']);
				// if ($subcat_id != NULL || !empty($subcat_id)) {
				// 	$input['sub_category'] = $subcat_id;
				// } else {
				// 	$input['sub_category'] =  (!empty($input['sub_category'])) ? $input['sub_category'] : NULL;
				// }

				// if ($input['newcategory'] == '#N/A' || $input['newcategory'] == NULL) {
				// 	$input['newcategory'] == NULL;
				// } else {
				// 	$cat_id = $this->getSubCategoryId($input['newcategory']);
				// 	$input['category'] = 7;
				// 	$input['sub_category'] = $cat_id;
				// }

				// if ($input['parent_sku'] == NULL) {
				// 	$input['type'] = 'parent_product';
				// } else {
				// 	$input['type'] = 'child_product';
				// }



				// if ($input['matching_wedding_band'] == '#N/A' || $input['matching_wedding_band'] == NULL) {
				// 	$input['matching_wedding_band'] = NULL;
				// } else {
				// 	$input['matching_wedding_band'];
				// }

				// if ($input['center_stone_options'] == '#N/A' || $input['center_stone_options'] == NULL) {
				// 	$input['center_stone_options'] = NULL;
				// } else {
				// 	$input['center_stone_options'];
				// }
				// if ($input['newdescription'] == '#N/A' || $input['newdescription'] == NULL) {
				// 	$input['description'] = $input['description'];
				// } else {
				// 	$input['description'] = $input['newdescription'];
				// }

				// if ($input['product_browse_pg_name'] == '#N/A' || $input['product_browse_pg_name'] == NULL) {
				// 	$input['product_browse_pg_name'] = NULL;
				// } else {
				// 	$input['product_browse_pg_name'];
				// }

				// if ($input['product_pg_name'] == '#N/A' || $input['product_pg_name'] == NULL) {
				// 	$input['product_pg_name'] = NULL;
				// } else {
				// 	$input['name'] = $input['product_pg_name'];
				// }
				// $input['meta_description'] = $input['name'];
				// $input['meta_keyword'] = $input['name'];
				// $input['meta_title'] = $input['name'];
				
				$input['status'] = 'true';

				// unset($input['id']);
				// unset($input['carat']);
				// unset($input['is_newest']);
				// unset($input['is_bestseller']);
				// unset($input['product_pg_name']);
				// unset($input['newcategory']);
				// unset($input['newsubcategory']);
				// unset($input['newdescription']);
				// unset($input['videos']);
				// unset($input['images']);

		
				// $matchData = [
				// 	'entity_id' => $input['entity_id'],
				// ];
				// $insertOrUpdate = ProductModel::updateOrCreate($matchData, $input);
				$check_exist = ProductModel::where('sku',$input['sku']);
				if (!$check_exist->exists()) {
					$insertOrUpdate = ProductModel::create($input);
					if ($insertOrUpdate) {
						// Access the ID of the model instance
						echo $insertOrUpdate->id . "<br>";
					} else {
						echo "NOt updated";
					}
				}
			
			}
		}
	}

	public function findSubcategory($categoryvalue)
	{
		$keyword_arr = ['3 Stone', 'Two-Stone Rings', 'Halo', 'Solitaires', 'Hidden Halo'];
		$categoryval = explode('/', $categoryvalue);

		foreach ($keyword_arr as $keyword) {
			if (in_array($keyword, $categoryval)) {
				$keyword =  ($keyword == '3 Stone') ? 'Three stone' : $keyword;
				$query =  Subcategory::where('menu_id', $this->menu_id)
					->where('category_id', 7)
					->where('name', $keyword);
				if ($query->exists()) {
					$subcatdata = $query->first();
					return $subcat_id = $subcatdata['id'];
				}
			}
		}
	}







	public function getSubCategoryId($subcatname)
	{
		$query =  Subcategory::where('menu_id', $this->menu_id)
			->where('category_id', 7)
			->where('name', str_replace('-', ' ', $subcatname));
		if ($query->exists()) {
			$catdata = $query->first();
			$cat_id = $catdata['id'];
		} else {

			// insert into category table where menu = $menu
			$insertData = new Subcategory;
			$insertData->menu_id = $this->menu_id;
			$insertData->category_id = 7;
			$insertData->name = $subcatname;
			$slug = $insertData->generateUniqueSlug($subcatname);
			$insertData->slug = $slug;
			$insertData->alias = $slug;
			$insertData->order_number = 0;
			$insertData->status = 'false';
			$insertData->save();
			$cat_id = $insertData->id;
		}
		return $cat_id;
	}


	public function saveImages($images, $skufolder, $product_id)
	{
		$imageUrlArray = json_decode($images, true);
		foreach ($imageUrlArray as $url) {
			$filename = basename($url);
			$matchData = [
				'product_id' => $product_id,
				'product_sku' => $skufolder,
				'image_path' => $filename,
			];
			$data = [
				'product_id' => $product_id,
				'product_sku' => $skufolder,
				'image_path' => $filename,
				'status' => 'true',
			];
			if (ProductImageModel::updateOrCreate($matchData, $data)) {
				return true;
			}
		}
	}

	public function saveVideos($videos, $skufolder, $product_id)
	{
		$videos = json_decode($videos, true);
		foreach ($videos as $index => $url) {
			$filename = basename($url);
			$mathData = [
				'product_id' => $product_id,
				'product_sku' => $skufolder,
				'color' => $index,
				'video_path' => $filename,
			];
			$data = [
				'product_id' => $product_id,
				'product_sku' => $skufolder,
				'color' => $index,
				'video_pathx' => $filename,
				'status' => 'true',
			];

			if (ProductVideosModel::updateOrCreate($mathData, $data)) {
				return true;
			}
		}
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
            $metal->status = 'false';
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
            $metalcolor->status = 'false';
            $metalcolor->order_number = 0;
            $metalcolor->save();
            $metalcolor_id = $metalcolor->id;
        }

        return $metalcolor_id;
    }
}
