@extends('layouts.layout')
@section('content')
	<div class="page-body">
		<!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-6">
						<div class="page-header-left">
							<h3>Blog category Lists
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
							<li class="breadcrumb-item">Blog category</li>
							<li class="breadcrumb-item active">Blog category Lists</li>
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
						<div class="card-header">

							<a href="{{ route($viewurl) }}" class="btn btn-primary mt-md-0 mt-2">Add new</a>
						</div>

						<div class="card-body">
							<div class="table-responsive table-desi">
								<table class="all-package coupon-table table table-striped">
									<thead>
										<tr>
											<th>Sr. No
												<!--span type="button"
												class="badge badge-primary add-row delete_all"><i class="fa fa-trash"></i></span-->
											</th>
											<th>Name</th>
											<th>Slug</th>
											<th>Icon</th>
											<th>Status</th>
											<!--th>Created On</th-->
											<th>Options</th>

										</tr>
									</thead>

									 <tbody>
									<!--tr><input type="hidden" value="{{ url('admin/deleteprong') }}" name="url" id="url"></tr-->
									<?php  $i=1; ?>
										@foreach($list as $item)
										<tr data-row-id="{{ $item->id }}">
											<td>
												<!---input class="checkbox_animated check-it" type="checkbox"
												value="" id="flexCheckDefault" data-id="{{ $item->id }}"-->
												<?= $i++; ?>
											</td>

											<td>{{ $item->name }}</td>
											<td>{{ $item->slug }}</td>
											<td><img src="{{env('AWS_URL') }}public/storage/{{ $item->icon }}"></td>

											<td >
												<span class="badge badge-{{ ($item->status =='true')?'success':'primary' }}">{{ ($item->status =='true')?'Active':'Inactive' }}</span>
											</td>

											<!--td class="list-date">{{ $item->created_at }}</td-->
											<td class="list-date">
											    <a href="{{ route($editurl, ['id' => $item->id]) }}">
													<i class="fa fa-edit" title="Edit"></i>
												</a>
											</td>
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
		<!-- Container-fluid Ends-->
	</div>
	@endsection
