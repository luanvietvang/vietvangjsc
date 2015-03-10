@extends('layouts.layout')

@section('container')
    <div class="staff">
        <h3>{!! mb_strtoupper($menu[4]->name, 'UTF-8') !!}</h3>
        {!! $new[0]->fulltext !!}
    </div>
@endsection