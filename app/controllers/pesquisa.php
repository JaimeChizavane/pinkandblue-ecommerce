<?php 

class Pesquisa extends Controller
{
	private $title 				= 'Quick Maputo | Categorias';
	private $description 		= '';
	private $url 				= ROOT.'lojas';
	private $image 				= '';
	private $cond 				= ' ';
	private $maximo			 	= 12;
	private $total_retornado 	= 0;
	private $pagina_actual		= 1;
	
	public function index($termos = "", $pagina = "")
	{
		$model 				= $this->model('DataModel');
		$sobremodel 		= $this->model('SobreModel');
		$this->image		= $sobremodel->Instituicao()["logo"];	
		$this->description	= $sobremodel->Instituicao()["quem_somos"];
				
		$this->args			= func_get_args();	
		
		foreach($this->args as $values)
		{
			$param = explode('=',$values);
			if(in_array('pagina',$param))
			{
				$this->pagina_actual 	= $param[1];
			}

			if(in_array('termo',$param))
			{
				if($param[1] != 'nulo')
				{
					$termo				 = str_replace("-"," ",$param[1]);
					$breadcrumbs[] 		 = 'Termo: '.$termo;
					$this->cond 		 = " WHERE p.nome LIKE '%$termo%' OR p.descricao LIKE '%$termo%' ";
				}	
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
			'paginacao' 					=>	$this->retornaPaginacao("pesquisa/",""),
			'lista_categorias' 				=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto,count(p.categoria_id) as total",
				" LEFT OUTER JOIN produtos p ON p.categoria_id = c.id WHERE c.status = 1 AND c.tipo IN('produto') GROUP BY c.id ASC"
			)
		);
		$this->returnView('lojas/pesquisa',$homeModel,false, "/lojas/");
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
			
			$output 	   .='<a href="'.ROOT.$url.'/pagina=1" class="dev-padding dev-border">Primeira pagina</a>';
				for($i = $this->pagina_actual - $maxLinks; $i <= $this->pagina_actual - 1; $i++)
				{
					if($i >= 1)
					{
						$output .='<a href="'.ROOT.$url.'/pagina='.$i.'" class="dev-padding dev-border">'.$i.'</a>';
					}
				}
				$output .='<span class="dev-padding dev-border dev-light-grey" style="cursor:text">'.$this->pagina_actual.'</span>';
				for($i = $this->pagina_actual + 1; $i <= $this->pagina_actual + $maxLinks; $i++)
				{
					if($i <= $total_pagina)
					{
						$output .='<a href="'.ROOT.$url.'/pagina='.$i.'" class="dev-padding dev-border ">'.$i.'</a>';
					}
				}
			$output .='<a href="'.ROOT.$url.'/pagina='.$total_pagina.'" class="dev-padding dev-border">Ultima pagina</a></a>';
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