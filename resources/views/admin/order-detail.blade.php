@extends('layouts.layout')
@section('content')
<style>
    .cart-section .cart-table thead tr th {
        border-top: 0px solid #232323;
        border-bottom: 1px solid #e7e3e3 !important;
    }
</style>
<!-- Right sidebar Ends-->
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Order Details
                            <small>Sama Admin panel</small>
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
                        <li class="breadcrumb-item">Orders</li>
                        <li class="breadcrumb-item active">Order Details</li>
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
                        <div class="bg-inner cart-section order-details-table">
                            <div class="row g-4">
                                <div class="col-sm-12">
                                    @if ($invoice_count == 0)
                                    <button class="btn btn-outline-primary">Cancel</button>
                                    @endif

                                    @if ($invoice_count == 0)
                                    <button class="btn btn btn-outline-secondary" onclick="MakeInvoice('{{ $order->order_id }}')">Invoice</button>
                                    @endif
                                    <button class="btn btn btn-outline-secondary">Ship</button>
                                </div>
                                <div class="col-xl-8">
                                    <div class="card-details-title">
                                        <h3>Order Number <span>#{{ $order->order_id }}</span></h3>
                                    </div>
                                    <div class="table-responsive table-details">
                                        <table class="table cart-table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Items</th>
                                                    <th class="text-end" colspan="2">
                                                        <a href="javascript:void(0)" class="theme-color">Grand Total -
                                                            ${{ round($order->amount, 2) }}</a>
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $orderItems = getOrderItem($order->order_id);
                                                @endphp

                                                @php
                                                $ringImages = [];
                                                $diamondImages = [];
                                                $gemstoneImages = [];
                                                @endphp

                                                @foreach ($orderItems as $orderItem)
                                                @php
                                                $products = json_decode($orderItem->order_data);
                                                if (
                                                !empty($products->ring_id) &&
                                                !empty($products->diamond_id)
                                                ) {
                                                $ringImages[$orderItem->id] = getProductImages(
                                                $products->ring_id,
                                                $products->ring_color,
                                                );
                                                $diamondImages[$orderItem->id] = getDiamondImages(
                                                $products->diamond_id,
                                                );
                                                } elseif (
                                                !empty($products->ring_id) &&
                                                !empty($products->gemstone_id)
                                                ) {
                                                $ringImages[$orderItem->id] = getProductImages(
                                                $products->ring_id,
                                                $products->ring_color,
                                                );
                                                $gemstoneImages[$orderItem->id] = getGemStoneImages(
                                                $products->gemstone_id,
                                                );
                                                } elseif (!empty($products->diamond_id)) {
                                                $diamondImages[$orderItem->id] = getDiamondImages(
                                                $products->diamond_id,
                                                );
                                                } elseif (!empty($products->gemstone_id)) {
                                                $gemstoneImages[$orderItem->id] = getGemStoneImages(
                                                $products->gemstone_id,
                                                );
                                                }
                                                @endphp

                                                <tr class="table-order">
                                                    @php
                                                    $ringImage = isset($ringImages[$orderItem->id])
                                                    ? $ringImages[$orderItem->id]
                                                    : null;
                                                    $diamondImage = isset($diamondImages[$orderItem->id])
                                                    ? $diamondImages[$orderItem->id]
                                                    : null;
                                                    $gemstoneImage = isset($gemstoneImages[$orderItem->id])
                                                    ? $gemstoneImages[$orderItem->id]
                                                    : null;
                                                    @endphp 
                                                    <td>
                                                        <div class="d-flex ">
                                                            @if ($ringImage)
                                                            <img src="{{ $ringImage }}" alt="" class="blur-up lazyload border" style="width:60px; height: 60px; border-radius:5px"> &nbsp;
                                                            @endif
                                                            @if ($diamondImage)
                                                            <img src="{{ $diamondImage->image_url }}" alt="" class="blur-up lazyload border" style="width:60px; height: 60px; border-radius:5px"> &nbsp;
                                                            @endif
                                                            @if ($gemstoneImage)
                                                            <img src="{{ $gemstoneImage->image_url }}" alt="" class="blur-up lazyload border" style="width:60px; height: 60px;  border-radius:5px">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p>Product Description</p>
                                                        <h5>
                                                            @if (isset($products->ring_id))
                                                            {{ getRingName($products->ring_id) }} <br>
                                                            @endif
                                                            @if ($diamondImage)
                                                            {{ $diamondImage->shape }} {{ $diamondImage->size }}
                                                            @endif
                                                            @if ($gemstoneImage)
                                                            {{ $gemstoneImage->shape }}
                                                            {{ $gemstoneImage->size }}
                                                            @endif
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <p>
                                                            @if (!empty($products->ring_size))
                                                            Size
                                                            @endif
                                                        </p>
                                                        <h5>{{ $products->ring_size }} @if (!empty($products->ring_size))
                                                            ({{ ucfirst($products->ring_type) }})
                                                            @endif
                                                        </h5>
                                                    </td>
                                                    <td>
                                                        <p>Price</p>
                                                        <h5>${{ round($products->ring_price + $products->diamond_price + $products->gemstone_price, 2) }}
                                                        </h5>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                                <tr class="table-order">
                                                    <td colspan="3">
                                                        <h5>Subtotal :</h5>
                                                    </td>
                                                    <td>
                                                        <h4>${{ round($order->amount, 2) }}</h4>
                                                    </td>
                                                </tr>

                                                <tr class="table-order">
                                                    <td colspan="3">
                                                        <h5>Shipping :</h5>
                                                    </td>
                                                    <td>
                                                        <h4>$0.00</h4>
                                                    </td>
                                                </tr>

                                                <tr class="table-order">
                                                    <td colspan="3">
                                                        <h5>Tax(GST) :</h5>
                                                    </td>
                                                    <td>
                                                        <h4>$0.00</h4>
                                                    </td>
                                                </tr>

                                                <tr class="table-order">
                                                    <td colspan="3">
                                                        <h4 class="theme-color fw-bold">Total Price :</h4>
                                                    </td>
                                                    <td>
                                                        <h4 class="theme-color fw-bold">${{ round($order->amount, 2) }}
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="order-success bg-white">
                                                <h4>summery</h4>
                                                <ul class="order-details">
                                                    <li>Order ID: {{ $order->order_id }}</li>
                                                    <li>Order Date:
                                                        {{ date('M d , Y', strtotime($order->created_at)) }}
                                                    </li>
                                                    <li>Order Total: ${{ round($order->amount, 2) }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                       
                                    @if(!empty($address))
                                        @foreach ($address as $add)
                                        <div class="col-12">
                                            <div class="order-success bg-white">
                                                <h4>  
                                                    @if ($add->address_type =='shipping_address')
                                                       Shipping address
                                                    @elseif ($add->address_type =='billing_address')
                                                        Billing  address
                                                    @else
                                                         Shipping address
                                                    @endif
                                                </h4>
                                                <ul class="order-details">
                                                    <li>{{ $add->first_name }} {{ $add->last_name }}</li>
                                                    <li>{{ $add->address_line1 }} .</li>
                                                    @if (!empty($add->address_line2))
                                                    <li>{{ $add->address_line2 }}</li>
                                                    @endif
                                                    <li>{{ $add->country }}, {{ $add->zipcode }} Contact No.
                                                        {{ $add->phone }}
                                                    </li>
                                                    <br>
                                                    @if ($add->address_type =='both')
                                                    
                                                        <h5>  Billing address is same as shipping address.</h5>
                                                   
                                                    @endif

                                                  

                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                        <div class="col-12">
                                            <div class="order-success bg-white">
                                                <div class="payment-mode">
                                                    <h4>payment method</h4>
                                                    <p>Pay on Delivery (Cash/Card). Cash on delivery (COD)
                                                        available. Card/Net banking acceptance subject to
                                                        device availability.</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($invoice_count > 0)
                                        <div class="col-12">
                                            <div class="order-success bg-white">
                                                <div class="payment-mode">
                                                    <h4>Invoice ({{ $invoice_count }})</h4>
                                                    <p>Invoice #{{ $invoice->id }} </p>
                                                    <span>
                                                        {{ date('d M, Y H:i:sA', strtotime($invoice->created_at)) }}
                                                    </span>

                                                    <p class="mt-2">
                                                        <a href="{{ route('order.invoices.view', ['order_id' => $order->order_id]) }}">View</a>
                                                        &ensp;
                                                        <a href="{{ route('sale.orders.invoice.download',['order_id'=>$order->order_id]) }}">Download</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-12">
                                            <div class="order-success bg-white">
                                                <div class="delivery-sec">
                                                    <h3>expected date of delivery: <span>october 22,
                                                            2021</span></h3>
                                                    <a href="#">track order</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- section end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@push('scripts')
<script>
    function MakeInvoice(order_id) {
        var url = "{{ url('/orders/invoice/') }}" + '/' + order_id;
        swal({
                title: "Are you sure?",
                text: "You want to create invoice!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        method: "GET",
                        success: function(response) {
                            console.log(response);
                            if (response == 'true') {
                                swal("Good job!", "Invoice generated successfully!", "success");
                                // swal(jsonres.res, {
                                //     icon: "Invoice Created",
                                // });
                                setTimeout(function() {
                                    window.location.reload();
                                }, 900);
                            }
                        },
                        error: function(response) {
                            console.log(response);
                        }
                    })
                } else {
                    swal("OK");
                }
            });

    }
</script>
@endpush
@endsection