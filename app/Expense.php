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
    public static function lastExpenses(int $limit)
    {  	
        $lastExpenses['sum'] = self::lastExpensesSum($limit);
        $lastExpenses['avg'] = self::lastExpensesAvg($lastExpenses['sum'], $limit);
        $limit == 1 ? $lastExpenses['limit'] = 'no último mês' : $lastExpenses['limit'] = "nos últimos $limit meses";  
        return $lastExpenses;               
    }

    /* retorna o total de despesas dos ultimos '$limit' meses; valor passado por referencia, caso o usuário possua despesas cadastradas em menos do que o $limit informado, considerar o nº de meses do usuário*/
    private static function lastExpensesSum(&$limit) 
    {
    	$result = DB::table('expenses')
                     ->select(DB::raw('sum(value) as sumExp, month'))
                     ->where('user_id', '=', Auth::user()->id)
                     ->orderBy('data', 'desc')
                     ->groupBy('month', 'data')
                     ->limit($limit)
                     ->get(); 

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
  
}


/*$lastExpenses['sum'] = DB::table('expenses')
                     ->select(DB::raw('sum(value) as sumExp, month'))
                     ->where('user_id', '=', Auth::user()->id)
                     ->orderBy('data', 'desc')
                     ->groupBy('month', 'data')
                     ->limit($limit)
                     ->get(); 

        $lastExpenses['avg'] = 0;
        foreach ($lastExpenses['sum'] as $key => $value){
            $lastExpenses['avg'] = $lastExpenses['avg'] + $value->sumExp;
        }
        
        $lastExpenses['avg'] = $lastExpenses['avg']/$limit; 
        $lastExpenses['avg'] = number_format($lastExpenses['avg'], 2, ',', '.');*/
