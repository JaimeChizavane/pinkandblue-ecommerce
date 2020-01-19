<?php 
class ClienteModel extends Model
{
	public function salvar_cliente($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "salvar_cliente")
		{
			$data	= date("Y-m-d");
			$this->query(
				"INSERT INTO clientes 
					(
						nome,
						apelido,
						contacto,
						email,
						senha,
						estado,
						data_registo,
						data_alterado
					)
				VALUES
					(
						:nome,
						:apelido,
						:contacto,
						:email,
						:senha,
						:estado,
						:data_registo,
						:data_alterado
					)
				"
			);	
			
			$this->bind(":nome",			$post["nome"]);
			$this->bind(":apelido",			$post["apelido"]);
			$this->bind(":contacto",		$post["contacto"]);
			$this->bind(":email",			$post["email"]);
			$this->bind(":senha",			password_hash($post["senha"],PASSWORD_BCRYPT));
			$this->bind(":estado",			1);
			$this->bind(":data_registo",	$data);
			$this->bind(":data_alterado",	$data);
			
			$this->execute();
			if($this->lastInsertId())
			{
				
				$_SESSION["cliente"]["id"]			= $this->lastInsertId();
				$_SESSION["cliente"]["nome"]		= $post["nome"];
				$_SESSION["cliente"]["apelido"]		= $post["apelido"];
				$_SESSION["cliente"]["contacto"]	= $post["contacto"];
				$_SESSION["cliente"]["email"]		= $post["email"];
				
				echo json_encode(
					array(
						"status"	=> "success"
					)
				);
			}
		}else
		{
			header("Location:".ROOT."cliente/");
		}			
	}
	

	public function editar_cliente($post)
	{	
		$data	= date("Y-m-d");
		$this->query(
			"
				UPDATE clientes SET
					nome 			=:nome,
					apelido 		=:apelido,
					contacto 		=:contacto,
					email 			=:email,
					data_alterado 	=:data_alterado
				WHERE id	=:cliente_id
			"
		);	
		
		$this->bind(":nome",			$post["primeiro_nome"]);
		$this->bind(":apelido",			$post["apelido"]);
		$this->bind(":contacto",		$post["contacto"]);
		$this->bind(":email",			$post["email"]);
		$this->bind(":cliente_id",		$post["cliente_id"]);
		$this->bind(":data_alterado",	$data);
		
		$_SESSION["cliente"]["nome"]		= $post["primeiro_nome"];
		$_SESSION["cliente"]["apelido"]		= $post["apelido"];
		$_SESSION["cliente"]["contacto"]	= $post["contacto"];
		$_SESSION["cliente"]["email"]		= $post["email"];
		
		$this->execute();
		
		echo json_encode
		(
			array
			(
				"status"	=> "success"
			)
		);
	}	

	public function google_profile_login($post)
	{
		if(isset($post["ofa"]) && !empty($post["Eea"]) && !empty($post["U3"]))
		{
			//check if Google ID already exits
			$this->query(
					"
						SELECT * FROM `clientes` 
							WHERE 
						email 				=:email 
							AND 
						app_user_id		 	=:app_user_id 
							AND 
						app IN('google')
					"
				);
			$this->bind(":email", 			$post['U3']);
			$this->bind(":app_user_id", 	$post['Eea']);
			$check_user = $this->single();
			if(!$check_user)
			{
				$data	= date("Y-m-d");
				$this->query(
					"INSERT INTO clientes 
						(
							nome,
							apelido,
							contacto,
							email,
							senha,
							app,
							app_user_id,
							estado,
							data_registo,
							data_alterado
						)
					VALUES
						(
							:nome,
							:apelido,
							:contacto,
							:email,
							:senha,
							:app,
							:app_user_id,
							:estado,
							:data_registo,
							:data_alterado
						)
					"
				);	
				
				$this->bind(":nome",			$post["ofa"]);
				$this->bind(":apelido",			$post["wea"]);
				$this->bind(":contacto",		"");
				$this->bind(":email",			$post["U3"]);
				$this->bind(":senha",			NULL);
				$this->bind(":app",				"google");
				$this->bind(":app_user_id",		$post["Eea"]);
				$this->bind(":estado",			1);
				$this->bind(":data_registo",	$data);
				$this->bind(":data_alterado",	$data);
				$this->execute();
				if($this->lastInsertId())
				{
					$_SESSION["cliente"]["id"]			= $this->lastInsertId();
					$_SESSION["cliente"]["nome"]		= $post["ofa"];
					$_SESSION["cliente"]["apelido"]		= $post["wea"];
					$_SESSION["cliente"]["contacto"]	= "";
					$_SESSION["cliente"]["email"]		= $post["U3"];
					
					$arr = array('status' => "success");
					echo json_encode($arr);
				}				
			} else 
			{
				//update the user details
				$data	= date("Y-m-d");
				$this->query(
					"UPDATE  clientes SET						
							nome			=:nome,
							apelido			=:apelido,
							contacto		=:contacto,
							email			=:email,	
							data_alterado	=:data_alterado
						WHERE 
							app_user_id		=:app_user_id
					"
				);	
				
				$this->bind(":nome",			$post["ofa"]);
				$this->bind(":apelido",			$post["wea"]);
				$this->bind(":contacto",		"");
				$this->bind(":email",			$post["U3"]);
				$this->bind(":app_user_id",		$post["Eea"]);
				$this->bind(":data_alterado",	$data);
				$this->execute();
				
			    $_SESSION["cliente"]["id"]			= $check_user["id"];
				$_SESSION["cliente"]["nome"]		= $post["ofa"];
				$_SESSION["cliente"]["apelido"]		= $post["wea"];
				$_SESSION["cliente"]["contacto"]	= "";
				$_SESSION["cliente"]["email"]		= $post["U3"];
				
				$arr = array('status' => "success");
				echo json_encode($arr);
			}
		}
		else 
		{
			$arr = array('error' => 1);
			echo json_encode($arr);
		}	
	}	
	
	public function login($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "login")
		{
			$this->query("SELECT * FROM clientes WHERE email =:email");
			$this->bind(":email",		$post["email"]);
			$data = $this->single();
			
			if(count($data) > 0)
			{
				if(password_verify($post["senha"], $data["senha"]))
				{
					$_SESSION["cliente"] = $data;
					echo json_encode(
						array(
							"status"	=> "success"
						)
					);
				}
			}else
			{
				echo json_encode(
					array(
						"status"	=> "failed"
					)
				);
			}			
		}
	}
	
	public function endereco_de_entrega($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "endereco_de_entrega")
		{
			$padrao = 1;
			
			$this->query("SELECT * FROM endereco WHERE cliente_id =:cliente_id");
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);		
			
			if(count($this->single()) > 1)
			{
				$padrao = 0;
			}
			
			$data	= date("Y-m-d");
			$this->query(
				"INSERT INTO endereco 
					(
						codigo_postal,
						cidade,
						endereco,
						cliente_id,
						padrao
					)
				VALUES
					(
						:codigo_postal,
						:cidade,
						:endereco,
						:cliente_id,
						:padrao
					)
				"
			);	
			
			$this->bind(":codigo_postal",	$post["codigo_postal"]);
			$this->bind(":cidade",			$post["cidade"]);
			$this->bind(":endereco",		$post["endereco"]);
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);
			$this->bind(":padrao",			$padrao);
			
			$this->execute();
			if($this->lastInsertId())
			{				
				echo json_encode(
					array(
						"status"	=> "success"
					)
				);
			}
		}else
		{
			header("Location:".ROOT."cliente/");
		}			
	}
	
	public function mudar_senha($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "mudar_senha")
		{
			$data	= date("Y-m-d");
			$this->query(
				"
					UPDATE 
						clientes 
						SET senha =:senha
					WHERE 
						id	=:cliente_id
				"
			);	
			
			$this->bind(":senha",			password_hash($post["senha"],PASSWORD_BCRYPT));
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);
			
			$this->execute();
			echo json_encode
			(
				array(
					"status"	=> "success"
				)
			);
		}
	}
	
	public function salvar_enderecos($post)
	{
		if(isset($post["inserir"]) && $post["inserir"] == "true")
		{
			$padrao = 1;
			
			$this->query("SELECT * FROM endereco WHERE cliente_id =:cliente_id");
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);		
			
			if(count($this->single()) > 1)
			{
				$padrao = 0;
			}
			
			$data	= date("Y-m-d");
			$this->query(
				"INSERT INTO endereco 
					(
						codigo_postal,
						cidade,
						endereco,
						cliente_id,
						padrao
					)
				VALUES
					(
						:codigo_postal,
						:cidade,
						:endereco,
						:cliente_id,
						:padrao
					)
				"
			);	
			
			$this->bind(":codigo_postal",	$post["codigo_postal"]);
			$this->bind(":cidade",			$post["cidade"]);
			$this->bind(":endereco",		$post["endereco"]);
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);
			$this->bind(":padrao",			$padrao);
			
			$this->execute();
			if($this->lastInsertId())
			{				
				echo json_encode(
					array(
						"status"	=> "success"
					)
				);
			}
		}else
		{
			$data	= date("Y-m-d");
			$this->query(
				"UPDATE endereco SET
					codigo_postal		=:codigo_postal,
						cidade			=:cidade,
						endereco		=:endereco,
						cliente_id		=:cliente_id,
						padrao			=:padrao
					WHERE id			=:endereco_id	
				"
			);	
			
			$this->bind(":codigo_postal",	$post["codigo_postal"]);
			$this->bind(":cidade",			$post["cidade"]);
			$this->bind(":endereco",		$post["endereco"]);
			$this->bind(":cliente_id",		$_SESSION["cliente"]["id"]);
			$this->bind(":padrao",			0);
			$this->bind(":endereco_id",		$post["endereco_id"]);			
			$this->execute();
			echo json_encode(
				array(
					"status"	=> "success"
				)
			);
		}
	}
	
	public function remover_enderecos($post)
	{
		$this->query("DELETE FROM endereco WHERE id	=:endereco_id");
		$this->bind(":endereco_id",		$post["endereco_id"]);			
		$this->execute();
		echo json_encode(
			array(
				"status"	=> "success"
			)
		);
	}
	
	public function remover_pedidos($post)
	{
		foreach($post["pedido_id"] as $id):
			$this->query("DELETE FROM pedidos WHERE id	=:pedido_id");
			$this->bind(":pedido_id",		$id);			
			$this->execute();
		endforeach;
		echo json_encode(
			array(
				"status"	=> "success"
			)
		);
	}
	
	public function remover_favoritos($post)
	{
		foreach($post["favorito_id"] as $id):
			$this->query("DELETE FROM favoritos WHERE id	=:favorito_id");
			$this->bind(":favorito_id",		$id);			
			$this->execute();
		endforeach;
		echo json_encode(
			array(
				"status"	=> "success"
			)
		);
	}
	
	public function finaliza_pagamento($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "finaliza_pagamento")
		{	
			$data = date("Y-m-d");
			$this->query(
				"INSERT INTO pedidos 
					(
						`cliente_id`, 
						`endereco_id`, 
						`tipo_pagamento`, 
						`ordem`, 
						`estado`, 
						`data_registo`, 
						`data_alterado`, 
						`total`
					)
				VALUES
					(
						:cliente_id,
						:endereco_id,
						:tipo_pagamento,
						:ordem,
						:estado,
						:data_registo,
						:data_alterado,
						:total
					)
				"
			);
						
			$this->bind(":cliente_id", 			$_SESSION["cliente"]["id"]);
			$this->bind(":endereco_id", 		$post["endereco_id"]);
			$this->bind(":tipo_pagamento", 		$post["pagamento"]);
			$this->bind(":ordem", 				null);
			$this->bind(":estado", 				1);
			$this->bind(":data_registo", 		$data);
			$this->bind(":data_alterado", 		$data);
			$this->bind(":total", 				$post["total"]);	
			
			$this->execute();
			
			$lastInsertId = $this->lastInsertId();
			
			if($lastInsertId)
			{
				$this->query(
					"INSERT INTO pedido_detalhes 
						(
							pedido_id, 
							produto_id, 
							nome, 
							preco, 
							quantidade
						)
						VALUES
						(
							:pedido_id, 
							:produto_id, 
							:nome, 
							:preco, 
							:quantidade
						)
					"
				);
				
				foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
				{
					$this->bind(":pedido_id",		$lastInsertId);
					$this->bind(":produto_id",		$valores["produto_id"]);
					$this->bind(":nome",			$valores["produto_nome"]);
					$this->bind(":preco",			$valores["produto_preco"]);
					$this->bind(":quantidade",		$valores["produto_quantidade"]);
					$this->execute();
				}
				
				$this->query("SELECT COUNT(id) as count_id FROM pedidos");
				$count = $this->single();
				$ordem = "PD - ".date("Y")." / ".str_pad($count["count_id"],5,"0",STR_PAD_LEFT);
				$this->query("UPDATE pedidos SET ordem = '{$ordem}' WHERE id = {$lastInsertId}");
				$this->execute();
				
				unset($_SESSION["carrinho_de_compras"]);
				echo json_encode(
					array(
						"status"	=> "success",
						"pedido_id"	=> $lastInsertId
					)
				);
			}
		}
	}
		
	public function salvar_favoritos($post)
	{
		if(isset($post["accao"]) && !empty($post["accao"]) && $post["accao"] == "salvar_favoritos")
		{	
			$data = date("Y-m-d");
			$this->query(
				"INSERT INTO favoritos 
					(
						`cliente_id`, 
						`nome`, 
						`data_registo`, 
						`data_alterado`, 
						`total`
					)
				VALUES
					(
						:cliente_id,
						:nome,
						:data_registo,
						:data_alterado,
						:total
					)
				"
			);
			
			// $ordem = $this->retorna_ordem_do_pedido();
			
			$this->bind(":cliente_id", 			$_SESSION["cliente"]["id"]);
			$this->bind(":nome", 				$post["nome"]);
			$this->bind(":data_registo", 		$data);
			$this->bind(":data_alterado", 		$data);
			$this->bind(":total", 				$post["total"]);	
			
			$this->execute();
			
			$lastInsertId = $this->lastInsertId();
			
			if($lastInsertId)
			{
				$this->query(
					"INSERT INTO favorito_detalhes 
						(
							favorito_id, 
							produto_id, 
							nome, 
							preco, 
							quantidade
						)
						VALUES
						(
							:favorito_id, 
							:produto_id, 
							:nome, 
							:preco, 
							:quantidade
						)
					"
				);
				
				foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
				{
					$this->bind(":favorito_id",		$lastInsertId);
					$this->bind(":produto_id",		$valores["produto_id"]);
					$this->bind(":nome",			$valores["produto_nome"]);
					$this->bind(":preco",			$valores["produto_preco"]);
					$this->bind(":quantidade",		$valores["produto_quantidade"]);
					$this->execute();
				}
				
				echo json_encode(
					array(
						"status"		=> "success",
						"favorito_id"	=> $lastInsertId
					)
				);
			}
		}
	}
}
	