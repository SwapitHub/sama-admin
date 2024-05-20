@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Cms category
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
                        <li class="breadcrumb-item">Cms</li>
                        <li class="breadcrumb-item active">Cms category</li>
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
                       <a href="{{ route('admin.addcmscategory') }}" class="btn btn-primary">Add Category</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package order-datatable" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>slug</th>
                                        <!--th>Order</th-->
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach ($category as $item)
                                    <tr>
                                        <td data-field="text">{{ $i++ }}</td>
                                        <td data-field="text">{{ $item->name }} <span
                                            class="badge badge-dark"  data-bs-toggle="tooltip" data-bs-placement="top" title="Order">
                                            {{ $item->order_number }}</span></td>

                                        <td data-field="text">{{ $item->slug }}</td>
                            
                                        <!--td data-field="number">{{ $item->order_number }}</td-->
                                        <td><span
                                            class="badge badge-<?= $item->status == 'true' ? 'success' : 'primary' ?>">
                                            {{ $item->status == 'true' ? 'Active' : 'Inactive' }}</span></td>

                                        <td>
                                            <a href="{{ route('admin.editcmscategory', ['id' => $item->id]) }}">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>

                                            <a href="javascript:void(0)" title="Delete Language"  onclick="deleteItem('{{ url('cms_deletecategory') }}/{{ $item->id }}')" >
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