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
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/categories') }}">{!! $parent !!}</a>
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
        {!! Form::open(array('action' => 'AdminController@categoriesEdit_sm','files' => true)) !!}
        <div class="row">
            <div class="col-lg-6">
                {!! Form::hidden('id', $obj->id) !!}
                
                 <div class="form-group">
                    <label>Image</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" checked="true" value="true" name="ckimg" id="ckimg" onclick="check_use_image(this.checked)">
                            Use only this image
                        </label>
                    </div>

                    <input type="file" name="image">
                    <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
                    @if($obj->logo != '')
                        {!! Html::image('/upload/categories/'.$obj->logo, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                    @else
                        {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                    @endif
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title" value="{!! $obj->name !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc">{!! $obj->desc !!}</textarea>
                </div>


            </div>
            <div class="col-lg-6">
                
                <h1>English Content</h1>

                <fieldset id="fs" disabled>
                    <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image_en">
                            <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
                            @if($obj_en->img != '')
                                {!! Html::image('/upload/categories/'.$obj_en->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                            @else
                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                            @endif
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_en" value="{!! $obj_en->name !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc_en">{!! $obj_en->desc !!}</textarea>
                </div>

                <h1>Japan Content</h1>

               <fieldset id="fs1" disabled>
                    <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image_ja">
                            <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
                            @if($obj_ja->img != '')
                                {!! Html::image('/upload/categories/'.$obj_ja->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                            @else
                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                            @endif
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_ja" value="{!! $obj_ja->name !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc_ja">{!! $obj_ja->desc !!}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            {!! Html::decode(Html::link('admin/categories','<button type="button" class="btn btn-danger">Cancel</button>')) !!}
        <!-- /.row -->

        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection