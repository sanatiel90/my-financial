<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $expenses = Expense::where('user_id', Auth::user()->id)->limit(6)->latest()->get(); 
        
        $lastExpensesSum = DB::table('expenses')
                     ->select(DB::raw('sum(value) as sumExp, month'))
                     ->where('user_id', '=', Auth::user()->id)
                     ->orderBy('data', 'desc')
                     ->groupBy('month', 'data')
                     ->limit(4)
                     ->get(); 

        $lastExpensesAvg = 0;
        foreach ($lastExpensesSum as $key => $value){
            $lastExpensesAvg = $lastExpensesAvg + $value->sumExp;
        }
        
        $lastExpensesAvg = $lastExpensesAvg/4; 
        $lastExpensesAvg = number_format($lastExpensesAvg, 2, ',', '.');
        /*var_dump($lastExpensesSum);
        echo '<br><br>';
        //echo $lastExpensesSum->itens->sumExp[0];
        echo '<br><br>';
        foreach ($lastExpensesSum as $key => $value) {
                echo $value->sumExp.' - '.$value->month;
                echo '<br>';
        }
        echo '<br><br>';
        dd($lastExpensesSum);*/
        
                                       

        return view('home', ['expenses' => $expenses, 'lastExpensesSum' => $lastExpensesSum, 'lastExpensesAvg' => $lastExpensesAvg]);
    }
}
