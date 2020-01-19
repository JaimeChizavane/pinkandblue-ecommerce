<?php
class UserModel extends Model{
	
	public function Index(){
		$this->query("DELETE FROM usuarios WHERE nome is null AND email is null");
		$this->execute();
		$this->query('SELECT * FROM usuarios ORDER BY id DESC');
		$rows = $this->resultSet();
		return $rows;
	}
		
	
	public function login(){
		return;
	}
	public function autenticaUser()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "login")
		{
			$conectedo = (isset($post["checked"])) ? 1 : 0;
			$this->query("SELECT * FROM usuarios WHERE (email =:email AND senha_criptografada =:senha_criptografada)");
			$this->bind(":email",$post["email"]);
			$this->bind(":senha_criptografada",md5($post["senha_visivel"]));
			$this->execute();
			$row = $this->single();
			if($row)
			{
				if($row["status"] == 1)
				{
					$_SESSION["manage_user"] = $row;
					echo json_encode(array(
						"status"=>"success"					
					));
				}else{
					echo json_encode(array(
						"status"=>"inactive"					
					));
				}
				
			}else{				
				echo json_encode(array(
					"status"=>"failed"					
				));
			}
		}
	}
	
	public function novo()
	{
		$data = date("Y-m-d");
		$this->query("INSERT INTO usuarios (nome, email, contacto, senha_criptografada, senha_visivel, nivel, data_registo,data_alterado,foto) VALUES (:nome, :email, :contacto, :senha_criptografada, :senha_visivel, :nivel, :data_registo, :data_alterado, :foto)");
		
		$this->bind(":nome",				null);
		$this->bind(":email",				null);
		$this->bind(":contacto",			null);
		$this->bind(":senha_criptografada",	null);
		$this->bind(":senha_visivel",		null);
		$this->bind(":nivel",				0);
		$this->bind(":data_registo",		$data);
		$this->bind(":data_alterado",		$data);
		$this->bind(":foto",				null);
		$this->execute();	
		$lastInsertId = $this->lastInsertId();
		if($lastInsertId)
		{
			echo json_encode(array(
				"status" 		=> "success",
				"novo_usuario" 	=> $this->lastInsertId()
			));
		}		
	}
	
	public function listarUsers($post)
	{
		$uteis 				= new Uteis;
		$totalRecords       = 0;
		$where				= "";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								"usuarios.nome",
								NULL,	
								NULL,		
								NULL,		
								NULL		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " WHERE usuarios.nome LIKE '%".$post["search"]["value"]."%' ";
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
				SELECT * FROM usuarios 
				{$where}
				{$order}
				{$limit}
			"
		);
		$rows = $this->resultSet();
		$status 	= "";
		$bg 		= "";
		$nivel 		= "";
		$totalRecords 	 = count($rows);
		$data = array();
		foreach($rows as $user):
			$status = ($user["status"] == 1) ? "Activo"          : "Não Activo";
			$nivel  = ($user["nivel"] == 1)  ? "Administrador"   : "Editor";
			$bg = ($user["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$user["nome"].'</td>';
			$output[] = '<td>'.$nivel.'</td>';
			$output[] =  '<td><span class="dev-padding dev-small '.$bg.' dev-round">'.$status.'</span></td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($user["data_registo"])).'</td>';
			$output[] =  '<td>
				<a href="'.ROOT_URL.'users/salvar/'.$user["id"].'" class="dev-small dev-round dev-border dev-grey dev-padding-small dev-margin-right"><i class="fa fa-edit fa-fw fa-1x"></i></a>
				<input type="checkbox" class="dev-check delete dev-border" id="'.$user["id"].'">
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
		$this->query('SELECT * FROM usuarios');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function salvar()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d");
		if(isset($post["salvar_usuario"]))
		{
			$nivel 	= (isset($post["nivel"]) 	? $post["nivel"] 	: 2);
			$status = (isset($post["status"]) 	? $post["status"] 	: 2);
			$this->query("UPDATE usuarios SET nome =:nome, email =:email, contacto =:contacto, senha_visivel =:senha_visivel, senha_criptografada =:senha_criptografada, nivel =:nivel, status =:status, data_alterado =:data_alterado WHERE id =:id");			
			$this->bind(":nome",				$post["nome"]);
			$this->bind(":email",				$post["email"]);
			$this->bind(":contacto",			$post["contacto"]);
			$this->bind(":senha_criptografada",	md5($post["senha_visivel"]));
			$this->bind(":senha_visivel",		$post["senha_visivel"]);
			$this->bind(":nivel",				$nivel);
			$this->bind(":status",				$status);
			$this->bind(":data_alterado",		$data);
			$this->bind(":id",					$post["id"]);
			$this->execute();
			header("Location:".ROOT_URL."users");
			
		}else{
			$this->query("SELECT * FROM usuarios WHERE id = ".$_GET["id"]."");
			$this->execute();
			return $this->single();
		}
	}
	
	public function senha()
	{
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "muda_senha")
		{
			$this->query('UPDATE usuarios SET senha =:senha WHERE id =:id');
			$this->bind(":senha",$post["senha"]);
			$this->bind(":id",$_SESSION["imovel_manage_user"]["id"]);
			$this->execute();
			echo 1;
		}
	}
	
	public function newsletterSubscribe()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d");
		$output	= '';
		if(isset($post["accao"]) && $post["accao"] == "salvar_newsletter_user")
		{
			$this->query('SELECT * FROM newsletter WHERE email =:email');
			$this->bind(":email",			$post["email"]);
			$this->execute();
			if($this->single())
			{
				echo json_encode(array(
					'status' => 'failed'
				));
				return;
			}
			
			$this->query('INSERT INTO newsletter SET nome =:nome, email =:email, data_registo =:data_registo');
			$this->bind(":nome",			$post["nome"]);
			$this->bind(":email",			$post["email"]);
			$this->bind(":data_registo",	$data);
			$this->execute();
			if($this->lastInsertId())
			{				
				echo json_encode(array(
					'status' => 'success'
				));
			}
			$this->query('SELECT * FROM imoveis WHERE status = 1 ORDER BY id DESC LIMIT 4');
			$this->execute();
			$imoveisArray = $this->resultSet();	
			$email		= new Email;
				$output		.= '
				<html>
				<head>
				  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				  <title>Casa Coimbra Real State</title>  
				</head>
				<body yahoo bgcolor="#ffffff" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%!important;" >
				<table width="100%" bgcolor="#ffffff" border="0" cellpadding="10" cellspacing="0" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;" >
				<tr>
				  <td style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
					<!--[if (gte mso 9)|(IE)]>
					  <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;" >
						<tr>
						  <td style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
					<![endif]-->
					<table bgcolor="#f5f5f5" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;width:100%;max-width:600px;" >
							<tr style="background-color:#036;">
								<td valign="top" mc:edit="headerBrand" id="templateContainerHeader" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;font-size:14px;padding-top:2.429em;padding-bottom:0.929em;" >

									<p style="text-align:center;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;" >
										<img src="http://casacoimbramaputo.com/painel/private/uploads/logo-white.png" style="display:inline-block;max-width:100%;border-width:0;line-height:100%;outline-style:none;text-decoration:none;height:auto;min-height:1px;" />
									</p>

								</td>
							</tr>
							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
										<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainer" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;border-top-width:1px;border-top-style:solid;border-top-color:#e2e2e2;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;border-radius:4px 4px 0 0;background-clip:padding-box;border-spacing:0;" >
								<tr>
									<td valign="top" class="bodyContentNewsLetter" mc:edit="body_content_newsletter_02" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:0em;padding-right:3.5em;padding-left:3.5em;padding-bottom:0.714em;text-align:left;" >
									<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:10px;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >Ola Inacio Agostinho Uassir, bem vindo a</p>
									<h1 style="color:#2e2e2e;display:block;font-family:Helvetica;font-size:26px;line-height:1.385em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" ><strong>Casa Coimbra Real Estate</strong></h1>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
										<!-- BEGIN BODY // -->
										<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainerMiddle" class="brdBottomPadd-lg" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#f0f0f0;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;" >
											<tr>
												<td valign="top" class="bodyContent" mc:edit="body_content" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:3.143em;padding-right:3.5em;padding-left:3.5em;text-align:left;padding-bottom:2.286em;" >
													<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >Obrigado por se juntar a nós. Você passará a receber novidades dos nossos imoveís. </p>
													<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >Confira abaixo a lista dos imoveis mais recentes. </p>
												</td>
											</tr>
										</table>
										<!-- // END BODY -->
									</td>
							</tr>
					  <tr>
							<td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
										<!-- BEGIN BODY // -->
							<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainerMiddle" class="brdBottomPadd" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#f0f0f0;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;" >
								<tr>
									<td valign="top" class="bodyContentTwoColumn" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:3.143em;padding-right:3.5em;padding-left:3.5em;text-align:left;padding-bottom:0em;" >
										<table border="0" cellpadding="0" cellspacing="0" width="100%" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;" >

									<tr valign="top">
									  <td class="two-column" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;text-align:left;font-size:0;" >
									  ';
								foreach($imoveisArray as $value)
								{
									$output .='<table class="column" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;width:45%;max-width:100%;display:inline-block;vertical-align:top;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;margin-bottom:2.000em;padding:0 2%;" >
										  <tr>
											<td class="text" mc:edit="body_content_col1" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
											  <p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" ><img src="'.ROOT_URL.'private/uploads/imoveis/'.$value['foto'].'" style="display:block;max-width:100%;border-width:0;line-height:100%;outline-style:none;text-decoration:none;min-height:1px;height:auto;" /></p>
											  <h4 style="color:#545454;display:block;font-family:Helvetica;font-size:14px;line-height:1.571em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-left:0;text-align:left;margin-bottom:8px;" ><strong>'.$value['nome'].'</strong></h4>
											  <h4 style="color:#545454;display:block;font-family:Helvetica;font-size:14px;line-height:1.571em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-left:0;text-align:left;margin-bottom:8px;" ><a href="'.ROOT.'" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#3386e4;text-decoration:none;" >Saiba Mais</a></h4>
											</td>
										  </tr>
										</table>';
								}		
								$output	.='	
									  </td>
									</tr>

								  </table>
												</td>
											</tr>
										</table>
										<!-- // END BODY -->
									</td>
							</tr>
							<tr>
								<td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
										<!-- BEGIN BODY // -->
											<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainerMiddleBtm" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#e2e2e2;border-radius:0 0 4px 4px;background-clip:padding-box;border-spacing:0;" >
											</table>
											<!-- // END BODY -->
									</td>
							</tr>
							<tr>
								<td align="center" valign="top" id="bodyCellFooter" class="unSubContent" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:39px;padding-bottom:15px;padding-right:0;padding-left:0;width:100% !important;" >
									<table width="100%" border="0" cellpadding="0" cellspacing="0" id="templateContainerFooter" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;" >
										<tr>
											<td valign="top" width="100%" mc:edit="footer_unsubscribe" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
												<h6 style="text-align:center;margin-top:7px;display:block;font-family:Helvetica;font-style:normal;font-weight:normal;letter-spacing:normal;margin-right:0;margin-left:0;color:#a1a1a1;font-size:12px;line-height:1.5em;margin-bottom:0;" ><a href="--unsubscribe--" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#a1a1a1;text-decoration:underline;font-weight:normal;" >cancelar a subscrição</a></h6>
											</td>
										</tr>
									</table>
								</td>
							</tr>

						</table>
						<!--[if (gte mso 9)|(IE)]>
						  </td>
						</tr>
					</table>
					<![endif]-->
					</td>
				</tr>
				</table>
				</body>
			</html>';		
			$email->sendEmail($post["email"], 'atendimento@casacoimbramaputo.com', "Confirmação da Subscrição no newsletter", $output);
		}
	}
	
	public function pesquisaContacto()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d");
		$output	= '';
		if(isset($post["accao"]) && $post["accao"] == "pesquisa_contacto")
		{
			$output .= '<html>
				<head>
				  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				  <title>Casa Coimbra Real State</title>  
				</head>
				<body bgcolor="#ffffff" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%!important;" >
					<table bgcolor="#f5f5f5" class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;width:100%;max-width:600px;" >
						<tr style="background-color:#036;">
							<td valign="top" mc:edit="headerBrand" id="templateContainerHeader" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;font-size:14px;padding-top:2.429em;padding-bottom:0.929em;" >

								<p style="text-align:center;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;" >
									<img src="http://casacoimbramaputo.com/painel/private/uploads/logo-white.png" style="display:inline-block;max-width:100%;border-width:0;line-height:100%;outline-style:none;text-decoration:none;height:auto;min-height:1px;" />
								</p>

							</td>
						</tr>
						<tr>
							<td align="center" valign="top" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;" >
								<table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateContainer" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse !important;border-top-width:1px;border-top-style:solid;border-top-color:#e2e2e2;border-left-width:1px;border-left-style:solid;border-left-color:#e2e2e2;border-right-width:1px;border-right-style:solid;border-right-color:#e2e2e2;border-radius:4px 4px 0 0;background-clip:padding-box;border-spacing:0;" >
									<tr>
										<td valign="top" class="bodyContentNewsLetter" mc:edit="body_content_newsletter_02" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:0em;padding-right:3.5em;padding-left:3.5em;padding-bottom:0.714em;text-align:left;" >
										<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:10px;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >Temos um contacto de '.$post['nome'].'/'.$post['contacto'].' para,</p>
										<h1 style="color:#2e2e2e;display:block;font-family:Helvetica;font-size:26px;line-height:1.385em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:0;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" ><strong>Casa Coimbra Real Estate</strong></h1>
										</td>
									</tr>
									<tr>
										<td valign="top" class="bodyContentNewsLetter" mc:edit="body_content_newsletter_02" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:0em;padding-right:3.5em;padding-left:3.5em;padding-bottom:0.714em;text-align:left;" >
										<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:16px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:10px;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >'.$post['mensagem'].'</p>
										</td>
									</tr>
									<tr>
										<td valign="top" class="bodyContentNewsLetter" mc:edit="body_content_newsletter_02" style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;color:#505050;font-family:Helvetica;font-size:14px;line-height:150%;padding-top:0em;padding-right:3.5em;padding-left:3.5em;padding-bottom:0.714em;text-align:left;" >
										<p style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;color:#545454;display:block;font-family:Helvetica;font-size:10px;line-height:1.500em;font-style:normal;font-weight:normal;letter-spacing:normal;margin-top:10px;margin-right:0;margin-bottom:15px;margin-left:0;text-align:left;" >Mtos Cptos</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</body>
			</html>';
			$this->query('SELECT * FROM instituicao');
			$this->execute();
			$row 		= $this->single();
			$email		= new Email;
			$email->sendEmail($row['email'], $post["email"],"Não consigui encontrar o imovel que pesquiso na Casa Coimbra Real Estate", $output);
			echo json_encode(array(
					'status' => 'success'
			));
		}
	}
	
	public function procuro()
	{
		$post 	= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$data	= date("Y-m-d H:i:s");
		$output	= '';
		if(isset($post["accao"]) && $post["accao"] == "procuro")
		{
			$categoria	 		= isset($post["categoria"]) ? $post["categoria"] : null;
			$user			 	= isset($post["user"]) ? $post["user"] : null;
			$preco_minimo 		= isset($post["preco_minimo"]) ? $post["preco_minimo"] : 0;
			$preco_maximo 		= isset($post["preco_maximo"]) ? $post["preco_maximo"] : 0;
			
			//saves the search in the db
			$this->query(
				"INSERT INTO procuras(
					nome,
					email,
					contacto,
					user,
					categoria,
					preco_minimo,
					preco_maximo,
					finalidade,
					urgencia,
					mensagem,
					data
				) 
				VALUES(
					:nome, 
					:email, 
					:contacto,
					:user,
					:categoria,
					:preco_minimo,
					:preco_maximo,
					:finalidade,
					:urgencia,							
					:mensagem, 
					:data
				)");
			$this->bind(":nome", 			$post["nome"]);
			$this->bind(":email", 			$post["email"]);
			$this->bind(":contacto", 		$post["contacto"]);
			
			$this->bind(":user", 			$user);
			
			$this->bind(":categoria",		$categoria);
			
			$this->bind(":preco_minimo", 	$preco_minimo);
			
			$this->bind(":preco_maximo", 	$preco_maximo);
			
			$this->bind(":finalidade", 		$post["finalidade"]);
			$this->bind(":urgencia", 		$post["urgencia"]);
			$this->bind(":mensagem", 		$post["mensagem"]);
			$this->bind(":data", 			$data);
			
			$this->execute();
			//var_dump($post);
			
			$lastInsertId = $this->lastInsertId();
			$this->query("UPDATE procuras SET codigo =:codigo WHERE id =:id");
			$this->bind(":codigo", 	str_pad($lastInsertId,5,"0",STR_PAD_LEFT));
			$this->bind(":id", 		$lastInsertId);
			$this->execute();		
			
			$output .= '<html>
			<head>
			<meta name="viewport" content="width=device-width"/>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>Casa Coimbra Maputo | Real State</title>
			</head>
			 
			<body bgcolor="#FFFFFF" style="margin: 0;padding: 0;font-family: Helvetica, Arial, sans-serif;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;width: 100% !important;height: 100%">
			<!-- HEADER -->
			<table bgcolor="#2980b9" style="width:100%!important">
				<tr>
					<td style="margin: 0 auto !important;padding: 0;max-width: 600px !important;">	
						<div style="margin: 0 auto;padding: 15px;">
							<table bgcolor="" style="margin: 0;padding: 0;width: 100%">
								<tr>
									<td style="margin: 0 auto !important;display:block!important;max-width:600px"><img src="http://casacoimbramaputo.com/painel/private/uploads/logo-white.png" style="max-width: 100%;display:block;margin:auto;"/></td>
								</tr>
							</table>
						</div>				
					</td>
				</tr>
			</table><!-- /HEADER -->
			<!-- BODY -->
			<table class="body-wrap" style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;width: 100%">
				<tr>
					<td bgcolor="#FFFFFF" style="margin: 0 auto !important;padding: 0;display: block !important;max-width: 600px !important;">
						<div style="margin: 0 auto;padding: 15px;font-family:Helvetica, Arial, sans-serif;max-width: 600px;">
						<table style="margin: 0;padding: 0;width: 100%">
							<tr>
								<td>
									<h3 style="margin: 0;padding: 0;font-family: HelveticaNeue-Light, Helvetica Neue Light, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;line-height: 1.1;margin-bottom: 15px;color: #000;font-weight: 500;font-size: 27px">Viva, Casa Coimbra Maputo</h3>
									<p style="margin: 0;padding: 15px;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;background-color: #ECF8FF;margin-bottom: 15px;font-weight: normal;font-size: 20px;line-height: 1.6">							
										Temos uma nova publicação para o forúm.<a href="'.ROOT.'painel" style="margin: 0;padding: 0;font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif;color: #2BA6CB;font-weight: bold">Clique para validar! »</a><br />
										<em>Este link o leva a pagina de validação das publicações para o forúm, onde poderá validar as mensagens antes de serem publicadas.</em><br />
										<em>As publicações enviadas para forúm estarão disponiveis após sua validação.</em><br />
										<em>As publicações poderão ser activadas no painel de gestão de conteudos da pagina.</em>
										<p style="font-size:14px">
										Esta notificação é privada, deve ser gerida apenás pelo administrador do website.</p>
									</p><!-- /Callout Panel -->							
								</td>
							</tr>
						</table>
						</div><!-- /content -->											
					</td>
				</tr>
			</table><!-- /BODY -->
			</body>
			</html>';
			$this->query('SELECT * FROM instituicao');
			$this->execute();
			$row 		= $this->single();
			$email		= new Email;
			$email->sendEmail($row['email'], "atendimento@casacoimbramaputo.com","Nova publicação para o forúm", $output);
			if($lastInsertId)
			{
				echo json_encode(array(
					'status' => 'success'
				));				
			}else
			{
				echo json_encode(array(
					'status' => 'false'
				));	
			}
		}
	}	
	
	public function removerUsers($post)
	{
		$id		= implode(", ",$post["id"]);
		$this->query("DELETE FROM usuarios WHERE id IN({$id})");
		$this->execute();
		echo json_encode(array(
			"status"	=> true
		));
	}
	
	public function logout()
	{
		unset($_SESSION["manage_user"]);
		header("Location:".ROOT_URL);
	}
}