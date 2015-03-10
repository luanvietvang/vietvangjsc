@extends('layouts.layout')

@section('container')
    <div id="container">
        <div class="contact-title-button">
            {!! Html::link('contact-us-'. $lang . '.html', mb_strtoupper($menu[6]->name, 'UTF-8')) !!}
        </div>
        <div class="contact-infomation">
            <ul>
            	<li>{!! Html::image('images/map-pin.png') . ' Địa chỉ: ' . $company[0]->address !!}</li>
            	<li>{!! Html::image('images/telephone.png') . ' Phone: ' . $company[0]->phone !!}</li>
            	<li>{!! Html::image('images/email.png') . ' Email: ' . $company[0]->email !!}</li>
            </ul>
        </div>
        <div class="contact-send">
            <div class="contact-send-content">
            	{!! Form::open(['url' => 'sendMail']) !!}
            		{!! Form::label('lblName', 'Name:') !!}
            		{!! Form::text('name', '') !!}<br/>
            		{!! Form::label('lblEmail', 'Email Address:') !!}
            		{!! Form::text('email', '') !!}<br/>
                    {!! Form::label('lblPosition', 'Position:') !!}
            		{!! Form::text('position', '') !!}<br/>
                    {!! Form::label('lblCompany', 'Company:') !!}
            		{!! Form::text('company', '') !!}<br/>
                    {!! Form::label('lblPhone', 'Phone Number:') !!}
            		{!! Form::text('phone', '') !!}<br/>
            		{!! Form::label('lblService', 'Services:') !!}
            		<div class="checkGroup">
	                    {!! Form::checkbox('services[]', 'it') !!} it&nbsp;&nbsp;
	                    {!! Form::checkbox('services[]', 'Production') !!} Production<br/>
	                    {!! Form::checkbox('services[]', 'trading') !!} trading
	                    {!! Form::checkbox('services[]', 'training & consulting') !!} training & consulting<br/>
	                    {!! Form::checkbox('services[]', 'hotel & restaurant') !!} hotel & restaurant
	                    {!! Form::checkbox('services[]', 'shops') !!} shops<br/>
	                    {!! Form::checkbox('services[]', 'others') !!} others
	                </div>
	                {!! Form::textarea('description') !!}
	                {!! Form::submit('Gửi email', ['class'=>'button blue']) !!}
            	{!! Form::close() !!}
            </div>
        </div>    
    </div>
@endsection