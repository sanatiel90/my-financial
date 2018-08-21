<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('expense')->group(function(){
	Route::get('/', 'ExpenseController@index')->name('expenses');
	Route::get('/create', 'ExpenseController@create')->name('new_expense');	
	Route::post('/', 'ExpenseController@store')->name('store_expense');
	Route::get('/{expense}', 'ExpenseController@show')->name('show_expense.expense');
	Route::post('/update', 'ExpenseController@update')->name('update_expense');	
	Route::post('/delete', 'ExpenseController@destroy')->name('delete_expense');

});
//não sei o que houve, mas não está aceitando a rota '/expense/'
Route::get('/expenses/search', 'ExpenseController@search')->name('search_expense');
Route::get('/expenses/jsonChart', 'ExpenseController@getJsonChart');
Route::get('/expenses/monthly', 'ExpenseController@expensesMonthly')->name('monthly_expenses');
Route::get('/expenses/monthly/detail', 'ExpenseController@expensesMonthlyDetail');
