@extends('admin.default')

@section('page-header')
	Other Costs <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['ProjectController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.othercosts.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
