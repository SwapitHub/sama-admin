<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .logo {
            height: 30px;
        }

        .invoice_no {
            text-align: right;
        }

        .address_type {
            padding: 10px;
        }
    </style>
</head>

<body>


    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="http://ec2-3-18-62-57.us-east-2.compute.amazonaws.com/admin/storage/app/public/images/1702918606_1702885018_samaLogo.png" alt="Logo" class="logo" />
            </td>
            <td class="w-half">
                <h3 class="invoice_no">Invoice: #{{ $invoiceId }}</h3>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div class="address_type">Hello, {{ $order->first_name }} {{ $order->last_name }}.<br>
                        Thank you for shopping from our store and for your order.
                    </div>
                </td>
                <td class="w-half">
                    <div class="address_type">
                        <span>Order Id : {{ $order->order_id }}</span> <br>
                        <span>{{ date('M d , Y',strtotime($order->created_at)) }}</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Product Images</th>
                <th>Details</th>
                <th>Price</th>
            </tr>

            @php
            $ringImages = [];
            $diamondImages = [];
            $gemstoneImages = [];
            @endphp
            @foreach ($orderItems as $orderItem)
            @php
            $products = json_decode($orderItem->order_data);
            if (!empty($products->ring_id) &&!empty($products->diamond_id))
            {
            $ringImages[$orderItem->id] = getProductImages($products->ring_id,$products->ring_color);
            $diamondImages[$orderItem->id] = getDiamondImages($products->diamond_id);
            }
            elseif (!empty($products->ring_id) &&!empty($products->gemstone_id)) {
            $ringImages[$orderItem->id] = getProductImages($products->ring_id,$products->ring_color);
            $gemstoneImages[$orderItem->id] = getGemStoneImages($products->gemstone_id);
            } elseif (!empty($products->diamond_id)) {
            $diamondImages[$orderItem->id] = getDiamondImages($products->diamond_id);
            } elseif (!empty($products->gemstone_id)) {
            $gemstoneImages[$orderItem->id] = getGemStoneImages($products->gemstone_id);
            }
            @endphp


            <tr class="items">

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
                    <div style="display:flex; margin-top:5px;">
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
                </td>
                <td>
                    ${{ round($orderItem->total_amount, 2) }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        Sub Total: ${{ round($order->amount, 2) }}
    </div>
    <div class="total">
        Shipping: $0
    </div>
    <div class="total">
        Tax(GST) :$0
    </div>
    <hr>
    <div class="total">
        Total: ${{ round($order->amount, 2) }}
    </div>

    <table class="w-full">
        <tr>
            @if(!empty($address))

            @foreach($address as $add)
            <td class="w-half">
                <div class="address_type">
                    @if($add->address_type =='shipping_address')
                    Shipping Address
                    @elseif($add->address_type =='billing_address')
                    Billing Address
                    @else
                    Billing Address
                    @endif
                    ,
                    <br>
                    {{ ucwords($add->address_line1) }}<br>
                    @if(!empty($add->address_line2)){{ ucfirst($add->address_line1) }}@endif
                    {{ ucfirst($add->city) }}, <br> Zip Code : {{ $add->zipcode }}<br>
                    Phone: {{ $add->phone }}
                </div>
            </td>
            @if($add->address_type =='both')
            <td class="w-half">
            <div class="address_type">
                    Billing Address,
                    <br>
                    {{ ucwords($add->address_line1) }}<br>
                    @if(!empty($add->address_line2)){{ ucfirst($add->address_line1) }}@endif
                    {{ ucfirst($add->city) }}, <br> Zip Code : {{ $add->zipcode }}<br>
                    Phone: {{ $add->phone }}
                </div>
            </td>
            @endif
            @endforeach
            @endif


        </tr>
    </table>

    <div class="footer margin-top">
        <div>Thank you</div>
        <div>&copy; Sama</div>
    </div>
</body>

</html>