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
							<a href="{{ url('dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item"><a href="{{ route($backtrack) }}">Role List</a></li>
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
								aria-selected="true"><i data-feather="alert-circle" class="me-2"></i>Permissions </a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"> Name </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
											value="{!! old()?old('name'):$obj['name']??'' !!}" type="text" placeholder="Name">
											@error('name')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
                                    <div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"> slug </label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
											value="{!! old()?old('slug'):$obj['slug']??'' !!}" type="text" placeholder="slug">
											@error('slug')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
                                    <div class="form-group row">
										<label for="validationCustom4" class="col-xl-3 col-md-4">
                                        Select URI action</label>
										<div class="col-xl-8 col-md-7">
                                           <select name="permissions[]" multiple id="permissions" class="form-control select2">
                                               {{-- <option selected disabled>HTTP Methods</option> --}}
                                                @foreach($route_list as $route)
											

												@if(empty($obj))
                                                  <option value="{{ $route['method'] }} :: {{ $route['name'] }}">{{ $route['method'] }} :: {{ $route['name'] }}</option>
												@else
													@php
													$methods = $route['method'];
													$value = "{$methods} :: {$route['name']}";
													@endphp
													<option value="{{ $value }}"
														{{ (is_array(old('permissions')) && in_array($value, old('permissions'))) || in_array($value, explode('###', $obj['permissions'])) ? 'selected' : '' }}>
														{{ $methods }} :: {{ $route['name'] }}
													</option>
												@endif
                                                @endforeach
                                           </select>
											@error('permissions')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									{{-- <div class="form-group row">
										<label class="col-xl-3 col-md-4">Status</label>
										<div class="col-md-7">
											<div class="checkbox checkbox-primary">
												<input id="checkbox-primary-2"  type="checkbox" name="status"
												value="true" data-original-title="" {{ old('status') == 'true' || (isset($obj) && is_object($obj) && $obj->status == 'true') ? 'checked' : '' }} >
												<label for="checkbox-primary-2">User Status</label>
											</div>
										</div>
									</div> --}}
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
