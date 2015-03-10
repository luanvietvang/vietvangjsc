<!DOCTYPE html>
<html>
	<meta charset="utf-8"></meta>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
	<title>VietVang – Việt Vang – Công ty phần mềm chất lượng cao | Vietnam IT company of Japanese quality – Việt Vang – Công ty phần mềm chất lượng cao</title>
	<!--Include head meta tag-->
	@include('includes.head')
	<!--End head meta tag-->
	<!--<link href="http://jps.com.vn/favicon.ico" rel="shortcut icon" type="image/x-icon">-->
	{!! Html::style('css/style.css') !!}
	<!--Body tag-->
	<body>
		<!--Div body main-->
		<div id="body-main">
			@include('includes.header')
			<!--Div gnav-->
			<div id="gnav">
				@include('includes.menu')
			</div>
			<!--End div gnav-->
			<!--Div container-->
			<div id="container">
				@yield('container')
			</div>
			<!--End div container-->
			<!--Div  footer-->
			<div id="footer">
				@include('includes.footer')
			</div>
			<!--End div footer-->
		</div>
		<!--End div body main-->
	</body>
	<!--End body tag-->
</html>