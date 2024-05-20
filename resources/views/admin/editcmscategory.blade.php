@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Edit category 
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
						<li class="breadcrumb-item"><a href="{{ url('admin/cms_category') }}">CMS</a></li>
						<li class="breadcrumb-item active">Edit Category</li>
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
								aria-selected="true"><i data-feather="voicemail" class="me-2"></i>CMS Category</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ route('admin.updatecmscategory') }}" method="POST" class="needs-validation">
									@csrf
									<input type="hidden" name="id" value="{{ $categorydata->id }}">
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4">Name</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="name" name="name"
											value="{{ old('name',$categorydata->name) }}" type="text" placeholder="Name">
											@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">keyword</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="keyword" name="keyword"
											value="{{ old('keyword',$categorydata->keyword) }}" type="text" placeholder="Keyword">
											@error('keyword')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>categoey</label>
										<div class="col-xl-8 col-md-7">
											<select name="category" class="form-control @error('category') is-invalid @enderror">
												<option selected value="" <?= ($categorydata->category == '')?'selected':'' ?>>==ROOT==</option>
												@foreach($category as $cat)
												<option value="{{ $cat->id }}" <?= ($categorydata->category == $cat->id )?'selected':'' ?>>{{ $cat->name }}</option>
												@endforeach
											</select>
											@error('category')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">description</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="description" name="description"
											value="{{ old('description',$categorydata->description) }}" type="text" placeholder="description">
											@error('description')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Slug </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="slug" name="slug"
											value="{{ old('slug') }}" type="text" placeholder="{{ $categorydata->slug }}">
											<small>(Leave blank if you do not want to update)</small>
											@error('slug')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Order</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="order_number" value="{{ $categorydata->order_number }}" class="form-control">
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2" type="checkbox" {{ ($categorydata->status=='true')?'checked':'' }} name="status"
												value="true" data-original-title="">
												<label for="checkbox-primary-2">Enable the category</label>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Title</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_title" value="{{ $categorydata->meta_title }}" class="form-control" placeholder="Meta Title">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Meta Keyword</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_keyword" value="{{ $categorydata->meta_keyword }}" class="form-control" placeholder="Meta Keyword">
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4" >
										Meta Description</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="meta_description" value="{{ $categorydata->meta_description }}" class="form-control" placeholder="Meta Description">
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
