<?php
class ProdutoModel extends Model
{	
	public function Index()
	{
		$this->query('DELETE FROM produtos WHERE (nome is null)');
		$this->execute();
		$this->query('SELECT p.*, c.nome as c_nome FROM produtos p 
			INNER JOIN categorias c ON c.id = p.categoria_id ORDER BY id DESC LIMIT 0,12');
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function dashboard()
	{
		$this->query('
				SELECT 
					COUNT(p.id) as total_produtos,	
					ct.total_categorias,
					sbc.total_subcategorias,
					mcs.total_marcas,
					pts.total_proprietarios,
					cl.total_clientes,
					pd.total_pedidos,
					pg.total_pagamentos
				FROM produtos p 
					JOIN(
						SELECT COUNT(c.id) as total_categorias FROM categorias c
					) ct
					JOIN(
						SELECT COUNT(sc.id) as total_subcategorias FROM subcategorias sc
					) sbc	
					JOIN(
						SELECT COUNT(mc.id) as total_marcas FROM marcas mc
					) mcs	
					JOIN(
						SELECT COUNT(pt.id) as total_proprietarios FROM proprietarios pt
					) pts	
					JOIN(
						SELECT COUNT(c.id) as total_clientes FROM clientes c
					) cl	
					JOIN(
						SELECT COUNT(p.id) as total_pedidos FROM pedidos p
					) pd	
					JOIN(
						SELECT FORMAT(SUM(p.total),2) as total_pagamentos FROM pedidos p WHERE estado IN(1)
					) pg				
			');
		$rows = $this->single();
		return $rows;
	}
	
	public function salvar()
	{
		$uteis 	= new Uteis;
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d");
		$preco = str_replace(",","",$post['preco']);
		if(isset($post["accao"]) && $post["accao"] == "salvar_produto")
		{
			$categoria_id 			= isset($post["categoria_id"]) 		? 	$post["categoria_id"] 		: 0;
			$proprietario_id	 	= isset($post["proprietario_id"]) 	? 	$post["proprietario_id"] 	: 0;
			$subcategoria_id	 	= isset($post["subcategoria_id"]) 	? 	$post["subcategoria_id"] 	: 0;
			$marca_id	 			= isset($post["marca_id"]) 			? 	$post["marca_id"] 			: 0;
			$this->query('UPDATE produtos SET 
				nome 				=:nome, 
				descricao 			=:descricao, 
				preco 				=:preco, 
				categoria_id		=:categoria_id,
				proprietario_id		=:proprietario_id,
				subcategoria_id		=:subcategoria_id,
				marca_id			=:marca_id,
				moeda				=:moeda,
				link				=:link,
				visitas				=:visitas,
				status				=:status,
				data_alterado		=:data_alterado
			WHERE id =:id');
			$this->bind(":nome",				$post["nome"]);
			$this->bind(":descricao",			 isset($post['descricao']) ? $_POST['descricao'] : NULL);
			$this->bind(":preco",				$preco);
			$this->bind(":categoria_id",		$categoria_id);
			$this->bind(":proprietario_id",		$proprietario_id);
			$this->bind(":subcategoria_id",		$subcategoria_id);
			$this->bind(":marca_id",			$marca_id);
			$this->bind(":moeda",				$post["moeda"]);
			$this->bind(":link",				$uteis->setUri($post["nome"]));
			$this->bind(":visitas",				1);
			$this->bind(":status",				$post["status"]);
			$this->bind(":data_alterado",		$data);
			$this->bind(":id",					$post["id"]);
			$this->execute();			
			echo json_encode(array(
				"status"		=> "success"
			));
			exit;
		}else{
			$this->query('SELECT * FROM produtos WHERE id = '.$_GET["id"]);
			$this->execute();
			$rows = $this->single();
			return $rows;
		}
	}
	
	
	public function novo()
	{
		$data = date("Y-m-d");
		$this->query('INSERT INTO 
				produtos SET 
				nome 				=:nome, 
				descricao 			=:descricao, 
				preco 				=:preco, 
				categoria_id		=:categoria_id,
				proprietario_id		=:proprietario_id,
				subcategoria_id		=:subcategoria_id,
				marca_id			=:marca_id,
				moeda				=:moeda,
				link				=:link,
				visitas				=:visitas,
				variacao_id			=:variacao_id,
				usuario_id			=:usuario_id,
				status				=:status,
				data_registo		=:data_registo,
				data_alterado		=:data_alterado');
			$this->bind(":nome",				null);
			$this->bind(":descricao",			null);
			$this->bind(":preco",				0);
			$this->bind(":categoria_id",		0);
			$this->bind(":proprietario_id",		0);
			$this->bind(":subcategoria_id",		0);
			$this->bind(":marca_id",			0);
			$this->bind(":moeda",				0);
			$this->bind(":link",				null);
			$this->bind(":visitas",				1);
			$this->bind(":variacao_id",			0);
			$this->bind(":usuario_id",			0);
			$this->bind(":status",				0);
			$this->bind(":data_registo",		$data);
			$this->bind(":data_alterado",		$data);
			$this->execute();
			$lastInsertId = $this->lastInsertId();
		if($lastInsertId) 
			echo json_encode(array(
				"status"=>"success",
				"novo_produto"=>$lastInsertId
		));	
		exit;	
	}
		
	//funcao responsavel por retornar a galeria do produto
	public function retornaGaleria()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$this->query("SELECT * FROM galeria_produto WHERE produto_id = :produto_id");
		$this->bind(':produto_id',$post['id']);
		$this->execute();
		$output		= '';		
		$galeria_produto = $this->resultSet();
		foreach($galeria_produto as $galeria):
		$output	.= '<div class="dev-col s6 m3 l3" style="padding:8px;position:relative;" id="foto_galeria_'.$galeria['id'].'">
				<img class="dev-border dev-padding-small dev-round" src="'.ROOT_URL.'private/uploads/produtos/'.$galeria['nome'].'" style="max-width:200px;max-height:180px;">
				<span class="remove_icon_foto_galeria" data-url="private/uploads/produtos/'.$galeria['nome'].'" data-id="'.$galeria['id'].'"><i class="fa fa-times"></i></span>
			</div>';
		endforeach;
		$output	.= '<div style="clear:both;"></div>';		
		echo json_encode(array(
			"status" => "success",
			"result" => $output
		));
		exit;
	}
		
	//funcao responsavel por retornar a foto Principal do produto
	public function retornafoto()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$output = '';
		$this->query("SELECT * FROM produtos WHERE id = :id");
		$this->bind(':id',$_POST['id']);
		$row = $this->single();
		if(!is_null($row['foto'])):
			$output .= '<div class="dev-col s12 m6 l6" id="foto_'.$post['id'].'" style="position:relative;">';
			$output .= '<img class="dev-border dev-padding-small dev-round-large" src="'.ROOT_URL.'private/uploads/produtos/'.$row['foto'].'" style="max-width:400px;width:100%;max-height:380px;">';
			$output .= '<span class="remove_icon_foto" data-url="private/uploads/produtos/'.$row['foto'].'" data-id="'.$row['id'].'"><i class="fa fa-times"></i></span>';
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
		if(isset($post['accao']) && $post['accao'] == 'uploadfoto')
		{
			$this->query('SELECT foto FROM produtos WHERE id = :id');
			$this->bind(':id',$post['id']);
			$retornafoto 	= $this->single();
			$foto 			= !empty($retornafoto['foto']) ? $retornafoto['foto'] : '';
			$dir    		= 'private/uploads/produtos/';			
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
					$this->query('UPDATE produtos SET foto = :foto WHERE id = :id');
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
	
	//funcao responsavel pelo upload da galeria
	public function uploadGaleria()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post['accao']) && $post['accao'] == 'uploadGaleria')
		{
			$dir    = 'private/uploads/produtos/';			
			if(!file_exists($dir)){
				mkdir($dir,0577);
			}
			if(isset($_FILES['galeria_produto']['tmp_name']) && !empty($_FILES['galeria_produto']['tmp_name'])){
				$this->query('INSERT INTO galeria_produto (nome, produto_id) VALUES(:nome, :produto_id)');
				$contagem = count($_FILES['galeria_produto']['tmp_name']);	
				for($i = 0; $i < $contagem; $i++){
					$fotoTmp 	= $_FILES['galeria_produto']['tmp_name'][$i];
					$referencia_galeria = explode(".",$_FILES['galeria_produto']['name'][$i]);
					$extensao_galeria 	= end($referencia_galeria);
					$fotoNome_galeria = md5(rand(),false).".".$extensao_galeria;
					move_uploaded_file($fotoTmp, $dir.$fotoNome_galeria);	
					$this->bind(':nome', $fotoNome_galeria);
					$this->bind(':produto_id', $_POST['id']);
					$this->execute();
				}
				echo json_encode(array(
					"status" => "success"
				));	
			}
		}
		return;
	}
	
	//funcao para remover galeria
	public function removefoto()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(file_exists($post['url'])):
			unlink($post['url']);
		endif;	
		$this->query("UPDATE produtos SET foto = null WHERE id = :id");
		$this->bind(':id',$post['id']);
		$this->execute();
		echo json_encode(array(
			"status" => "success",
			"id"	=>	$post['id']	
		));	
	}
	
	//funcao para remover galeria
	public function removeGaleria()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(file_exists($post['url'])):
			unlink($post['url']);			
		endif;
		$this->query("DELETE FROM galeria_produto WHERE id = :id");
		$this->bind(':id',$post['id']);
		$this->execute();
		echo json_encode(array(
			"status" => "success",
			"id"	 => $post['id']	
		));
	}
	
