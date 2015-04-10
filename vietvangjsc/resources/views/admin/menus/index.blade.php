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
                        </ol>
                    </div>
                </div>
                <!-- Show message -->
                <div class="row">
                    <div class="col-lg-6">
                        {!! $msg !!}
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
<!--                         <h2>{!! $title !!}</h2>
 -->                        <div class="table-responsive">
                            {!! Form::open(array('action' => 'AdminController@categoriesMutiDel')) !!}
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="chon()" id="check_all"> All</th>
                                        <th>No.</th>
                                        <th>Title</th>
                                        <th>Img</th>
                                        <th>Desc</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($obj); $i++)
                                    <tr class="active">
                                        <td><input type="checkbox" onclick="chon_item(this.checked)" name="item[]" id="item[]" value="{!! $obj[$i]->id !!}" ></td>
                                        <td>{!! $i + 1 !!}</td>
                                        <td>{!! $obj[$i]->name !!}</td>
                                        <td class="text-center">{!! Html::image('/upload/categories/'.$obj[$i]->logo, 'img', array( 'width' => 70, 'height' => 70 )) !!}</td>
                                        <td>{!! $obj[$i]->desc !!}</td>
                                        <td>
                                            {!! Html::decode(Html::link('admin/categories/edit/'. $obj[$i]->id,'<button type="button" class="btn btn-xs btn-warning">Edit</button>')) !!}
                                            {!! Html::decode(Html::link('admin/categories/del/'. $obj[$i]->id,'<button type="button" class="btn btn-xs btn-danger">Del</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {!! Html::decode(Html::link('admin/categories/add','<button type="button" class="btn btn-primary">Add</button>')) !!}
                                        <button type="Submit" class="btn btn-danger">Del</button>
                                        
                                        <div class="col-md-12 text-center">
                                            {!! $obj->render() !!}         
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
   
