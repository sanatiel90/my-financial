<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $categories = [
       		['name_categ' => 'Alimentação', 'name_sub_categ' => 'Lanches', 'description' => 'lanches consumidos, geralmente fast food'],
       		['name_categ' => 'Alimentação', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos alimentos'],
       		
       		['name_categ' => 'Saúde', 'name_sub_categ' => 'Remédios', 'description' => 'remédios comprados'],
       		['name_categ' => 'Saúde', 'name_sub_categ' => 'Consultas', 'description' => 'consultas e exames'],
       		['name_categ' => 'Saúde', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos saúde'],
       		
       		['name_categ' => 'Lazer', 'name_sub_categ' => 'Cinema', 'description' => 'ingressos de cinema'],
       		['name_categ' => 'Lazer', 'name_sub_categ' => 'Jogos Eletrônicos', 'description' => 'jogos para pc, celular e consoles'],
       		['name_categ' => 'Lazer', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos lazer'],

			['name_categ' => 'Produto', 'name_sub_categ' => 'Livros', 'description' => 'livros comprados'],
			['name_categ' => 'Produto', 'name_sub_categ' => 'Computador', 'description' => 'PC e itens para PC(teclado, mouse, peças, etc)'],
			['name_categ' => 'Produto', 'name_sub_categ' => 'Vestuário', 'description' => 'roupas, sapatos, etc'],
			['name_categ' => 'Produto', 'name_sub_categ' => 'Móveis', 'description' => 'armários, camas, colchões, mesas, etc'],
			['name_categ' => 'Produto', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos produtos'],

       		['name_categ' => 'Transporte', 'name_sub_categ' => 'Passagens', 'description' => 'passagens de ônibus, avião, etc'],
       		['name_categ' => 'Transporte', 'name_sub_categ' => 'Serviço', 'description' => 'táxis, uber e afins'],	
       		['name_categ' => 'Transporte', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos transporte'],

       		['name_categ' => 'Serviços', 'name_sub_categ' => 'Reparo', 'description' => 'conserto de peças, equipamentos, móveis'],
       		['name_categ' => 'Serviços', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos serviços'],   		

       		['name_categ' => 'Outros', 'name_sub_categ' => 'Outros', 'description' => 'outros gastos não categorizados'],


       ];
       
        DB::table('categories')->insert($categories);
    }
}
