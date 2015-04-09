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
                                {!! Html::decode(Html::link(URL::previous(),'<button type="button" class="btn btn-success">BACK</button>')) !!}
                            </li>
                        </ol>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="table-responsive">
                            <table class="table" style="border: none !important">
                                <tbody>
                                    <tr>
                                        <td class="fontbold">Category:</td><td colspan="2">{!! $obj->category_id !!}</td>
                                        <td class="fontbold">Customer:</td><td colspan="2">{!! $obj->cutomer !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold">Image Vi:</td><td class="text-center">@if($obj->img != '')
                                                {!! Html::image('/upload/products/'.$obj->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                        <td class="fontbold">Image En:</td>
                                        <td class="text-center">
                                            @if($obj_en->img != '')
                                                {!! Html::image('/upload/products/'.$obj_en->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                        <td class="fontbold">Image Ja:</td>
                                        <td class="text-center">
                                            @if($obj_ja->img != '')
                                                {!! Html::image('/upload/products/'.$obj_ja->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold">List img</td>
                                        <td class="fontbold" colspan="5">
                                            @if($obj->list_img != '')
                                                @foreach((explode(',', $obj->list_img)) as $img)
                                                    {!! Html::image('/upload/products/'.$img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                                @endforeach
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="2">Title Vi</td>
                                        <td class="fontbold" colspan="2">Title En</td>
                                        <td class="fontbold" colspan="2">Title Ja</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{!! $obj->name !!}</td>
                                        <td colspan="2">{!! $obj_en->name !!}</td>
                                        <td colspan="2">{!! $obj_ja->name !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="2">Desc Vi</td>
                                        <td class="fontbold" colspan="2">Desc En</td>
                                        <td class="fontbold" colspan="2">Desc Ja</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{!! $obj->note !!}</td>
                                        <td colspan="2">{!! $obj_en->desc !!}</td>
                                        <td colspan="2">{!! $obj_ja->desc !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="6">fulltext Vi</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">{!! $obj->desc !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="6">fulltext En</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">{!! $obj_en->fulltext !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="6">fulltext Ja</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">{!! $obj_ja->fulltext !!}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                            {!! Html::decode(Html::link(URL::previous(),'<button type="button" class="btn btn-danger">CLOSE</button>')) !!}
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
   
