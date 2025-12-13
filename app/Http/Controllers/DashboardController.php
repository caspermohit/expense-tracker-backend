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
        
    
        $totalExpenses = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->where('expense_type','Expense')->sum('expense_amount');
        $monthlyExpenses = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->where('expense_type','Expense')->sum('expense_amount');
        $recentExpenses = Expenses::where('user_id',$user_id)->orderBy('created_at','desc')->take(5)->get();
        $monthlyIncome = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->where('expense_type','Income')->sum('expense_amount');
        $totalIncome = Expenses::where('user_id',$user_id)->where('expense_type','Income')->sum('expense_amount');
        $denominator = $monthlyExpenses > 0 ? $monthlyExpenses : 1;
        $houseExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','House')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $foodExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Food')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $clothesExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Clothes')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $entertainmentExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Entertainment')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $transportationExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Transportation')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $healthExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Health')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $educationExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Education')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $othersExpenses = (Expenses::where('user_id',$user_id)->where('expense_category','Others')->where('expense_type','Expense')->sum('expense_amount')/$denominator)*100;
        $monthlySavings = $monthlyIncome-$monthlyExpenses;
        return response()->json
            ([
                'totalExpenses'=>$totalExpenses,
                'totalIncome'=>$totalIncome,
                'monthlyExpenses'=>$monthlyExpenses,
                'monthlyIncome'=>$monthlyIncome,
                'monthlySavings'=>$monthlySavings,
                'recentExpenses'=>$recentExpenses,
                'houseExpenses'=>$houseExpenses,
                'foodExpenses'=>$foodExpenses,
                'clothesExpenses'=>$clothesExpenses,                
                'entertainmentExpenses'=>$entertainmentExpenses,
                'transportationExpenses'=>$transportationExpenses,
                'healthExpenses'=>$healthExpenses,
                'educationExpenses'=>$educationExpenses,
                'othersExpenses'=>$othersExpenses,
                'message'=>'Dashboard fetched successfully'
                

            ]
            ,200);

    }
}
