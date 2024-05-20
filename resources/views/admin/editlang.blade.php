@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Edit Language 
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
                            <li class="breadcrumb-item"><a href="{{ url('languages') }}">Localization</a></li>
                            <li class="breadcrumb-item active">Edit Language</li>
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
                                        aria-selected="true"><i data-feather="voicemail" class="me-2"></i>Language</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                    aria-labelledby="top-profile-tab">
                                    <form action="{{ route('admin.updatelang') }}" method="POST" class="needs-validation"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $langdata->id }}">
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4"><span class="text-danger">*</span>Language Name</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="title" name="lang_name"
                                                    value="{{ old('lang_name',$langdata->lang_name) }}" type="text" placeholder="Language Name">
                                                @error('lang_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom1" class="col-xl-3 col-md-4"><span class="text-danger">*</span>Code</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="code"  name="code"
                                                    value="{{ old('code',$langdata->code) }}" type="text" placeholder="Language Code">
                                                @error('code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom2" class="col-xl-3 col-md-4">Icon</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control dropify" id="icon" name="icon"
                                                    data-default-file="{{ asset('storage/app/public') }}/{{ $langdata->icon }}" type="file">
                                                @error('icon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom4" class="col-xl-3 col-md-4">
                                                Order</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input type="text" name="order_number" value="{{ $langdata->order_number }}" class="form-control">
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-md-4">Status</label>
                                            <div class="col-md-7">
                                                <div class="checkbox checkbox-primary">
                                                    <input id="checkbox-primary-2" type="checkbox" {{ ($langdata->status =='true')?'checked':'' }} name="status"
                                                        value="true" data-original-title="">
                                                    <label for="checkbox-primary-2">Enable the Language</label>
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
