<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Category;
use Illuminate\Support\Facades\Auth;
use App\Libraries\ExpenseFilter;

class ExpenseController extends Controller
{
	public function index()
    {
    	$categories = Category::all();
        $filterOptions = new ExpenseFilter(); 
    	$expenses = Expense::where('user_id', Auth::user()->id)->latest()->paginate(20);
    	return view('expense.index', ['expenses' => $expenses, 'categories' => $categories, 'filterOptions' => $filterOptions]);
    }	

    public function create()
    {
    	$categories = Category::all();
    	return view('expense.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        Expense::create($request->all());
    	return redirect()->action('ExpenseController@index')->with('status', 'Despesa cadastrada com sucesso!');
    }

    public function show(Expense $expense)
    {
    	$categories = Category::all();
    	return view('expense.edit', ['expense' => $expense, 'categories' => $categories]);
    }

    public function update(Request $request)
    {
    	$expense = Expense::findOrFail($request->expense_id);
    	$expense->update($request->all());
    	return redirect()->action('ExpenseController@index')->with('status', 'Despesa atualizada com sucesso!');
    }


    public function destroy(Request $request)
    {
    	$expense = Expense::findOrFail($request->id);
    	echo $expense->description;
    	$expense->delete();
		return redirect()->back()->with('status', 'Despesa excluída com sucesso!');    	
    }


    public function search(Request $request)
    {
    	$dataForm = $request->except('_token');
        $categories = Category::all();
    	$filterOptions = new ExpenseFilter(); 
        //criando a qry com os filtros
        $expenses = Expense::where(function($qry) use($request){
    		$qry->where('user_id', Auth::user()->id);
            if(isset($request->filt_desc)){
    			$qry->where('description', 'like', '%'.$request->filt_desc.'%');
    		}
			if(isset($request->filt_dat)){
				$qry->where('data', $request->filt_dat);
			}
			if((isset($request->filt_cat)) && ($request->filt_cat != 0)){
				$qry->where('category_id', $request->filt_cat);
			}  		
    	})->orderBy($this->findOrder($request->filt_order),$this->findAscDesc($request->filt_order))
          ->paginate($request->filt_itens_pag); 

    	return  view('expense.index', ['expenses' => $expenses, 
                                       'categories' => $categories, 
                                       'dataForm' => $dataForm,
                                       'filterOptions' => $filterOptions
                                      ]);
    }



    private function findOrder($order)
    {
    	switch ($order) {
    		case 'last':
    			return 'id';
    			break;
    		case 'first':
    			return 'id';
    			break;
    		case 'desc':
    			return 'description';
    			break;	
    		case 'cat':
    			return 'category_id';
    			break;	
    		case 'val_max':
    			return 'value';
    			break;	
    		case 'val_min':
    			return 'value';
    			break;	
    		case 'dat':
    			return 'data';
    			break;					
    		default:
    			return 'id';
    			break;
    	}
    }

    private function findAscDesc($order)
    {
        switch ($order) {
            case 'last':
                return 'desc';
                break;
            case 'first':
                return 'asc';
                break;
            case 'desc':
                return 'asc';
                break;  
            case 'cat':
                return 'asc';
                break;  
            case 'val_max':
                return 'desc';
                break;  
            case 'val_min':
                return 'asc';
                break;  
            case 'dat':
                return 'asc';
                break;                  
            default:
                return 'asc';
                break;
        }
    }


}
