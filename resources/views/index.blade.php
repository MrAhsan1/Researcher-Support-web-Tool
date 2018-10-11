@extends('layouts.master')
@section('content')
<!-- slider start here -->
<div class="slide"> 
	<div class="slideshow owl-carousel">
		<div class="item">
			<img src="images/banner.jpg" alt="banner" title="banner" class="img-responsive"/>
		</div>
		<div class="item">
			<img src="images/banner.jpg" alt="banner" title="banner" class="img-responsive"/>
		</div>
		<div class="item">
			<img src="images/banner.jpg" alt="banner" title="banner" class="img-responsive"/>
		</div>
	</div>
	<!-- slide-detail start here -->
	

	<div class="slide-detail">
		<div class="container">
			<div class="matter">
				<h4>Research More Search Less</h4>
				<p class="des">The Researcher Recommendation System prides itself as being “one of the world’s most voluminous search engines especially for academic web resources.</p>
			</div>
			<div class="matter2">
				<h2>Advance Search</h2>
				<form class="form-horizontal" method="get" action="{{route('advancesearch.show')}}">
					<fieldset>
					<div class="form-group">
						<div class="col-sm-10 padd0">
							<div class="col-sm-4">
								<input name="authors" class="form-control" value="" placeholder="Author Name" type="text" pattern="[A-Za-z, ]{3,}" title="Must atleast three charaters, Only Alphabets">
							</div>
							<div class="col-sm-4">
									<select name="date" class="form-control selectpicker bs-select-hidden">
										<option value="" selected="selected" disabled>Select Publish Range</option>
										<option value="2000-2010" >2000-2010</option>
										<option value="2011-2015">2011-2015</option>
										<option value="2016-2018">2016-2018</option>
									</select>
							</div>
							<div class="col-sm-4">
								<input name="s" class="form-control" value="" placeholder="Search Text" type="text">
							</div>
							<div class="col-sm-12 padd0">
								<div class="col-sm-4" style="margin-top: 15px">
									
								</div>
								<div class="col-sm-4" style="margin-top: 15px">
									<label>Choose If You want Specific Search.</label>
								</div>
								<div class="col-sm-1">
									<input name="science" class="form-control" value="Science Direct" type="checkbox">
									<label>Science Direct</label>
								</div>
								<div class="col-sm-1">
									<input name="eric" class="form-control" value="Eric" type="checkbox">
									<label>Eric</label>
								</div>
								<div class="col-sm-1">
									<input name="acm" class="form-control" value="Acm" type="checkbox">
									<label>ACM</label>
								</div>
								<div class="col-sm-1">
									<input name="pubmed" class="form-control" value="pubmed" type="checkbox">
									<label>Pubmed</label>
								</div>
						    </div>
						</div>


						<div class="col-sm-2">
							<button class="btn-primary" type="submit">Search</button>
						</div>
					</div>
					
				</fieldset>
				</form>
			</div>
		</div>
	</div>	
	<!-- slide-detail end here -->
</div>
<!-- slider end here -->

<!-- space start here -->
<div class="space">
	<div class="container">
		 
	</div>
</div>
<div class="space">
	<div class="container">
	</div>
</div>
<div class="space">
	<div class="container">
	</div>
</div>
<!-- space end here -->

<!-- featured start here -->
<div class="featured">
	<div class="image">
		<img src="images/features/bg.jpg" class="img-responsive" alt="bg" title="bg" />
	</div>
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ul class="list-inline">
						<li>
							<div class="box">
								
							</div>
						</li>
						<li>
							<div class="box">
								<div class="icon">
									<div class="icons">
										<img src="images/features/icon2.png" class="img-responsive" alt="image" title="image" />	
									</div>
								</div>
								<h4>User Registers</h4>
								<p>{{$users}}</p>
							</div>
						</li>
						<li>
							<div class="box">
								<div class="icon">
									<div class="icons">
										<img src="images/features/icon4.png" class="img-responsive" alt="image" title="image" />	
									</div>
								</div>
								<h4>Papers Published</h4>
								<p>{{$paper }}</p>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- featured end here -->

<!-- space start here -->
<div class="space">
	<div class="container">
	</div>
</div>
<div class="space">
	<div class="container">
	</div>
</div>
<div class="space">
	<div class="container">
	</div>
</div>
<!-- space end here -->

<div class="space">
	<div class="container">
	</div>
</div>
<div class="space">
	<div class="container">
	</div>
</div>

@endsection
