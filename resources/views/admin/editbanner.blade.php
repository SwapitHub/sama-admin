@extends('layouts.layout')
@section('content')
<style>
	#termsec{
	display:none;
	}	
</style>
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Banner Management
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
						<li class="breadcrumb-item"><a href="{{ url('bannerlist') }}">Banner List</a></li>
						<li class="breadcrumb-item active">Edit Banner</li>
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
								aria-selected="true"><i data-feather="image" class="me-2"></i>Banner</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ route('admin.updatebanner') }}" method="POST" class="needs-validation"
								enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="id" value="{{ $bannerdata->id }}">
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4">Title</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="title" name="title"
											value="{{ old('title',$bannerdata->title) }}" type="text" placeholder="Title">
											@error('title')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Sub Title</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="subtitle" name="subtitle"
											value="{{ old('subtitle',$bannerdata->subtitle) }}" type="text" placeholder="Sub Title">
											@error('subtitle')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4">Type</label>
										<div class="col-xl-8 col-md-7">
											<select name="type" id="type" onchange="showTerm(this.value)" class="form-control">
												<option value="general" {{ ($bannerdata->type == 'general')?'selected':'' }}>General</option>	
												<option value="promotional" {{ ($bannerdata->type == 'promotional')?'selected':'' }}>Promotional</option>	
											</select>
										</div>
									</div>
									<div id="termsec">
										<div class="form-group row">
											<label for="validationCustom4" class="col-xl-3 col-md-4">
											Term and condition</label>
											<div class="col-xl-8 col-md-7">
												<textarea name="termcondition" id="termcondition" cols="30" rows="10" placeholder="Term and condition" class="summernote">{{ $bannerdata->term_condition }}</textarea>
												@error('termcondition')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Link</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="link" placeholder="Link"
											value="{{ old('link',$bannerdata->link) }}" name="link" type="url">
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Banner</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control dropify" id="image" name="image"
											data-default-file="{{ asset('storage/app/public') }}/{{ $bannerdata->banner }}" type="file">
											@error('image')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Description</label>
										<div class="col-xl-8 col-md-7">
											<textarea name="description" id="" cols="30" rows="10" class="summernote">{{ old('description',$bannerdata->description) }}</textarea>
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2" type="checkbox" {{ ($bannerdata->status=='true')?'checked':'' }} name="status"
												value="true" data-original-title="">
												<label for="checkbox-primary-2">Enable the Banner</label>
											</div>
										</div>
									</div>
									<div class="pull-left">
										<button type="submit" class="btn btn-primary submitBtn">Update <i
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
@push('scripts')
<script>
	$(document).ready(function(){
		var value = "{{ old('type',$bannerdata->type) }}";
		showTerm(value);
	});
	function showTerm(value)
	{   
		if(value =='promotional')
		{
			$("#termsec").css('display','block');  
			
		}
		else
		{
			$("#termsec").css('display','none');
		}
	}
</script>
@endpush
@endsection
