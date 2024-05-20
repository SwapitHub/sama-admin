@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Language
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
                        <li class="breadcrumb-item active">Languages</li>
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
                       <a href="{{ route('admin.langview') }}" class="btn btn-primary">Add Language</a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table all-package order-datatable" id="editableTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Language Name</th>
                                        <th>Code</th>
                                        <th>Icon</th>
                                        <!--th>Order</th-->
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($langlist as $item)
                                    <tr>
                                        <td data-field="text">{{ $item->id }}</td>
                                        <td data-field="text">{{ $item->lang_name }}  <span
                                            class="badge badge-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Order">
                                            {{ $item->order_number  }}</span></td>

                                        <td data-field="text">{{ $item->code }}</td>

                                        <td> <img src="{{ asset('storage/app/public') }}/{{ $item->icon }}" alt=""> </td>

                                        <!--td data-field="number">{{ $item->order_number }}</td-->
                                        <td><span
                                            class="badge badge-<?= $item->status == 'true' ? 'success' : 'primary' ?>">
                                            {{ $item->status == 'true' ? 'Active' : 'Inactive' }}</span></td>

                                        <td>
                                            <a href="{{ route('admin.editlang', ['id' => $item->id]) }}">
                                                <i class="fa fa-edit" title="Edit"></i>
                                            </a>

                                            <a href="javascript:void(0)" title="Delete Language"  onclick="deleteItem('{{ url('admin/deletelang') }}/{{ $item->id }}')" >
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