@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>{{ $title }} 
							<small>Dimond Admin panel</small>
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
						<li class="breadcrumb-item"><a href="{{ route($backtrack) }}">Blogs</a></li>
						<li class="breadcrumb-item active">{{ $title }} </li>
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
								aria-selected="true"><i data-feather="image" class="me-2"></i>Create blog</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Category</label>
										<div class="col-xl-8 col-md-7">
										  <select name="category" class="form-control">
											  <option selected disabled>select</option>  
											  @foreach($categories as $category)
											     <option value="{{ $category['id'] }}" <?= (old('category',isset($obj['category'])) == $category['id']) ?'selected':'' ?> > {{ $category['name'] }}</option>
											  @endforeach;
										  </select>
											@error('category')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Type</label>
										<div class="col-xl-8 col-md-7">
										  <select name="type" class="form-control">
											  <option selected disabled>select</option>
											   @foreach($types as $type)
											     <option value="{{ $type['id'] }}" <?= (old('type',isset($obj['category'])) == $type['id'])?'selected':'' ?> >{{ $type['name'] }}</option>
											  @endforeach;
										  </select>
											@error('type')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Title</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
											value="{!! old()?old('title'):$obj['title']??'' !!}" type="text" placeholder="Title">
											@error('title')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Sub Title</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('sub_title') is-invalid @enderror" id="sub_title" name="sub_title"
											value="{!! old()?old('sub_title'):$obj['sub_title']??'' !!}" type="text" placeholder="Sub title">
											@error('title')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Slug </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="slug" name="slug"
											value="{{ old('slug') }}" type="text" placeholder="{!! $obj['slug']??'slug' !!}">
											<small>(Leave blank if you want system generated)</small>
											@error('slug')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4"><span class="text-danger">*</span>Content</label>
										<div class="col-xl-8 col-md-7">
										    <textarea name="content" class="summernote @error('content') is-invalid @enderror" >{!! old()?old('content'):$obj['content']??'' !!}</textarea>
											@error('content')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										<span>*</span>Dafault Image</label>
										<div class="col-xl-8 col-md-7">
											<input type="file" name="image" data-default-file="{{ old('image') ? old('image') : (isset($obj) && is_object($obj) && isset($obj->image) ? asset('storage/app/public/' . $obj->image) : '') }}"  class="form-control dropify">
											@error('image')
											<style> .dropify-wrapper { border:1px solid red;border-radius: 0.25rem; } </style>
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Order</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="order_number" value="{!! old()?old('order_number'):$obj['order_number']??'0' !!}" class="form-control">
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2"  type="checkbox" name="status"
												value="true" data-original-title="" {{ old('status') == 'true' || (isset($obj) && is_object($obj) && $obj->status == 'true') ? 'checked' : '' }} >
												<label for="checkbox-primary-2">Enable the blog </label>
											</div>
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
																				