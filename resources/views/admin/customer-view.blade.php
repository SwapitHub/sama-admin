@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>User Profile
							<small>Dimond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ route('admin.dashboard')}}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">User</li>
						<li class="breadcrumb-item active">Profile</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->

	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-5">
				<div class="card">
					<div class="card-body">
						<div class="profile-details ">

							<div class="row">
								<div class="col-sm-6">
									<img src="{{ asset('admin')}}/images/dashboard/designer.jpg" alt=""
									class="img-fluid img-90 rounded-circle blur-up lazyloaded">
									<h5 class="f-w-600 mb-0 text-capitalize">{{ ucfirst($obj['first_name']) }}  {{ strtolower($obj['last_name']) }}</h5>
									<span>{{ $obj['email'] }}</span>
								</div>
								<div class="col-sm-6 text-end">
									<a href="{{ route($editurl, ['id' => $obj['id']]) }}"><i class="fa fa-edit fa-2x"></i></a>
								</div>
							</div>


						</div>

						<hr>
						<div class="project-status">
							<div class="table-responsive profile-table">
								<table class="table table-borderless">
									<tbody>
										<tr>
											<td>Status :</td>
											<td><span class=" text-capitalize badge badge-{{ $obj['status'] =='true'?'success':'primary'; }}">{{ $obj['status'] }}</span>
											</td>
										</tr>
										<tr>
											<td>User ID :</td>
											<td><span class="badge badge-dark">#{{ $obj['id'] }}</span>
												<td></td>
											</tr>
											<tr>
												<td>User Email :</td>
												<td>{{ $obj['email'] }}</td>
											</tr>
											<tr>
												<td>Mobile Number :</td>
												<td>{{ $obj['phone']??'NA' }}</td>
											</tr>
											<tr>
												<td>Created At :</td>
												<td>{{ $obj['created_at'] }}</td>
											</tr>
										</tbody>
									</table>
								</div>


							</div>
						</div>
					</div>
				</div>
                <div class="col-xl-7">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
									href="#top-profile" role="tab" aria-controls="top-profile"
									aria-selected="true"><i data-feather="map-pin" class="me-2"></i>Saved Address (<?php echo count($address); ?>)</a>
								</li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
									href="#top-contact" role="tab" aria-controls="top-contact"
									aria-selected="false"><i data-feather="list" class="me-2"></i>Orders ({{ count($orders) }})</a>
								</li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
									href="#top-contact-update" role="tab" aria-controls="top-contact"
								aria-selected="false"><i data-feather="calendar" class="me-2"></i>Transactions (<?php echo count($transactions); ?>)</a> </li>
							</ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
								aria-labelledby="top-profile-tab">
                                    <h5 class="f-w-600">Saved Address (<?php echo count($address); ?>)</h5>
									<div class="table-responsive table-desi">
										<table class="table trans-table all-package">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Address Type</th>
													<th scope="col">Line 1</th>
													<th scope="col">Line 2</th>
													<th scope="col">City</th>
													<th scope="col">State</th>
													<th scope="col">Country</th>
													<th scope="col">Zip Code</th>
												</tr>
											</thead>
											<tbody>
												@foreach($address as $index=>$add)
												<tr>
													<th>{{ $index+1 }}</th>
													<td>{{ $add['address_type'] =='default'?'Default':'Billing Address'; }}</td>
													<td>{{ $add['address_line1'] }}</td>
													<td>{{ $add['address_line2'] }}</td>
													<td>{{ $add['city'] }}</td>
													<td>{{ $add['state'] }}</td>
													<td>{{ $add['country'] }}</td>
													<td>{{ $add['zipcode'] }}</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
                                <div class="tab-pane fade" id="top-contact" role="tabpanel"
								aria-labelledby="contact-top-tab">
                                    <div class="account-setting">
                                        <h5 class="f-w-600">Orders (<?php echo count($orders); ?>)</h5>
                                        <div class="table-responsive table-desi">
											<table class="table trans-table all-package">
												<thead>
													<tr>
														<th scope="col">#</th>
														<th scope="col">Order ID</th>
														<th scope="col">Amount</th>
														<th scope="col">Method</th>
														<th scope="col">Status</th>
														<th scope="col">Created At</th>
													</tr>
												</thead>
												<tbody>
													@foreach($orders as $index=>$order)
													<tr>
														<th>{{ $index+1 }}</th>
														<td>{{ $order['order_id'] }}</td>
														<td>{{ $order['amount'] }}</td>
														<td>{{ $order['method'] }}</td>
														<td>{{ $order['status'] }}</td>
														<td>{{ $order['created_at'] }}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
                                <div class="tab-pane fade" id="top-contact-update" role="tabpanel"
								aria-labelledby="contact-top-tab">
                                    <div class="account-setting">
                                        <h5 class="f-w-600">Transactions (<?php echo count($transactions); ?>)</h5>
										<div class="table-responsive table-desi">
											<table class="table trans-table all-package">
												<thead>
													<tr>
														<th scope="col">#</th>
														<th scope="col">Transaction Id</th>
                                                        <th scope="col">Amount</th>
														<th scope="col">Order Id</th>
														<th scope="col">Invoice Id</th>
														<th scope="col">Paymane Method</th>
														<th scope="col">Status</th>
														<th scope="col">Created At</th>
													</tr>
												</thead>
												<tbody>
													@foreach($transactions as $index=>$transaction)
													<tr>
														<th>{{ $index+1 }}</th>
														<td>{{ $transaction['transaction_id'] }}</td>
                                                        <td>{{ $transaction['amount'] }}</td>
														<td>{{ $transaction['order_id'] }}</td>
														<td>{{ $transaction['invoice_id'] }}</td>
														<td>{{ $transaction['paymanet_method'] }}</td>
														<td>{{ $transaction['status'] }}</td>
														<td>{{ $transaction['created_at'] }}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
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
