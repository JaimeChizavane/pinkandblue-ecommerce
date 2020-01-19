<?php

class Cliente extends Controller
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
		if(!empty($_SESSION["cliente"]))
		{
			header("Location:".ROOT."cliente/pagamentos");
		}
		$this->returnView('lojas/cliente',[],false, "/lojas/");
	}

	public function registo()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->salvar_cliente($post);
	}
	
	public function editar_cliente()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->editar_cliente($post);
	}
	
	public function mudar_senha()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->mudar_senha($post);
	}	
	
	public function login()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->login($post);
	}

	public function google_profile_login()
	{		
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->google_profile_login($post);
	}

	public function logout()
	{
		unset($_SESSION["cliente"]);
		$_SESSION["logout"] == true;
		header("Location:".ROOT."cliente/");
		return;
	}

	public function endereco_de_entrega()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->endereco_de_entrega($post);
	}

	public function retorna_enderecos_relacionados()
	{
		$model 				= $this->model('DataModel');
		$data = array(
		'lista_enderecos' 				=> 	$model->list_all_result(
		"endereco e",
		"*",
		" WHERE e.cliente_id = {$_SESSION["cliente"]["id"]}"
		),
		);

		$output = "";

		foreach ($data["lista_enderecos"] as $enderecos) {
			$checked = ($enderecos["padrao"] == 1) ? " checked " : "";
			$data    = array(
			$enderecos["cidade"], $enderecos["endereco"], "codigo postal: ". $enderecos["codigo_postal"]
			);
			$output .= '
					<div>
						<input class="dev-radio j_endereco_id" type="radio" name="endereco_id" id="'.$enderecos["id"].'" value="'.$enderecos["id"].'" '.$checked.'>
						<label class="dev-validate" for="'.$enderecos["id"].'">'.implode(",", $data).'</label>
					</div>
					';
		}

		echo json_encode(
		array(
		"status"	=> "success",
		"result"	=> $output
		)
		);
	}

	public function pagamentos()
	{
		if(empty($_SESSION["cliente"]))
		{
			header("Location:".ROOT."cliente");
		}
		
		$model 				= $this->model('DataModel');
		$data = array(
			'lista_enderecos' 				=> 	$model->list_all_result(
				"
					endereco e
				",
				"
					e.*
				",
				" 
					WHERE e.cliente_id = {$_SESSION["cliente"]["id"]}
				"
			),
		);
		$this->returnView('lojas/pagamentos',$data,false, "/lojas/");
	}

	
	public function enderecos()
	{
		$model 				= $this->model('DataModel');
		$data = array(
			'lista_enderecos' 				=> 	$model->list_all_result(
				"
					endereco e
				",
				"
					e.*
				",
				" 
					WHERE e.cliente_id = {$_SESSION["cliente"]["id"]}
					ORDER BY e.id DESC
				"
			),
		);
		$this->returnView('lojas/enderecos',$data,false, "/lojas/");
	}
		
	public function salvar_enderecos()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->salvar_enderecos($post);
	}
	
	public function remover_enderecos()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->remover_enderecos($post);
	}
	
	public function remover_pedidos()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->remover_pedidos($post);
	}
	public function remover_favoritos()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->remover_favoritos($post);
	}
	
	public function perfil()
	{
		$model 				= $this->model('DataModel');
		$data = array(
			'lista_perfil' 				=> 	$model->list_one_result(
				"
					clientes c
				",
				"
					c.*
				",
				" 
					WHERE c.id = {$_SESSION["cliente"]["id"]}
				"
			),
		);
		$this->returnView('lojas/perfil',$data,false, "/lojas/");
	}
	
	public function finaliza_pagamento()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->finaliza_pagamento($post);
	}


	public function pedidos()
	{
		if (empty($_SESSION["cliente"])) {
			header("Location:".ROOT."cliente/");
			return;
		}
		
		$model 				= $this->model('DataModel');
		$data = array(
			'lista_pedidos' 				=> 	$model->list_all_result(
				"
					pedidos p
				",
				"
					p.*, 
					count(pd.pedido_id) as items
				",
				"
					INNER JOIN pedido_detalhes pd ON pd.pedido_id = p.id 
					WHERE p.cliente_id = {$_SESSION["cliente"]["id"]} 
					GROUP BY p.id  ORDER BY p.id ASC
				"
			),
		);
		$this->returnView('lojas/pedidos',$data,false, "/lojas/");
	}

	public function pedido($id_key = "", $id_value = "")
	{
		if (empty($_SESSION["cliente"])) {
			header("Location:".ROOT."cliente/");
			return;
		}
		$model 						= $this->model('DataModel');
		$data = array(
			'lista_pedido_destalhes' 	=> 	$model->list_all_result(
				"
					pedido_detalhes pd
				",
				"
					pd.*
				",
				"
					WHERE pd.pedido_id = {$id_value}
				"
			),
			'lista_pedido' 			=> 	$model->list_one_result(
				"
					pedidos p
				",
				"
					p.*
				",
				"
					WHERE p.id = {$id_value}
				"
			),
			'lista_endereco' 			=> 	$model->list_one_result(
				"
					endereco e
				",
				"
					e.*
				",
				"
					INNER JOIN pedidos p ON p.endereco_id = e.id 
					WHERE p.id = {$id_value} ORDER BY p.id ASC
				"
			),
		);
		$this->returnView('lojas/pedido',$data,false, "/lojas/");
	}

	public function adicionar_favoritos()
	{
		if (empty($_SESSION["cliente"])) 
		{
			echo json_encode(
				array(
				"status" => "sem_sessao"
				)
			);
			return;
		}

		echo json_encode(
			array(
			"status" => "sessao_iniciada"
			)
		);
	}

	public function salvar_favoritos()
	{
		$model 				= $this->model('ClienteModel');
		$post				= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$model->salvar_favoritos($post);
	}


	public function favoritos()
	{
		if (empty($_SESSION["cliente"])) {
			header("Location:".ROOT."cliente/");
			return;
		}
		$model 								= $this->model('DataModel');
		$data = array(
			'lista_favorito' 				=> 	$model->list_all_result(
				"
					favoritos f
				",
				"
					f.*, count(fd.favorito_id) as items
				",
				"
					INNER JOIN favorito_detalhes fd ON fd.favorito_id = f.id 
					WHERE f.cliente_id = {$_SESSION["cliente"]["id"]} GROUP BY f.id
				"
			),
		);
		$this->returnView('lojas/favoritos',$data,false, "/lojas/");
	}

	public function favorito($id_key = "", $id_value = "")
	{
		if (empty($_SESSION["cliente"])) {
			header("Location:".ROOT."cliente/");
			return;
		}
		$model 							= 	$this->model('DataModel');
		$favoritos						=	$model->list_one_result(
				"favoritos f",
				"
					f.*
				",
				"
					WHERE f.id = {$id_value}
				"
			);
		$data = array(
			'lista_favorito'			=>	$favoritos,
			'total_favorito'			=>	count($favoritos),
			'lista_favorito_detalhes' 	=> 	$model->list_all_result(
				"favorito_detalhes fd",
				"
					fd.*
				",
				" WHERE fd.favorito_id = {$id_value}"
			)
		);
		$this->returnView('lojas/favorito',$data,false, "/lojas/");
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