@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Add category 
							<small>Dimond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ url('dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item"><a href="{{ url('categories') }}">Product category list</a></li>
						<li class="breadcrumb-item active">Add Category</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
	
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12">
				<div class="card tab2-card">
					<div class="card-body">
						<ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
							<li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
								href="#top-profile" role="tab" aria-controls="top-profile"
								aria-selected="true"><i data-feather="alert-octagon" class="me-2"></i>Product Category</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ route('admin.addcategories') }}" method="POST" class="needs-validation " novalidate>
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4 form-label"><span>*</span>Name</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('name') is-invalid @enderror "id="name" name="name"
											value="{{ old('name') }}" type="text" placeholder="Name">
											@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Menu</label>
										<div class="col-xl-8 col-md-7">
											<select name="menu" id="menu" class="form-control @error('menu') is-invalid @enderror">
												<option selected disabled>select</option>   
												@foreach($menulist as $menu)
												<option value="{{ $menu->id }}">{{ $menu->name }}</option>
												@endforeach
											</select>
											@error('menu')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Keyword</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="keyword" name="keyword"
											value="{{ old('keyword') }}" type="text" placeholder="Keyword">
											@error('keyword')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Description</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="description" name="description"
											value="{{ old('description') }}" type="text" placeholder="description">
											@error('description')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Alias </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="alias" name="alias"
											value="{{ old('alias') }}" type="text" placeholder="alias">
											@error('alias')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Slug </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="slug" name="slug"
											value="{{ old('slug') }}" type="text" placeholder="slug">
											<small>(Leave blank if you want system generated)</small>
											@error('slug')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Order</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="order_number" value="0" class="form-control">
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2" type="checkbox" checked name="status"
												value="true" data-original-title="">
												<label for="checkbox-primary-2">Enable the category</label>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Title</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_title" value="" class="form-control" placeholder="Meta Title">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Keyword</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_keyword" value="" class="form-control" placeholder="Meta Keyword">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4" >
										Meta Description</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_description" value="" class="form-control" placeholder="Meta Description">
										</div>
									</div>
									<div class="pull-left">
										<button type="submit" class="btn btn-primary submitBtn">Save <i
										class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
									</div>
								</form>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>
@endsection
