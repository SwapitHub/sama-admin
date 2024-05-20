@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Add Currency 
                                <small>Dimond Admin panel</small>
                            </h3>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ol class="breadcrumb pull-right">
                            <li class="breadcrumb-item">
                                <a href="{{ url('admin/dashboard') }}">
                                    <i data-feather="home"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/currency') }}">Localization</a></li>
                            <li class="breadcrumb-item active">Add Currency</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
                                        href="#top-profile" role="tab" aria-controls="top-profile"
                                        aria-selected="true"><i data-feather="voicemail" class="me-2"></i>Currency</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                    aria-labelledby="top-profile-tab">
                                    <form action="{{ route('admin.addcurrency') }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4">Name</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                    value="{{ old('name') }}" type="text" placeholder="Currency Name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom1" class="col-xl-3 col-md-4">Code</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control @error('code') is-invalid @enderror" id="code" name="code"
                                                    value="{{ old('code') }}" type="text" placeholder="Language Code">
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom1" class="col-xl-3 col-md-4">Symbol</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control @error('symbol') is-invalid @enderror" id="symbol" name="symbol"
                                                    value="{{ old('symbol') }}" type="text" placeholder="symbol">
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom1" class="col-xl-3 col-md-4">Exchange rate</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control @error('exchange_rate') is-invalid @enderror" id="exchange_rate" name="exchange_rate"
                                                    value="{{ old('exchange_rate') }}" type="text" placeholder="Exchange Rate">
                                                @error('exchange_rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom4" class="col-xl-3 col-md-4">
                                                Order</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input type="text" name="order_number" value="0" class="form-control">
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">Status</label>
                                            <div class="col-md-7">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox-primary-2" type="checkbox" checked name="status"
                                                        value="true" data-original-title="">
                                                    <label for="checkbox-primary-2">Enable the Currency</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pull-left">
                                            <button type="submit" class="btn btn-primary submitBtn">Save <i
                                                    class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
                                        </div>
                                    </form>

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
