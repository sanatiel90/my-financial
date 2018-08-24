<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
    	$categories = Category::all();
    	return view('category.index', ['categories' => $categories]);
    }


    public function create()
    {
    	return view('category.create');
    }


    public function store(Request $request)
    {
    	Category::create($request->all());
    	return redirect()->action('CategoryController@index')->with('status', 'Categoria cadastrada com sucesso!'); 
    }

    public function destroy(Request $request)
    {
    	$category = Category::findOrFail($request->id);
    	$category->delete();
		return redirect()->back()->with('status', 'Categoria excluída com sucesso!');    	
    }


}
