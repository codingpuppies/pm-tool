@extends('admin.default')

@section('page-header')
	Fixed Costs Particular <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($items, [
			'action' => ['FixedCostController@update', 0],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.fixedcosts.form')

		<button type="submit" class="btn btn-primary">{{ trans('app.edit_button') }}</button>
		
	{!! Form::close() !!}
	
@stop
