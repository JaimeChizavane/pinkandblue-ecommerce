<?php
class BairroModel extends Model
{
	
	public function Index()
	{
		$this->query('DELETE FROM bairros WHERE nome is null');
		$this->execute();
		$this->query('SELECT * FROM bairros ORDER BY data_registo DESC');
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function salvar()
	{
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$uteis  = new Uteis;
		$data	= date("Y-m-d");
		if(isset($post["salvar_bairro"]))
		{
			$this->query("UPDATE bairros SET nome =:nome, link = :link, provincia_id =:provincia_id, status =:status, data_alterado =:data_alterado WHERE id =:id");
			$this->bind(":nome",			$post["nome"]);
			$this->bind(":link",			$uteis->setUri($post["nome"]));
			$this->bind(":status",			$post["status"]);
			$this->bind(":provincia_id",	$post["provincia_id"]);
			$this->bind(":data_alterado",	$data);
			$this->bind(":id",				$post["id"]);
			$this->execute();
			header("Location:".ROOT_URL."/bairros");
		}else{
			$this->query('SELECT * FROM bairros WHERE usuario_id = "'.$_SESSION["manage_user"]["id"].'" AND id = '.$_GET["id"]);
			$rows = $this->single();
			return $rows;
		}
	}
	
	public function novo()
	{
		$data = date("Y-m-d");
		$post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "criar_novo_bairro")
		{
			$this->query("INSERT INTO bairros 
				(nome, link, status, provincia_id, data_registo, data_alterado, usuario_id) 
				VALUES(:nome, :link, :status, :provincia_id, :data_registo, :data_alterado, :usuario_id)");
			$this->bind(":nome",			null);
			$this->bind(":link",			null);
			$this->bind(":status",			0);
			$this->bind(":provincia_id",	0);
			$this->bind(":data_registo",	$data);
			$this->bind(":data_alterado",	$data);
			$this->bind(":usuario_id",		$_SESSION['manage_user']['id']);
			$this->execute();
			$lastInsertId = $this->lastInsertId();
			if($lastInsertId) 
				echo json_encode(array(
					"status"			=> "success",
					"novo_bairro"		=> $lastInsertId
			));	
		}			
	}
	
	public function listarBairros($post)
	{
		$uteis = new Uteis;
		$totalRecords       = 0;
		$where				= "";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								"bairros.nome",
								NULL,	
								NULL,		
								NULL,		
								NULL,		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " WHERE bairros.nome LIKE '%".$post["search"]["value"]."%' ";
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
				SELECT * FROM bairros 
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
		foreach($rows as $bairro):
			$status = ($bairro["status"] == 1) ? "Activo" : "Não Activo";
			$bg = ($bairro["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$bairro["nome"].'</td>';
			$output[] = '<td><span class="dev-badge dev-flat-belize-hole">'.$uteis->recuperaTotal('imoveis','WHERE bairro_id ='.$bairro["id"].'').'</span></td>';
			$output[] =  '<td><span class="dev-padding dev-small '.$bg.' dev-round">'.$status.'</span></td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($bairro["data_registo"])).'</td>';
			$output[] =  '<td>
				<a href="'.ROOT_URL.'bairros/salvar/'.$bairro["id"].'" class="dev-small dev-round dev-border dev-grey dev-padding-small dev-margin-right"><i class="fa fa-edit fa-fw fa-1x"></i></a>
				<input type="checkbox" class="dev-check dev-border delete" id="'.$bairro["id"].'">
			</td>';
			$data[]   = $output;  
		endforeach;
		echo json_encode(
			array(
				"draw" 				=> intval($post["draw"]),
				"recordsTotal" 		=> $totalRecords,
				"recordsFiltered" 	=> $this->get_all_publish_data(),
				"data" 				=> $data
			)
		);
	}
	
	public function get_all_publish_data()
	{
		$this->query('SELECT * FROM bairros');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function removerBairros($post)
	{
		$id		= implode(", ",$post["id"]);
		$this->query("DELETE FROM bairros WHERE id IN({$id})");
		$this->execute();
		echo json_encode(array(
			"status"	=> true
		));
	}
}