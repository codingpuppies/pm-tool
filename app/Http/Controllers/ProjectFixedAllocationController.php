<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Project;
use App\ProjectDeveloper;
use App\ProjectFixedAllocation;
use App\VariableCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectFixedAllocationController extends Controller
{
    public function index(Request $request)
    {
        // get data for specific year, default is current month and year
        $year = isset($request->year) ? $request->year : (int)date('Y');

        // get projects
        $projects = Project::where(function ($query) use ($year) {
            $query->whereBetween('actual_start_date', [$year . '-01-31', $year . '-12-31'])
                ->orWhereBetween('actual_end_date', [$year . '-01-31', $year . '-12-31'])
                ->orWhereNull('actual_end_Date');
        })

            ->get();;

        // get allocation per month
        $allocated_efforts = ProjectFixedAllocation::where('year', $year)
            ->whereNull('deleted_at')
            ->get();

        //total all allocated effort
        $total_allocated_effort = [];
        $project_fixed_allocation = [];


        foreach ($projects as $project) {
            $total_allocated_effort[$project->id] = 0;

            foreach ($allocated_efforts as $effort) {
                if ($effort->project_id == $project->id) {
                    $total_allocated_effort[$project->id] += $effort->percentage;
                    $project_fixed_allocation[$project->id][$effort->month] = true;
                }
            }
        }


        // send details
        $url = 'admin.projectfixedcost.index';

        return view($url)
            ->with('projects', $projects)
            ->with('allocated_efforts', $allocated_efforts)
            ->with('total_allocated_effort', $total_allocated_effort)
            ->with('project_fixed_allocation', $project_fixed_allocation)
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
        // get data for specific year, default is current month and year
        $year = isset($request->year) ? $request->year : (int)date('Y');

        // get projects
        $projects = Project::where(function ($query) use ($year) {
            $query->whereBetween('actual_start_date', [$year . '-01-31', $year . '-12-31'])
                ->orWhereBetween('actual_end_date', [$year . '-01-31', $year . '-12-31'])
                ->orWhereNull('actual_end_Date');
        })

            ->get();;

        // count project per month
        $projects_per_month = [];

        for ($month = 1; $month <= 12; $month++) {
            $projects_per_month[$month] = 0;

            $project_count = Project::select('*')
                ->where(function ($query) use ($month, $year) {
                    $query->whereNull('actual_end_date')
                        ->orWhere('actual_end_date', '>=', $year . '-' . ($month < 10 ? '0' . $month : $month) . '-01');
                })
                ->where(function ($query) use ($month, $year) {
                    $query->where('actual_start_date', '<=', $year . '-' . ($month < 10 ? '0' . $month : $month) . '-31')
                        ->orWhere('actual_end_date', '<=', $year . '-' . ($month < 10 ? '0' . $month : $month) . '-31');
                })
                ->get();

            $projects_per_month[$month] = count($project_count);
        }


        // get allocation per month
        $allocated_efforts = ProjectFixedAllocation::where('year', $year)
            ->whereNull('deleted_at')
            ->get();

        //total all allocated effort
        $total_allocated_effort = [];
        $project_fixed_allocation = [];


        foreach ($projects as $project) {
            $total_allocated_effort[$project->id] = 0;

            foreach ($allocated_efforts as $effort) {
                if ($effort->project_id == $project->id) {
                    $total_allocated_effort[$project->id] += $effort->percentage;
                    $project_fixed_allocation[$project->id][$effort->month] = true;
                }
            }
        }

        // send details
        $url = 'admin.projectfixedcost.edit_estimate';

        return view($url)
            ->with('projects', $projects)
            ->with('allocated_efforts', $allocated_efforts)
            ->with('total_allocated_effort', $total_allocated_effort)
            ->with('project_fixed_allocation', $project_fixed_allocation)
            ->with('_year', $year)
            ->with('projects_per_month', $projects_per_month);

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
                if ($effort === null || $effort == '') $effort = 0;

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
