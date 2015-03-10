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
        <div class="list-products">
            @foreach ($products as $key => $value) 
                <div class="item">
                    {!! Html::decode(Html::link($value->alias . '-p' . $value->id . '-' . $lang .'.html', Html::image('images/' . $value->img))) !!}
                    {!! Html::link($value->alias . '-p' . $value->id . '-' . $lang .'.html', $value->name, ['class'=>'title-product']) !!}
                </div>
            @endforeach
        </div>
    </div>
@endsection