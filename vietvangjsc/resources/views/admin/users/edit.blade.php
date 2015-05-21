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
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/users') }}">{!! $parent !!}</a>
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
        {!! Form::open(array('action' => 'AdminController@usersEdit_act','files' => true)) !!}
        <div class="row">
            @for ($i = 0; $i < count($user); $i++)
            <div class="form-group">
                <label>Name</label>
                {!! Form::text('name',$user[$i]->name, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Email</label>
                {!! Form::text('email',$user[$i]->email, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Password</label>
                {!! Form::text('password',$user[$i]->password,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::hidden('id', $user[$i]->id) !!}
            </div>
            @endfor
            <button type="submit"  class="btn btn-primary">Save</button>
        </div>
        {!! Form::close() !!}
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection