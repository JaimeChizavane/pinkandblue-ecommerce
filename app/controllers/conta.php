<?php 

class Conta extends Controller
{
	private $title 				= 'QuickMaputo | Conta';
	private $description 		= '';
	private $url 				= ROOT.'conta';
	private $image 				= '';
	
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
			'lista_lojas' 					=>	$model->list_all_result("produtos p","*"," WHERE p.status = 1 ORDER BY p.data_alterado ASC LIMIT 8"),
			'lista_categorias' 				=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto",
				" WHERE c.status = 1 AND c.tipo IN('produto')"
			)
		);
		$this->returnView('lojas/conta',$homeModel,false, "/lojas/");
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