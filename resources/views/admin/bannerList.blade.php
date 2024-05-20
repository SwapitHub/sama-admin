@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Banner List
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
                            <li class="breadcrumb-item"><a href="{{ url('addbanner') }}">Add Banner</a></li>
                            <li class="breadcrumb-item active">Banner List</li>
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
                        <!-- <div class="card-header">
                                                <h5>Manage Order</h5>
                                            </div> -->
                        <div class="card-body order-datatable">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Banner Id</th>
                                        <th>Title</th>
                                        <th>Sub Title</th>
                                        <th>Banner</th>
                                        <th>Status</th>
                                        <th>Banner Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bannerlist as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                {{ $item->title }}
                                            </td>
                                            <td> {{ $item->subtitle }}</td>
                                            <td>
                                                <center><a href="{{ asset('storage/app/public') . '/' . $item->banner }}"
                                                        alt="{{ $item->title }}" target="_blank"><img
                                                            src="{{ asset('storage/app/public') . '/' . $item->banner }}"
                                                            alt="{{ $item->title }}"
                                                            style="height: 100px; width:100px"></a></center>
                                            </td>
                                            <td><span
                                                    class="badge badge-<?= $item->status == 'true' ? 'success' : 'primary' ?>">
                                                    {{ $item->status == 'true' ? 'Active' : 'Inactive' }}</span></td>
                                            <td> {{ $item->type }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('admin.getedit', ['id' => $item->id]) }}"
                                                        title="Edit Banner"><i class="fa fa-edit me-2 font-success"></i></a>
                                                    <a href="javascript:void(0)"
                                                        onclick="deleteItem('{{ url('deletebanner') }}/{{ $item->id }}')"
                                                        title="Delete Banner"><i class="fa fa-trash font-danger"></i></a>
                                                </div>
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
        <!-- Container-fluid Ends-->
    </div>
@endsection
