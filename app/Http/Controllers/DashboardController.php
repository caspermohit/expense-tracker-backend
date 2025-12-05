<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expenses;
use illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){
        
        $user_id = auth()->id();
        $totalExpenses = Expenses::where('user_id',$user_id)->sum('expense_amount');
        $monthlyExpenses = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->sum('expense_amount');
        $recentExpenses = Expenses::where('user_id',$user_id)->orderBy('created_at','desc')->take(5)->get();
        $monthlyIncome = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->where('expense_type','Income')->sum('expense_amount');
        $totalIncome = Expenses::where('user_id',$user_id)->where('expense_type','Income')->sum('expense_amount');
        $monthlySavings = $monthlyIncome-$monthlyExpenses;
        return response()->json
            ([
                'totalExpenses'=>$totalExpenses,
                'totalIncome'=>$totalIncome,
                'monthlyExpenses'=>$monthlyExpenses,
                'monthlyIncome'=>$monthlyIncome,
                'monthlySavings'=>$monthlySavings,
                'recentExpenses'=>$recentExpenses,
                'message'=>'Dashboard fetched successfully'

            ]
            ,200);

    }
}
