@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Widget 
                            <small>Diamond Admin panel</small>
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
                        <li class="breadcrumb-item">widget</li>
                        <li class="breadcrumb-item active">widget List</li>
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
						<a href="{{ route($viewurl) }}" class="btn btn-primary">Add New</a>
					</div>
					
                    <div class="card-body">
                        <div class="table-responsive table-desi">
							<table class="table all-package order-datatable" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Link</th>
                                        <th>Status</th>
										<!--th>Order</th-->
                                        <th>Option</th>
									</tr>
								</thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($list as $item)
                                    <tr>
                                        <td data-field="text">{{$i++ }}</td>
                                        <td data-field="text">{{ $item->name }} </td>
                                        <td data-field="text">{{ $item->url }}</td>
                                        <td>
											<span class="badge badge-<?= $item->status == 'true' ? 'success' : 'primary' ?>">
											{{ $item->status == 'true' ? 'Active' : 'Inactive' }}</span>
										</td>
									
										<td>
											<a href="{{ route('admin.edit.widget', ['id' => $item->id]) }}">
												<i class="fa fa-edit" title="Edit"></i>
											</a>
											
											<a href="javascript:void(0)" title="Delete Language"  onclick="deleteItem('{{ url('deletewidget') }}/{{ $item->id }}')" >
												<i class="fa fa-trash" title="Delete"></i>
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