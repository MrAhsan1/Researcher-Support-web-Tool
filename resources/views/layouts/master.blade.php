<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Mirrored from ocsolutions.co.in/html/education/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 01 Apr 2018 16:20:51 GMT -->
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Researcher Recomendation</title>
<!-- Bootstrap stylesheet -->
<link href="{{URL::to('/')}}/bootstrap/css/bootstrap.css" rel="stylesheet">
<!-- font -->
<link href="{{URL::to('/')}}/https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet"> 
<!-- icofont -->
<link href="{{URL::to('/')}}/icofont/css/icofont.css" rel="stylesheet" type="text/css" />
<!-- font-awesome -->
<link href="{{URL::to('/')}}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- crousel css -->
<link href="{{URL::to('/')}}/js/owl-carousel/owl.carousel.css" rel="stylesheet" type="text/css" />
<!--bootstrap select-->
<link href="{{URL::to('/')}}/js/dist/css/bootstrap-select.css" rel="stylesheet" type="text/css" />
<!-- stylesheet -->
<link href="{{URL::to('/')}}/css/style.css" rel="stylesheet" type="text/css"/>
<!-- Favicon -->
<link href="images/favicon.png" rel="shortcut icon" type="image/png"/>

<style type="text/css">
	.scroll-menu{
		max-width: 500px;
		max-height: 50vh;
		overflow: auto; 
	}
</style>
</head>
<body>
<!--top start here -->
<div class="top">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<ul class="list-inline pull-left icon">
					@if (session('Status'))
						<h3>{{session('Status')}}</h3>
					@endif
                    @if(Auth::guest())
                    @else
					@if(auth()->user()->status == "")
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
						aria-expanded="false" aria-haspopup="false">
								<b title="User Settings"> Turn On Notifications From Edit Profile </b>
						</a>
					</li>
					@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
						aria-expanded="false" aria-haspopup="false">
							
							@if (auth()->User()->unreadNotifications->count())
							<i class="icofont icofont-world" title="Notification" style="font-size: 15px;color:#fb0"></i> 
							<span class="badge badge-light" style="background-color: red; font-size: 10px">{{auth()->User()->unreadNotifications->count()}}</span>
							<b title="User Settings">  Notification </b>
							@else
								<i class="icofont icofont-world" title="Notification" style="font-size: 15px;color:gray"></i>
								<b title="User Settings">  Notification </b>
							@endif
						</a>

						<ul class="dropdown-menu scroll-menu">
								<li>
									<a href="{{route('markAllRead')}}" style="color: #fb0"> Mark all as Read</a>
								</li>
								@if(auth()->User()->unreadNotifications->count() == 0)
								<li>
									<a href=""> No New Notification</a>
								</li>
								@endif

							@foreach (auth()->User()->unreadNotifications as $notification)

								<li style="background-color: lightgray">
									<a href="{{url('/show/papers',[$notification->data['data']['id'],$notification->id])}}" style="color: black"> {{ $notification->data['data']['title'] }} </a> 
								</li>
							
							@endforeach

							
						</ul>

					@endif
					@endif
					</li>
				</ul>
				<ul class="list-inline pull-right icon">
					@if (Auth::guest())
						<li><a href="{{ url('/login') }}"><i class="icofont icofont-login"></i>Login</a></li>
						<li><a href="{{ url('/register') }}"><i class="icofont icofont-ui-user"></i>Register</a></li>
					@else

					<li class="dropdown">
							<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button"
								aria-expanded="true" aria-haspopup="true">

								<i class="icofont icofont-ui-user" style="font-size:15px;color:#fb0"></i> 
								<b title="User Settings"> {{auth()->User()->fname}} </b>
								<i class="icofont icofont-caret-down"> </i>

							</a>
						<div class="dropdown-menu repeating">
							<div class="dropdown-inner">
							<ul class="list-unstyled">
								<li>
									<a href="{{ url('/profile') }}">  
                                    	<i class="heart fa fa-user" style="font-size:15px;color:#fb0"></i> Edit Profile
                                	</a>
								</li>
								<li>
									<a href="{{ url('/myFavorite') }}">  
                                    	<i class="heart fa fa-heart" style="font-size:15px;color:#fb0"></i>My Favourites
                                	</a>
								</li>
								<li>
									<a href="{{ url('/logout') }}">
										<i class="icofont icofont-logout" style="font-size:15px;color:#fb0"></i>Log out
									</a>
								</li>
								
								
							</ul>
							</div>
						</div>
					</li>
				@endif
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<!--top end here

