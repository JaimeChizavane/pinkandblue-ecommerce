<?php 

class Home extends Controller
{
	private $title 				= 'Quick Maputo| Lojas';
	private $description 		= '';
	private $url 				= ROOT.'lojas';
	private $image 				= '';
	private $cond 				= ' WHERE ';
	private $maximo			 	= 12;
	private $total_retornado 	= 0;
	private $pagina_actual		= 1;
	
	public function index()
	{
		$model 				= $this->model('DataModel');
		$sobremodel 		= $this->model('SobreModel');
		$this->image		= $sobremodel->Instituicao()["logo"];	
		$this->description	= $sobremodel->Instituicao()["quem_somos"];
		
		$homeModel = array(
			'MetaTitle'						=>	$this->MetaTitle(),
			'openGraph'						=>	$this->openGraph(),
			'instituicao'					=>	$sobremodel->Instituicao(),
			'lista_produtos' 				=>	$model->list_all_result("produtos p",
											"p.*",
											" WHERE p.status = 1 ORDER BY p.data_alterado ASC LIMIT 12"),
			'lista_categorias' 				=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto,count(p.categoria_id) as total",
				" LEFT OUTER JOIN produtos p ON p.categoria_id = c.id WHERE c.status = 1 AND c.tipo IN('produto') GROUP BY c.id ASC"
			),
			'lista_banners' 				=> 	$model->list_all_result(
				"banners b",
				"b.nome, b.id, b.link, b.foto",
				" WHERE b.status = 1 AND b.tipo IN('produto') GROUP BY b.id ASC"
			),
			'lista_subcategorias' 			=> 	$model->list_all_result(
				"subcategorias sb",
				"sb.*, c.nome as c_nome, c.tipo",
				" INNER JOIN categorias c ON c.id = sb.categoria_id WHERE sb.status = 1 AND c.tipo IN('produto')"
			)
		);
		$this->returnView('lojas/home',$homeModel,false, "/lojas/");
	}
	
	public function lista_produtos_por_categoria()
	{
		$model 			= $this->model('DataModel');
		$categoria_id 	= $_POST["categoria_id"];	
		$data 			= $model->list_all_result("produtos p",
											"p.*, c.link as c_link",
											"INNER JOIN categorias c ON c.id = p.categoria_id WHERE p.status = 1 AND categoria_id = {$categoria_id} ORDER BY p.data_alterado ASC LIMIT 12");	
		$output 			= "";	
		$link				= "";
		$mais_produtos_btn 	= "";
		$rowcount			= count($data);
		if($rowcount > 0):	
			foreach($data as $produtos):
				$output .= 	'<div class="dev-col l2 m6 s6 dev-margin-bottom dev-display-container">';
					$output .= '<div class="bounce dev-display-topright" id="notificacao_de_adicao_no_carrinho" style="z-index:999;display:none">
						<div class="dev-display-container">
							<a href="'.ROOT.'carrinho"><img src="'. TEMPLATE_PATH.'lojas/img/icons/shopping-bag.png" style="width:40px;" class="dev-margin-right">';
							$output .= '<span class="dev-badge dev-flat-alizarin dev-display-topmiddle total_items">';					
								if(isset($_SESSION["carrinho_de_compras"]))
								{
									$output .= count($_SESSION["carrinho_de_compras"]);
								}
								else
									$output .= "0";
							$output .= '</span>
							</a>
						</div>
					</div>';
					$output .= 	'<div class="dev-center dev-border dev-round-large dev-display-container dev-show-hover">';
						$output .= 	'<a href="'.ROOT.'produto/'.$produtos["link"].'">';
							$output .= 	'<div class="dev-padding-16" style="width:150px;height:200px;margin:0 auto;line-height:200px;max-width: 100%;">';
								$output .= 	'<img src="'.ROOT_URL.'private/uploads/preloader2.gif" data-src="'.ROOT_URL.'private/uploads/produtos/'.$produtos["foto"].'" alt="" class="dev-center dev-lazy" style="width:100%;max-height:100%;">';
							$output .= 	'</div>';
						$output .= 	'</a>';
						
						$output .= 	'<div class="dev-container dev-center dev-padding-bottom">';			
							$output .= 	'<a href="'.ROOT.'produto/'.$produtos["link"].'">';
								$output .= 	'<h1 class="dev-small dev-margin-0"><strong>'.$produtos["nome"].'</strong></h1>';
								$output .= 	'<h2 class="dev-medium dev-margin-0 dev-text-red"><strong>'.$produtos["moeda"].' '.number_format($produtos["preco"],2).'</strong></h2>';
							$output .= 	'</a>';								
							$output .= 	'<div class="dev-margin-top">';
								$output .= 	'<div class="dev-tooltip j_adiciona_no_carrinho">
												<div class="dev-tooltip-content dev-tooltip-top">
													<i class="fa fa-spinner dev-spin" style="font-size:30px"></i> 
													<p class="dev-margin-0">Adicionando no carrinho...</p>
												</div>
											</div>';
								$output .= 	'<button
												data-produto_id="'.$produtos["id"].'" 
												data-preco="'.$produtos["preco"].'" 
												data-moeda="'.$produtos["moeda"].'" 
												data-nome="'.$produtos["nome"].'" 
												data-quantidade="1" 
												data-foto="'.$produtos["foto"].'" 
											class="dev-btn dev-block dev-flat-alizarin dev-round-large j_adicionar_no_carrinho"><i class="fa fa-shopping-cart"></i> Adicionar</button>';
							$output .= 	'</div>';						
						$output .= ' </div>';
					$output .= 	'</div>';
				$output .= 	'</div>';
				$link	    		= $produtos["c_link"];				
			endforeach;	
			$mais_produtos_btn .= '<a href="'.ROOT.'categorias/'.$link.'" class="dev-btn dev-block dev-flat-alizarin">Mais Produtos <i class="fa fa-long-arrow-right"></i></a>';
		else:
			$output 			.= 	'<div class="dev-center dev-xxlarge dev-padding-64">Nenhum Produto encontrado para esta categoria</div>';
			$mais_produtos_btn 	.= "";
		endif;	
		echo json_encode(
			array(
				"status" 				=> "success",
				"result" 				=> $output,
				"total"					=> $rowcount,
				"mais_produtos_btn" 	=> $mais_produtos_btn
			)
		);	
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