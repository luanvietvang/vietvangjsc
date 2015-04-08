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
                                        <td class="fontbold">Menu:</td><td>{!! $obj->menu_id !!}</td>
                                        <td class="fontbold">Category:</td><td>{!! $obj->category_id !!}</td>
                                        <td class="fontbold">Hit:</td><td>@if($obj->hit == 1) Yes @else No @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold">Image Vi:</td><td class="text-center">@if($obj->img != '')
                                                {!! Html::image('/upload/articles/'.$obj->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                        <td class="fontbold">Image En:</td>
                                        <td class="text-center">
                                            @if($obj_en->img != '')
                                                {!! Html::image('/upload/articles/'.$obj_en->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @else
                                                {!! Html::image('/upload/noimage.gif', 'img', array( 'width' => 100, 'height' => 100 )) !!}
                                            @endif
                                        </td>
                                        <td class="fontbold">Image Ja:</td>
                                        <td class="text-center">
                                            @if($obj_ja->img != '')
                                                {!! Html::image('/upload/articles/'.$obj_ja->img, 'img', array( 'width' => 100, 'height' => 100 )) !!}
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
                                        <td colspan="2">{!! $obj->title !!}</td>
                                        <td colspan="2">{!! $obj_en->name !!}</td>
                                        <td colspan="2">{!! $obj_ja->name !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="2">Desc Vi</td>
                                        <td class="fontbold" colspan="2">Desc En</td>
                                        <td class="fontbold" colspan="2">Desc Ja</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{!! $obj->desc !!}</td>
                                        <td colspan="2">{!! $obj_en->desc !!}</td>
                                        <td colspan="2">{!! $obj_ja->desc !!}</td>
                                    </tr>
                                    <tr>
                                        <td class="fontbold" colspan="6">fulltext Vi</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">{!! $obj->fulltext !!}</td>
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
                                   <!--  <tr>
                                        <td class="fontbold" colspan="6">SEO's
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td class="fontbold">SEO's</td>
                                        <td colspan="6">
                                            <p><span class="fontitalic fontbold">Title:</span> {!! $obj_seo->title !!}</p>
                                            <p><span class="fontitalic fontbold">Keyword:</span> {!! $obj_seo->keywords !!}</p>
                                            <p><span class="fontitalic fontbold">Description:</span> {!! $obj_seo->description !!}</p>
                                            <p><span class="fontitalic fontbold">Author:</span> {!! $obj_seo->author !!}</p>
                                            <p><span class="fontitalic fontbold">Google_publisher:</span> {!! $obj_seo->google_publisher !!}</p>
                                            <p><span class="fontitalic fontbold">Google_author:</span> {!! $obj_seo->google_author !!}</p>
                                            <p><span class="fontitalic fontbold">Facebook_id:</span> {!! $obj_seo->facebook_id !!}</p>
                                            <p><span class="fontitalic fontbold">Og_title:</span> {!! $obj_seo->og_title !!}</p>
                                            <p><span class="fontitalic fontbold">Og_description:</span> {!! $obj_seo->og_description !!}</p>
                                        </td>
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
   
