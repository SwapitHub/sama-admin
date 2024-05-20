@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Create Menu
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
						<li class="breadcrumb-item"><a href="{{ route('admin.menus') }}">Menus</a></li>
						<li class="breadcrumb-item active">Create Menu</li>
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
						<form class="needs-validation " novalidate  action="{{ route('admin.postcreatemenu') }}" method="POST" enctype="multipart/form-data" >
							@csrf
							<div class="form-group row">
								<label for="menuname" class="col-xl-3 col-md-4"><span>*</span>Menu
								Name</label>
								<div class="col-md-8">
									<input class="form-control  @error('menuname') is-invalid @enderror" id="menuname" type="text"
									required name="menuname" value="{{ old('menuname') }}">
									@error('menuname')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="slug" class="col-xl-3 col-md-4">slug</label>
								<div class="col-md-8">
									<input class="form-control" id="slug" type="text"
									name="slug" value="{{ old('slug') }}">
									<small>(Leave blank if you want system generated)</small>
									@error('slug')
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="image" class="col-xl-3 col-md-4"><span>*</span>
								Image</label>
								<div class="col-md-8">
									<input class="form-control dropify @error('image') is-invalid @enderror" id="image" name="image" type="file"
									required>
									@error('image')
									<style> .dropify-wrapper { border:1px solid #dc3545;border-radius: 0.25rem; } </style>
									<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="image" class="col-xl-3 col-md-4">Term&condition</label>
								<div class="col-md-8">
									<textarea name="term_condition" class="form-control summernote" id="" cols="30" rows="10"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label for="menuname" class="col-xl-3 col-md-4"><span></span>Order
								</label>
								<div class="col-md-8">
									<input class="form-control" id="order_number" name="order_number" type="number"
									required value="0">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-md-4">Status</label>
								<div class="col-xl-9 col-md-8">
									<div class="checkbox checkbox-primary">
										<input id="status" type="checkbox"
										data-original-title="" name="status" checked value="true" title="">
										<label for="status">Enable the Menu</label>
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
@endsection																