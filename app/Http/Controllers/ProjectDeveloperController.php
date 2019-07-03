<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Project;
use App\ProjectDeveloper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectDeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        $assigned_devs = ProjectDeveloper::whereNull('deleted_at')
            ->get()
            ->toArray();

        $developers = Developer::all()->toArray();

        return view('admin.projectdevelopers.index')
            ->with('projects', $projects)
            ->with('assigned_devs', $assigned_devs)
            ->with('developers', $developers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projectdevelopers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ProjectDeveloper::rules());

        ProjectDeveloper::create([
            'project_id' => $request->project_id,
            'developer_id' => $request->developer_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
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
    public function edit($id)
    {
        // Project details
        $item = Project::findOrFail($id);
        $project_managers = [];
        $developers = [];
        $project_developers = [];

        //get project managers
        $pm = DB::table('developers')
            ->select(DB::raw('concat(first_name," ",last_name) as name, id'))
            ->where('position', config('variables.role_code')['PM'])
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        foreach ($pm as $pm_record) {
            $project_managers[$pm_record->id] = $pm_record->name;
        }

        // get developers
        $devs = DB::table('developers')
            ->select(DB::raw('concat(first_name," ",last_name) as name, id'))
            ->where('position', '!=', config('variables.role_code')['PM'])
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        foreach ($devs as $dev_record) {
            $developers[$dev_record->id] = $dev_record->name;
        }

        // get assigned developers and project managers
        $assigned_devs = DB::table('project_developer')
            ->select('developer_id')
            ->where('project_id', $id)
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        foreach ($assigned_devs as $assigned_dev_record) {
            $project_developers[$assigned_dev_record->developer_id] = $assigned_dev_record->developer_id;
        }


        return view('admin.projectdevelopers.edit')
            ->with('item', $item)
            ->with('project_managers', $project_managers)
            ->with('developers', $developers)
            ->with('project_developers', $project_developers);
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
        // check if project is existing
        $item = Project::findOrFail($id);

        // get project managers
        $project_managers = $request->project_manager;

        // get developers
        $developers = $request->developers;

        // delete all assigned developers
        ProjectDeveloper::where('project_id', $item->id)->delete();

        // create new records
        foreach ($project_managers as $pm) {
            ProjectDeveloper::create([
                'project_id' => $item->id,
                'developer_id' => $pm,
                'date_start' => now(),
                'date_end' => $item->estimated_end_date,
                'role' => config('variables.role_code')['PM'],
            ]);
        }
        foreach ($developers as $dev) {
            ProjectDeveloper::create([
                'project_id' => $item->id,
                'developer_id' => $dev,
                'date_start' => now(),
                'date_end' => $item->estimated_end_date,
                'role' => config('variables.role_code')['DEVELOPER'],
            ]);
        }

//        return redirect()->route(ADMIN . '.projectdevelopers.edit')->withSuccess(trans('app.success_update'));
        return back()->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $developer = ProjectDeveloper::find($id);
        $developer->delete();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
