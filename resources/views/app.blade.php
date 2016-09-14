<!DOCTYPE html>
<html lang="ru">
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
<body ng-app="main">
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
				</ul>
			</div>
		</div>
	</nav>

	<div class="container-fluid">
		<ng-view></ng-view>
	</div>

	<!-- Scripts -->

</body>
</html>