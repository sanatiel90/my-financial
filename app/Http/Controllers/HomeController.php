<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Illuminate\Support\Facades\Auth;

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
        $exp = Expense::expensesByCateg();
        $lastExpensesMonthly = Expense::lastExpensesMonthly(4);

        return view('home', ['expenses' => $expenses, 'lastExpensesMonthly' => $lastExpensesMonthly, 'exp' => $exp]);
    }
}
