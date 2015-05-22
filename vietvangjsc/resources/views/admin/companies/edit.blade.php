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
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/company') }}">{!! $parent !!}</a>
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
        {!! Form::open(array('action' => 'AdminController@companyEdit_act','files' => true)) !!}
        <div class="row">
            @for ($i = 0; $i < count($companies); $i++)
            <div class="form-group">
                <label>Name</label>
                {!! Form::text('name',$companies[$i]->name, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Title</label>
                {!! Form::text('title',$companies[$i]->title, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Director</label>
                {!! Form::text('director',$companies[$i]->director,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Address</label>
                {!! Form::text('address',$companies[$i]->address,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Phone</label>
                {!! Form::text('phone',$companies[$i]->phone,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Fax</label>
                {!! Form::text('fax',$companies[$i]->fax,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Email</label>
                {!! Form::text('email',$companies[$i]->email,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Skype</label>
                {!! Form::text('skype',$companies[$i]->skype,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Copyright</label>
                {!! Form::text('copyright',$companies[$i]->copyright,array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::hidden('id', $companies[$i]->id) !!}
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