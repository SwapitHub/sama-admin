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
							<li class="breadcrumb-item">Customer</li>
							<li class="breadcrumb-item active">{{ $title }}</li>
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
							
							<a href="{{ $viewurl }}" class="btn btn-primary mt-md-0 mt-2">Add new</a>
						</div>
						
						<div class="card-body">
							<div class="table-responsive table-desi">
								<table class="all-package coupon-table table table-striped" >
									<thead>
										<tr>
											<th>
												SR
											</th>
											<th>Name</th>
											<th>Email</th>
	                                        <th>Role</th>
											<th>Status</th>
											<th>Options</th>
											
										</tr>
									</thead>
									
									 <tbody>
									@php $i=1; @endphp 
										@foreach($list as $item)
										<tr data-row-id="{{ $item->id }}">
											<td>
												{{ $i++; }}
											</td>
											
											<td>{{ $item->name }}</td>
											<td>{{ $item->email }}</td>
											<td><span class="badge badge-primary">{{ $item->role_name }}</span></td>
											<!--td>{{ $item->address??'NA' }}</td--->
											
											<td >
												<span class="badge badge-{{ ($item->status ==1)?'success':'primary' }}">{{ ($item->status ==1)?'Active':'Inactive' }}</span>
											</td>
											
											<!--td class="list-date">{{ $item->created_at }}</td>
											<td class="list-date">{{ $item->updated_at }}</td--->
											<td class="list-date">
											    <a href="{{ route($editurl, ['id' => $item->id]) }}">
													<i class="fa fa-edit" title="Edit"></i>
												</a>
												@if($item->name != 'admin')
													<a href="javascript:void(0)" onclick="deleteItem('{{ url('deleteuser') }}/{{ $item->id }}')">
														<i class="fa fa-trash" title="Delete"></i>
													</a>
												@endif
												
											    </a>	
											</td>
										</tr>
										@endforeach
									</tbody> 
								</table>
							</div>
							<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
								<div>
									Showing {{ $list->firstItem() }} to {{ $list->lastItem() }} of total {{$list->total()}} entries
								</div>
								<div class="float-end">
									<p>{{ $list->links() }}</p>
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
	