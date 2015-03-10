@extends('layouts.layout')

@section('container')
	<div id="container">
        <div class="new-title-button">
            @if ($blag == '1')
                {!! Html::link('recruitment-' . $lang . '.html', mb_strtoupper($menu[5]->name, 'UTF-8')) !!}
            @else
                {!! Html::link('news-' . $lang . '.html', mb_strtoupper($menu[3]->name, 'UTF-8')) !!}
            @endif
        </div>
        @if (count($news) != 0)
            <div class="new-page-content">
                 <div class="new-page-content-left">
                     @foreach ($news as $key => $value) 
                        <div class="new-page-content-left-01">
                            <div class="new-page-content-left-title">
                                <div class="new-page-content-left-dd-mm-yy">
                                    <p>{!! date_parse($value->created_at)['day'] . '-' . date_parse($value->created_at)['month']  !!}<br><span>{!!date_parse($value->created_at)['year']!!}</p>
                                </div>
                                 <div class="new-page-content-left-titlename">
                                    {!! Html::link($value->alias. '-n' . $value->id . '-' . $lang . '.html', mb_strtoupper($value->title, 'UTF-8')) !!}
                                </div>
                            </div>
                            <div class="new-page-content-left-content">
                                {!! $value->desc !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="new-page-next-previuos">
                <a class="new-page-next-previuos-button" href="#"></a>
                    <a class="new-page-next-next-button" href="#"></a>
            </div>
        @else
            <div class="new-page-content">
                <p style="margin:20px; font-size:16px">Hiện tại chưa có tin tuyển dụng.</p>
            </div>
        @endif
    </div>
@endsection