@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Order List
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
                            <li class="breadcrumb-item">Orders</li>
                            <li class="breadcrumb-item active">Order List</li>
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
                            <div class="table-responsive table-desi ">
                                <table class="table all-package table-hover" id="editableTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order Id / Date / Statue</th>
                                            <th>Grand Total / Paymemt Method</th>
                                            <th>Custome / Email </th>
                                            <th>Product</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($orders as $index => $order)
                                            @php
                                                $orderItem = getOrderItem($order->order_id);
                                                $redirect_url = route('sale.orders.detail', ['id' => $order->id]);
                                            @endphp
                                           <tr onclick=window.location="{{ $redirect_url }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td class="text-start">
                                                    #{{ $order->order_id }}
                                                    <br> <span>{{ $order->created_at }}</span> <span
                                                        class="badge badge-{{ $order->status == 'SUCCESS' ? 'success' : 'primary' }}">{{ $order->status }}</span>
                                                </td>
                                                <td data-field="number">$
                                                    {{ $order->amount }} / {{ $order->method }}
                                                </td>

                                                <td data-field="date">
                                                    <span>{{ $order->first_name }} {{ $order->last_name }}</span> <br>
                                                    <span>{{ $order->email }}</span>
                                                </td>
                                                <td class="d-flex">
                                                    @foreach ($orderItem as $orderItem)
                                                        <?php
                                                            $products = json_decode($orderItem->order_data);
                                                            $ringImage = null;
                                                            $diamondImage = null;
                                                            $gemstoneImage = null;
                                                
                                                            if (!empty($products->ring_id) && !empty($products->diamond_id)) {
                                                                $ringImage = getProductImages($products->ring_id, $products->ring_color);
                                                                $diamondImage = getDiamondImages($products->diamond_id);
                                                            } elseif (!empty($products->ring_id) && !empty($products->gemstone_id)) {
                                                                $ringImage = getProductImages($products->ring_id, $products->ring_color);
                                                                $gemstoneImage = getGemStoneImages($products->gemstone_id);
                                                            } elseif (!empty($products->diamond_id)) {
                                                                $diamondImage = getDiamondImages($products->diamond_id);
                                                            } elseif (!empty($products->gemstone_id)) {
                                                                $gemstoneImage = getGemStoneImages($products->gemstone_id);
                                                            }
                                                        ?>
                                                        <div class="d-flex border p-2">
                                                            @if ($ringImage)
                                                                <img src="{{ $ringImage }}" alt="">
                                                            @endif
                                                            @if ($diamondImage)
                                                                <img src="{{ $diamondImage->image_url }}" alt="">
                                                            @endif
                                                            @if ($gemstoneImage)
                                                                <img src="{{ $gemstoneImage->image_url }}" alt="">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </td>
                                                
                                                

                                          

                                                <td>
                                                    <a href="{{ route('sale.orders.detail', ['id' => $order->id]) }}">
                                                        <i class="fa fa-angle-right fw-bold" title="View"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                             <div class="dataTables_paginate paging_simple_numbers d-flex justify-content-between align-items-center">
                                <div>
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of total {{$orders->total()}} entries
                                </div>
                                <div class="float-end">
                                    <p>{{ $orders->links() }}</p>
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
