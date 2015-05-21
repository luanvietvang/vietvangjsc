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
                
                <!-- <div class="row"> -->
                {!! Form::open(array('url' => 'admin/products/search')) !!}
                    <div class="form-group input-group">
                        <input type="text" class="form-control" name="keyword" id="keyword">
                        <span class="input-group-btn"><button class="btn btn-default" type="Submit"><i class="fa fa-search"></i></button></span>
                    </div>
                {!! Form::close() !!}
                <!-- </div> -->
                <div class="row">
                    <div class="col-lg-12">
<!--                         <h2>{!! $title !!}</h2>
 -->                     <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                  <thead>
                                    <tr>
                                        <th><label>No.</label>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($users); $i++)
                                    <tr class="active">
                                         <td><label>{!! $i + 1 !!}</label>
                                        <td>{!! $users[$i]->name !!}</td>
                                        <td>{!! $users[$i]->email !!}</td>
                                        <td>{!! $users[$i]->password !!}</td>
                                        <td>{!! $users[$i]->created_at !!}</td>
                                        <td>{!! $users[$i]->updated_adt !!}</td>
                                        <td>
                                            {!! Html::decode(Html::link('admin/users/edit/'.$users[$i]->id,'<button type="button" class="btn btn-xs btn-warning">Edit</button>')) !!}
                                            {!! Html::decode(Html::link('admin/users/delete/'.$users[$i]->id,'<button type="button" class="btn btn-xs btn-danger">Del</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {!! Html::decode(Html::link('admin/users/add','<button type="button" class="btn btn-primary">Add</button>')) !!}
                                        
                                        <div class="col-md-12 text-center">
                                            {!! $users->render() !!}         
                                        </div> <!-- End .pagination -->
                                    </td>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </div>
                    

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
@endsection
   