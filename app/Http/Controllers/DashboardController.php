<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        
        $user_id = auth()->id();
        $totalExpenses = Expenses::where('user_id',$user_id)->sum('expense_amount');
        $totalCategories = Category::where('user_id',$user_id)->count();
        $monthlyExpenses = Expenses::where('user_id',$user_id)->whereMonth('date',now ()->month)->whereYear('date',now ()->year)->sum('expense_amount');
        $recentExpenses = Expenses::Where('user_id',$user_id)->with('category')->orderBy('date','desc')->take(5)->get();
        $categorySummary = Expenses::where('user_id',$user_id)->select('category_id',Category::raw('sum(expense_amount) as total'))->groupBy('category_id')->get();
        return response()->json
            ([
                'totalExpenses'=>$totalExpenses,
                'totalCategories'=>$totalCategories,
                'monthlyExpenses'=>$monthlyExpenses,
                'recentExpenses'=>$recentExpenses,
                'categorySummary'=>$categorySummary,
                'message'=>'Dashboard fetched successfully'

            ]
            ,200);

    }
}
