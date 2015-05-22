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
                                        <th>Director</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Language</th>
                                        <th>Tool</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($companies); $i++)
                                    <tr class="active">
                                        <td><label>{!! $i + 1 !!}</label>
                                        <td>{!! $companies[$i]->name !!}</td>
                                        <td>{!! $companies[$i]->director !!}</td>
                                        <td>{!! $companies[$i]->address !!}</td>
                                        <td>{!! $companies[$i]->phone !!}</td>
                                        @if ($companies[$i]->lang == 'vi')
                                        <td><label>Tiếng Việt</label></td>
                                        @endif
                                        @if ($companies[$i]->lang == 'en')
                                        <td><label>Tiếng Anh</label></td>
                                        @endif
                                        @if ($companies[$i]->lang == 'ja')
                                        <td><label>Tiếng Nhật</label></td>
                                        @endif
                                        <td>
                                            {!! Html::decode(Html::link('admin/company/edit/'.$companies[$i]->id,'<button type="button" class="btn btn-xs btn-warning">Edit</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {!! Html::decode(Html::link('admin/company/location','<button type="button" class="btn btn-primary">Location</button>')) !!}
                                        
                                        <div class="col-md-12 text-center">      
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
   