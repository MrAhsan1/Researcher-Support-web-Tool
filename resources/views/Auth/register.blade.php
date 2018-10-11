@extends('layouts.minimaster')
@section('content')

<!-- bread-crumb start here -->
<div class="bread-crumb">
	<img src="{{URL::to('/')}}/images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>register now</h2>
			<ul class="list-inline">
				<li>
					<a href="{{ url('/') }}">HOME</a>
				</li>
				<li>
					<a href="{{ url('/register') }}">register now</a>
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
				<h5>sign UP</h5>
				<hr>
				<form method="post" enctype="multipart/form-data" action="{{route('auth.register')}}">
					{{csrf_field()}}
					<div class="form-group">	
						<label>FIRST NAME*</label>
						<input type="text" name="fname" placeholder="Example : John" style="color: black" value="{{old('fname')}}" class="form-control" />
					</div>
					<div class="form-group">	
						<label>LAST NAME*</label>
						<input type="text" name="lname" placeholder="Example : Doe" style="color: black" value="{{old('lname')}}" class="form-control" />
					</div>
					<div class="form-group">	
						<label>Email*</label>
						<input type="text" name="email" value="{{old('email')}}" placeholder="Johndoe@example.com" style="color: black" class="form-control" />
					</div>
					<div class="form-group">
						<label>Password*</label>
						<input type="password" name="password" value="" placeholder="********" style="color: black" id="password" class="form-control" />
					</div>
					<div class="form-group">
						<label>Confirm Password*</label>
						<input type="password" name="password_confirmation" value="" placeholder="********" style="color: black" id="input-confirmpassword" class="form-control" />
					</div>
					<div class="form-group">
						<label>Choose Research Area Which You Have Knowledge (Maximum 4)</label>
							<select name="research_areas[]" class="selectpicker" data-live-search="true"  data-width="100%" multiple data-max-options="4">
						      <option value="Machine Learning">Machine Learning</option>
			                  <option value="Data Mining">Data Mining</option>
			                  <option value="Artificial Intelligence">Artificial Intelligence</option>
			                  <option value="Image Processing">Image Processing</option>
			                  <option value="Internet of Things">Internet of Things</option>
			                  <option value="Natural Language Processing">Natural Language Processing</option>
                       		  <option value="Recommendation Systems">Recommendation Systems</option>
                        	  <option value="Database Management Systems">Database Management Systems</option>
			                  <option value="Computer Vision">Computer Vision</option>
			                  <option value="RFID">RFID</option>
						    </select>
					</div>
					<button type="submit" class="btn btn-primary btn-block" >Register now</button>
				</form>
				<div class="donot">
					Have an account? 
					<a href="{{ url('/login') }}">Login Now</a>
				</div>
			</div>	
		</div>
	</div>
</div>
<!-- Register end here -->
@endsection