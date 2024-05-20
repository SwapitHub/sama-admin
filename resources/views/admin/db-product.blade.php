@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>Products
							<small>Diamond Admin panel</small>
						</h3>
					</div>
				</div>
				<div class="col-lg-6">
					<ol class="breadcrumb pull-right">
						<li class="breadcrumb-item">
							<a href="{{ route('admin.dashboard') }}">
								<i data-feather="home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">Products</li>
						<li class="breadcrumb-item active">Products List</li>
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
					<div class="card-header" style="display:initial">

						<div class="row" role="group" aria-label="Basic outlined example">
							<div class="col-md-8">
								<form method="GET" style="display:flex">
									<input type="text" name="filter" class="form-control" value="{{ request()->input('filter') }}" placeholder="search by SKU,NAME,ENTITY ID" style="margin-left:3%">&ensp;
									<button class="btn btn-primary" type="search">Search</button>
								</form>
							</div>
							<div class="col-md-4 float-right">
								<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal">import <i class="fa fa-upload"></i></button>
								<a href="{{ route('admin.product.export') }}" type="button" class="btn btn-secondary">Export <i class="fa fa-download"></i></a>
							</div>
						</div>
						<div class="card-body">
							<div class="add-product">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Product</button>
							</div>

							<br>
							<div class="table-responsive table-desi">
								<table class="all-package coupon-table table table-striped">
									<thead>
										<tr>
											<th>
												Sr. No
											</th>
											<th>Name</th>
											<th>Sku</th>
											<th>status</th>
											<th>Menu</th>
											<th>Categories</th>
											<th>Sub Categories</th>
											<th>Description</th>
											<th>Metal Color</th>
											<th>Options</th>

										</tr>
									</thead>
									<tbody>
										@foreach($list as $index=>$item)
										<tr>
											<td>{{ $index+1 }}</td>
											<td>{{ $item->name }}</td>
											<td>{{ $item->sku }}</td>
											<td class="text-uppercase"> <span class="badge badge-{{ ($item->status=='true')?'success':'primary' }}">{{ $item->status }}</span> </td>
											<td>{{ getMenu($item->menu) }}</td>
											<td>{{ getCategories($item->category) }}</td>
											<td> {{ ($item->sub_category != null)?getSubCategories($item->sub_category):"NA"; }} </td>
											<td>{{ substr($item->description,0,30) }} ...</td>
											<td>{{ $item->metalColor }}</td>
											<td>
												<a href="{{ url('/db-product-list/edit') }}/{{ $item->id }}" title="Edit"><i class="fa fa-edit"></i></a>
												<a href="{{ url('/db-product-list/edit') }}/{{ $item->id }}" title="Edit"><i class="fa fa-trash"></i></a>
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
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Import Product</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
				</div>
				<form action="{{ $action_url }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="">Menu</label>
							<select name="menu" id="" required class="form-control">
								<option selected disabled>choose menu</option>
								@foreach ($menus as $menu)
								<option value="{{ $menu->name }}">{{ $menu->name }}</option>
								@endforeach
							</select>
						</div>


						<input type="file" name="excel_file" required class="form-control" accept=".xlsx, .xls, .csv">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- create product model --}}
	<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addModalLabel">Add Product</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
				</div>
				<form action="{{ $create_url }}" method="POST" id="createProduct">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="">Type <span>*</span></label>
							<select name="type" id="product_type" required class="form-control">
								<option value="Simple" selected>Simple</option>
								<option value="Configurable">Configurable </option>
							</select>
						</div>
						<div class="form-group">
							<label for="">SKU <span>*</span></label>
							<input type="text" name="sku" id="sku" required class="form-control">
							<span class="errors"></span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- cerate Configurable modal --}}
	<div class="modal fade" id="configurableModel" tabindex="-1" aria-labelledby="configurableModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="configurableModelLabel">Configurable Attributes</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
				</div>
				<form action="{{ route('admin.product.configurable') }}" method="POST">
					@csrf
					<div class="modal-body">
						<div class="form-group">
							<label for="">Choose attributes <span>*</span></label>
							<select name="carat[]" id="product_carat" multiple required class="form-control multichoose">
								@php
								$counter = 1;
								@endphp
								@foreach($carats as $carat)
								<option value="{{ $carat['carat'] }}" {{ $counter <= 5 ? 'selected' : '' }}>{{ $carat['carat'] }} CT</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							{{-- <label for="">SKU <span>*</span></label> --}}
							<input type="hidden" name="parent_sku" id="parent_sku" required class="form-control">
							<input type="hidden" name="its_type" id="its_type" required class="form-control">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@push('scripts')
	<script>
		$("#createProduct").submit(function(event) {
			event.preventDefault();
			var type = $("#product_type").val();
			var sku = $("#sku").val();
			var formData = {
				'type': type,
				'sku': sku
			}

			$.ajax({
				method: "POST",
				url: "{{ route('admin.product.create') }}",
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(res) {
					console.log(res);
					if (res.res == 'error') {
						$(".errors").html(res.msg[0]);
					}
					if (res.res == 'success') {
						if (res.msg == 'load_model') {
							$("#addModal").modal('hide');
							$("#configurableModel").modal('show');
							$("#parent_sku").val(res.sku);
							$("#its_type").val(res.its_type);
						}
						if (res.is_redirect == 'true') {
							window.location.href = res.redirect_to;
						}
					}
				},
				error: function(res) {
					consloe.log(res);
					$("#errors").html(res.msg);
				}

			})

		});
	</script>

	@endpush
	@endsection