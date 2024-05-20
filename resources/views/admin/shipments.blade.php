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
                        <form class="form-inline search-form search-box">
                            <div class="form-group">
                                <input class="form-control-plaintext" type="search" placeholder="Search..">
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-desi">
                            <table class="table trans-table all-package">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Transaction Id</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>142</td>

                                        <td>#212145214510</td>

                                        <td>Jul 20, 2021</td>

                                        <td>Paypal</td>

                                        <td>Pending</td>

                                        <td>$175/-</td>
                                    </tr>

                                    <tr>
                                        <td>217</td>

                                        <td>#784561421721</td>

                                        <td>Jul 25, 2021</td>

                                        <td>Paypal</td>

                                        <td>Process</td>

                                        <td>$845/-</td>
                                    </tr>

                                    <tr>
                                        <td>546</td>

                                        <td>#476547821142</td>

                                        <td>Jul 29, 2021</td>

                                        <td>Stripe</td>

                                        <td>Delivered</td>

                                        <td>$314/-</td>
                                    </tr>

                                    <tr>
                                        <td>671</td>

                                        <td>#745384127541</td>

                                        <td>Jul 30, 2021</td>

                                        <td>Paypal</td>

                                        <td>Pending</td>

                                        <td>$217/-</td>
                                    </tr>

                                    <tr>
                                        <td>565</td>

                                        <td>#96725125102</td>

                                        <td>Aug 01, 2021</td>

                                        <td>Stripe</td>

                                        <td>Process</td>

                                        <td>$542/-</td>
                                    </tr>

                                    <tr>
                                        <td>754</td>

                                        <td>#547121023651</td>

                                        <td>Aug 10, 2021</td>

                                        <td>Stripe</td>

                                        <td>Pending</td>

                                        <td>$2141/-</td>
                                    </tr>

                                    <tr>
                                        <td>164</td>

                                        <td>#876412242215</td>

                                        <td>Aug 18, 2021</td>

                                        <td>Paypal</td>

                                        <td>Delivered</td>

                                        <td>$4872/-</td>
                                    </tr>

                                    <tr>
                                        <td>841</td>

                                        <td>#31534221621</td>

                                        <td>Aug 29, 2021</td>

                                        <td>Paypla</td>

                                        <td>Process</td>

                                        <td>$7841/-</td>
                                    </tr>

                                    <tr>
                                        <td>354</td>

                                        <td>#78412457421</td>

                                        <td>Sep 09, 2021</td>

                                        <td>Paypal</td>

                                        <td>Pending</td>

                                        <td>$2784/-</td>
                                    </tr>

                                    <tr>
                                        <td>784</td>

                                        <td>#241524757448</td>

                                        <td>Sep 17, 2021</td>

                                        <td>Stripe</td>

                                        <td>Delivered</td>

                                        <td>$461/-</td>
                                    </tr>

                                    <tr>
                                        <td>142</td>

                                        <td>#212145214510</td>

                                        <td>Sep 20, 2021</td>

                                        <td>Stripe</td>

                                        <td>Pending</td>

                                        <td>$175/-</td>
                                    </tr>

                                    <tr>
                                        <td>217</td>

                                        <td>#784561421721</td>

                                        <td>Dec 10, 2021</td>

                                        <td>Stripe</td>

                                        <td>Process</td>

                                        <td>$845/-</td>
                                    </tr>

                                    <tr>
                                        <td>546</td>

                                        <td>#476547821142</td>

                                        <td>Feb 15, 2021</td>

                                        <td>Stripe</td>

                                        <td>Delivered</td>

                                        <td>$314/-</td>
                                    </tr>

                                    <tr>
                                        <td>671</td>

                                        <td>#745384127541</td>

                                        <td>Mar 27, 2021</td>

                                        <td>Paypal</td>

                                        <td>Pending</td>

                                        <td>$217/-</td>
                                    </tr>

                                    <tr>
                                        <td>565</td>

                                        <td>#96725125102</td>

                                        <td>Sep 1, 2021</td>

                                        <td>Stripe</td>

                                        <td>Process</td>

                                        <td>$542/-</td>
                                    </tr>
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