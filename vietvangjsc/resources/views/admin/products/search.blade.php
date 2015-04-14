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
                                <i class="fa fa-table"></i> <a href="{{ URL::to('admin/products') }}">{!! $parent !!}</a>
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
                <div class="row">
                    <div class="col-lg-12">
                        @if(count($obj) > 0)
                        <h2>Tìm thấy {!!count($obj)!!} sản phẩm !</h2>
                        <div class="table-responsive">
                            {!! Form::open(array('action' => 'AdminController@productsMutiDel')) !!}
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="chon()" id="check_all">No.</th>
                                        <th>Title</th>
                                        <th>Img</th>
                                        <th>Note</th>
                                        <th>Cate</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Tools</th>>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < count($obj); $i++)
                                    <tr class="active">
                                        <td><input type="checkbox" onclick="chon_item(this.checked)" name="item[]" id="item[]" value="{!! $obj[$i]->id !!}" >{!! $i + 1 !!}</td>
                                        <td>{!! $obj[$i]->name !!}</td>
                                        <td class="text-center">{!! Html::image('/upload/products/'.$obj[$i]->img, 'img', array( 'width' => 70, 'height' => 70 )) !!}</td>
                                        <td>{!! $obj[$i]->note !!}</td>
                                        <td>{!! $obj[$i]->category_id !!}</td>
                                        <td>{!! $obj[$i]->cutomer !!}</td>
                                        <td>{!! $obj[$i]->created_at !!}</td>
                                        <td>
                                            {!! Html::decode(Html::link('admin/products/detail/'. $obj[$i]->id,'<button type="button" class="btn btn-xs btn-info">Info</button>')) !!}
                                            {!! Html::decode(Html::link('admin/products/edit/'. $obj[$i]->id,'<button type="button" class="btn btn-xs btn-warning">Edit</button>')) !!}
                                            {!! Html::decode(Html::link('admin/products/del/'. $obj[$i]->id,'<button type="button" class="btn btn-xs btn-danger">Del</button>')) !!}
                                        </td>
                                    </tr>
                                    @endfor
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        {!! Html::decode(Html::link('admin/products/add','<button type="button" class="btn btn-primary">Add</button>')) !!}
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
                        @else
                        <h2>Không tìm thấy sản phẩm nào với từ khóa [{!! $kw !!}] !</h2>
                        @endif
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
@endsection
   
