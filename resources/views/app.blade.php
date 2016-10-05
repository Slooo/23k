<!DOCTYPE html>
<html lang="ru" ng-app="main">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="_token" content="{{ csrf_token() }}">
	<title>23k</title>

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
		
	<!-- CSS -->
	<link rel="stylesheet" href="{{ elixir('css/app.css') }}">

	<!-- JS -->
	<script src="{{ elixir('js/app.js') }}" type="text/javascript" media="all"></script>

</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">23k</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="#/">Главная</a></li>
					<li><a href="#/workflow">Документооборот</a></li>
					<li><a href="#/smr">СМР</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<ng-view></ng-view>
		<div class="scroll-bar">
		    <div id="scroll-up"><i class="fa fa-3x fa-arrow-circle-up" aria-hidden="true"></i></div>
		    <div id="scroll-down"><i class="fa fa-3x fa-arrow-circle-down" aria-hidden="true"></i></div>
		</div>
	</div>


	<div class="container">
	    <div class="content">
	        <div class="title">Laravel 5</div>
	        <div class="quote">{{ Inspiring::quote() }}</div>
	    </div>
	</div>


	<!-- Scripts -->
	<script>
	    $('#wf-search').focus();

	    $('#scroll-up').click(function(e){
	        e.preventDefault();
	        $('html, body').stop().animate({scrollTop:0}, '500', 'swing');
	    });

	    $('#scroll-down').click(function(e){
	        e.preventDefault();
	        $("html, body").animate({ scrollTop: $(document).height() }, 500);
	    });

	</script>

</body>
</html>