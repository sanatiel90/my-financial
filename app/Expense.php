<?php
declare(strict_types=1);
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Expense extends Model
{
    protected $fillable = ['value', 'description', 'data', 'category_id', 'user_id', 'month' ];

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    //retorna o total de despesas por mês, a média e o total de meses pesquisados
    public static function lastExpensesMonthly(int $limit = 0)
    {  	
        $lastExpenses['sum'] = self::lastExpensesSum($limit);
        $lastExpenses['avg'] = self::lastExpensesAvg($lastExpenses['sum'], $limit);
        $limit == 1 ? $lastExpenses['limit'] = 'no último mês' : $lastExpenses['limit'] = "nos últimos $limit meses";  
        return $lastExpenses;               
    }

    /* retorna o total de despesas dos ultimos '$limit' meses; valor passado por referencia, caso o usuário possua despesas cadastradas em menos do que o $limit informado, considerar o nº de meses do usuário*/
    private static function lastExpensesSum(&$limit) 
    {
    	//se $limit nao for 0, quer dizer q foi informado um limite e este será aplicado, caso contrário nenhum limite foi informado e 
    	//serão pegues todas as ocorrencias
    	if($limit !== 0){
    		$result = DB::table('expenses')
                     ->select(DB::raw('sum(value) as sumExp, month'))
                     ->where('user_id', '=', Auth::user()->id)
                     //->orderBy('data', 'desc')
                     ->groupBy('month') //, 'data'
                     ->limit($limit)                      
                     ->get(); 
    	} else {
    		$result = DB::table('expenses')
                     ->select(DB::raw('sum(value) as sumExp, month'))
                     ->where('user_id', '=', Auth::user()->id)
                    // ->orderBy('data', 'desc')
                     ->groupBy('month') //, 'data'               
                     ->get();

            $limit = $result->count();       
    	}	

    	
      if($result->count() < $limit){
      	$limit = $result->count();
      }                
      
      return $result;
    }

    //recebe o total de despesas e faz a média
    private static function lastExpensesAvg($lastExpensesSum, $limit)
    {
    	$lastExpensesAvg = 0;
        foreach ($lastExpensesSum as $key => $value){
            $lastExpensesAvg = $lastExpensesAvg + $value->sumExp;
        }
        
        if ($limit > 0){
        	$lastExpensesAvg = $lastExpensesAvg/$limit; 
        	$lastExpensesAvg = number_format($lastExpensesAvg, 2, ',', '.');
        } else {
        	$lastExpensesAvg = 0;
        }

        return $lastExpensesAvg;
    }
  

    public static function expensesByCateg($month = null)
    {
     		/*$expenses =  DB::table('expenses')
    				->join('categories', 'expenses.category_id', '=', 'categories.id')
    				->select(DB::raw('expenses.category_id, categories.name_categ, categories.name_sub_categ, sum(expenses.value) sumCateg'))
    				->where('expenses.user_id', '=', Auth::user()->id)
    				->groupBy('expenses.category_id', 'categories.name_categ', 'categories.name_sub_categ')
    				->get();
  */
        $expensesAux = DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select(DB::raw('expenses.category_id, categories.name_categ, categories.name_sub_categ, sum(expenses.value) sumCateg'))
            ->where('expenses.user_id', '=', Auth::user()->id);
        if(!$month){
              $expenses = $expensesAux->groupBy('expenses.category_id', 'categories.name_categ', 'categories.name_sub_categ')
                         ->get();

        } else {
              $expenses = $expensesAux->where('expenses.month', '=', $month)
                         ->groupBy('expenses.category_id', 'categories.name_categ', 'categories.name_sub_categ')
                         ->get();
        }    
    	 
       return $expenses;
    }



    public static function expensesDetail($month, $tipo)
    {
       if($tipo == 1){ //despesas de um mÊs especifico agrupado por categoria
          $expenses =  DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select(DB::raw('categories.name_categ, categories.name_sub_categ, sum(expenses.value) sumCateg'))
            ->where('expenses.user_id', '=', Auth::user()->id)
            ->where('expenses.month', '=', $month)
            ->groupBy('expenses.category_id', 'categories.name_categ', 'categories.name_sub_categ')
            ->get();
       } else if ($tipo == 2) { //todas as despesas de um mÊs
          $expenses =  DB::table('expenses')
            ->join('categories', 'expenses.category_id', '=', 'categories.id')
            ->select(DB::raw('expenses.description, expenses.value, expenses.category_id, expenses.data, categories.name_categ, categories.name_sub_categ'))
            ->where('expenses.user_id', '=', Auth::user()->id)
            ->where('expenses.month', '=', $month)
            ->get();
       }

       return $expenses;
    }



}
