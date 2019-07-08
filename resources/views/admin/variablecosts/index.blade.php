@extends('admin.default')

@section('page-header')
    Variable Costs
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.variablecosts.create') }}" method="GET" id="frm_fixed_costs">
            <div class="row">
                <div class="col-md-7">
                    <input type="hidden" id="is_edit" name="is_edit" value="0">
                    <button class="btn btn-info" id="btn-estimate" onclick="edit_estimate()">
                        Edit Estimate
                    </button>

{{--                    <button class="btn btn-success" id="btn-actual" onclick="edit_actual()">--}}
{{--                        Actual--}}
{{--                    </button>--}}

                </div>
                <div class="col-md-2  pull-right">
                    <select class="form-control" name="month" id="month">
                        @for($month=0;$month<12;$month++)
                            <option value="{{$month}}"
                                    @if($_month==$month) selected @endif>{{date_format(date_create("2019-".$month."-01"),"F")}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2  pull-right">

                    <select class="form-control" name="year" id="year">
                        @for($year=2019;$year<2025;$year++)
                            <option value="{{$year}}" @if($_year==$year) selected @endif>{{$year}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-1  pull-right">
                    <button class="form-control btn-primary" onclick="submitForm();">GO</button>
                </div>
            </div>

        </form>
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-20">
        <table class="table table-hover table-striped mB-0" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th class="text-center align-middle" style="background-color:{{config('variables.developer_column')}}">
                    Developers
                </th>

                @foreach($projects as $project)

                    <td style="padding:0!important ;">
                        <table class="table text-center"
                               style="height:100%; border:0 !important;margin-bottom:0!important;">
                            <tr>
                                <td colspan="2" class="c-white"
                                    style="background-color:{{ config('variables.table_column')[$project->id%4]  }};">
                                    {{$project->project_name}}
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                    <h6>EST</h6>
                                </td>
                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][1] }}">
                                    <h6>ACT</h6>
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach
                <td style="padding:0!important ;">
                    <table class="table text-center"
                           style="height:100%; border:0 !important;margin-bottom:0!important;">
                        <tr>
                            <td colspan="2" class="c-white"
                                style="background-color:#9c27b0;">
                                Total
                            </td>
                        </tr>
                        <tr>
                            <td style="width:50%;margin:0!important;background-color:#f3e5f5">
                                <h6>EST</h6>
                            </td>
                            <td style="width:50%;margin:0!important;background-color:#ce93d8">
                                <h6>ACT</h6>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </thead>

            <tbody>
            @foreach ($developers as $item)
                <tr>
                    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                    @foreach($projects as $project)
                        <td style="padding:0!important ;">
                            <table class="table text-center"
                                   style="height:100%; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    @if(isset($assigned_projects[$item->id][$project->id]))
                                        <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">

                                            <h6>
                                                @if(isset($assigned_developers[$item->id][$project->id]))
                                                    {{$assigned_developers[$item->id][$project->id]->estimate_effort}}%
                                                @else
                                                    0%
                                                @endif
                                            </h6>
                                        </td>
                                        <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][1] }}">
                                            <h6>
                                                @if(isset($assigned_developers[$item->id][$project->id]))
                                                    {{$assigned_developers[$item->id][$project->id]->actual_effort}}%
                                                @else
                                                    0%
                                                @endif
                                            </h6>
                                        </td>
                                    @else
                                        <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">

                                            <h6>
                                                --
                                            </h6>
                                        </td>
                                        <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][1] }}">
                                            <h6>
                                                --
                                            </h6>
                                        </td>

                                    @endif

                                </tr>
                            </table>
                        </td>

                    @endforeach
                    <td style="padding:0!important ;">
                        <table class="table text-center"
                               style="height:100%; border:0 !important;margin-bottom:0!important;">

                            <tr>
                                <td style="width:50%;margin:0!important;background-color:#f3e5f5">
                                    <h6>
                                        <b>{{$total_developer_estimated[$item->id]}}%</b>
                                    </h6>
                                </td>
                                <td style="width:50%;margin:0!important;background-color:#ce93d8">
                                    <h6>
                                        <b>{{$total_developer_actual[$item->id]}}%</b>
                                    </h6>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
{{--            <tr>--}}
{{--                <td><b>TOTAL</b></td>--}}
{{--                @foreach($projects as $project)--}}
{{--                    <td style="padding:0!important ;">--}}
{{--                        <table class="table text-center"--}}
{{--                               style="height:100%; border:0 !important;margin-bottom:0!important;">--}}
{{--                            <tr>--}}
{{--                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">--}}
{{--                                    <h6>--}}
{{--                                        @if(isset($total_project_estimated[$project->id]))--}}
{{--                                            <b>{{$total_project_estimated[$project->id]}}%</b>--}}
{{--                                        @else--}}
{{--                                            <b>0%</b>--}}
{{--                                        @endif--}}
{{--                                    </h6>--}}
{{--                                </td>--}}
{{--                                <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][1] }}">--}}
{{--                                    <h6>--}}
{{--                                        @if(isset($assigned_developers[$item->id][$project->id]))--}}
{{--                                            <b>{{$assigned_developers[$item->id][$project->id]->actual_effort}}%</b>--}}
{{--                                        @else--}}
{{--                                            <b>0%</b>--}}
{{--                                        @endif--}}
{{--                                    </h6>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        </table>--}}
{{--                    </td>--}}

{{--                @endforeach--}}

{{--            </tr>--}}
            </tbody>

        </table>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/variablecosts";
            form.submit();
        }

        function edit_estimate() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/variablecosts/edit/edit_variable";
            document.getElementById("is_edit").value = '{{config('variables.EDIT_ESTIMATE_VARIABLE_COST')}}';
            form.submit();
        }

        function edit_actual() {
            const form = document.getElementById("frm_fixed_costs");
            form.action = "/admin/variablecosts/edit/edit_actual";
            document.getElementById("is_edit").value = '{{config('variables.EDIT_ACTUAL_VARIABLE_COST')}}';
            form.submit();
        }
    </script>

@endsection