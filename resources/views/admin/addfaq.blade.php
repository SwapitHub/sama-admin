@extends('layouts.layout')
@section('content')
<div class="page-body">
	<!-- Container-fluid starts-->
	<div class="container-fluid">
		<div class="page-header">
			<div class="row">
				<div class="col-lg-6">
					<div class="page-header-left">
						<h3>{{ $title }} 
							<small>Diamond Admin panel</small>
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
						<li class="breadcrumb-item"><a href="{{ route($backtrack) }}">Faq List</a></li>
						<li class="breadcrumb-item active">{{ $title }} </li>
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
								aria-selected="true"><i data-feather="activity" class="me-2"></i>Faq</a>
							</li>
						</ul>
						<div class="tab-content" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-profile" role="tabpanel"
							aria-labelledby="top-profile-tab">
								<form action="{{ $url_action }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
									@csrf
									<div class="form-group row">
										<label for="faq_category" class="col-xl-3 col-md-4"><span>*</span>Category
										</label>
										<div class="col-md-8">
											<select name="faq_category" id="faq_category"  class="form-control @error('faq_category') is-invalid @enderror">
												<option selected disabled>select</option>	
												@foreach($categories as $cat)
												<option value="{{ $cat->id }}" <?php if(old('faq_category',!empty($obj['faq_category'])) == $cat->id){echo "selected";} ?>  >{{ $cat->faq_category }}</option>
												@endforeach
											</select>
											@error('faq_category')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<label for="validationCustom0" class="col-xl-3 col-md-4"><span>*</span>Question</label>
										<div class="col-xl-8 col-md-7">
											<input class="form-control text-capitalize @error('question') is-invalid @enderror" id="question" name="question"
											value="{!! old()?old('question'):$obj['question']??'' !!}" type="text" placeholder="question">
											@error('question')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
									</div>
									<div id="termsec">
										<div class="form-group row">
											<label for="validationCustom4" class="col-xl-3 col-md-4"><span>*</span>Answer</label>
											<div class="col-xl-8 col-md-7">
												<textarea name="answer" id="answer" cols="30" rows="10" placeholder="answer" class="summernote">{!! old()?old('answer'):$obj['answer']??'' !!}</textarea>
												@error('answer')
												<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
										</div>
									</div>
								
								<div class="form-group row">
									<label for="validationCustom4" class="col-xl-3 col-md-4">
									Order</label>
									<div class="col-xl-8 col-md-7">
										<input type="text" name="order_number" value="{!! old()?old('order_number'):$obj['order_number']??'0' !!}" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-xl-3 col-md-4">Status</label>
									<div class="col-md-7">
										<div class="checkbox checkbox-primary">
											<input id="checkbox-primary-2"  type="checkbox" name="status"
											value="true" data-original-title="" {{ old('status') == 'true' || (isset($obj) && is_object($obj) && $obj->status == 'true') ? 'checked' : '' }} >
											<label for="checkbox-primary-2">Enable the faq</label>
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
