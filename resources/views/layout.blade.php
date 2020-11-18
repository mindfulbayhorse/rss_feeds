<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Laracast')</title>
</head>
<body>
	<div class="wide_screen" id="app">
		@hasSection('left_sidebar')
				@yield('left_sidebar')
		@endif
		
        <div class="center_part">
			<h1>@yield('title')</h1>
		
		
		      @yield('content')
				
		</div>

	</div>
<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
