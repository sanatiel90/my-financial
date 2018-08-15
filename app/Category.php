<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name_categ', 'name_sub_categ', 'description'];

    public function expenses()
    {
    	return $this->hasMany('App\Expense');
    }

}
