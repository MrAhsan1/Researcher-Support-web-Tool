@extends('layouts.minimaster')
@section('content')
<div class="bread-crumb">
	<img src="images/banner-top.jpg" class="img-responsive" alt="banner-top" title="banner-top">
	<div class="container">
		<div class="matter">
			<h2>about us</h2>
			<ul class="list-inline">
				<li>
					<a href="{{url('/')}}">HOME</a>
				</li>
				<li>
					<a href="{{url('/about')}}">about us</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- bread-crumb end here -->

<!-- About us Start here -->

<div class="about" id="about">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-xs-12">
				<div class="commontop text-left">
					<a name="About">
					<h2>About us</h2>
					<p></p>
					<hr>
				</div>
				<p style="text-align: justify;text-decoration-color: black;" class="des">Researcher Support Web Tool is one of the world's most voluminous search engines especially for academic web resources. Researcher Support Web Tool provides to search papers from a more than one digital libraries like(Science Direct,ACM etc). You can download papers about 80% of the indexed documents for free (Open Access). RSWT is operated by Code Warriors. <a href="about.html"></a></p>
				
			</div>
			
		</div>
	</div>
</div>
<!-- about end here -->
@yield('team')

@endsection()
