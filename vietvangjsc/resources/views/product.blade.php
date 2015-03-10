@extends('layouts.layout')

@section('container')
	<div id="container">
        <div class="gnav-product">
            <ul>
                <li>{!! Html::link('products-'. $lang . '.html', 'All') !!}</li>
                @foreach ($categories as $key => $value) 
                	<li>{!! Html::link($value->alias . '-c' . $value->id .'-' . $lang . '.html', $value->name) !!}</li>
                @endforeach
            </ul>
        </div>
        <div class="product-detail">
                    <div class="product-detail-title">
                        <div class="product-detail-title-image">
                            {!! Html::image('images/'. $product[0]->img) !!}
                        </div>
                        <div class="product-detail-title-detail">
                            <p>{!! $product[0]->name !!}</p>
                            {!! $product[0]->note !!}
                        </div>
                    </div>
                    <div class="product-detail-tab"> 
                        <section class="tabs">
                            <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
                            <label for="tab-1" class="tab-label-1">GIỚI THIỆU CHUNG</label>
                            <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
                            <label for="tab-2" class="tab-label-2">HÌNH ẢNH</label>
                            <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3" />
                            <label for="tab-3" class="tab-label-3">KHÁCH HÀNG</label>
                            <div class="clear-shadow"></div>
                            <div class="content">
                                <div class="content-1">
                                    {!! $product[0]->desc !!}
                                </div>
                                <div class="content-2">
                                    <p>Some content</p>
                                </div>
                                <div class="content-3">
                                    <p>Some content</p>
                                </div>
                            </div>
                        </section>
                    </div> 
                </div>
    </div>
@endsection