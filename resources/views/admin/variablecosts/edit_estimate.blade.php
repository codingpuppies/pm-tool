@extends('admin.default')

@section('page-header')
    Variable Costs - Estimates Update
    <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')

    <div class="mB-20">

        <form action="{{ route(ADMIN . '.variablecosts.index') }}" method="GET" id="frm_variable_cost">
            <input type="hidden" id="is_edit" name="is_edit" value="0">

            <div class="row">
                <div class="col-md-7">

                    <button class="btn btn-info">
                        Back
                    </button>


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


    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-20 pB-60">

        <form action="/admin/variablecosts/1" method="post">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <input type="hidden" name="month" value="{{$_month}}">
            <input type="hidden" name="year" value="{{$_year}}">


            <table class="table table-striped mB-0" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="text-center align-middle"
                        style="background-color:{{config('variables.developer_column')}}">
                        Developers
                    </th>


                    @foreach($projects as $project)

                        <td style="padding:0!important; width:10%">
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
                            @if(isset($assigned_projects[$item->id][$project->id]))
                                <td style="padding:0!important ;">
                                    <table class="table text-center"
                                           style="height:100%; border:0 !important;margin-bottom:0!important;">
                                        <tr>
                                            <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                                <input placeholder="0" type="number" class="form-control"
                                                       onchange="sumEfforts({{$project->id}},this.value)"
                                                       name="efforts[{{$project->id}}][{{$item->id}}][]"
                                                       value="@if(isset($assigned_developers[$item->id][$project->id]) && $assigned_developers[$item->id][$project->id]!=null){{trim($assigned_developers[$item->id][$project->id]->estimate_effort)}}@else 0 @endif">
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            @else
                                <td style="padding:0!important ; background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                    <table class="table text-center"
                                           style="height:100%; border:0 !important;margin-bottom:0!important;">
                                        <tr>
                                            <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                                <label class="form-label">--</label>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            @endif

                        @endforeach
                        <td style="padding:0!important; background-color:#f3e5f5;">
                            <table class="table text-center"
                                   style="height:100% !important; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    <td style="height:100% !important; width:50%;margin:0!important;background-color:#f3e5f5">
                                        <h6>
                                            <b>{{$total_developer_estimated[$item->id]}}%</b>
                                        </h6>
                                    </td>

                                </tr>
                            </table>
                        </td>

                    </tr>
                @endforeach
                <tr>
                    <td><b>TOTAL</b></td>
                    @foreach($projects as $project)
                        <td style="padding:0!important;">
                            <table class="table text-center"
                                   style="height:100%; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    <td style="width:50%;margin:0!important;background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}">
                                        <h6 id="display_{{$project->id}}">
                                            @if(isset($total_project_estimated[$project->id]))
                                                <b>{{$total_project_estimated[$project->id]}}%</b>
                                            @else
                                                <b>0%</b>
                                            @endif
                                        </h6>
                                        @if(isset($total_project_estimated[$project->id]))
                                            <input id="{{$project->id}}" type="hidden" value="{{$total_project_estimated[$project->id]}}">
                                        @else
                                            <input id="{{$project->id}}" type="hidden" value="0">
                                        @endif
                                    </td>

                                </tr>
                            </table>
                        </td>

                    @endforeach

                </tr>

                </tbody>

            </table>
            <button class="pull-right btn btn-primary mt-2">UPDATE</button>
            <button class="pull-right btn btn-outline-danger mt-2 mr-1">CANCEL</button>
        </form>
    </div>

    <script>
        function submitForm() {
            const form = document.getElementById("frm_variable_cost");
            form.action = "/admin/variablecosts/edit/edit_variable";
            document.getElementById("is_edit").value = '{{config('variables.EDIT_ESTIMATE_VARIABLE_COST')}}';
            form.submit();
        }

        function sumEfforts(id,new_val) {
            var current_effort = document.getElementById(id).value;
            var total_effort = parseFloat(current_effort) + parseFloat(new_val);
            document.getElementById(id).value = total_effort;
            document.getElementById("display_"+id).innerHTML = '<b>'+total_effort+'%</b>';

        }
    </script>

@endsection