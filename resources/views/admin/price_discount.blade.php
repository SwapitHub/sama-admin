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
						<li class="breadcrumb-item"><a href="#">Product Price discount </a></li>
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
								aria-selected="true"><i data-feather="activity" class="me-2"></i>Price Discount</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Discount Type</label>
										<div class="col-xl-8 col-md-7">
										<select name="type" class="form-control">
										   <option value="precentage">Precentage</option>
										</select>
											<!--input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
											value="{!! old()?old('amount'):$obj['amount']??'' !!}" type="number" placeholder="amount"--->
											@error('type')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Amount</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount"
											value="{!! old()?old('amount'):$obj['amount']??'' !!}" type="number" placeholder="amount">
											@error('amount')
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
					
					<div class="card-body">
						
						<div class="tab-content" id="top-tabContent">
							<div class="table-responsive table-desi">
								<table class="all-package coupon-table table table-striped">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Amount (in precentage)</th>
											
										</tr>
									</thead>
									
									<tbody>
										<tr><input type="hidden" value="http://ec2-3-139-195-178.us-east-2.compute.amazonaws.com/admin/deletemenu" name="url" id="url"></tr>
										<tr data-row-id="10">
											<td>1</td>
											<td>{{ $obj['amount'] }}</td>
										</tr>
								
									
									
										
									</tbody>
								</table>
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
