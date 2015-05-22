@extends('admin.layouts.layout')
@include('admin.includes.googlemap')
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
      
        <!-- Show message -->
        <div class="row">
            <div class="col-lg-6">
                {!! $msg !!}
            </div>
        </div>
        <!-- /.googlemap -->
        {!! Form::open(array('action' => 'AdminController@locationEdit_act','files' => true)) !!}
        <div class="row">
            @for ($i = 0; $i < count($location); $i++)
            <div class="form-group">
                <label>Latitude</label>
                {!! Form::text('latitude',$location[$i]->latitude, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <label>Longitude</label>
                {!! Form::text('longitude',$location[$i]->longitude, array('class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::hidden('id', $location[$i]->id) !!}
            </div>
            @endfor
            <button type="submit"  class="btn btn-primary">Save</button>
        </div>
        {!! Form::close() !!}
        <div class='row' id="googleMap" style="width:100%;height:400px;"></div>
        <!-- /.googlemap -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection