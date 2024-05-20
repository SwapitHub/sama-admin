@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Transactions
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
                        <li class="breadcrumb-item">Localization</li>
                        <li class="breadcrumb-item active">Transactions</li>
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
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table trans-table all-package">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Id</th>
                                        <th>Transaction Id</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($transactions as $index=>$transaction)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td><a href="{{ route('sale.orders.detail',['id'=>$transaction->order_id]) }}" style="text-decoration:underline;color:blue !important">#{{ $transaction->order_id }}</a></td>

                                        <td>#{{ $transaction->transaction_id }}</td>

                                        <td>{{ date('M d, Y', strtotime($transaction->created_at)) }}</td>

                                        <td>{{ $transaction->paymanet_method }}</td>

                                        <td>{{ $transaction->status }}</td>

                                        <td>${{ $transaction->amount }}/-</td>
                                    </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
							<div>
								Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of total {{$transactions->total()}} entries
							</div>
							<div class="float-end">
								<p>{{ $transactions->links() }}</p>
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