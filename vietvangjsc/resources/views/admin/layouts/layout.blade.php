<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin – Việt Vang – Công ty phần mềm chất lượng cao </title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::to('admin/css/sb-admin.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ URL::to('admin/css/plugins/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ URL::to('admin/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
	<!--Body tag-->
<body>
    <div id="wrapper">

	    <!-- Navigation -->
	    @include('admin.includes.header')
	    <!--container-->
		
			@yield('container')

		<!--End container-->
        

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ URL::to('admin/js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::to('admin/js/bootstrap.min.js') }}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ URL::to('js/plugins/morris/raphael.min.js') }}"></script>
    <script src="{{ URL::to('admin/js/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ URL::to('admin/js/plugins/morris/morris-data.js') }}"></script>

    <!-- Ckediter -->
    <script src="{{ URL::to('ckeditor/ckeditor.js') }}"></script>

    <!-- My javascript -->
    <script src="{{ URL::to('admin/js/func.js') }}"></script>
</body>
	<!--End body tag-->
</html>