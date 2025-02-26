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
                                                       onchange="sumEfforts({{$item->id}},{{$project->id}},this)"
                                                       name="efforts[{{$project->id}}][{{$item->id}}][]"
                                                       value="@if(isset($assigned_developers[$item->id][$project->id]) && $assigned_developers[$item->id][$project->id]!=null){{trim($assigned_developers[$item->id][$project->id]->estimate_effort)}}@else 0 @endif">

                                                <input type="hidden" id="old_{{$item->id}}_{{$project->id}}"
                                                       value="@if(isset($assigned_developers[$item->id][$project->id]) && $assigned_developers[$item->id][$project->id]!=null){{trim($assigned_developers[$item->id][$project->id]->estimate_effort)}}@else 0 @endif">
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            @else
                                <td style=" padding:0!important ;
                                                       background-color:{{ config('variables.table_est_act')[$project->id%4][0]  }}
                                        ">
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
                                        <h6 id="display_developer_{{$item->id}}">
                                            <b>{{$total_developer_estimated[$item->id]}}%</b>
                                        </h6>
                                        @if(isset($total_developer_estimated[$item->id]))
                                            <input id="developer_{{$item->id}}" type="hidden"
                                                   value="{{$total_developer_estimated[$item->id]}}">
                                        @else
                                            <input id="developer_{{$item->id}}" type="hidden"
                                                   value="0">
                                        @endif
                                    </td>

                                </tr>
                            </table>
                        </td>

                    </tr>
                @endforeach

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

        function sumEfforts(developer_id, project_id, dev_effort) {
            var new_effort = dev_effort.value;
            var old_effort = document.getElementById("old_" + developer_id + "_" + project_id).value;
            // var current_project_effort = document.getElementById("project_"+project_id).value;
            var current_developer_effort = document.getElementById("developer_"+developer_id).value;

            // var total_project_effort = (parseFloat(current_project_effort) - old_effort) + parseFloat(new_effort);
            var total_developer_effort = (parseFloat(current_developer_effort) - old_effort) + parseFloat(new_effort);

            // if total project/developer is over 100, reset to previous value
            if(total_developer_effort > 100 ){
                alert('over 100');
                // total_project_effort = (parseFloat(current_project_effort) - new_effort) + parseFloat(new_effort);
                total_developer_effort = (parseFloat(current_developer_effort) - new_effort) + parseFloat(new_effort);
                new_effort = old_effort;
                dev_effort.value = old_effort;
            }


            /* compute for the total project estimate efforts*/
            // document.getElementById("project_"+project_id).value = total_project_effort;
            document.getElementById("developer_"+developer_id).value = total_developer_effort;

            // old input value for effort
            document.getElementById("old_" + developer_id + "_" + project_id).value = parseInt(new_effort);

            /*Display newly computed efforts*/
            // document.getElementById("display_project_" + project_id).innerHTML = '<b>' + total_project_effort + '%</b>';
            document.getElementById("display_developer_" + developer_id).innerHTML = '<b>' + total_developer_effort + '%</b>';


        }
    </script>

@endsection