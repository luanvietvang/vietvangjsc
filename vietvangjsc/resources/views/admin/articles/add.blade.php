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
                        <i class="fa fa-table"></i> <a href="{{ URL::to('admin/articles') }}">{!! $parent !!}</a>
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
        {!! Form::open(array('action' => 'AdminController@articlesAdd_sm','files' => true)) !!}
        <div class="row">
            <div class="col-lg-6">

                <div class="form-group">
                    <label>Categories</label>
                    <select class="form-control" name="category_id">
                        <option value="0">Select</option>
                        @foreach($cate as $ct)
                            <option value="{!! $ct->id !!}">{!! $ct->name !!}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Menu</label>
                    <select class="form-control" name="menu_id">
                        <option value="0">Select</option>
                        @foreach($menu as $mn)
                            {!! $mn !!}
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Hit</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="hit" id="hit" value="1" checked>Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="hit" id="hit" value="0">No
                        </label>
                    </div>
                </div>
                
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
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title" value="{!! Input::old('title') !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc">{!! Input::old('desc') !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Full Text</label>
                    <textarea class="ckeditor form-control" rows="3"name="fulltext">{!! Input::old('fulltext') !!}</textarea>
                </div>

                <h1>SEO's</h1>

                <div class="form-group">
                    <label>Keywords</label>
                    <input class="form-control" placeholder="Enter text" name="keywords" value="{!! Input::old('keywords') !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="description">{!! Input::old('description') !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Author</label>
                    <input class="form-control" placeholder="Enter text" name="author" value="{!! Input::old('author') !!}">
                </div>

                <div class="form-group">
                    <label>Google publisher</label>
                    <input class="form-control" placeholder="Enter text" name="google_publisher" value="{!! Input::old('google_publisher') !!}">
                </div>

                <div class="form-group">
                    <label>Google author</label>
                    <input class="form-control" placeholder="Enter text" name="google_author" value="{!! Input::old('google_author') !!}">
                </div>

                <div class="form-group">
                    <label>Facebook id</label>
                    <input class="form-control" placeholder="Enter text" name="facebook_id" value="{!! Input::old('facebook_id') !!}">
                </div>

                <div class="form-group">
                    <label>Og title</label>
                    <input class="form-control" placeholder="Enter text" name="og_title" value="{!! Input::old('og_title') !!}">
                </div>

                <div class="form-group">
                    <label>Og description</label>
                    <input class="form-control" placeholder="Enter text" name="og_description" value="{!! Input::old('og_description') !!}">
                </div>

                <button type="submit"  class="btn btn-primary">Save</button>
                <button type="submit" name="continue" class="btn btn-success">Save & Continues</button>
                <button type="reset" class="btn btn-default">Reset</button>

            </div>
            <div class="col-lg-6">
                <h1>English Content</h1>

                <fieldset id="fs" disabled>
                    <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image_en">
                            <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_en" value="{!! Input::old('title_en') !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc_en">{!! Input::old('desc_en') !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Full Text</label>
                    <textarea class="ckeditor form-control" rows="3" name="fulltext_en">{!! Input::old('fulltext_en') !!}</textarea>
                </div>

                <h1>Japan Content</h1>

               <fieldset id="fs1" disabled>
                    <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image_ja">
                            <small>(*.gif , *.jpg ,*.png < 2000kb)</small><br>
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" placeholder="Enter text" name="title_ja" value="{!! Input::old('title_ja') !!}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="desc_ja">{!! Input::old('desc_ja') !!}</textarea>
                </div>

                <div class="form-group">
                    <label>Full Text</label>
                    <textarea class="ckeditor form-control" rows="3" name="fulltext_ja">{!! Input::old('fulltext_ja') !!}</textarea>
                </div>
                
            </div>
        </div>
        {!! Form::close() !!}
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection