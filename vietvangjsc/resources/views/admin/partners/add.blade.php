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
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/menus') }}">{!! $parent !!}</a>
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
        {!! Form::open(array('action' => 'AdminController@menusAdd_sm','files' => true)) !!}
        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    <label>Parent Menu</label>
                    <select class="form-control" name="parent_id">
                        <option value="0">Select</option>
                        @foreach($menu as $mn)
                            {!! $mn !!}
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Position</label>
                    <input class="form-control" placeholder="Enter text" name="position" value="{!! Input::old('position') !!}">
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title" value="{!! Input::old('title') !!}">
                </div>
               
            </div>
            <div class="col-lg-6">
                <h1>English Content</h1>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_en" value="{!! Input::old('title_en') !!}">
                </div>

                <h1>Japan Content</h1>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_ja" value="{!! Input::old('title_ja') !!}">
                </div>
                
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