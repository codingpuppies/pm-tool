@extends('admin.default')

@section('page-header')
	Projects <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['ProjectController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.projects.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
