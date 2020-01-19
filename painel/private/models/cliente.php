<?php
class ClienteModel extends Model
{
	
	public function Index()
	{
		$this->query('DELETE FROM proprietarios WHERE nome is null OR nome = "" ');
		$this->execute();
		$this->query('SELECT * FROM proprietarios ORDER BY data_registo DESC');
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function salvar()
	{
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$uteis	= new Uteis;
		$data = date("Y-m-d");
		if(isset($post["accao"]) && $post["accao"] == "salvar_proprietario")
		{
			$this->query("UPDATE proprietarios SET nome =:nome, contacto =:contacto, email =:email, website =:website,descricao =:descricao, tipo =:tipo, link =:link, status =:status, data_alterado =:data_alterado WHERE id =:id");
			$this->bind(":nome",			$post["nome"]);
			$this->bind(":contacto",		$post["contacto"]);
			$this->bind(":email",			$post["email"]);
			$this->bind(":website",			$post["website"]);
			$this->bind(":link",			$uteis->setUri($post["nome"]));
			$this->bind(":descricao",		$post["descricao"]);
			$this->bind(":tipo",			$post["tipo"]);
			$this->bind(":status",			$post["status"]);
			$this->bind(":data_alterado",	$data);
			$this->bind(":id",				$post["id"]);
			$this->execute();
			echo json_encode(array(
				"status"		=> "success"
			));
			exit;
		}else{
			$this->query('SELECT * FROM proprietarios WHERE id = '.$_GET["id"]);
			$rows = $this->single();
			return $rows;
		}
	}
	
	//funcao responsavel por retornar a foto Principal do proprietario
	public function retornafoto()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$output = '';
		$this->query("SELECT * FROM proprietarios WHERE id = :id");
		$this->bind(':id',$_POST['id']);
		$row = $this->single();
		if(!is_null($row['foto'])):
			$output .= '<div class="dev-col s12 m6 l6" id="foto_'.$post['id'].'" style="position:relative;">';
			$output .= '<img class="dev-border dev-padding-small dev-round-large" src="'.ROOT_URL.'tim.php?src='.ROOT_URL.'private/uploads/proprietarios/'.$row['foto'].'&w=380&h=215" style="max-width:100%;width:100%;">';
			$output .= '<span class="remove_icon_foto" data-url="private/uploads/proprietarios/'.$row['foto'].'" data-id="'.$row['id'].'"><i class="fa fa-times"></i></span>';
			$output .= '</div>';
			$output .= '<div style="clear:both;"></div>';			
		endif;
		echo json_encode(array(
			"status" => "success",
			"result" => $output
		));
		exit;
	}
	
	//funcao responsavel pelo upload da foto
	public function uploadfoto()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post['accao']) && $post['accao'] == 'uploadfoto'){
			$this->query('SELECT foto FROM proprietarios WHERE id = :id');
			$this->bind(':id',$post['id']);
			$retornafoto 	= $this->single();
			$foto 			= !empty($retornafoto['foto']) ? $retornafoto['foto'] : '';
			$dir    		= 'private/uploads/proprietarios/';			
			if(!file_exists($dir)){
				mkdir($dir,0577);
			}			
			if(isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])):
				if(file_exists($dir.$foto) && !is_dir($dir.$foto)){
					unlink($dir.$foto);
				}			
				$referencia = explode(".",$_FILES['foto']['name']);
				$extensao	= end($referencia);
				$foto 		= md5(rand(),false).".".$extensao;
				if(move_uploaded_file($_FILES['foto']['tmp_name'],$dir.$foto)){
					$this->query('UPDATE proprietarios SET foto = :foto WHERE id = :id');
					$this->bind(':foto', $foto);
					$this->bind(':id', $post['id']);
					$this->execute();
					echo json_encode(array(
						"status" => "success"
					));
				}			
			endif;
		}
		return;
	}
	
	public function novo()
	{
		$data = date("Y-m-d");
		$post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "criar_novo_proprietario")
		{
			$this->query("INSERT INTO proprietarios 
				(nome, contacto, email, website, link, descricao, status, tipo, data_registo, data_alterado, usuario_id) 
				VALUES(:nome, :contacto, :email, :website, :link, :descricao, :status, :tipo, :data_registo, :data_alterado, :usuario_id)");
			$this->bind(":nome",			null);
			$this->bind(":contacto",		null);
			$this->bind(":email",			null);
			$this->bind(":website",			null);
			$this->bind(":link",			null);
			$this->bind(":descricao",		null);
			$this->bind(":status",			0);
			$this->bind(":tipo",			$post["tipo"]);
			$this->bind(":data_registo",	$data);
			$this->bind(":data_alterado",	$data);
			$this->bind(":usuario_id",		$_SESSION['manage_user']['id']);
			$this->execute();
			$lastInsertId = $this->lastInsertId();
			if($lastInsertId) 
				echo json_encode(array(
					"status"			=> "success",
					"novo_proprietario"	=> $lastInsertId
			));	
		}			
	}
	
	public function listarClientes($post)
	{
		$this->query("DELETE FROM clientes WHERE (clientes.nome IS NULL OR clientes.nome = '') ");
		$this->execute();
		
		$uteis 				= new Uteis;
		$totalRecords       = 0;
		$where				= "  WHERE  ";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								"clientes.nome",
								NULL,	
								NULL,		
								NULL,		
								NULL,		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " clientes.nome LIKE '%".$post["search"]["value"]."%' ";
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
				SELECT * FROM clientes 
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
		foreach($rows as $proprietario):
			$status = ($proprietario["status"] == 1) ? "Activo" : "Não Activo";
			$bg = ($proprietario["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$proprietario["nome"].'</td>';
			$output[] = '<td><span class="dev-badge dev-flat-belize-hole">'.$uteis->recuperaTotal($parent_table,'WHERE proprietario_id ='.$proprietario["id"].'').'</span></td>';
			$output[] =  '<td><span class="dev-padding dev-small '.$bg.' dev-round">'.$status.'</span></td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($proprietario["data_registo"])).'</td>';
			$output[] =  '<td>
				<a href="'.ROOT_URL.'proprietarios/salvar/'.$proprietario["id"].'" class="dev-small dev-round dev-border dev-grey dev-padding-small dev-margin-right"><i class="fa fa-edit fa-fw fa-1x"></i></a>
				<input type="checkbox" class="dev-check dev-border delete" id="'.$proprietario["id"].'">
			</td>';
			$data[]   = $output;  
		endforeach;
		echo json_encode(
			array(
				"draw" 				=> intval($post["draw"]),
				"recordsTotal" 		=> $totalRecords,
				"recordsFiltered" 	=> $this->get_all_published_data(""),
				"data" 				=> $data
			)
		);
	}
	
	public function get_all_published_data($cond = null)
	{
		$this->query('SELECT * FROM clientes '.$cond.'');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	
	public function removerClientes($post)
	{
		$id		= implode(", ",$post["id"]);
		$this->query("DELETE FROM clientes WHERE id IN({$id})");
		$this->execute();
		echo json_encode(array(
			"status"	=> true
		));
	}
}