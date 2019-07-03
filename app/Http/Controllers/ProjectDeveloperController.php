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
        $items = ProjectDeveloper::latest('updated_at')->get();

        return view('admin.projectdevelopers.index', compact('items'));
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
        $item = Project::find($id);

        //get project managers
        $pm = DB::table('developers')
            ->select(DB::raw('concat(first_name," ",last_name) as name, id'))
            ->where('position', config('variables.role_code')['PM'])
            ->get()
            ->toArray();

        // get developers
        $devs = DB::table('developers')
            ->select(DB::raw('concat(first_name," ",last_name) as name, id'))
            ->where('position', config('variables.role_code')['DEVELOPER'])
            ->get()
            ->toArray();

        return view('admin.projectdevelopers.edit')
            ->with('item', $item)
            ->with('pm', $pm)
            ->with('devs', $devs);
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
        $item = ProjectDeveloper::findOrFail($id);

        $this->validate($request, ProjectDeveloper::rules(true, $id));

        $item->update([
            'project_id' => $request->project_id,
            'developer_id' => $request->developer_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route(ADMIN . '.projectdevelopers.index')->withSuccess(trans('app.success_update'));
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
