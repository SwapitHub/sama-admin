@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Site Information
							<small>Dimond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ route('admin.dashboard')  }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">Settings</li>
						<li class="breadcrumb-item active">Site Information</li>
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
								aria-selected="true"><i data-feather="info" class="me-2"></i>Website Information</a>
							</li>
							<li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
								href="#top-contact" role="tab" aria-controls="top-contact"
								aria-selected="false"><i data-feather="external-link" class="me-2"></i>Social Links</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ route('admin.update_siteinfo') }}"
								method="POST" id="profile-form" enctype="multipart/form-data" data-parsley-validate>
									@csrf
									<input type="hidden" name="id" value="{{ $siteinfo->id }}">
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4">Site Name</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="sitename" value="{{ old('sitename',$siteinfo->name)  }}"  name="sitename" type="text">
											@error('sitename')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Email</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="email" value="{{ old('email',$siteinfo->email) }}" name="email" type="text">
											@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>

									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Phone no.</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="phone" value="{{ old('phone',$siteinfo->phone) }}" name="phone" type="text">
											@error('phone')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Logo</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control dropify" id="logo" name="logo" data-default-file="{{ env('AWS_URL') }}public/storage/{{ $siteinfo->logo }}" type="file">
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Favicon</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control dropify" id="favicon" name="favicon" type="file" data-default-file="{{ env('AWS_URL') }}public/storage/{{ $siteinfo->favicon }}">
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Address</label>
										<div class="col-xl-8 col-md-7">
											<textarea name="address" id="" cols="30" rows="10" class="summernote">{{ $siteinfo->address }}</textarea>
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Copyright</label>
										<div class="col-xl-8 col-md-7">
											<textarea name="copyright" id="" cols="30" rows="10" class="summernote">{{ $siteinfo->copyright }}</textarea>
										</div>
									</div>
									<div class="pull-left">
										<button type="submit" class="btn btn-primary submitBtn">Save <i
										class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
									</div>
								</form>

							</div>
							<div class="tab-pane fade" id="top-contact" role="tabpanel"
							aria-labelledby="contact-top-tab">
								<div class="account-setting">
									<form class="form" action="{{ route('admin.updatesite_urls') }}" method="POST">
										@csrf
										<input type="hidden" name="id" value="{{ $siteinfo->id }}">
										<div class="form-group row">
											<label for="validationCustom1" class="col-xl-3 col-md-4">
											Facebook</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="facebook" value="{{ $siteinfo->facebook }}" name="facebook"
												type="url">
											</div>
										</div>
										<div class="form-group row">
											<label for="validationCustom2" class="col-xl-3 col-md-4">
											Instagram</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="instagram" value="{{ $siteinfo->instagram }}" name="instagram"
												type="url" >
											</div>
										</div>
										<div class="form-group row">
											<label for="validationCustom2" class="col-xl-3 col-md-4">
											Twitter</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="twitter" value="{{ $siteinfo->twitter }}" name="twitter"
												type="url" >
											</div>
										</div>
										<div class="form-group row">
											<label for="validationCustom2" class="col-xl-3 col-md-4">
											Linkedin</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="linkedin" value="{{ $siteinfo->linkedin }}" name="linkedin"
												type="url" >
											</div>
										</div>
										<div class="form-group row">
											<label for="validationCustom4" class="col-xl-3 col-md-4">
											Youtube</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="youtube"
												name="youtube" value="{{ $siteinfo->youtube }}" type="url">
											</div>
										</div>
										<div class="form-group row">
											<label for="validationCustom4" class="col-xl-3 col-md-4">
											Pinterest</label>
											<div class="col-xl-8 col-md-7">
												<input class="form-control" id="pinterest"
												name="pinterest" value="{{ $siteinfo->pinterest }}" type="url">
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
	</div>
	<!-- Container-fluid Ends-->
</div>
@endsection
