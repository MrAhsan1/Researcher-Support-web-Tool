@extends('layouts.minimaster')
@section('content')

<!-- bread-crumb start here -->
<div class="bread-crumb">
	<img src="images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>Forgot Password</h2>
			<ul class="list-inline">
				<li>
					<a href="{{ url('/') }}">HOME</a>
				</li>
				<li>
					<a href="{{ url('/forgot-password') }}">Forget Password</a>
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
				@endif
				<h5>Password Reset</h5>
				<hr>
				<form method="post" enctype="multipart/form-data" action="{{route('forgot')}}">
					{{csrf_field()}}
					<div class="form-group">	
						<label>Email*</label>
						<input type="text" name="email" class="form-control" value="{{old('email')}}"/>
					</div>
					<button type="submit" class="btn btn-primary btn-block" >Send Code</button>
				</form>
			</div>	
		</div>
	</div>
</div>
<!-- Register end here -->
@endsection