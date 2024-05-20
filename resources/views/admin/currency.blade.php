@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Currency
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
                        <li class="breadcrumb-item">Localization</li>
                        <li class="breadcrumb-item active">Currency</li>
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
                       <a href="{{ route('admin.currencyview') }}" class="btn btn-primary">Add Currency</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package order-datatable" id="editableTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Currency Name</th>
                                        <th>Code</th>
                                        <th>Symbol</th>
                                        <th>Exchange Rate</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($currency as $item)
                                    <tr>
                                        <td data-field="text">{{ $item->id }}</td>
                                        <td data-field="text">{{ $item->name }}</td>

                                        <td data-field="text">{{ $item->code }}</td>
                                        <td data-field="text">{{ $item->symbol }}</td>

                                        <td> {{ $item->exchange_rate }} </td>

                                        <td data-field="number">{{ $item->order_number }}</td>
                                        <td><span
                                            class="badge badge-<?= $item->status == 'true' ? 'success' : 'primary' ?>">
                                            {{ $item->status == 'true' ? 'Active' : 'Inactive' }}</span></td>

                                        <td>
                                            <a href="{{ route('admin.editcurrency', ['id' => $item->id]) }}">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>

                                            <a href="javascript:void(0)" title="Delete Language"  onclick="deleteItem('{{ url('admin/deletecurrency') }}/{{ $item->id }}')" >
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