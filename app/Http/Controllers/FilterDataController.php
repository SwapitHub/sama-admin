<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\Menu;
use App\Models\MetalColor;
use App\Models\RingMetal;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Carat;
use Validator;
	

class FilterDataController extends Controller
{
    public function filterCategory($menuid)
    {
       $categories =  Category::orderBy('id','desc')
                              ->where('menu',$menuid)
                              ->where('status','true')
                              ->get();

       $cathtml = '<option value="">--Select--</option>';

        foreach ($categories as $category) {
            $cathtml .= '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
         return $cathtml;
    }

    public function filterSubCategory($menu,$category)
    {
        $Subcategories =  Subcategory::orderBy('id','desc')
                                    ->where('menu_id',$menu)
                                    ->where('category_id',$category)
                                    ->where('status','true')    
                                    ->get();
        $html = '<option value="">--Select--</option>';
 
         foreach ($Subcategories as $subcat) {
             $html .= '<option value="' . $subcat->id . '">' . $subcat->name . '</option>';
         }
          return $html;
    }

    public function filterProduct(Request $request)
    {

        // $rules = [
        //     'product_id' => 'required',
        //     'menu_id' => 'required',
        //     'category_id' => 'required',
        // ];
        // $messages = [
        //     'product_id.required' => 'Product id is required.',
        //     'menu_id.required' => 'Menu id is required.',
        //     'category_id.required' => 'Category id is required.',

        // ];
        // $validator = Validator::make($request->all(), $rules, $messages);
        // if ($validator->fails()) {
        //     $errors = $validator->errors()->all();
        //     $output['res'] = 'error';
        //     $output['msg'] = $errors;
        //     return response()->json($output, 200);
        // }else
        // {
           $request = $request['data'];
           $product =  ProductModel::find($request['product_id']); 
           $similar_product = $product['similar_products']??[];
           if(!empty($similar_product))
           {
             $similar_product =  explode(',',$similar_product);
             $result = ProductModel::orderBy('id', 'desc')
                                ->whereNotIn('id', $similar_product)
                          
                          ->where('status', 'true')
                        //   ->where('parent_sku','==',NULL)
                          ->where('menu', $request['menu_id'])
                          ->where('category', $request['category_id'])
                          ->when($request['sub_category_id'] != NULL, function ($query) use ($request) {
                              return $query->where('sub_category', $request['sub_category_id']);
                          })
                          ->get();
           }
           else
           {
             $result = ProductModel::orderBy('id','desc')
                            ->where('status','true')
                            // ->where('parent_sku','==','NULL')
                            ->where('menu',$request['menu_id'])
                            ->where('category',$request['category_id'])
                            ->when($request['sub_category_id'] != NULL, function ($query) use ($request) {
                                  return $query->where('sub_category', $request['sub_category_id']);
                                })
                            ->get();
           }
        ?>
        <label for="" class="col-form-label"><span class="text-danger">*</span> Products</label>
             <select class="custom-select form-control multichoose" multiple name="similar_product[]" id=""  required="">
                <option value="">--Select--</option>
                <?php foreach($result as $product): ?>
                   <option value="<?= $product->id ?>"><?= $product->sku ?>  - <?= $product->name ?></option>
                 <?php endforeach; ?>
             </select>
             <script>
                const select = new Choices('.multichoose', {
                    removeItems: true,
                    searchPlaceholderValue: 'Type to search',
                    removeItemButton: true
                });
             </script>
        <?php
 
    }

    public function addSimilarProduct(Request $request)
    {
        $rules = [
            'id' => 'required',
            'similar_product' => 'required',

        ];
        $messages = [
            'id.required' => 'Product id is required.',
            'similar_product' => 'Product is required.',
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
            $similar_products = $request->similar_product;
            $product =  ProductModel::find($request->id);
            $active_similar_products = $product->similar_products;
            $active_similar_products = explode(',',$active_similar_products);

            // Merge the arrays
            $active_similar_products = array_merge($active_similar_products, $similar_products);

            // Implode the merged array

            

            $product->similar_products = implode(',',$active_similar_products);
            $table = '<table class="table table-responsive table-stripped">
            <thead>
                <tr>
                    <th>sr</th>
                    <th>name</th>
                    <th>sku</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>';
            if($product->save())
            {
                $output['res'] = 'success';
                $output['msg'] = 'saved';
               
                // foreach($request->similar_product as $index => $item)
                foreach(array_filter($active_similar_products) as $index => $item)
                {
                   $pro =  ProductModel::find($item);
                    $table .= '<tr>';
                    $table .= '<td>' . ($index + 1) . '</td>'; 
                    $table .= '<td>' . $pro->name . '</td>';
                    $table .= '<td>' . $pro->sku . '</td>';
                    $table .= '<td><i class="fa fa-trash delete-similar-product" data-product-id="' . $pro->id . '"></i></td>';
                    $table .= '</tr>';
                }
                $table .= '</tbody></table>';
                return response()->json(['res' => 'success', 'table' => $table], 200);

            }   
        }
    }

    public function removeSimilarProduct(Request $request)
    {
        
         $data = $request->all();
         $productId = $data['product_id'];
         $shouldbe_remove = $data['similar_id'];

        $details =  ProductModel::find($productId);
        if(!empty($details)){
            $active_similar_data = $details->similar_products;
            $active_similar_data = explode(',', $active_similar_data);
            $active_similar_data = array_diff($active_similar_data, [$shouldbe_remove]);
            $new_similar_data = implode(',', $active_similar_data);
            $details->similar_products = $new_similar_data;
            if($details->save())
            {
                return response()->json(['success' => true]);
            }
        }
        
    }
}


