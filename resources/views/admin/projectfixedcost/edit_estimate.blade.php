@extends('admin.default')

@section('page-header')
    Project Fixed Costs Allocation Update
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
            <input type="hidden" name="year" value="{{$_year}}">


            <table class="table table-striped mB-0" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th class="text-center align-middle"
                        style="background-color:{{config('variables.developer_column')}}">
                        Project
                    </th>
                    @for($month=1;$month<=12;$month++)
                        <td style="padding:0!important; width:7%">
                            <table class="table text-center"
                                   style="height:100%; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    <td colspan="2" class="c-white c-white text-center"
                                        style="background-color:{{ config('variables.table_column')[$month]}};">
                                        {{date_format(date_create("2019-".($month)."-01"),"M")}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="c-white"
                                        style="background-color:{{ config('variables.table_column')[$month]}}">
                                        <h6>{{$projects_per_month[$month]}}</h6>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endfor

                </tr>
                </thead>

                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td style="padding:0!important ;">
                            <table class="table text-center"
                                   style="height:100%; border:0 !important;margin-bottom:0!important;">
                                <tr>
                                    <td colspan="2">
                                        {{$project->project_name}}
                                    </td>
                                </tr>

                            </table>
                        </td>
                        @for($month=1;$month<=12;$month++)
                            @if(date_format(date_create($project->actual_start_date),"m") <= $month
                            && ( $project->actual_end_date == null
                            || date_format(date_create($project->actual_end_date),"Y-m-d") >= date_format(date_create($_year.'-'.$month.'-01'),"Y-m-d")))

                                @if(isset($project_fixed_allocation[$project->id][$month]))
                                    @foreach($allocated_efforts as $effort)
                                        @if($effort->project_id == $project->id && $effort->month == $month)
                                            <td style="width:7.5%;margin:0!important;">
                                                <b>
                                                    <input placeholder="0" type="number" class="form-control"
                                                           name="efforts[{{$project->id}}][{{$month}}][]"
                                                           value="{{$effort->percentage}}">

                                                    <input type="hidden" id="old_{{$month}}_{{$project->id}}"
                                                           value="{{$effort->percentage}}">

                                                </b>
                                            </td>
                                        @endif
                                    @endforeach
                                @else
                                    <td style="width:7.5%;margin:0!important;">
                                        <b>
                                            <input placeholder="0" type="number" class="form-control"
                                                   min="0"
                                                   name="efforts[{{$project->id}}][{{$month}}][]"
                                                   value="0">

                                            <input type="hidden" id="old_{{$month}}_{{$project->id}}"
                                                   value="0">

                                        </b>
                                    </td>
                                @endif
                            @else
                                <td>
                                    <input placeholder="" type="text" class="form-control"
                                           disabled readonly=""
                                           title="Unavailable"
                                           value="">
                                </td>
                            @endif
                        @endfor
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
    </script>

@endsection