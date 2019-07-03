<?php

namespace App\Http\Controllers;

use App\Developer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Developer::latest('updated_at')->get();

        return view('admin.developers.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.developers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Developer::rules());
        $this->validate($request, User::rules());

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'role' => $request->position,
            'password' => $request->password,
        ]);

        Developer::create([
            'user_id' => $user->id,
            'salary' => $request->salary,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'position' => $request->position,
            'department' => $request->department,
            'employee_number' => $request->employee_number,
            'status' => 1,
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
        $item = Developer::findOrFail($id);

        return view('admin.developers.edit', compact('item'));
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
        $item = Developer::findOrFail($id);

        $user = User::findOrFail($item->user_id);

        $this->validate($request, Developer::rules(true, $id));
        $this->validate($request, User::rules(true, $user->id));

        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $item->update([
            'salary' => $request->salary,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'position' => $request->position,
            'department' => $request->department,
            'employee_number' => $request->employee_number,
            'status' => 1,
        ]);

        return redirect()->route(ADMIN . '.developers.index')->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $developer = Developer::find($id);
        $developer->delete();

        $user = User::find($developer->user_id);
        $user->delete();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
