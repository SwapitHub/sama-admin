@extends('layouts.layout')
@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="page-header-left">
                            <h3>Profile
                                <small>Dimond Admin panel</small>
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
                            <li class="breadcrumb-item">Settings</li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="profile-details text-center">
                                <img src="assets/images/dashboard/designer.jpg" alt=""
                                    class="img-fluid img-90 rounded-circle blur-up lazyloaded">
                                <h5 class="f-w-600 mb-0">Sama Admin Panel</h5>
                                <span>{{ Auth::user()->email }}</span>
                            </div>
                            <hr>
                            <div class="project-status">
                                <div class="table-responsive profile-table">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <td>Login Status :</td>
                                                <td><span class="badge badge-success">True</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Admin ID :</td>
                                                <td><span class="badge badge-dark">{{ Auth::user()->id }}</span>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Admin Email :</td>
                                                <td>{{ Auth::user()->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>Mobile Number :</td>
                                                <td>0123456789</td>
                                            </tr>
                                            <tr>
                                                <td>Designation :</td>
                                                <td>{{ Auth::user()->designation }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="card tab2-card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-material" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-profile-tab" data-bs-toggle="tab"
                                        href="#top-profile" role="tab" aria-controls="top-profile"
                                        aria-selected="true"><i data-feather="user" class="me-2"></i>Profile</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                        href="#top-contact" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="key" class="me-2"></i>Change
                                        Password</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                        href="#top-contact-update" role="tab" aria-controls="top-contact"
                                        aria-selected="false"><i data-feather="image" class="me-2"></i>Update icon </a> </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade show active" id="top-profile" role="tabpanel"
                                    aria-labelledby="top-profile-tab">
                                    <h5 class="f-w-600">Profile</h5>
                                    <form class="form" action="{{ route('admin.updateProfile') }}"
                                        method="POST" id="profile-form" data-parsley-validate>
                                        @csrf
                                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                        <div class="form-group row">
                                            <label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span> Admin
                                                Name</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="adminname"  name="adminname" type="text"
                                                    value="{{ Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>
                                                Email</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="email" name="email" type="text"
                                                    value="{{ Auth::user()->email }}" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>
                                                Designation</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="designation" name="designation"
                                                    value="{{ Auth::user()->designation }}" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="validationCustom4" class="col-xl-3 col-md-4">
                                                Password</label>
                                            <div class="col-xl-8 col-md-7">
                                                <input class="form-control" id="password" value="{{ Auth::user()->password }}" readonly
                                                    type="password" required="">
                                            </div>
                                        </div>
                                        <div class="pull-left">
                                            <button type="submit" class="btn btn-primary submitBtn">Save <i
                                                    class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="top-contact" role="tabpanel"
                                    aria-labelledby="contact-top-tab">
                                    <div class="account-setting">
                                        <h5 class="f-w-600">Change Password</h5>
                                        <form class="form" action="{{ route('admin.changePassword') }}" method="POST">
                                             @csrf
                                             <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                            <div class="form-group row">
                                                <label for="validationCustom1" class="col-xl-3 col-md-4"><span>*</span>
                                                    Old Password</label>
                                                <div class="col-xl-8 col-md-7">
                                                    <input class="form-control" id="old_password" name="old_password"
                                                        type="text" placeholder="Old Password" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom2" class="col-xl-3 col-md-4"><span>*</span>
                                                    New Password</label>
                                                <div class="col-xl-8 col-md-7">
                                                    <input class="form-control" id="password" name="password"
                                                        type="password" placeholder="New Password" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="validationCustom4" class="col-xl-3 col-md-4"><span>*</span>
                                                    Confirm Password</label>
                                                <div class="col-xl-8 col-md-7">
                                                    <input class="form-control" id="password_confirmation" required
                                                        name="password_confirmation" placeholder="Confirm Password"
                                                        type="password" required="">
                                                </div>
                                            </div>
                                            <div class="pull-left">
                                                <button type="submit" class="btn btn-primary submitBtn">Save <i
                                                        class="fa fa-spinner fa-spin main-spinner d-none"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="top-contact-update" role="tabpanel"
                                    aria-labelledby="contact-top-tab">
                                    <div class="account-setting">
                                        <h5 class="f-w-600">Update icon</h5>
                                        <form class="form-icon"
                                            action="{{ route('admin.upload_icon') }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                            <div class="form-group row">
                                                <label for="validationCustom2" class="col-xl-3 col-md-4">
                                                    <span>*</span> Admin icon </label>
                                                <div class="col-xl-8 col-md-7">
                                                    <input class="dropify" id="icon"
                                                        data-default-file="{{ env('AWS_URL') }}public/storage/{{ Auth::user()->designation_icon }}"
                                                        name="icon" type="file" accept="image/*">
                                                </div>
                                            </div>

                                            <div class="pull-left">
                                                <button type="submit" class="btn btn-primary submitBtn">Save <i
                                                        class="fa fa-spinner fa-spin main-spinner d-none"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
