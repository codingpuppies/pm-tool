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
        $month = isset($request->month) ? $request->month : (int)date('m');
        $year = isset($request->year) ? $request->year : (int)date('Y');

        $items = VariableCost::where('month', $month)
            ->where('year', $year)
            ->orderBy('amount', "desc")
            ->get();

        $projects = Project::all();
        $developers = Developer::all();
        $assigned_developers = ProjectDeveloper::all();


        return view('admin.variablecosts.index')
            ->with('items', $items)
            ->with('projects', $projects)
            ->with('developers', $developers)
            ->with('assigned_developers', $assigned_developers)
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
        if($item){
            $month = $item->month;
            $year = $item->year;
        }else{
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
