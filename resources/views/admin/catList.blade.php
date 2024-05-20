@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Category
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
						<li class="breadcrumb-item">Product Management</li>
						<li class="breadcrumb-item active">Category</li>
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
						<a href="{{ route('admin.addcategory') }}" type="button" class="btn btn-primary add-row mt-md-0 mt-2">Add
						Category</a>

						<form method="GET" style="display:flex">
							<input type="text" name="filter" class="form-control" value="{{ request()->input('filter') }}" placeholder="search" style="margin-left:3%">&ensp;
							<button class="btn btn-primary" type="search">Search</button>
						</form>
					</div>
					
					<div class="card-body">
						<div class="table-responsive table-desi">
							<table class="table all-package table-category " id="editableTable">
								<thead>
									<tr>
										<th>
											<span type="button"
											class="badge badge-primary add-row delete_all"><i class="fa fa-trash"></i></span>
										</th>
										<th>Name</th>
										<th>Slug</th>
										<th>Status</th>
										<th>Menu</th>
										<th>Option</th>
									</tr>
								</thead>
								
								<tbody>
									@foreach($categories as $item)
									<tr><input type="hidden" value="{{ url('deletecategory') }}" name="url" id="url"></tr>
									<tr data-row-id="{{ $item->id }}">
										<td>
											<input class="checkbox_animated check-it" type="checkbox"
											value="" id="flexCheckDefault" data-id="{{ $item->id }}">
										</td>
										<td data-field="name">{{ $item->name }}</td>
										
										<td data-field="price">{{ $item->slug }}</td>
										
										<td class="" data-field="status">
											<span class="badge badge-{{ ($item->status =='true')?'success':'primary' }}">{{ ($item->status =='true')?'Active':'Inactive' }}</span>
										</td>
										
										<td data-field="name">{{ $item->menu_name }}</td>
										
										<td>
											<a href="{{ route('admin.editcategory',['id'=>$item->id]) }}">
												<i class="fa fa-edit" title="Edit"></i>
											</a>
											
											<a href="javascript:void(0)" onclick="deleteItem('{{ url('admin/deletecategory') }}/{{ $item->id }}')">
												<i class="fa fa-trash" title="Delete"></i>
											</a>
										</td>
									</tr>
									@endforeach
								</tbody>
								
							</table>
							<div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
								<div>
									Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of total {{$categories->total()}} entries
								</div>
								<div class="float-end">
									<p>{{ $categories->links() }}</p>
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
