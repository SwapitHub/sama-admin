@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Email SMTP
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
						<li class="breadcrumb-item"><a href="#">Email Configuration</a></li>
						<li class="breadcrumb-item active">Email SMTP</li>
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
								aria-selected="true"><i data-feather="key" class="me-2"></i>SMTP details</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ route('admin.updatesmtp') }}" method="POST" class="needs-validation"
								enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4">Name</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="name" name="name"
											value="{{ old('name',$smtp->name) }}" type="text" placeholder="configuration name">
											@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom1" class="col-xl-3 col-md-4">Host</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="host" name="host"
											value="{{ old('host',$smtp->host) }}" type="text" placeholder="Host Name">
											@error('host')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Port</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="port" placeholder="Port"
											value="{{ old('port',$smtp->port) }}" name="port" type="number">
											@error('port')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom2" class="col-xl-3 col-md-4">Encryption</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control" id="encryption" value="{{ old('encryption',$smtp->encryption) }}" placeholder="Encryption" name="encryption" type="text" >
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Username</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="username" placeholder="Username" class="form-control" value="{{ old('username',$smtp->username) }}">
											@error('username')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										
									</div>
									<div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
										Password</label>
										<div class="col-xl-8 col-md-7">
											<input type="text" name="password" placeholder="Password" class="form-control" value="{{ old('password',$smtp->password) }}">
											@error('password')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
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
