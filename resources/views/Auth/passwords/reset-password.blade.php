@extends('layouts.minimaster')
@section('content')

<!-- bread-crumb start here -->
<div class="bread-crumb">
	<img src="{{URL::to('/')}}/images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>Reset Password</h2>
			<ul class="list-inline">
				<li>
					<a href="{{ url('/') }}">HOME</a>
				</li>
				<li>
					<a href="{{ url('#') }}">Reset Password</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- bread-crumb end here -->

<div class="login">
	<div class="container"> 
		<div class="col-md-10 col-sm-12 col-xs-12 box padd0">
			<div class="col-md-10 col-sm-6 col-xs-12">
				@if (count($errors)>0)
					@foreach ($errors->all() as $error)
						<p class="alert alert-danger">{{$error}}</p>
					@endforeach
				@endif

				@if (session('success'))
						<p class="alert alert-success">{{session('success')}}</p>
				@else
				<h5>Password Reset</h5>
				<hr>
				<form method="post" enctype="multipart/form-data" action="{{route('reset')}}">
					{{csrf_field()}}
					<div class="form-group">	
						<label>Email*</label>
						<input type="text" name="email" class="form-control" value="{{old('email')}}"/>
					</div>
					<div class="form-group">	
						<label>New Password*</label>
						<input type="password" name="password" class="form-control"/>
					</div>
					<div class="form-group">	
						<label>Confirm New Password*</label>
						<input type="password" name="password_confirmation" class="form-control"/>
					</div>
					<button type="submit" class="btn btn-primary btn-block" >Reset Password</button>
				</form>
				@endif
			</div>	
		</div>
	</div>
</div>
<!-- Register end here -->
@endsection