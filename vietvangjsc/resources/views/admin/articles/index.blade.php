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
                                <i class="fa fa-table"></i> {!! $title !!}
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- Show message -->
                <div class="row">
                    <div class="col-lg-12">
                        {!! $msg !!}
                    </div>
                </div>
                
                <!-- <div class="row"> -->
                {!! Form::open(array('url' => 'admin/articles')) !!}
                    <div class="form-group input-group">
                        <input type="text" class="form-control" name="keyword" id="keyword" value="{!! $kw !!}">
                        <span class="input-group-btn"><button class="btn btn-default" type="Submit"><i class="fa fa-search"></i></button></span>
                    </div>
                {!! Form::close() !!}
                <!-- </div> -->
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Articles</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox"> All</th>
                                        <th>No.</th>
                                        <th>Title</th>
                                        <th>Img</th>
                                        <th>Desc</th>
                                        <th>Cate</th>
                                        <th>Menu</th>
                                        <th>Date</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($arts); $i++)
                                    <tr class="active">
                                        <td><input type="checkbox"></td>
                                        <td>{!! $i + 1 !!}</td>
                                        <td>{!! $arts[$i]->title !!}</td>
                                        <td>{!! $arts[$i]->img !!}</td>
                                        <td>{!! $arts[$i]->desc !!}</td>
                                        <td>{!! $arts[$i]->category_id !!}</td>
                                        <td>{!! $arts[$i]->menu_id !!}</td>
                                        <td>{!! $arts[$i]->created_at !!}</td>
                                        <td>
                                            <button type="button" class="btn btn-xs btn-info">Info</button>
                                            <button type="button" class="btn btn-xs btn-warning">Edit</button>
                                            {!! Html::decode(Html::link('admin/articles/del/'. $arts[$i]->id,'<button type="button" class="btn btn-xs btn-danger">Del</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        {!! $arts->render() !!}         
                    </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
@endsection
   
