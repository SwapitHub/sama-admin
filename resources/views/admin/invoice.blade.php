
@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>INvoices
                            <small>Diamond Admin Panel</small>
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
                        <li class="breadcrumb-item">Order </li>
                        <li class="breadcrumb-item active">Invoice</li>
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
                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table trans-table all-package">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Order Id</th>
                                        <th>Amount</th>
                                        <th>Invoice Date</th>
                                        <th>Status</th>
                                        <th>option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $index=>$invoice)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $invoice->order_id }}</td>
                                        <td>${{ $invoice->amount }}</td>
                                        <td>{{ $invoice->created_at }}</td>
                                        <td>{{ $invoice->status }}</td>
                                        <td><a href="{{ route('order.invoices.view',['order_id'=>$invoice->order_id]) }}"><i class="fa fa-eye fa-2x" title="view"></i></a></td>
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

