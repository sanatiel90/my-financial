<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;
use App\Expense;
use App\Category;
use Illuminate\Support\Facades\Auth;
use App\Libraries\ExpenseFilter;

class ExpenseController extends Controller
{
    //usando middleware('auth') em todas os metodos/rotas de Expenses
	public function __construct()
    {
        return $this->middleware('auth');
    }


    public function index()
    {
    	$categories = Category::orderBy('name_categ')->orderBy('name_sub_categ')->get();
        $filterOptions = new ExpenseFilter(); 
    	$sumExp = Expense::where('user_id', Auth::user()->id)->sum('value'); 
        $expenses = Expense::where('user_id', Auth::user()->id)->latest()->paginate(20);
        
    	return view('expense.index', [ 'expenses' => $expenses, 
                                       'categories' => $categories, 
                                       'filterOptions' => $filterOptions, 
                                       'sumExp' => $sumExp]);
    }	

    public function create()
    {
    	$categories = Category::orderBy('name_categ')->orderBy('name_sub_categ')->get(); //Category::all();
    	return view('expense.create', ['categories' => $categories]);
    }

    public function store(ExpenseRequest $request)
    {
        $expense = new Expense();
        $expense->value = $request->value;
        $expense->description = $request->description;
        $expense->category_id = $request->category_id;
        $expense->user_id = $request->user_id;
        //casa data nao tiver sido informada, preencher com data atual
        $request->data != null ? $expense->data = $request->data : $expense->data = date('Y-m-d');
        $expense->month = $this->extractMonthDateStr($expense->data); 
        $expense->save();

    	return redirect()->action('ExpenseController@index')->with('status', 'Despesa cadastrada com sucesso!');
    }

    public function show(Expense $expense)
    {
    	$categories = Category::orderBy('name_categ')->orderBy('name_sub_categ')->get(); //Category::all();
    	return view('expense.edit', ['expense' => $expense, 'categories' => $categories]);
    }

    public function update(ExpenseRequest $request)
    {
    	$expense = Expense::findOrFail($request->expense_id);
    	$expense->update($request->all());
    	return redirect()->action('ExpenseController@index')->with('status', 'Despesa atualizada com sucesso!');
    }


    public function destroy(Request $request)
    {
    	$expense = Expense::findOrFail($request->id);
    	$expense->delete();
		return redirect()->back()->with('status', 'Despesa excluída com sucesso!');    	
    }


    public function search(Request $request)
    {
    	$dataForm = $request->except('_token');
        $categories = Category::orderBy('name_categ')->orderBy('name_sub_categ')->get(); //Category::all();
    	$filterOptions = new ExpenseFilter(); 
        
        //criando a qry com os filtros
        $expensesAux = Expense::where(function($qry) use($request){
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
        })->orderBy($this->findOrder($request->filt_order),$this->findAscDesc($request->filt_order));
        
        //pegando o total considerando a busca feita
        $sumExp = $expensesAux->sum('value');

        //paginando resultados
        $expenses = $expensesAux->paginate($request->filt_itens_pag);

    	return  view('expense.index', ['expenses' => $expenses, 
                                       'categories' => $categories, 
                                       'dataForm' => $dataForm,
                                       'filterOptions' => $filterOptions,
                                       'sumExp' => $sumExp
                                      ]);
    }


    //monta o json para alimentar o gráfico de despesas por categoria
    public function getJsonChart($month = null){

        $jsonChart = '{
                    "cols": [
                        {"id":"","label":"Category","pattern":"","type":"string"},
                        {"id":"","label":"Total","pattern":"","type":"number"}
                    ],
                    "rows": [ ';
        $expenses = Expense::expensesByCateg($month);
        foreach($expenses as $k => $v){
            $jsonChart .= '{"c":[{"v":"'.$v->name_categ.'","f":null},{"v":'.$v->sumCateg.',"f":null}]},';
        }
        $jsonChart = substr($jsonChart, 0, -1);
        $jsonChart .= ' ] }';
                  
        return $jsonChart;
    }


    public function expensesMonthly()
    {
        $lastExpensesMonthly = Expense::lastExpensesMonthly();
        return view('expense.monthly', ['lastExpensesMonthly' => $lastExpensesMonthly]);
    }


    public function expensesMonthlyDetail(Request $request)
    {
        $expensesMonth['all'] = Expense::expensesDetail($request->month, 2); 
        $expensesMonth['categ'] = Expense::expensesDetail($request->month, 1);
        $expensesMonth['graf'] = $this->getJsonChart($request->month);
        return response()->json($expensesMonth);
    }

    
    public function printMonthlyDetail(Request $request)
    {
        $expensesMonth['all'] = Expense::expensesDetail($request->month, 2); 
        $expensesMonth['categ'] = Expense::expensesDetail($request->month, 1);
        $expensesMonth['user'] = Auth::user()->name;
        $expensesMonth['total'] =  Expense::where('user_id', Auth::user()->id)->sum('value');
        $expensesMonth['month'] = $request->month;

        $pdf = \PDF::loadView('expense.print', ['expenses' => $expensesMonth]);
        return $pdf->stream();   
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


    private function extractMonthDateStr($date){    
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        switch ($month) {
            case '01':
                $month = 'Janeiro';
                break;
            case '02':
                $month = 'Fevereiro';
                break;
            case '03':
                $month = 'Março';
                break;
            case '04':
                $month = 'Abril';
                break;
            case '05':
                $month = 'Maio';
                break;
            case '06':
                $month = 'Junho';
                break;
            case '07':
                $month = 'Julho';
                break;
            case '08':
                $month = 'Agosto';
                break;
            case '09':
                $month = 'Setembro';
                break;
            case '10':
                $month = 'Outubro';
                break;
            case '11':
                $month = 'Novembro';
                break;
            case '12':
                $month = 'Dezembro';
                break;
            default:
                $month = 'Indefinido';
                break;
        }

        return "$month $year";
    }





}
