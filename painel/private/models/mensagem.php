<?php
class MensagemModel extends Model
{
	public function Index()
	{
		$this->query('SELECT * FROM mensagens ORDER BY id DESC');
		$this->execute();
		return $this->resultSet();
	}
	
	public function ver()
	{
		$id		= $_GET["id"];
		$this->query('SELECT 
			imoveis.id 					as imoveis_id, 
			imoveis.nome 				as imoveis_nome, 
			imoveis.descricao 			as imoveis_descricao, 
			imoveis.preco 				as imoveis_preco,  
			imoveis.quartos 			as imoveis_quartos,  
			imoveis.casas_de_banho 		as imoveis_casas_de_banho,  
			imoveis.mensagem_id 		as imoveis_mensagem_id,  
			imoveis.bairro_id 			as imoveis_bairro_id,  
			imoveis.moeda 				as imoveis_moeda,  
			imoveis.latitude 			as imoveis_latitude,  
			imoveis.longitude 			as imoveis_longitude,  
			imoveis.endereco 			as imoveis_endereco,  
			imoveis.foto 				as imoveis_foto,
			mensagens.nome 				as mensagens_nome,
			mensagens.email 			as mensagens_email,
			mensagens.contacto 			as mensagens_contacto,
			mensagens.mensagem 			as mensagens_mensagem,
			mensagens.imovel_id 		as mensagens_imovel_id	
		FROM mensagens INNER JOIN imoveis ON imoveis.id = mensagens.imovel_id WHERE mensagens.id = '.$id.'');
		$this->execute();
		return $this->single();
	}
	
	public function imovel()
	{
		$id		= $_GET["id"];
		$this->query('SELECT 
				imoveis.id 				as imoveis_id, 
				imoveis.nome 			as imoveis_nome, 
				imoveis.descricao 		as imoveis_descricao, 
				imoveis.preco 			as imoveis_preco, 
				imoveis.quartos 		as imoveis_quartos, 
				imoveis.casas_de_banho 	as imoveis_casas_de_banho, 
				imoveis.mensagem_id 	as imoveis_mensagem_id, 
				imoveis.bairro_id 		as imoveis_bairro_id, 
				imoveis.moeda 			as imoveis_moeda, 
				imoveis.latitude 		as imoveis_latitude, 
				imoveis.longitude 		as imoveis_longitude, 
				imoveis.endereco 		as imoveis_endereco, 
				imoveis.foto 			as imoveis_foto, 
				mensagens.id 			as mensagens_id, 
				mensagens.nome 			as mensagens_nome,
				mensagens.email 		as mensagens_email,
				mensagens.contacto 		as mensagens_contacto, 
				mensagens.mensagem 		as mensagens_mensagem, 
				mensagens.imovel_id 	as mensagens_imovel_id, 
				mensagens.data_registo 	as mensagens_data_registo FROM mensagens INNER JOIN imoveis ON imoveis.id = mensagens.imovel_id 
			WHERE mensagens.imovel_id = '.$id.'');
		$this->execute();
		return $this->resultSet();
	}
	
	public function salvar()
	{
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d");
		if(isset($post["accao"]) && $post["accao"] == "salvar_mensagem")
		{
			$this->query('INSERT INTO mensagens(nome,email,contacto,mensagem, imovel_id, data_registo) VALUES(:nome, :email, :contacto, :mensagem, :imovel_id, :data_registo)');
			$this->bind(':nome',			$post['nome']);
			$this->bind(':email',			$post['email']);
			$this->bind(':contacto',		$post['contacto']);
			$this->bind(':mensagem',		$post['mensagem']);
			$this->bind(':imovel_id',		$post['imovel_id']);
			$this->bind(':data_registo',	$data);
			$this->execute();
			if($this->lastInsertId())
			{
				echo json_encode(array(
					'status' => 'success'
				));
			}
		}
	}
	
	public function listarMensagens($post)
	{		
		$uteis = new Uteis;
		$totalRecords       = 0;
		$where				= "";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								NULL,
								"mensagens.email",	
								NULL,		
								NULL
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " WHERE mensagens.nome LIKE '%".$post["search"]["value"]."%' ";
		}
		
		if(isset($post["order"]) && !empty($post["order"]))
		{
			$order = " ORDER BY ".$order_array[$post["order"][0]["column"]]." ".$post["order"][0]["dir"]." ";
		}
		
		if(isset($post["length"]) && $post["length"] != -1)
		{
			$limit = " LIMIT ".$post["start"].", ".$post["length"]." ";
		}
		
		$this->query(
			"
				SELECT * FROM mensagens 
				{$where}
				{$order}
				{$limit}
			"
		);
		$rows = $this->resultSet();
		$status = "";
		$bg = "";
		$totalRecords 	 = count($rows);
		$data = array();
		foreach($rows as $mensagem):
			$status = ($mensagem["status"] == 1) ? "Activo" : "Não Activo";
			$bg = ($mensagem["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$mensagem["mensagem"].'</td>';
			$output[] = '<td>'.$mensagem["email"].'</td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($mensagem["data_registo"])).'</td>';
			$output[] =  '<td>
				<a href="'.ROOT_URL.'mensagens/ver/'.$mensagem["id"].'" class="dev-small dev-round dev-border dev-grey dev-padding-small dev-margin-right"><i class="fa fa-search fa-fw fa-1x"></i></a>
				<input type="checkbox" class="dev-check dev-border delete" id="'.$mensagem["id"].'">
			</td>';
			$data[]   = $output;  
		endforeach;
		echo json_encode(
			array(
				"draw" 				=> intval($post["draw"]),
				"recordsTotal" 		=> $totalRecords,
				"recordsFiltered" 	=> $this->get_all_published_data(),
				"data" 				=> $data
			)
		);
	}
	
	public function get_all_published_data()
	{
		$this->query('SELECT * FROM mensagens');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function remover()
	{
		$id		= $_GET["id"];
		$this->query("DELETE FROM mensagens WHERE id =:id");
		$this->bind(":id",$_GET["id"]);
		$this->execute();
		header("Location: ".ROOT_URL."/mensagens");
	}
	
	public function email()
	{
		return;
	}
	
}