<?php 

class Produto extends Controller
{	
	public function index($link = "")
	{
		$model 				= $this->model('DataModel');
		
		$produto = $model->list_one_result("produtos p",
											"p.*, c.nome as c_nome, c.link as c_link",
											" INNER JOIN categorias c ON c.id = p.categoria_id WHERE p.status = 1 AND p.link ='{$link}' LIMIT 1");
		
		
		$data = array(
			'single_produto' 				=>	$produto,
			'lista_relacionados'			=>	$model->list_all_result("produtos p",
											"p.*, c.nome as c_nome, c.link as c_link",
											" INNER JOIN categorias c ON c.id = p.categoria_id WHERE p.status = 1 AND p.categoria_id = {$produto["categoria_id"]} AND p.link !='{$link}' ORDER BY p.data_alterado ASC LIMIT 12"),
			'lista_categorias' 				=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto,count(p.categoria_id) as total",
				" LEFT OUTER JOIN produtos p ON p.categoria_id = c.id WHERE c.status = 1 AND c.tipo IN('produto') GROUP BY c.id ASC"
			),
			'lista_galeria' 				=>	$model->list_all_result("galeria_produto ga","ga.id, ga.nome, p.link",
			" INNER JOIN produtos p ON p.id = ga.produto_id WHERE p.link = '{$link}'"),
			'lista_categoria' 				=> 	$model->list_one_result(
				"categorias c",
				"c.nome",
				" WHERE link = '{$produto["c_link"]}'"
			),
			'lista_subcategorias' 			=> 	$model->list_all_result(
				"subcategorias sb",
				"sb.*, c.nome as c_nome,c.link as c_link, c.tipo, count(p.subcategoria_id) as total",
				" INNER JOIN categorias c ON c.id = sb.categoria_id LEFT OUTER JOIN produtos p ON p.subcategoria_id = sb.id WHERE sb.status = 1 AND c.link = '{$produto["c_link"]}' GROUP BY sb.id"
			)
		);
		$this->returnView('lojas/produto',$data,false, "/lojas/");
	}	
}