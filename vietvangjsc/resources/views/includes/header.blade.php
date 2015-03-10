<div id="header">
    <div class="hleft">
        <h1>
            {!! Html::decode(Html::link('home-'. $lang . '.html', Html::image('images/logo.png'))) !!}
        </h1>
        <h3>Your problem, our software solution!</h3>
    </div>
    <div class="hcenter">
        <p>{!! $company[0]->title !!}</p>
    </div>
    <div class="hright">
        <ul>
            @if (URL::current() == URL::to('/'))
                <li>{!! Html::decode(Html::link('home-vi.html', Html::image('images/vietnam.png'))) !!}</li>
                <li>{!! Html::decode(Html::link('home-ja.html', Html::image('images/japan.png'))) !!}</li>
                <li>{!! Html::decode(Html::link('home-en.html', Html::image('images/us.png'))) !!}</li>
            @else
                <li>{!! Html::decode(Html::link(str_replace('-'.$lang, '-vi', URL::current()), Html::image('images/vietnam.png'))) !!}</li>
                <li>{!! Html::decode(Html::link(str_replace('-'.$lang, '-ja', URL::current()), Html::image('images/japan.png'))) !!}</li>
                <li>{!! Html::decode(Html::link(str_replace('-'.$lang, '-en', URL::current()), Html::image('images/us.png'))) !!}</li>
            @endif
        </ul>
    </div>
</div>