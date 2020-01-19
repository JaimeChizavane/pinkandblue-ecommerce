<?php 

class Categorias extends Controller
{
	private $title 				= 'Quick Maputo | Categorias';
	private $description 		= '';
	private $url 				= ROOT.'lojas';
	private $image 				= '';
	private $cond 				= ' ';
	private $maximo			 	= 12;
	private $total_retornado 	= 0;
	private $pagina_actual		= 1;
	
	public function index($categorias = "", $subcategorias = "", $pagina = "")
	{
		$model 				= $this->model('DataModel');
		$sobremodel 		= $this->model('SobreModel');
		$this->image		= $sobremodel->Instituicao()["logo"];	
		$this->description	= $sobremodel->Instituicao()["quem_somos"];
		
		$args_arr			= explode("=",$subcategorias);
		$subcategorias 		= in_array("pagina",$args_arr) ? "" : $subcategorias;
		
		$this->cond			= !empty($subcategorias) 
							? " INNER JOIN subcategorias sb ON sb.id = p.subcategoria_id WHERE sb.link = '{$subcategorias}' AND p.status = 1 AND c.link ='{$categorias}' " 
							: "  WHERE p.status = 1 AND c.link ='{$categorias}' ";
							
		
		$this->args			= func_get_args();	
		
		$breadcrumbs = "";
		
		foreach($this->args as $values)
		{
			$param = explode('=',$values);
			if(in_array('pagina',$param))
			{
				$this->pagina_actual 	= $param[1];
			}		
		}
		
		$inicio 		= ($this->maximo * $this->pagina_actual) - $this->maximo;	
		
		$produtos 		= $model->list_all_result("produtos p",
											"p.*, c.nome as c_nome, c.link as c_link",
											" INNER JOIN categorias c ON c.id = p.categoria_id {$this->cond}  ORDER BY p.data_alterado ASC LIMIT {$inicio}, {$this->maximo}");									
		$this->total 	= $model->get_total_result("produtos p",
											"p.*, c.nome as c_nome, c.link as c_link",
											" INNER JOIN categorias c ON c.id = p.categoria_id {$this->cond} ORDER BY p.data_alterado ASC");								
		
		$homeModel = array(
			'MetaTitle'						=>	$this->MetaTitle(),
			'openGraph'						=>	$this->openGraph(),
			'instituicao'					=>	$sobremodel->Instituicao(),
			'lista_produtos' 				=>	$produtos,
			'breadcrumbs' 					=>	$breadcrumbs,
			'paginacao' 					=>	$this->retornaPaginacao("categorias/",""),
			'lista_categorias' 				=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto,count(p.categoria_id) as total",
				" LEFT OUTER JOIN produtos p ON p.categoria_id = c.id WHERE c.status = 1 AND c.tipo IN('produto') GROUP BY c.id ASC"
			),
			'lista_categoria' 				=> 	$model->list_one_result(
				"categorias c",
				"c.nome",
				" WHERE link = '{$categorias}'"
			),
			'lista_subcategorias' 			=> 	$model->list_all_result(
				"subcategorias sb",
				"sb.*, c.nome as c_nome,c.link as c_link, c.tipo, count(p.subcategoria_id) as total",
				" INNER JOIN categorias c ON c.id = sb.categoria_id LEFT OUTER JOIN produtos p ON p.subcategoria_id = sb.id WHERE sb.status = 1 AND c.link = '{$categorias}' GROUP BY sb.id"
			)
		);
		$this->returnView('lojas/categorias',$homeModel,false, "/lojas/");
	}
	
	public function retornaPaginacao($page = null, $slash = "/")
	{
	    $output 	= '';
		$maxLinks 	= 4;
		if($this->total > $this->maximo)
		{
			$total_pagina 	= ceil($this->total/$this->maximo);
			$url = "";
			
			if(!is_null($this->args))
			{
				foreach($this->args as $values)
				{
					if(in_array("pagina",explode("=",$values)))
					{
						array_pop($this->args);
					}
				}
				$url 			= implode("/",$this->args);
			}				
			
			if(!is_null($page))
			{
				$url = $page.$slash.$url;
			}
			
			$output 	   .='<li><a href="'.ROOT.$url.'/pagina=1" class="">Primeira pagina</a></li>';
				for($i = $this->pagina_actual - $maxLinks; $i <= $this->pagina_actual - 1; $i++)
				{
					if($i >= 1)
					{
						$output .='<li><a href="'.ROOT.$url.'/pagina='.$i.'" class="">'.$i.'</a></li>';
					}
				}
				$output .='<li><a href="javascript:void(0)" class="dev-light-grey"><span class="" style="cursor:text">'.$this->pagina_actual.'</span></a></li>';
				for($i = $this->pagina_actual + 1; $i <= $this->pagina_actual + $maxLinks; $i++)
				{
					if($i <= $total_pagina)
					{
						$output .='<li><a href="'.ROOT.$url.'/pagina='.$i.'" class="">'.$i.'</a></li>';
					}
				}
			$output .='<li><a href="'.ROOT.$url.'/pagina='.$total_pagina.'" class="">Ultima pagina</a></li>';
			return $output;
		}
	}	
	
	private function MetaTitle()
	{
		return '<title>'.$this->title.'</title>';
	}
	
	private function openGraph()
	{
		return '
			<meta property="og:title" 		content="'.$this->title.'">'."\n".'			
			<meta property="og:description" content="'.strip_tags(trim(html_entity_decode($this->description))).'">'."\n".'		
			<meta property="og:url" 		content="'.$this->url.'">'."\n".'		
			<meta property="og:image" 		content="'.ROOT_URL.'private/uploads/logo.jpg">'."\n".'			
		';
	}
	
}