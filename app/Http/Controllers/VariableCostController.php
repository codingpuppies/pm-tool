<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Project;
use App\ProjectDeveloper;
use App\VariableCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VariableCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get data for specific month and year, default is current month and year
        $month = isset($request->month) ? $request->month : (int)date('m');
        $year = isset($request->year) ? $request->year : (int)date('Y');

        $items = VariableCost::where('month', $month)
            ->where('year', $year)
            ->get();

        // get projects
        $projects = Project::all();

        // get developer lists
        $developers = Developer::where('department', '!=', config('variables.role_code')['MGT'])
            ->orderBy('position', "desc")
            ->get();

        // project assigned developers
        $projectdevelopers = ProjectDeveloper::all();


        // get estimates per month
        $variable_cost = VariableCost::where('month', $month)
            ->where('year', $year)
            ->whereNull('deleted_at')
            ->get();

        // set containers
        $assigned_developers = [];
        $total_developer_estimated = [];
        $total_developer_actual = [];
        $total_project_estimated = [];
        $total_project_actual = [];
        $assigned_projects = [];

        // initialize effort
        foreach ($developers as $developer) {
            $total_developer_estimated[$developer->id] = 0;
            $total_developer_actual[$developer->id] = 0;
        }
        // initialize project total assigned efforts
        foreach ($projects as $project) {
            $total_project_estimated[$project->id] = 0;
            $total_project_actual[$project->id] = 0;
        }

        // check if assigned in project
        foreach ($developers as $developer) {
            foreach ($projectdevelopers as $proj_developer) {
                if ($proj_developer->developer_id == $developer->id) {
                    $assigned_projects[$developer->id][$proj_developer->project_id] = true;
                }
            }
        }

        // comput for each effort
        foreach ($variable_cost as $cost) {
            $assigned_developers[$cost->developer_id][$cost->project_id] = $cost;

            // increment developer total efforts
            $total_developer_estimated[$cost->developer_id] += $cost->estimate_effort;
            $total_developer_actual[$cost->developer_id] += $cost->actual_effort;

            // increment developer total efforts
            $total_project_estimated[$cost->project_id] += $cost->estimate_effort;
            $total_project_actual[$cost->project_id] += $cost->actual_effort;


        }

        $url = '';
        if (isset($request->is_edit)) {
            if ($request->is_edit == config('variables.EDIT_ESTIMATE_VARIABLE_COST')) {
                $url = 'admin.variablecosts.edit_estimate';
            }else if ($request->is_edit == config('variables.EDIT_ACTUAL_VARIABLE_COST')) {
                $url = 'admin.variablecosts.edit_actual';
            }else{
                $url = 'admin.variablecosts.index';
            }
        } else {
            $url = 'admin.variablecosts.index';
        }

        return view($url)
            ->with('items', $items)
            ->with('projects', $projects)
            ->with('developers', $developers)
            ->with('projectdevelopers', $projectdevelopers)
            ->with('assigned_developers', $assigned_developers)
            ->with('assigned_projects', $assigned_projects)
            ->with('total_developer_estimated', $total_developer_estimated)
            ->with('total_developer_actual', $total_developer_actual)
            ->with('total_project_estimated', $total_project_estimated)
            ->with('total_project_actual', $total_project_actual)
            ->with('variable_cost', $variable_cost)
            ->with('_month', $month)
            ->with('_year', $year);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $month = isset($request->month) ? $request->month : (int)date('m');
        $year = isset($request->year) ? $request->year : (int)date('Y');


        return view('admin.variablecosts.create')
            ->with('_month', $month)
            ->with('_year', $year);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get particulars and amount
        $month = $request->month;
        $year = $request->year;
        $particular = $request->particular;
        $amount = $request->amount;

        VariableCost::create([
            'month' => $month,
            'year' => $year,
            'particular' => $particular,
            'amount' => $amount
        ]);

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $item = VariableCost::find($id);
        if ($item) {
            $month = $item->month;
            $year = $item->year;
        } else {
            $month = isset($request->month) ? $request->month : (int)date('m');
            $year = isset($request->year) ? $request->year : (int)date('Y');
        }

        return view('admin.variablecosts.edit')
            ->with('item', $item)
            ->with('_month', $month)
            ->with('_year', $year);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mode)
    {
        /**/
        $efforts = $request->efforts;

        // get project id as array keys
        $projects = array_keys($efforts);

        // each effort input is arrayed, so project then developer index
        foreach ($projects as $project) {
            // get developer id via array key
            $developers = array_keys($efforts[$project]);

            foreach ($developers as $developer) {
                // get inputted effort value
                $effort = $efforts[$project][$developer][0];
                if($effort === null || $effort == '') $effort = 0;

                // search if existing effort per project
                $variable_cost = VariableCost::where('project_id', $project)
                    ->where('developer_id', $developer)
                    ->where('month', $request->month)
                    ->where('year', $request->year)
                    ->whereNull('deleted_at')
                    ->first();

                // if there is no value yet, create
                if (!$variable_cost) {

                    $record = new VariableCost();
                    $record->project_id = $project;
                    $record->developer_id = $developer;
                    $record->estimate_effort = $effort;
                    $record->actual_effort = 0;
                    $record->month = $request->month;
                    $record->year = $request->year;
                    $record->mode = 1;
                    $record->date = date('Y-m-d');
                    $record->save();

                } else {
                    // if existing, update

                    VariableCost::where('project_id', $project)
                        ->where('developer_id', $developer)
                        ->where('month', $request->month)
                        ->where('year', $request->year)
                        ->whereNull('deleted_at')
                        ->update([
                            'estimate_effort' => $effort
                        ]);

                }
            }
        }
        return redirect()->route(ADMIN . '.variablecosts.index', ['month' => $request->month, 'year' => $request->year])->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fixed_cost = VariableCost::find($id);
        $fixed_cost->amount = '0';
        $fixed_cost->save();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
