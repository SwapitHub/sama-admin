@extends('layouts.layout')
@section('content')
	<div class="page-body">
		<!-- Container-fluid starts-->
		<div class="container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-lg-6">
						<div class="page-header-left">
							<h3>Subcategory Lists
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
							<li class="breadcrumb-item">Subcategory</li>
							<li class="breadcrumb-item active">Subcategory Lists</li>
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
							
							<a href="{{ route('admin.creatsubcategory') }}" class="btn btn-primary mt-md-0 mt-2">Create Subcategory</a>

							<form method="GET" style="display:flex">
								<input type="text" name="filter" class="form-control" value="{{ request()->input('filter') }}" placeholder="search" style="margin-left:3%">&ensp;
								<button class="btn btn-primary" type="search">Search</button>
							</form>
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
											<th>slug</th>
											<th>Menu</th>
											<th>Category</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Options</th>
											
										</tr>
									</thead>
									
									<tbody>
									<tr><input type="hidden" value="{{ url('deletesubcat') }}" name="url" id="url"></tr>
										@foreach($subcategories as $item)
										<tr data-row-id="{{ $item->id }}">
											<td>
												<input class="checkbox_animated check-it" type="checkbox"
												value="" id="flexCheckDefault" data-id="{{ $item->id }}">
											</td>
											
											<td>{{ $item->name }}</td>
											<td>{{ $item->slug }}</td>
											<td>{{ $item->menu_name }}</td>
											<td>{{ $item->catname }}</td>
											
											<td >
												<span class="badge badge-{{ ($item->status =='true')?'success':'primary' }}">{{ ($item->status =='true')?'Active':'Inactive' }}</span>
											</td>
											
											<td class="list-date">{{ $item->created_at }}</td>
											<td class="list-date">
											    <a href="{{ route('admin.editsubcat', ['id' => $item->id]) }}">
													<i class="fa fa-edit" title="Edit"></i>
												</a>	
											</td>
										</tr>
										@endforeach
									</tbody>
							</table> 
								<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
									<div>
										Showing {{ $subcategories->firstItem() }} to {{ $subcategories->lastItem() }} of total {{$subcategories->total()}} entries
									</div>
									<div class="float-end">
										<p>{{ $subcategories->links() }}</p>
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
	