<!-- header start here-->
<header>
	<div class="container">
		<div class="row">
			<div class="col-md-3 col-sm-3 col-xs-12">
				<div id="logo">
					<a href="{{url('/')}}">
						<img class="img-responsive" src="{{URL::to('/')}}/images/logo.png" alt="logo" title="logo" />
					</a>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<!-- menu start here -->
				<div id="menu">	
					<nav class="navbar">
						<div class="navbar-header">
							<span class="menutext visible-xs">Menu</span>
							<button data-target=".navbar-ex1-collapse" data-toggle="collapse" class="btn btn-navbar navbar-toggle" type="button">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</button>
						</div>
						<div class="collapse navbar-collapse navbar-ex1-collapse padd0">
							<ul class="nav navbar-nav text-right">
								<li>
									<a href=" {{ url('/') }}">HOME</a>
								</li>
								<li>
									<a href="{{url('/contact')}}">Contact Us</a>
								</li>
								<li>
									<a href="{{url('/about')}}">About Us</a>
								</li>
								@if (Auth::check())
								<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Research Areas <i class="fa fa-caret-down"></i></a>

									<div class="dropdown-menu repeating">
										<div class="dropdown-inner">
											<ul class="list-unstyled">
												@foreach(explode(',',auth()->User()->research_areas) as $research_areas)
												<li>
													@if($research_areas=='Data Mining')
													<a href="{{ url('/showdatamining') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Machine Learning')
													<a href="{{ url('/showmachinelearning') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Recommendation Systems')
													<a href="{{ url('/showrecommendationsystems') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Artificial Intelligence')
													<a href="{{ url('/showartificialintelligence') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Database Management Systems')
													<a href="{{ url('/showdatabase') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Computer Vision')
													<a href="{{ url('/showcomputervision') }}">{{$research_areas}} </a>
													@elseif($research_areas=='RFID')
													<a href="{{ url('/showrfid') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Internet of Things')
													<a href="{{ url('/showinternetofthings') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Image Processing')
													<a href="{{ url('/showimageprocessing') }}">{{$research_areas}} </a>
													@elseif($research_areas=='Natural Language Processing')
													<a href="{{ url('/shownlp') }}">{{$research_areas}} </a>
													@endif
												</li>
												@endforeach
											</ul>
										</div>
									</div>
								</li>
								@endif
							</ul>
						</div>
					</nav>
				</div>
				<!-- menu end here -->
			</div>
			<div class="col-md-3 col-sm-4 col-xs-12">
				<ul class="list-inline icon pull-right">
					<li>
						<form class="form-horizontal" method="get" id="srch" action="{{route('search.show')}}">
							<fieldset>
								<div class="form-group">
									<input name="search" value="" class="form-control" placeholder="Search" type="text">
								</div>
								<button type="submit" value="submit" class="btn">
									<i class="icofont icofont-search"></i>
								</button>
								
							</fieldset>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
</header>
<!-- header end here -->
@yield('content')
<!-- footer start here -->
<footer>
	<div class="container">
		<div class="row inner">
			<div class="col-sm-4">
				<a href="{{url('/')}}"><img src="{{URL::to('/')}}/images/footer-logo.png" class="img-responsive img" title="logo" alt="logo"></a>
				<p class="des" style="text-align: justify;">Researcher Support Web Tool is one of the world's most voluminous search engines especially for academic web resources. Researcher Support Web Tool provides to search papers from a more than one digital libraries like(Science Direct,ACM etc). You can download papers about 80% of the indexed documents for free (Open Access). RSWT is operated by Code Warriors.</p>
			</div>
			<div class="col-sm-2"></div>
			<div class="col-sm-6">
				<h5>Digital Repositories</h5>
				<hr>
				<ul class="list-unstyled">
					<li style="padding-bottom: 25px">
 						<a href="{{ url('/repositoriespapers',['source' => 'eric']) }}" style="font-size: 20px;">Eric ({{$eric}})</a>
					</li>
					<li style="padding-bottom: 25px">
						<a href="{{ url('/repositoriespapers',['source' => 'acm']) }}" style="font-size: 20px;">ACM ({{$acm}})</a>
					</li>
					<li style="padding-bottom: 25px">
						<a href="{{ url('/repositoriespapers',['source' => 'pubmed']) }}" style="font-size: 20px;">Pubmed ({{$pubmed}})</a>
					</li>
					<li style="padding-bottom: 25px">
						<a href="{{url('/repositoriespapers',['source' => 'ingenta'])}}" style="font-size: 20px;">Ingenta ({{$ingenta}})</a>
					</li>
					<li>
						<a href="{{ url('/repositoriespapers',['source' => 'science direct']) }}" style="font-size: 20px;">Science Direct ({{$science}})</a>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
		<div class="powered">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 text-left">
						<p><a href="http://ahsanayoub.tk/">Code Warriors</a> © 2018 , All Rights Reserved.</p>
					</div>
				</div>
			</div>
		</div>

</footer>
<!-- footer end here -->


<!-- jquery -->
<script src="{{URL::to('/')}}/js/jquery.2.1.1.min.js" type="text/javascript"></script>
<script src="{{URL::to('/')}}/js/jquery.min.js" type="text/javascript"></script>
<!-- bootstrap js -->
<script src="{{URL::to('/')}}/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!--bootstrap select-->
<script src="{{URL::to('/')}}/js/dist/js/bootstrap-select.js" type="text/javascript"></script>
<!-- owlcarousel js -->
<script src="{{URL::to('/')}}/js/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
<!--internal js-->
<script src="{{URL::to('/')}}/js/internal.js" type="text/javascript"></script>

</body>
</html>
