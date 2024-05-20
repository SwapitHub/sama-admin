@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Menu Lists
							<small>Diamond Admin panel</small>
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
						<li class="breadcrumb-item">Menus</li>
						<li class="breadcrumb-item active">Menu Lists</li>
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
						
						<a href="{{ route('admin.createmenu') }}" class="btn btn-primary mt-md-0 mt-2">Create Menu</a>
					</div>
					
					<div class="card-body">
						<div class="table-responsive table-desi">
							<table class="all-package coupon-table table table-striped">
								<thead>
									<tr>
										<th>
											<span type="button"
											class="badge badge-primary add-row delete_all"><i class="fa fa-trash"></i></span>
										</th>
										<th>Name</th>
										<th>Slug</th>
										<!--th>Order</th-->
										<th>Status</th>
										<!--th>Created On</th-->
										<th>Options</th>
										
									</tr>
								</thead>
								
								<tbody>
									<tr><input type="hidden" value="{{ url('deletemenu') }}" name="url" id="url"></tr>
									@foreach($menus as $item)
									<tr data-row-id="{{ $item->id }}">
										<td>
											<input class="checkbox_animated check-it" type="checkbox"
											value="" id="flexCheckDefault" data-id="{{ $item->id }}">
										</td>
										
										<td>{{ $item->name }} <span data-bs-toggle="tooltip" data-bs-placement="top" title="Order" class="badge badge-dark">{{ $item->order_number }}</span></td>
										<td>{{ $item->slug }}</td>
										<!--td>{{ $item->order_number }}</td-->
										
										<td >
											<span class="badge badge-{{ ($item->status =='true')?'success':'primary' }}">{{ ($item->status =='true')?'Active':'Inactive' }}</span>
										</td>
										
										<!--td class="list-date">{{ $item->created_at }}</td-->
										<td class="list-date">
											<a href="{{ route('admin.editmenu', ['id' => $item->id]) }}">
												<i class="fa fa-edit" title="Edit"></i>
											</a>	
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
                            <div>
                                Showing {{ $menus->firstItem() }} to {{ $menus->lastItem() }} of total {{$menus->total()}} entries
                            </div>
                            <div class="float-end">
                                <p>{{ $menus->links() }}</p>
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
