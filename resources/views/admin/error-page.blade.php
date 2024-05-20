@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
        <br>
        <div class="card">
            <div class="card-header">
                 <p class="card-title">403 Access Denied</p>
            </div>
            <div class="card-body">
                <p>Sorry, you do not have permission to access this page.</p>
                <a href="{{ url('dashboard') }}"><i class="fa fa-arrow-left"></i> &ensp;Go to Dashboard</a>
            </div>
        </div>
	</div>
	<!-- Container-fluid Ends-->
</div>

@endsection		
