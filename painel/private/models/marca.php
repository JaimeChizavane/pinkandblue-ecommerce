<?php
class MarcaModel extends Model
{
	
	public function Index()
	{
		$this->query('DELETE FROM marcas WHERE nome is null OR nome = "" ');
		$this->execute();
		$this->query('SELECT * FROM marcas ORDER BY data_registo DESC');
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function salvar()
	{
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$uteis	= new Uteis;
		$data = date("Y-m-d");
		if(isset($post["accao"]) && $post["accao"] == "salvar_marca")
		{
			$this->query("UPDATE marcas SET nome =:nome, descricao =:descricao, categoria_id =:categoria_id, link =:link, status =:status, data_alterado =:data_alterado WHERE id =:id");
			$this->bind(":nome",			$post["nome"]);
			$this->bind(":link",			$uteis->setUri($post["nome"]));
			$this->bind(":descricao",		$post["descricao"]);
			$this->bind(":categoria_id",	$post["categoria_id"]);
			$this->bind(":status",			$post["status"]);
			$this->bind(":data_alterado",	$data);
			$this->bind(":id",				$post["id"]);
			$this->execute();
			echo json_encode(array(
				"status"		=> "success"
			));
			exit;
		}else{
			$this->query('SELECT * FROM marcas WHERE id = '.$_GET["id"]);
			$rows = $this->single();
			return $rows;
		}
	}
	
	//funcao responsavel por retornar a foto Principal do imovel
	public function retornafoto()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$output = '';
		$this->query("SELECT * FROM marcas WHERE id = :id");
		$this->bind(':id',$_POST['id']);
		$row = $this->single();
		if(!is_null($row['foto'])):
			$output .= '<div class="dev-col s12 m6 l6" id="foto_'.$post['id'].'" style="position:relative;">';
			$output .= '<img class="dev-border dev-padding-small dev-round-large" src="'.ROOT_URL.'tim.php?src='.ROOT_URL.'private/uploads/marcas/'.$row['foto'].'&w=380&h=215" style="max-width:100%;width:100%;">';
			$output .= '<span class="remove_icon_foto" data-url="private/uploads/marcas/'.$row['foto'].'" data-id="'.$row['id'].'"><i class="fa fa-times"></i></span>';
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
			$this->query('SELECT foto FROM marcas WHERE id = :id');
			$this->bind(':id',$post['id']);
			$retornafoto 	= $this->single();
			$foto 			= !empty($retornafoto['foto']) ? $retornafoto['foto'] : '';
			$dir    		= 'private/uploads/marcas/';			
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
					$this->query('UPDATE marcas SET foto = :foto WHERE id = :id');
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
		if(isset($post["accao"]) && $post["accao"] == "criar_nova_marca")
		{
			$this->query("INSERT INTO marcas 
				(nome, link, descricao, status, categoria_id, data_registo, data_alterado, usuario_id) 
				VALUES(:nome, :link, :descricao, :status, :categoria_id, :data_registo, :data_alterado, :usuario_id)");
			$this->bind(":nome",			null);
			$this->bind(":link",			null);
			$this->bind(":descricao",		null);
			$this->bind(":status",			0);
			$this->bind(":categoria_id",	0);
			$this->bind(":data_registo",	$data);
			$this->bind(":data_alterado",	$data);
			$this->bind(":usuario_id",		$_SESSION['manage_user']['id']);
			$this->execute();
			$lastInsertId = $this->lastInsertId();
			if($lastInsertId) 
				echo json_encode(array(
					"status"			=> "success",
					"nova_marca"	=> $lastInsertId,
					"tipo"				=> $post["tipo"]
			));	
		}			
	}
	
	public function listarMarcas($post)
	{
		$this->query("DELETE FROM marcas WHERE (marcas.nome IS NULL OR marcas.nome = '') ");
		$this->execute();
		
		$uteis 				= new Uteis;
		$tipo 				= $post["tipo"];
		$parent_table		= $this->return_parent_table($tipo);
		$totalRecords       = 0;
		$where				= "  WHERE c.tipo IN ('{$tipo}') ";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								"marcas.nome",
								NULL,	
								NULL,		
								NULL,		
								NULL,		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= "WHERE marcas.nome LIKE '%".$post["search"]["value"]."%' ";
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
				SELECT 
				mc.nome,
				mc.id,
				mc.descricao,
				mc.foto,
				mc.link,
				mc.data_registo,
				mc.status,
				c.nome as cat_nome,
				c.tipo
				FROM marcas mc
				INNER JOIN categorias c ON c.id = mc.categoria_id
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
		foreach($rows as $marca):
			$status = ($marca["status"] == 1) ? "Activo" : "Não Activo";
			$bg = ($marca["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$marca["nome"].'</td>';
			$output[] = '<td>'.$marca["cat_nome"].'</td>';
			$output[] = '<td><span class="dev-badge dev-flat-belize-hole">'.$uteis->recuperaTotal($parent_table,'WHERE marca_id ='.$marca["id"].'').'</span></td>';
			$output[] =  '<td><span class="dev-padding dev-small '.$bg.' dev-round">'.$status.'</span></td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($marca["data_registo"])).'</td>';
			$output[] =  '<td>
				<a href="'.ROOT_URL.'marcas/salvar/'.$marca["id"].'?tipo='.$tipo.'" class="dev-small dev-round dev-border dev-grey dev-padding-small dev-margin-right"><i class="fa fa-edit fa-fw fa-1x"></i></a>
				<input type="checkbox" class="dev-check dev-border delete" id="'.$marca["id"].'">
			</td>';
			$data[]   = $output;  
		endforeach;
		echo json_encode(
			array(
				"draw" 				=> intval($post["draw"]),
				"recordsTotal" 		=> $totalRecords,
				"recordsFiltered" 	=> $this->get_all_published_data(" INNER JOIN categorias ON categorias.id = marcas.categoria_id WHERE categorias.tipo IN ('{$tipo}')"),
				"data" 				=> $data
			)
		);
	}
	
	public function get_all_published_data($cond = null)
	{
		$this->query('SELECT * FROM marcas '.$cond.'');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function return_parent_table($param)
	{
		if($param == "imovel")
		{
			return "imoveis";
		}else if($param == "automovel")
		{
			return "automoveis";
		}else if($param == "produto")
		{
			return "produtos";
		}else if($param == "blog")
		{
			return "blog";
		}	
	}
	
	public function removerMarcas($post)
	{
		$id		= implode(", ",$post["id"]);
		$this->query("DELETE FROM marcas WHERE id IN({$id})");
		$this->execute();
		echo json_encode(array(
			"status"	=> true
		));
	}
}