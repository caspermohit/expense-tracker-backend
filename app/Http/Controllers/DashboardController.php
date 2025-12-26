<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        
        $user_id = auth()->id();
        
    
        $totalExpenses = Expenses::where('user_id',$user_id)->where('expense_type','Expense')->sum('expense_amount');
        $monthlyExpenses = Expenses::where('user_id',$user_id)->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->where('expense_type','Expense')->sum('expense_amount');
        $recentExpenses = Expenses::where('user_id',$user_id)->orderBy('created_at','desc')->whereMonth('created_at',now ()->month)->whereYear('created_at',now ()->year)->get();
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
        $totalSavings = $totalIncome-$totalExpenses;
        $monthlySavings = $monthlyIncome-$monthlyExpenses;
        

/* ===== NEW: LAST 12 MONTHS INCOME vs EXPENSE (BAR GRAPH) ===== */

$startDate = Carbon::now()->subMonths(11)->startOfMonth();

$monthlyChart = DB::table('expenses')
    ->selectRaw("
        DATE_FORMAT(created_at, '%Y-%m') as month,
        SUM(CASE WHEN expense_type = 'Income' THEN expense_amount ELSE 0 END) as income,
        SUM(CASE WHEN expense_type = 'Expense' THEN expense_amount ELSE 0 END) as expense
    ")
    ->where('user_id', $user_id)
    ->where('created_at', '>=', $startDate)
    ->groupBy('month')
    ->orderBy('month')
    ->get();

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
                'totalSavings' => $totalSavings,
                'monthlyChart' => $monthlyChart,
                'message'=>'Dashboard fetched successfully'
                

            ]
            ,200);

    }
}