	public function remover()
	{
		$post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "remover")
		{
			if($post['id'] > 0){
				$this->query("DELETE FROM produtos WHERE id =:id");
				$this->bind(":id",$post['id']);
				$this->execute();
				echo json_encode(array(
					'status' => 'success'					
				));	
			}	
			
		}		
	}
		
	public function agrupar()
	{
		$post 		 = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		$uteis 		 = new Uteis;
		$cond		 = ' WHERE p.status IN (0,1) ';	
		$output 	 = '';
		$limit		 = " LIMIT 0,12 ";
		$last_id	 = "";			
		if(isset($post["accao"]) && $post["accao"] == "filtrar")
		{
			if(!empty($post["nome"]))
			{
				$cond .= ' AND p.nome LIKE "%'.$post["nome"].'%"';
			}
			
			if(!empty($post["categoria"]))
			{
				$cond 	.= ' AND p.categoria_id IN ('.$post["categoria"].')';
			}
			
			if(!empty($post["subcategoria"]))
			{
				$cond 	.= ' AND p.subcategoria_id IN ('.$post["subcategoria"].')';
			}
			
			if(!empty($post["marca"]))
			{
				$cond 	.= ' AND p.marca_id IN ('.$post["marca"].')';
			}
			
			if(!empty($post["proprietario"]))
			{
				$cond 	.= ' AND p.proprietario_id IN ('.$post["proprietario"].')';
			}
			
			if(!empty($post["page"]))
			{
				$cond 	.= ' AND p.id < '.$post["page"].' ';
			}

			$this->query('SELECT p.*, c.nome as c_nome FROM produtos p 
			INNER JOIN categorias c ON c.id = p.categoria_id '.$cond.' ORDER BY id DESC '.$limit.'');
			$this->execute();
			$data = $this->resultSet();
			foreach($data as $model){
				$last_id 	 = $model["id"];
				$output 	.= '<div class="dev-col l3 m6 s6 dev-margin-bottom" style="padding-left:15px;padding-right:15px;" id="produtos_'.$model["id"].'">
				<div class="dev-border dev-round-large dev-white dev-display-container">
					<div style="" class="dev-center">';
						$output 	.= '<img src="'.ROOT_URL.'private/uploads/produtos/'.$model["foto"].'" alt="'.$model["nome"].'" class="dev-image dev-padding-small" style="max-width:200px;max-height:180px;">';
					$output 	.= '</div>';
					$output 	.= '<div class="dev-padding">';
						$output 	.= '<p style="min-height:50px;height:50px;overflow: hidden;  text-overflow: ellipsis; margin-top:0" class="dev-center"><a href="'.ROOT.'produtos/'.$model['link'].'" target="_blank" class="dev-text-blue" style="text-decoration:none;">'.$model["nome"].'</a></p>';
						$output		.= '<p><span class="dev-padding-small dev-small dev-flat-belize-hole">
							'.$model["c_nome"].'
						</span></p>';
						$output 	.= '<p style="margin:0;" class="dev-large">'. $model["moeda"].' '.number_format($model["preco"],2).'</p>';
						$output 	.= '<p style="margin:0;" class="dev-small">';
						$output 	.= '<a href="#" class="dev-small" style="text-decoration:none;"><i class="fa fa-eye"></i> '.$model["visitas"].' visitas </a>
						
						<a href="#" class="dev-small" style="text-decoration:none;"><i class="fa fa-calendar"></i> '. date("d/m/Y",strtotime($model["data_registo"])).'</a>';
					$output 	.= '</div>';				
					$output 	.= '<div class="dev-padding">
						<button class="mybtn dev-padding"><i class="fa fa-plus"></i> Acção</button>
						<div class="dropdown">
						  <button class="mybtn dev-padding" style="border-left:1px solid navy">
							<i class="fa fa-caret-down"></i>
						  </button>
						  <div class="dropdown-content">
							<a href="'.ROOT_URL."produtos/salvar/".$model["id"].'" class="" style="border-radius:0;"><i class="fa fa-pencil"></i> Editar</a>
							<a class="j_remove_produto" href="'.$model["id"].'" style="border-radius:0;"><i class="fa fa-trash"></i> Remover</a>
							<a class="" href="'.ROOT.'produto/'.$model['link'].'" target="_blank" style="border-radius:0;"><i class="fa fa-search"></i> Ver</a>
						  </div>
						</div>
					</div>';
					$output	.= '<div class="dev-display-topleft" style="">
						<span class="dev-padding-small dev-small dev-flat-belize-hole">';
							if($model["status"] == 1)
							{
								$output	.="Activo";
							}else if($model["status"] == 2)
							{
								$output	.="Não Activo";
							}
						$output	.='</span>
					</div>';
					$output 	.= '</div>';
				$output 	.= '</div>';					
			}
			
			$this->query('SELECT * FROM produtos '.$cond.' ORDER BY id DESC ');
			$this->execute();
			$totalRecords = $this->resultSet();
			
			$output 	.= '<div class="dev-center dev-margin-top dev-margin-bottom j_page_button_loading">
				<button class="dev-button dev-flat-belize-hole j_page"';
				if(count($totalRecords) <= 12): 
					$output 	.= '" disabled "';
				endif;	
					$output 	.= ' id="'.$last_id.'">Mostrar mais Resultados</button>
				</div>';
		}	
		echo $output;
	}
}