<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate();
        $data['user_id'] = $request->user()->id;
       
        $expense = Expenses::create($data);
        return response()->json ([
            'message' => 'Expense created sucessfully',
            
            'expense' => $expense

        ],201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $expense = Expenses::where('user_id',auth()->id())->with('category')->findorFail($id);
        return response()->json (['message' => 'expense featured successfully','expense'=>$expense],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expenses::where('user_id', auth()->id())->findorFail($id);
        $expense->update ($request->validated());
        return response()->json(['message' => 'expense updated successfully'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $expense = Expenses::where('user_id', auth()->id())->findorFail($id);
        if(auth()->id() !== $expense->user_id){
            return response()->json(['message'=>'unauthoried access'],401);
        }
        $expense->delete();
        return response()->json(['message'=>'expense deleted successfully'],204);
    }
}
