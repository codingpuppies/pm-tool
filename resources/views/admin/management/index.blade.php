@extends('admin.default')

@section('page-header')
    Management <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ route(ADMIN . '.management.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }}
        </a>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Employee No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tfoot>
                <tr>
                    <th>Employee No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>
                            <a href="{{ route(ADMIN . '.developers.edit', $item->id) }}">{{ $item->employee_number }}</a>
                        </td>
                        <td>
                            <a href="{{ route(ADMIN . '.developers.edit', $item->id) }}">{{ $item->first_name }} {{ $item->last_name }}</a>
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>{{ config('variables.mgt_position')[$item->position] }}</td>
                        <td>{{ config('variables.mgt_department')[$item->department] }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.developers.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.developers.destroy', $item->id),
                                        'method' => 'DELETE',
                                        ]) 
                                    !!}

                                        <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>
                                        
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
    </div>

@endsection