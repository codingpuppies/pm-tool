<?php

namespace App\Http\Controllers;

use App\Developer;
use App\OtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OtherCostController extends Controller
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

        $items = OtherCost::where('month', $month)
            ->where('year', $year)
            ->orderBy('amount', "desc")
            ->get();

        $total_expenses = OtherCost::select(DB::raw('sum(amount) as amount'))
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->toArray();

        if (!$total_expenses)
            $total_expenses[0]['amount'] = 0;


        return view('admin.othercosts.index')
            ->with('items', $items)
            ->with('total_expenses', $total_expenses[0]['amount'])
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


        return view('admin.othercosts.create')
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

        OtherCost::create([
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
        $item = OtherCost::find($id);
        if($item){
            $month = $item->month;
            $year = $item->year;
        }else{
            $month = isset($request->month) ? $request->month : (int)date('m');
            $year = isset($request->year) ? $request->year : (int)date('Y');
        }

        return view('admin.othercosts.edit')
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
        $fixed_cost = OtherCost::find($id);
        $fixed_cost->amount = '0';
        $fixed_cost->save();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
