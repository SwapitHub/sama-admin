@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Edit Product
                            <small>Diamond Admin panel</small>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ol class="breadcrumb pull-right">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i data-feather="home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.product.dblist') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" action="{{ $action_url; }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="id" value="">
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Name</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name',$product->name) }}">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    SKU</label>
                                <div class="col-md-8">
                                    <input class="form-control @error('internal_sku') is-invalid @enderror" id="internal_sku" type="text" name="internal_sku" value="{{ old('internal_sku',$product->internal_sku) }}">
                                    @error('internal_sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Menu</label>
                                <div class="col-md-8">
                                    <select name="menu" id="menu_id" class="form-control">
                                        <option selected disabled>Menu</option>
                                        @foreach($Menus as $menu)
                                        <option value="{{ $menu->id }}" <?= $menu->id == $product->menu?'selected':''; ?> >{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('menuname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Categories</label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select name="category[]" id="category_id" multiple class="form-control">
                                                <option value="">Category</option>
                                            </select>
                                            @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <select name="subcategory[]" id="subcategory" multiple class="form-control">
                                                <option value="">Subcategory</option>
                                            </select>
                                            @error('subcategory')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Metal Type</label>
                                <div class="col-md-8">
                                    <select name="metalType" id="metalType" class="form-control">
                                        <option selected disabled>select</option>
                                       @foreach($metalType as $mtype)
                                       <option value="{{ $mtype->id }}" <?= $mtype->id == $product->metalType_id ?'selected':'' ?>>{{ $mtype->metal }}</option>
                                       @endforeach
                                    </select>
                                    @error('metalType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="color" class="col-xl-3 col-md-4"><span>*</span>
                                    Metal Color</label>
                                <div class="col-md-8">
                                    <select name="metal_color" id="metal_color" class="form-control">
                                        <option value="">choose</option>
                                        @foreach($metalColor as $mcolor)
                                       <option value="{{ $mcolor->id }}" <?= $mcolor->id == $product->metalColor_id ?'selected':'' ?>>{{ $mcolor->name }}</option>
                                       @endforeach
                                    </select>
                                    @error('metal_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Default Image</label>
                                <div class="col-md-8">
                                    <input type="file" name="default_image" class="dropify" data-default-file="{{ $product->default_image_url }}">
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4"><span>*</span>
                                    Description</label>
                                <div class="col-md-8">
                                    <textarea name="description" id="" cols="30" rows="10" class="summernote">{{ $product->description }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Diamond Quality
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="diamond_quality" type="text" name="diamond_quality" value="{{ old('diamond_quality',$product->diamondQuality) }}" placeholder="">
                                    @error('diamond_quality')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Center Shape
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="center_shape" type="text" name="center_shape" value="{{ old('center_shape',$product->CenterShape) }}" placeholder="">
                                    @error('center_shape')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Slug
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="{{ $product->slug }}">
                                    <small>Leave blank if you don't want to upldate</small>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">White gold price
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="white_gold_price" type="text" name="white_gold_price" value="{{ old('white_gold_price',$product->white_gold_price) }}" placeholder="white gold price">
                                    @error('white_gold_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Yellow gold price
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="yellow_gold_price" type="text" name="yellow_gold_price" value="{{ old('yellow_gold_price',$product->yellow_gold_price) }}" placeholder="yellow gold price">
                                    @error('yellow_gold_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Rose gold price
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="rose_gold_price" type="text" name="rose_gold_price" value="{{ old('rose_gold_price',$product->rose_gold_price) }}" placeholder="rose gold price">
                                    @error('rose_gold_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Platinum price
                                </label>
                                <div class="col-md-8">
                                    <input class="form-control" id="platinum_price" type="text" name="platinum_price" value="{{ old('platinum_price',$product->platinum_price)}}" placeholder="platinum price">
                                    @error('platinum_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <h5 style="margin-left:10px;">Similar Products</h5>
                            <div class="form-group row">
                                <label for="menuname" class="col-xl-3 col-md-4">Products 
                                </label>
                                <?php
                                $similarProducts = explode(',',$product->similar_products);
                                ?>
                                <div class="col-md-8">
                                    <select name="similar_products[]" id="similar_products" multiple class="form-control">
                                        <?php
                                         if($product->similar_products == null){
                                            echo "<option selected disabled>select</option>";
                                         }    
                                        ?>
                                        @foreach($similar_products as $similar_product)
                                           
                                        <option <?= (in_array($similar_product->id,$similarProducts))?'selected':'' ?> value="{{ $similar_product->id }}">{{ $similar_product->sku }} - {{ $similar_product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('platinum_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">Mark as </label>
                                <div class="col-xl-9 col-md-8">
                                    <div class="checkbox checkbox-primary">
                                        <input id="is_newest" type="checkbox" data-original-title="" {{ ($product->is_newest =='1')?'checked':'' }} name="is_newest" value="1" title="">
                                        <label for="is_newest">Newest</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">Mark as </label>
                                <div class="col-xl-9 col-md-8">
                                    <div class="checkbox checkbox-primary">
                                        <input id="is_bestseller" type="checkbox" data-original-title="" {{ ($product->is_bestseller =='1')?'checked':'' }} name="is_bestseller" value="1" title="">
                                        <label for="is_bestseller">Best seller</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xl-3 col-md-4">Status</label>
                                <div class="col-xl-9 col-md-8">
                                    <div class="checkbox checkbox-primary">
                                        <input id="status" type="checkbox" data-original-title="" {{ ($product->status =='true')?'checked':'' }} name="status" value="true" title="">
                                        <label for="status">Enable the Product</label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-block">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@push('scripts')
<!-- Your additional script here -->
<script>
     var cat = '{{ $product->category }}';
     var  menuid = {{ $product->menu }}
	$(document).ready(function(){
		getCatlist(menuid);
        getSubcategories(menuid,cat);
		
	});
	function getCatlist(menuid)
	{
		var url = "{{ url('getselectedcategories') }}";
		var act_url = url +'/'+ menuid ;
        var data = cat;
        var csrfToken = '{{ csrf_token() }}';
        $.ajax({
            url : act_url,
            method:"POST",
            data: { 
                _token: csrfToken,
                data: data
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function() {
                $("#category_id").html('<option>processing...</option>');
            },
            success:function(res)
            {
                $("#category_id").html(res);
            },
            error:function(res)
            {
                console.log(res);
            }
        })
	}

    function getSubcategories(menuid,cat)
    {
        var url = "{{ url('getsubcategories') }}";
		var act_url = url +'/'+ menuid ;
        var cat = cat;
        var subcat = '{{ $product->sub_category }}';
        var data = {'categories':cat,'selectedsubcat':subcat};
        var csrfToken = '{{ csrf_token() }}';
        $.ajax({
            url : act_url,
            method:"POST",
            data: { 
                _token: csrfToken,
                data: data
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            beforeSend: function() {
                // $("#category_id").html('<option>processing...</option>');
            },
            success:function(res)
            {
                console.log(res);
                $("#subcategory").html(res);
            },
            error:function(res)
            {
                console.log(res);
            }
        })
    }


	$("#menu_id").on('change',function(){  
		var menuId = $(this).val();
		if(menuId)
		{
			var url = "{{ url('getcategories') }}/"+menuId;
			$("#category_id").html('<option>processing...</option>');
			$("#category_id").load(url);
		}
		else
		{
		    $('#category_id').empty();
            $('#category_id').append($('<option>').text('Select a category'));	 
		}
	})	
    $("#category_id").on('change',function(){
        var categories = $(this).val();
        var categoriesString = categories.join(','); // Convert array to comma-separated string
        getSubcategories(menuid,categoriesString);
        
    })
    $('#subcategory').select2({
			selectOnClose: true
		});
        $("#similar_products").select2({
            selectOnClose: true
        })

        // get products based on category id 
        function getSimilarProducts(cat_id)
        {
            alert(cat_id);
        }
</script>
@endpush
@endsection


