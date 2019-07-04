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
    public function index(Request $request )
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

        // check if developer is assigned
        foreach($projectdevelopers as $projectdeveloper){
            
        }

        // get estimates per month
        $variable_cost = VariableCost::where('month', $month)
            ->where('year', $year)
            ->whereNull('deleted_at')
            ->get();

        // set containers
        $assigned_developers = [];
        $total_developer_estimated = [];
        $total_developer_actual = [];

        // initialize effort
        foreach($developers as $developer){
            $total_developer_estimated[$developer->id] = 0;
            $total_developer_actual[$developer->id] = 0;
        }

        // comput for each effort
        foreach ($variable_cost as $cost) {
            $assigned_developers[$cost->developer_id][$cost->project_id] = $cost;
            $total_developer_estimated[$cost->developer_id] += $cost->estimate_effort;
            $total_developer_actual[$cost->developer_id] += $cost->actual_effort;
        }

        return view('admin.variablecosts.edit_estimate')
            ->with('items', $items)
            ->with('projects', $projects)
            ->with('developers', $developers)
            ->with('projectdevelopers', $projectdevelopers)
            ->with('assigned_developers', $assigned_developers)
            ->with('total_developer_estimated', $total_developer_estimated)
            ->with('total_developer_actual', $total_developer_actual)
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
    public function update(Request $request, $id)
    {
        /**/
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
