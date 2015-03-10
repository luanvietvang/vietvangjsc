@extends('layouts.layout')

@section('container')
	<div id="container">
        <div class="about-2-left">
            <h3>{!! mb_strtoupper($info[0]->title,'UTF-8') !!}</h3>    
            {!!  $info[0]->fulltext !!}  
        </div>
    </div>
@endsection
