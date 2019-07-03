@extends('admin.default')

@section('page-header')
    Project Developers
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">
        <a href="{{ route(ADMIN . '.projects.create') }}" class="btn btn-info">
            {{ trans('app.add_button') }} Project
        </a>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Project Name</th>
                <th>Project Manager</th>
                <th>Developers</th>
                <th>Action</th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Project Name</th>
                <th>Project Manager</th>
                <th>Developers</th>
                <th>Action</th>
            </tr>
            </tfoot>

            <tbody>
            @foreach ($projects as $item)
                <tr>
                    <td><a href="{{ route(ADMIN . '.users.edit', $item->id) }}">{{ $item->project_name }}</a></td>
                    <td>
                        @foreach($assigned_devs as $dev)
                            @if($dev['project_id']==$item->id)
                                @if($dev['role']==config('variables.role_code')['PM'])
                                    @foreach($developers as $developer)
                                        @if($developer['id']==$dev['developer_id'])
                                            <a href="#">
                                                {{$developer['first_name']}} {{$developer['last_name']}}
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($assigned_devs as $dev)
                            @if($dev['project_id']==$item->id)
                                @if($dev['role']==config('variables.role_code')['DEVELOPER'])
                                    @foreach($developers as $developer)
                                        @if($developer['id']==$dev['developer_id'])
                                            <a href="#">
                                            {{$developer['first_name']}} {{$developer['last_name']}}<br>
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        @endforeach
                    </td>
{{--                    <td>{{ $item->description }}</td>--}}
{{--                    <td>{{ $item->tcp }}</td>--}}
{{--                    <td>{{ compute_month_diff($item->estimated_start_date,$item->estimated_end_date)}} months</td>--}}
{{--                    <td>{{ $item->estimated_start_date }}</td>--}}
{{--                    <td>{{ $item->estimated_end_date }}</td>--}}
{{--                    <td>{{ config('variables.project_status')[$item->status] }}</td>--}}
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ route(ADMIN . '.projectdevelopers.edit', $item->id) }}"
                                   title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span
                                            class="ti-pencil"></span></a></li>
{{--                            <li class="list-inline-item">--}}
{{--                                {!! Form::open([--}}
{{--                                    'class'=>'delete',--}}
{{--                                    'url'  => route(ADMIN . '.projectdevelopers.destroy', $item->id),--}}
{{--                                    'method' => 'DELETE',--}}
{{--                                    ])--}}
{{--                                !!}--}}

{{--                                <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i--}}
{{--                                            class="ti-trash"></i></button>--}}

{{--                                {!! Form::close() !!}--}}
{{--                            </li>--}}
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

@endsection