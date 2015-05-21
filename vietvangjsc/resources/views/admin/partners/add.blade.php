@extends('admin.layouts.layout')
@section('container')
 <div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {!! $title !!}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="{{ URL::to('admin') }}">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/partners') }}">{!! $parent !!}</a>
                    </li>
                </ol>
            </div>
        </div>
        <!-- Validate -->
        @if ( $errors->has())
        <div class="row">
            @foreach ( $errors->all() as $error )
            <div class="col-md-6 col-md-offset-2 alert alert-danger">{!! $error !!}</div>
            @endforeach
        </div>
       
        @else
            <p>&nbsp;</p>
        @endif
        <!-- Show message -->
        <div class="row">
            <div class="col-lg-6">
                {!! $msg !!}
            </div>
        </div>
        <!-- /.row -->
        {!! Form::open(array('action' => 'AdminController@addPartner_act','files' => true)) !!}
        <div class="row">
            <div class="form-group">
                <label>Name</label>
                {!! Form::text('name','', array('placeholder'=>'Enter Name Partner', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>URL</label>
                {!! Form::text('url','',array('placeholder'=>'Enter url', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo">
                    <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
            </div>
            <button type="submit"  class="btn btn-primary">Save</button>
            <button type="submit" name="continue" class="btn btn-success">Save & Continues</button>
            <button type="reset" class="btn btn-default">Reset</button>
        </div>
        {!! Form::close() !!}
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection