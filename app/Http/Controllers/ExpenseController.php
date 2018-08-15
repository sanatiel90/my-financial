<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Category;

class ExpenseController extends Controller
{

    public function create(){
    	$categories = Category::all();
    	return view('expense.create', ['categories' => $categories]);
    }

    public function store(Request $request){
    	Expense::create($request->all());
    	return redirect()->action('HomeController@index')->with('status', 'Despesa cadastrada com sucesso!');
    }
}
