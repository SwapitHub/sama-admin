@extends('layouts.layout')
@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-6">
                    <div class="page-header-left">
                        <h3>Dashboard
                            <small>Dimond Admin panel</small>
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
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3 col-md-6 xl-50">
                <a href="{{ route('admin.widget.list') }}"><div class="card o-hidden widget-cards">
                    <div class="warning-box card-body">
                        <div class="media static-top-widget align-items-center">
                            <div class="icons-widgets">
                                <div class="align-self-center text-center">
                                    <i data-feather="navigation" class="font-warning"></i>
                                </div>
                            </div>
                            <div class="media-body media-doller">
                                <span class="m-0">Widget</span>
                                <h3 class="mb-0"> <span class="counter">{{ $widget }}</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div>
            <div class="col-xxl-3 col-md-6 xl-50">
                <a href="{{ route('admin.product.dblist') }}"><div class="card o-hidden widget-cards">
                    <div class="secondary-box card-body">
                        <div class="media static-top-widget align-items-center">
                            <div class="icons-widgets">
                                <div class="align-self-center text-center">
                                    <i data-feather="box" class="font-secondary"></i>
                                </div>
                            </div>
                            <div class="media-body media-doller">
                                <span class="m-0">Products</span>
                                <h3 class="mb-0"><span class="counter"><?= $productCount; ?></span><small> </small>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div>
            <div class="col-xxl-3 col-md-6 xl-50">
                <a href="{{ route('admin.customer.messagelist') }}"><div class="card o-hidden widget-cards">
                    <div class="primary-box card-body">
                        <div class="media static-top-widget align-items-center">
                            <div class="icons-widgets">
                                <div class="align-self-center text-center"><i data-feather="message-square" class="font-primary"></i></div>
                            </div>
                            <div class="media-body media-doller"><span class="m-0">Messages</span>
                                <h3 class="mb-0"><span class="counter">{{ $contactMsg; }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div>
            <div class="col-xxl-3 col-md-6 xl-50">
                <a href="{{ route('admin.customer') }}"><div class="card o-hidden widget-cards">
                    <div class="danger-box card-body">
                        <div class="media static-top-widget align-items-center">
                            <div class="icons-widgets">
                                <div class="align-self-center text-center"><i data-feather="users" class="font-danger"></i></div>
                            </div>
                            <div class="media-body media-doller"><span class="m-0">New Customers</span>
                                <h3 class="mb-0"><span class="counter">{{ $users }}</span></h3>
                            </div>
                        </div>
                    </div>
                </div></a>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

@endsection
