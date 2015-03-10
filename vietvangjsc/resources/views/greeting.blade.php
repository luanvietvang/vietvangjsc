@extends('layouts.layout')

@section('container')
<div class="about-left">
    <h3>{!!  mb_strtoupper($info[0]->title,'UTF-8') !!}</h3>
    <p>{!!  $info[0]->fulltext !!}</p>
</div>
<div class="about-right">
    <div class="boss-image">
        {!! Html::image('images/'.$info[0]->img) !!}
        <p>{!! $company[0]->director  !!}</p>
    </div>
    <div class="menu-right-lv2">
        <ul>
            @foreach ($subMenu as $key=>$subValue)
                @if ($key != 0)
                    @if ($key != 4)
                        <li>{!! Html::decode(Html::link($subValue->alias . '-' . $lang . '.html', Html::image('images/add-icon.png') . $subValue->name)) !!}</li>
                    @else
                        <li class="li-end">{!! Html::decode(Html::link($subValue->alias . '-' . $lang . '.html', Html::image('images/add-icon.png') . $subValue->name)) !!}</li>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endsection