<?php
class DefinicoesModel extends Model
{
	public function Index()
	{
		$this->query("DELETE FROM definicoes WHERE (provedor is null OR provedor = '') AND (api_key is null OR api_key = '')");
		$this->execute();
		$this->query('SELECT 
			definicoes.id as definicoes_id, 
			definicoes.provedor as definicoes_provedor, 
			definicoes.api_key as definicoes_api_key, 
			definicoes.sid as definicoes_sid, 
			definicoes.token as definicoes_token, 
			definicoes.status as definicoes_status,
			definicoes.usuario_id as definicoes_usuario_id,
			usuarios.id as usuarios_id,
			usuarios.usuario as usuarios_usuario,
			usuarios.email as usuarios_email,
			usuarios.senha as usuarios_senha,
			usuarios.nivel as usuarios_nivel,
			usuarios.status as usuarios_status,
			usuarios.data_registo as usuarios_data_registo,
			usuarios.data_alterado as usuarios_data_alterado	
		FROM definicoes INNER JOIN usuarios ON definicoes.id = usuarios.id WHERE usuarios.nivel = 1');
		$rows = $this->resultSet();
		return $rows;		
	}

	public function nova()
	{
		$post 		= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "criar_nova_definicao")
		{
			$this->query("INSERT INTO definicoes (provedor,api_key,sid,token,status,usuario_id) VALUES(:provedor,:api_key,:sid,:token,:status,:usuario_id)");
			$this->bind(":provedor", null);
			$this->bind(":api_key", null);
			$this->bind(":sid", null);
			$this->bind(":token", null);
			$this->bind(":status", 2);
			$this->bind(":usuario_id",$_SESSION["sms_manage_user"]["id"]);
			$this->execute();
			echo json_encode(array(
				"status"=> "success",
				"nova_definicao"=> $this->lastInsertId()
			));
		}
	}

	public function salvar()
	{
		$post 		= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["salvar_definicoes"]))
		{
			if($post["status"] == 1)
			{
				$this->query('UPDATE definicoes SET status = 2');
				$this->execute();
			}
			$this->query('UPDATE definicoes SET provedor =:provedor, api_key =:api_key, sid	=:sid, token =:token, status =:status WHERE id =:id');
			$this->bind(":provedor",$post["provedor"]);
			$this->bind(":api_key",$post["api_key"]);
			$this->bind(":sid",$post["sid"]);
			$this->bind(":token",$post["token"]);
			$this->bind(":status",$post["status"]);
			$this->bind(":id",$post["id"]);
			$this->execute();				
			Messages::setMsg("Salvo com sucesso");
			header("refresh: 1; url=".ROOT_URL."definicoes");
		}else{
			$this->query('SELECT * FROM definicoes WHERE id = '.$_GET["id"].'');
			$rows = $this->single();
			return $rows;
		}
	}
}