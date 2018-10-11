@extends('layouts.minimaster')
@section('content')
<div class="bread-crumb">
	<img src="images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>contact us</h2>
			<ul class="list-inline">
				<li>
					<a href="{{url('/')}}">HOME</a>
				</li>
				<li>
					<a href="{{url('/contact')}}">contact us</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- bread-crumb end here -->

<!-- contactus start here -->
<div class="contactus">
	<div class="container"> 
		<div class="row">
			<div class="col-sm-9 col-xs-12">
				@if (session('success'))
						<p class="alert alert-success">{{session('success')}}</p>
				@else
				<form method="post" enctype="multipart/form-data" class="form-horizontal" action="sendmail">
					{{csrf_field()}}
					<h5>get in touch for any query</h5>
					<hr />
					<div class="form-group">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label>Name*</label>
							<input name="name" value="" id="input-name" class="form-control"  type="text">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label>Email*</label>
							<input name="email" value="" id="input-email" class="form-control"  type="text">
						</div>
					</div>
					<div class="form-group">	
						<div class="col-md-12 col-sm-12 col-xs-12">
							<label>Query Subject</label>
							<input name="query1" value="" id="input-phone" class="form-control"  type="text">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<label>Message*</label>
							<textarea name="message" id="input-enquiry" class="form-control"></textarea>
						</div>
					</div>
					<input class="btn btn-primary" value="Send Message" type="submit">
				</form>

				@endif
			</div>
		</div>
	</div>
</div>
<!-- contactus end here -->

@endsection