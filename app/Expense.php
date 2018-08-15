<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['value', 'description', 'data', 'category_id', 'user_id' ];


    public function category()
    {
    	return $this->belongsTo('App\Category');
    }


    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    
}
