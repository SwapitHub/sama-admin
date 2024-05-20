@extends('layouts.layout')
@section('content')
<style>
	.pagination a {
    padding: 5px;
	border: 1px solid;
	}	
	.pagination span.current {
    padding: 5px;
    border: 1px solid;
	font-weight: 750;
	}
</style>
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
							<a href="index.html">
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
						
						<!---div class="btn-group" role="group" aria-label="Basic outlined example"-->
							<a href="{{ url('product-list') }}" type="button" class="btn btn-outline-primary active">APIs Product</a>
							<a href="{{ url('db-product-list') }}" type="button" class="btn btn-outline-primary">Database Product</a>
						<!--/div--->
					</div>
					
					<div class="card-body">
						<div class="table-responsive table-desi">
							<table class="all-package coupon-table table table-striped">
								<thead>
									<tr>
										<th>
											Sr. No
										</th>
										<th>Name</th>
										<th>sku</th>
										<th>description</th>
										<th>Metal Color</th>
										
									</tr>
								</thead>
								<tbody>
									@foreach($list as $item)
									
									<tr>
										<td>{{ $item['entity_id'] }}</td>	
										<td>{{ $item['name'] }}</td>	
										<td>{{ $item['sku'] }}</td>	
										<td>{{ $item['description'] }}</td>	
										<td>{{ $item['metalColor'] }}</td>	
										
									</tr>
								@endforeach
								</tbody>
								</table>
								<?php
									// Define the total number of items and items per page
									$totalItems = $totalcount; // Replace this with your actual total number of items
									$itemsPerPage = 30;
									
									// Calculate the total number of pages
									$totalPages = ceil($totalItems / $itemsPerPage);
									
									// Get the current page number from the query string (assuming you're using GET)
									$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
									
									// Make sure the current page is within the valid range
									$current_page = max(1, min($totalPages, intval($current_page)));
									
									// Calculate the offset for the SQL query
									$offset = ($current_page - 1) * $itemsPerPage;
								
								// Now you can use $offset and $itemsPerPage in your SQL query to fetch the data for the current page
								echo '<div class="pagination">';
								$onEachSide = 10; // Adjust this value to control the number of links displayed on each side
								
								$startPage = max(1, $current_page - $onEachSide);
								$endPage = min($totalPages, $current_page + $onEachSide);
								
								for ($i = $startPage; $i <= $endPage; $i++) {
									if ($i == $current_page) {
										echo "<span class='current'>$i</span>";
										} else {
										echo "<a href='?page=$i'>$i</a>";
									}
								}
								
								echo '</div>';
								?>
								
								
								
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Container-fluid Ends-->
</div>
@endsection
