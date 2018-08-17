<?php

namespace App\Libraries;

class ExpenseFilter extends Filter
{
	

	public function __construct()
	{
		$this->filtOrder = [
							'last' => 'Últimas adicionadas', 
							 'first' => 'Primeiras adicionadas',
							 'desc' => 'Descrição',
							 'cat' => 'Categoria',
							 'val_max' => 'Maior valor',
							 'val_min' => 'Menor valor',
							 'dat' => 'Data da despesa'
							];

		$this->filtItensPag = [20, 10, 30, 50];
	}

	public function getFiltOrder()
	{
		return $this->filtOrder;
	}

	public function getFiltItensPag()
	{
		return $this->filtItensPag;
	}



}
