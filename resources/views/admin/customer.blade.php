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
						<li class="breadcrumb-item"><a href="{{ route($backtrack) }}">Customer List</a></li>
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
								aria-selected="true"><i data-feather="user" class="me-2"></i>Customer </a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>First Name </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('first_name') is-invalid @enderror" id="fname" name="first_name"
											value="{!! old()?old('first_name'):$obj['first_name']??'' !!}" type="text" placeholder="First Name">
											@error('first_name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Last Name </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('last_name') is-invalid @enderror" id="lname" name="last_name"
											value="{!! old()?old('last_name'):$obj['last_name']??'' !!}" type="text" placeholder="Last Name">
											@error('last_name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>Email</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="Email" value="{!! old()?old('email'):$obj['email']??'' !!}">
											@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>Phone</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="number" placeholder="Phone no." value="{!! old()?old('phone'):$obj['phone']??'' !!}">
											@error('phone')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										<span>*</span>Address</label>
										<div class="col-xl-8 col-md-7">
											<textarea name="address" style="margin:0px;" class="form-control @error('address') is-invalid @enderror" placeholder="Address">{!! old()?old('address'):$obj['address']??'' !!}</textarea>
											@error('address')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										<span>*</span>Password</label>
										<div class="col-xl-8 col-md-7">
											<input type="password" name="password" placeholder="*********"  class="form-control @error('password') is-invalid @enderror">
											@if(!empty($obj))
											<small>leave blank if you do not want to update</small>
											@endif
											@error('password')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2"  type="checkbox" name="status"
												value="true" data-original-title="" {{ old('status') == 'true' || (isset($obj) && is_object($obj) && $obj->status == 'true') ? 'checked' : '' }} >
												<label for="checkbox-primary-2">Customer Status</label>
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
