@extends('layouts.minimaster')
@section('content')

<!-- bread-crumb start here -->
<div class="bread-crumb">
	<img src="{{URL::to('/')}}/images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>login now</h2>
			<ul class="list-inline">
				<li>
					<a href="{{ url('/') }}">HOME</a>
				</li>
				<li>
					<a href="{{ url('/login') }}">Login now</a>
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
				<h5>sign IN</h5>
				<hr>
				@if (count($errors)>0)
					@foreach ($errors->all() as $error)
						<p class="alert alert-danger">{{$error}}</p>
					@endforeach
				@endif
				@if (session('alert'))
						<p class="alert alert-danger">{{session('alert')}}</p
				@endif
				@if (session('success'))
						<p class="alert alert-success">{{session('success')}}</p
				@endif
				@if (session('Warning'))
						<p class="alert alert-danger">{{session('Warning')}}</p
				@endif
				<h5></h5>
				<form method="post" enctype="multipart/form-data" action="{{route('auth.login')}}">
					{{csrf_field()}}
					<div class="form-group">	
						<label>Email*</label>
						<input type="text" name="email" placeholder="Johndoe@example.com" class="form-control" value="{{old('email')}}"/>
					</div>
					<div class="form-group">
						<label>password*</label>
						<input type="password" name="password" value="" placeholder="********" id="password" class="form-control" />
					</div>
					<a href="{{ url('/forgot-password') }}">Forgot your password?</a>
					<button type="submit" class="btn btn-primary btn-block" >Login</button>
				</form>
				<div class="donot">
					Create an account? 
					<a href="{{ url('/register') }}">Register Now</a>
				</div>
			</div>	
		</div>
	</div>
</div>
<!-- Register end here -->
@endsection