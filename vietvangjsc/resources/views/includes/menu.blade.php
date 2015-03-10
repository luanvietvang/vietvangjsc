<div id="gnav">
    <ul>
        @foreach ($menu as $key=>$value)
            @if ($key == 1)
                <li>
                    {!! Html::link($subMenu[0]->alias . '-' . $lang . '.html', mb_strtoupper($value->name, 'UTF-8')) !!}
                    <ul>
                        @foreach ($subMenu as $subValue)
                            <li>{!! Html::link($subValue->alias . '-' . $lang . '.html', $subValue->name) !!}</li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li>
                    {!! Html::link( $value->alias . '-' . $lang . '.html', mb_strtoupper($value->name, 'UTF-8')) !!}
                </li>
            @endif
        @endforeach
    </ul>
</div>