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
                    <div class="col-lg-6">
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
                        <h2>{!! $title !!}</h2>
                        <div class="table-responsive">
                            {!! Form::open(array('action' => 'AdminController@articlesMutiDel')) !!}
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="chon()" id="check_all"> All</th>
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
                                        <td><input type="checkbox" onclick="chon_item(this.checked)" name="item[]" id="item[]" value="{!! $arts[$i]->id !!}" ></td>
                                        <td>{!! $i + 1 !!}</td>
                                        <td>{!! $arts[$i]->title !!}</td>
                                        <td class="text-center">{!! Html::image('/upload/articles/'.$arts[$i]->img, 'img', array( 'width' => 70, 'height' => 70 )) !!}</td>
                                        <td>{!! $arts[$i]->desc !!}</td>
                                        <td>{!! $arts[$i]->category_id !!}</td>
                                        <td>{!! $arts[$i]->menu_id !!}</td>
                                        <td>{!! $arts[$i]->created_at !!}</td>
                                        <td>
                                            {!! Html::decode(Html::link('admin/articles/detail/'. $arts[$i]->id,'<button type="button" class="btn btn-xs btn-info">Info</button>')) !!}
                                            {!! Html::decode(Html::link('admin/articles/edit/'. $arts[$i]->id,'<button type="button" class="btn btn-xs btn-warning">Edit</button>')) !!}
                                            {!! Html::decode(Html::link('admin/articles/del/'. $arts[$i]->id,'<button type="button" class="btn btn-xs btn-danger">Del</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {!! Html::decode(Html::link('admin/articles/add','<button type="button" class="btn btn-primary">Add</button>')) !!}
                                        <button type="Submit" class="btn btn-danger">Del</button>
                                        
                                        <div class="col-md-12 text-center">
                                            {!! $arts->render() !!}         
                                        </div> <!-- End .pagination -->
                                    </td>
                                </tr>
                            </tfoot>
                            </table>
                            {!! Form::close() !!} 
                        </div>
                    </div>
                    

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
@endsection
   
