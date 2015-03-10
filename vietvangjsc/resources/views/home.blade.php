@extends('layouts.layout')

@section('container')
<div class="service">
    <div class="service-pos">
        <div class="service-pos-top">
            {!! Html::image('images/'. $categories[0]->logo) !!}
            {!! Html::link( $categories[0]->alias . '-' . $categories[0]->id . '-' . $lang . '.html', $categories[0]->name) !!}
        </div>
        <div class="service-pos-bottom">
            <ul class="description">
                {!! $categories[0]->desc !!}
            </ul>
            <ul class="customer">
                @foreach ($partners as $value)
                    <li>{!! Html::decode(Html::link($value->url, Html::image('images/' . $value->logo))) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="service-crm">
        <div class="service-crm-top">
            {!! Html::image('images/'. $categories[1]->logo) !!}
            {!! Html::link( $categories[1]->alias . '-' . $categories[1]->id . '-' . $lang . '.html', $categories[1]->name) !!}
        </div>
        <div class="service-crm-bottom">
            <ul class="description">
                {!! $categories[1]->desc !!}
            </ul>
            <ul class="customer">
                @foreach ($partners as $value)
                    <li>{!! Html::decode(Html::link($value->url, Html::image('images/' . $value->logo))) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="service-hrm">
        <div class="service-hrm-top">
            {!! Html::image('images/'. $categories[2]->logo) !!}
            {!! Html::link( $categories[2]->alias . '-' . $categories[2]->id . '-' . $lang . '.html', $categories[2]->name) !!}
        </div>
        <div class="service-hrm-bottom">
            <ul class="description">
                {!! $categories[2]->desc !!}
            </ul>
            <ul class="customer">
                @foreach ($partners as $value)
                    <li>{!! Html::decode(Html::link($value->url, Html::image('images/' . $value->logo))) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="service-seo">
        <div class="service-seo-top">
            {!! Html::image('images/'. $categories[3]->logo) !!}
            {!! Html::link( $categories[3]->alias . '-' . $categories[3]->id . '-' . $lang . '.html', $categories[3]->name) !!}
        </div>
        <div class="service-seo-bottom">
            <ul class="description">
                {!! $categories[3]->desc !!}
            </ul>
            <ul class="customer">
                @foreach ($partners as $value)
                    <li>{!! Html::decode(Html::link($value->url, Html::image('images/' . $value->logo))) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="service-continue">
    <div class="service-webdesign">
        <div class="service-webdesign-left">
            {!! Html::image('images/'. $categories[4]->logo) !!}
        </div>
        <div class="service-webdesign-right">
            {!! Html::link( $categories[4]->alias . '-' . $categories[4]->id . '-' . $lang . '.html', $categories[4]->name) !!}
            <ul class="description">
                {!! $categories[4]->desc !!}
            </ul>
            <ul class="customer">
                @foreach ($partners as $value)
                    <li>{!! Html::decode(Html::link($value->url, Html::image('images/' . $value->logo))) !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="slider-images">
        {!! Html::decode(Html::link($hitNew[0]->alias.'-n'.$hitNew[0]->id.'-'.$lang.'.html', Html::image('images/' . $hitNew[0]->img))) !!}
    </div>
</div>
<div class="news-content">
    <div class="hot-news">
        <div class="hot-news01">
            <div class="hot-news-button01">
                <p>{!! Html::decode(Html::link($menu[3]->alias . '-' . $lang . '.html',mb_strtoupper($menu[3]->name, 'UTF-8'))) !!}</p>
            </div>
            <div class="hot-news-title01">
                <div class="hot-news-day01">
                    <p>{!! date_parse($news[0]->created_at)['day'] . '-' . date_parse($news[0]->created_at)['month']  !!}<br><span>{!!date_parse($news[0]->created_at)['year']!!}</span></p>
                </div>
                <div class="hot-news-titlecontent">
                    {!! Html::decode(Html::link($news[0]->alias . '-n' . $news[0]->id . '-' . $lang . '.html', mb_strtoupper($news[0]->title, 'UTF-8'))) !!}
                </div>
            </div>
            <div class="hot-news-content01">
                <p>
                    {!! Html::image('images/'.$news[0]->img, '', ['align'=>'left', 'style'=>'padding-right: 5px; width:100px; height:100px']) !!}
                    {!! $news[0]->desc !!}
                </p>
            </div>
        </div>
        <div class="hot-news02">
            <div class="hot-news-title02">
                <div class="hot-news-day02">
                    <p>{!! date_parse($news[1]->created_at)['day'] . '-' . date_parse($news[1]->created_at)['month']  !!}<br><span>{!!date_parse($news[1]->created_at)['year']!!}</span></p>
                </div>
                <div class="hot-news-titlecontent">
                    {!! Html::decode(Html::link($news[1]->alias . '-n' . $news[1]->id . '-' . $lang . '.html', mb_strtoupper($news[1]->title, 'UTF-8'))) !!}
                </div>
            </div>
            <div class="hot-news-content02">
                <p>
                    {!! Html::image('images/'.$news[1]->img, '', ['align'=>'left', 'style'=>'padding-right: 5px;; width:100px; height:100px']) !!}
                    {!! $news[1]->desc !!}
                </p>
            </div>
            <div class="next-previuos">
                <a class="previuos-button" href="#"></a>
                <a class="next-button" href="#"></a>
            </div>
        </div>
    </div>
    <div class="hotline">
        <div class="hotline-button01">
                <p>HOTLINE</p>
        </div>
        <div class="hotline-content01">
            <a class="hotline-phone-large" href="#"><img src="images/phone-large.png" alt="phone" /></a>
            <p>{!! $company[0]->phone !!}</p>
            {!! Html::decode(Html::link('', Html::image('images/email-icon.png'). ' ' .$company[0]->email, ['class'=>'imail-contact'])) !!}
            {!! Html::decode(Html::link('', Html::image('images/skype_icon.png'). ' ' . $company[0]->skype, ['class'=>'skype-contact'])) !!}
        </div>
    </div>
</div>
@endsection
