<?php

namespace App\Http\Controllers;

use App\Developer;
use App\FixedCost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixedCostController extends Controller
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

        $items = FixedCost::where('month', $month)
            ->where('year', $year)
            ->orderBy('amount',"desc")
            ->get();

        $total_expenses = FixedCost::select(DB::raw('sum(amount) as amount'))
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->toArray();

        if(!$total_expenses)
            $total_expenses[0]['amount'] = 0;


        return view('admin.fixedcosts.index')
            ->with('items',$items)
            ->with('total_expenses',$total_expenses[0]['amount'])
            ->with('_month',$month)
            ->with('_year',$year);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // get management salary
        $salary = Developer::select(DB::raw('SUM(salary) as salary'))
            ->where('department','=',config('variables.role_code')['MGT'])
            ->get()
            ->toArray();
        if(!$salary)
            $salary[0]['salary'] = 0;

        $month = isset($request->month) ? $request->month : (int)date('m');
        $year = isset($request->year) ? $request->year : (int)date('Y');

        $particulars = FixedCost::where('month', $month)
            ->where('year', $year)
            ->latest('updated_at')
            ->get();

        $items = [];
        foreach($particulars as $item)
        {
            $items[$item->particular]=$item->amount;
        }
        if(count($items)==0){
            return view('admin.fixedcosts.create')
                ->with('salary',$salary[0]['salary'])
                ->with('items',$items)
                ->with('_month',$month)
                ->with('_year',$year);
        }else{
            return view('admin.fixedcosts.edit')
                ->with('salary',$salary[0]['salary'])
                ->with('items',$items)
                ->with('_month',$month)
                ->with('_year',$year);
        }


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
        $particulars = $request->particulars;
        $amounts = $request->amounts;

        for($x = 0; $x < count($particulars); $x++){
            FixedCost::create([
                'month' => $month,
                'year' => $year,
                'particular' => $particulars[$x],
                'amount' => $amounts[$x],
                'is_regular' => 1,
            ]);
        }

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
        $items = FixedCost::where('month', (int)date('m'))
            ->where('year', date('Y'))
            ->get();

        return view('admin.fixedcosts.edit', compact('items'));
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
        $fixed_cost = FixedCost::find($id);
        $fixed_cost->amount='0';
        $fixed_cost->save();

        return back()->withSuccess(trans('app.success_destroy'));
    }
}
