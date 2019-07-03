@extends('admin.default')

@section('page-header')
	Manager <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['DeveloperController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.management.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
