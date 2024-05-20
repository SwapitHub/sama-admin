@extends('layouts.layout')
@section('content')
	<div class="page-body">
		<!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-6">
						<div class="page-header-left">
							<h3>Edit Menu
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
							<li class="breadcrumb-item active">Edit Menu</li>
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
							<form class="needs-validation" action="{{ route('admin.updatemenu') }}" method="POST" enctype="multipart/form-data" novalidate>
								@csrf
								<input type="hidden" name="id" value="{{ $menudata->id }}">
								<div class="form-group row">
									<label for="menuname" class="col-xl-3 col-md-4"><span>*</span>Menu
									Name</label>
									<div class="col-md-8">
										<input class="form-control @error('menuname') is-invalid @enderror" id="menuname" type="text"
										name="menuname" value="{{ old('menuname',$menudata->name) }}">
										@error('menuname')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="menuname" class="col-xl-3 col-md-4">slug
								   </label>
									<div class="col-md-8">
										<input class="form-control" id="slug" type="text"
										 name="slug" value="{{ old('slug') }}" placeholder="{{ $menudata->slug }}">
										 	<small>(Leave blank if you do not want to update)</small>
										@error('slug')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="image" class="col-xl-3 col-md-4"><span>*</span>
									Image</label>
									<div class="col-md-8">
										<input class="form-control dropify" id="image" data-default-file="{{ env('AWS_URL') }}public/storage/{{ $menudata->image }}" name="image" type="file">
										@error('image')
										<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
								<div class="form-group row">
									<label for="image" class="col-xl-3 col-md-4">Term&condition</label>
									<div class="col-md-8">
										<textarea name="term_condition" class="form-control summernote" id="" cols="30" rows="10">{{  old('term_condition',$menudata->term_condition) }}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label for="menuname" class="col-xl-3 col-md-4"><span></span>Order
									</label>
									<div class="col-md-8">
										<input class="form-control" id="order_number" name="order_number" type="number"
										required value="{{ $menudata->order_number }}">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-md-4">Status</label>
									<div class="col-xl-9 col-md-8">
										<div class="checkbox checkbox-primary">
											<input id="status" type="checkbox"
											data-original-title="" name="status" value="true" title="" {{ ($menudata->status =='true')?'checked':'' }}>
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
