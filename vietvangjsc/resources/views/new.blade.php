@extends('layouts.layout')

@section('container')
	<div id="container">
        <div class="about-left">
            {!! Html::image('images/' . $new[0]->img, '', ['style'=>'width:600px; height: 312px;']) !!}
            <br/><br/>
            <h3>{!! mb_strtoupper($new[0]->title, 'UTF-8') !!}</h3>
            <br/>
            {!! $new[0]->desc !!}
        </div>
        <div class="about-right">
            <div class="other-news-button">
                {!! Html::decode(Html::link('', Html::image('images/other-icon.png') . 'TIN KHÁC')) !!}
            </div>
            @foreach ($otherNew as $key => $value)
                <div class="new-page-content-left-other-01">
                    <div class="new-page-content-left-other-title">
                        <div class="new-page-content-left-other-dd-mm-yy">
                            <p>{!! date_parse($value->created_at)['day'] . '-' . date_parse($value->created_at)['month']  !!}<br><span>{!!date_parse($value->created_at)['year']!!}</p>
                        </div>
                        <div class="new-page-content-left-other-titlename">
                            {!! Html::link($value->alias. '-n' . $value->id . '-' . $lang . '.html', mb_strtoupper($value->title, 'UTF-8')) !!}
                        </div>
                    </div>
                    <div class="new-page-content-left-other-content">
                        {!! $value->desc !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection