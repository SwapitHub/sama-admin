@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Edit Subcategory
							<small>Diamond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ url('admin/dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route('admin.subcategories') }}">Subcategory List</a></li>
						<li class="breadcrumb-item active">Edit Subcategory</li>
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
						<form class="needs-validation" action="{{ route('admin.updatesubcat') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<input type="hidden" name="id" value="{{ $subcat->id }}">
							<div class="form-group row">
								<label for="menu_id" class="col-xl-3 col-md-4"><span>*</span>Menu
								</label>
								<div class="col-md-8">
									<select name="menu_id" id="menu_id"  class="form-control">
										<option>select</option>	
										@foreach($menus as $menu)
										<option value="{{ $menu->id }}" {{ $subcat->menu_id == $menu->id ? 'selected' : '' }} >{{ $menu->name }}</option>
										@endforeach
									</select>
									@error('menu_id')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="category_id" class="col-xl-3 col-md-4"><span>*</span>Category
								</label>
								<div class="col-md-8">
									<select name="category_id" id="category_id" class="form-control">
										<option>select</option>	
									</select>
									@error('category_id')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="col-xl-3 col-md-4"><span>*</span>Category name
								</label>
								<div class="col-md-8">
									<input type="text" name="name" name="name" value="{{ old('name',$subcat->name) }}" class="form-control">
									@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="alias" class="col-xl-3 col-md-4">Alias</label>
								<div class="col-md-8">
									<input class="form-control" id="alias" type="text"
									name="alias" value="{{ old('alias',$subcat->alias) }}" >
									@error('alias')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="slug" class="col-xl-3 col-md-4">Slug</label>
								<div class="col-md-8">
									<input class="form-control" id="slug" type="text"
									name="slug" value="{{ old('slug') }}" placeholder="{{ $subcat->slug }}">
										<small>(Leave blank if you do not want to update)</small>
									@error('slug')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="keyword" class="col-xl-3 col-md-4">Keyword
								</label>
								<div class="col-md-8">
									<input type="text" name="keyword" name="keyword" value="{{ old('keyword',$subcat->keyword) }}" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label for="keyword" class="col-xl-3 col-md-4">Description
								</label>
								<div class="col-md-8">
									<input type="text" name="description" name="description" value="{{ old('description',$subcat->description) }}" class="form-control">
								</div>
							</div>
							<div class="form-group row">
								<label for="image" class="col-xl-3 col-md-4">
								Image</label>
								<div class="col-md-8">
									<input class="form-control dropify" id="image" data-default-file="{{ asset('storage/app/public') }}/{{ $subcat->image }}" name="image" type="file">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-md-4">Image status</label>
								<div class="col-xl-9 col-md-8">
									<div class="checkbox checkbox-primary">
										<input id="img_status" type="checkbox"
										data-original-title="" name="img_status" value="true" title="" {{ ($subcat->img_status=='true')?'checked':'' }}>
										<label for="img_status">Enable the Image in menu</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="menuname" class="col-xl-3 col-md-4"><span></span>Order
								</label>
								<div class="col-md-8">
									<input class="form-control" id="order_number" name="order_number" type="number"
									required value="{{ $subcat->order_number }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-md-4">Status</label>
								<div class="col-xl-9 col-md-8">
									<div class="checkbox checkbox-primary">
										<input id="status" type="checkbox"
										data-original-title="" name="status" value="true" title="" {{ ($subcat->status=='true')?'checked':'' }}>
										<label for="status">Enable the subcategory</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Title</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_title" value="{{ $subcat->meta_title }}" class="form-control" placeholder="Meta Title">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Keyword</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_keyword" value="{{ $subcat->meta_keyword }}" class="form-control" placeholder="Meta Keyword">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4" >
										Meta Description</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_description" value="{{ $subcat->meta_description }}" class="form-control" placeholder="Meta Description">
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
	$(document).ready(function(){
		var  menuid = {{ $subcat->menu_id }}
		getCatlist(menuid);
		
	});
	function getCatlist(menuid)
	{
		var url = "{{ url('getselectedcategory') }}";
		var act_url = url +'/'+ menuid +'/'+ {{ $subcat->category_id }};
		$("#category_id").html('<option>processing...</option>');
		$("#category_id").load(act_url);
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
</script>
@endpush
@endsection		
