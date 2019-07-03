<?php

namespace App\Http\Controllers;

use App\Developer;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Project::latest('updated_at')->get();

        return view('admin.projects.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Project::rules());

        Project::create([
            'project_name' => $request->project_name,
            'description' => $request->description,
            'estimated_start_date' => $request->estimated_start_date,
            'estimated_end_date' => $request->estimated_end_date,
            'actual_start_date' => $request->estimated_start_date,
            'actual_end_date' => $request->estimated_end_date,
            'tcp' => $request->tcp,
            'status' => $request->status,
        ]);

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Project::findOrFail($id);

        return view('admin.projects.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Project::findOrFail($id);

        $this->validate($request, Project::rules(true,$id));

        $item->update([
            'project_name' => $request->project_name,
            'description' => $request->description,
            'estimated_start_date' => $request->estimated_start_date,
            'estimated_end_date' => $request->estimated_end_date,
            'actual_start_date' => $request->estimated_start_date,
            'actual_end_date' => $request->estimated_end_date,
            'tcp' => $request->tcp,
            'status' => $request->status,
        ]);

        return redirect()->route(ADMIN . '.projects.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $developer = Project::find($id);
        $developer->delete();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
