<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
  
}
