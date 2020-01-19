<?php
class InstituicaoModel extends Model{
	public function index()
	{
		$this->query('SELECT * FROM instituicao');
		$this->execute();
		return $this->single();
	}
	
	//funcao responsavel por salvar os dados da instituicao
	public function salvar(){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post['accao']) && $post['accao'] == 'salva_instituicao'){				
			// Insert into MySQL
			$this->query('UPDATE instituicao SET quem_somos = :quem_somos, missao = :missao, visao = :visao, localizacao = :localizacao, email = :email, contacto = :contacto WHERE id = :id');			
			$this->bind(':quem_somos', 		$_POST['quem_somos']);
			$this->bind(':missao', 			$_POST['missao']);
			$this->bind(':visao', 			$_POST['visao']);
			$this->bind(':localizacao', 	$post['localizacao']);
			$this->bind(':email', 			$post['email']);
			$this->bind(':contacto', 		$post['contacto']);
			$this->bind(':id', 1);
			$this->execute();
			// Verify		
			// Redirect	
			echo json_encode(array(
				'status' => 'success'
			));
			return;
		}		
	}
	
	public function salvar_mapa()
	{
		$post 	= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
		if(isset($post["accao"]) && $post["accao"] == "salvar_mapa")
		{
			$this->query('UPDATE instituicao SET
				longitude	=:longitude,
				latitude	=:latitude
				WHERE id =:id
			');			
			$this->bind(":longitude",	$post["longitude"]);
			$this->bind(":latitude",	$post["latitude"]);
			$this->bind(":id",			1);
			$this->execute();
			echo json_encode(array(
				"status" 	=> "success"				
			));
		}
	}
	
	//funcao responsavel por salvar os dados da instituicao
	public function redes(){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post['accao']) && $post['accao'] == 'salva_instituicao_redes'){				
			// Insert into MySQL
			$this->query('UPDATE instituicao SET facebook = :facebook, google = :google, twitter =:twitter, youtube = :youtube, instagram = :instagram WHERE id = :id');			
			$this->bind(':facebook', 		$post['facebook']);
			$this->bind(':google', 			$post['google']);
			$this->bind(':youtube', 		$post['youtube']);
			$this->bind(':instagram', 		$post['instagram']);
			$this->bind(':twitter', 		$post['twitter']);
			$this->bind(':id', 				1);
			$this->execute();
			// Verify		
			// Redirect	
			echo json_encode(array(
				'status'	=> 'success'
			));
			return;
		}		
	}
	
	//funcao responsavel pelo upload da imagem
	public function uploadLogo(){
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		if(isset($post['accao']) && $post['accao'] == 'uploadLogo'){
			$imagem = '';
			$dir    = 'private/uploads/instituicao/';			
			if(!file_exists($dir)){
				mkdir($dir,0577);
			}			
			if(isset($_FILES['logo']['tmp_name']) && !empty($_FILES['logo']['tmp_name'])):
				if(file_exists($dir.$imagem) && !is_dir($dir.$imagem)){
					unlink($dir.$imagem);
				}			
				$referencia = explode(".",$_FILES['logo']['name']);
				$extensao	= end($referencia);
				$imagem 	= md5(rand(),false).".".$extensao;
				if(move_uploaded_file($_FILES['logo']['tmp_name'],$dir.$imagem)){
					$this->query('UPDATE instituicao SET logo = :logo WHERE id = :id');
					$this->bind(':logo', 		$imagem);
					$this->bind(':id', 			1);
					$this->execute();
					echo json_encode(array(
						'status'	=> 'success'
					));
				}			
			endif;
		}
		return;
	}
	
	//funcao responsavel por retornar o logotipo
	public function retornaLogo(){
		$this->query("SELECT * FROM instituicao");
		$row = $this->single();
		if($row['logo']):
			echo '<div class="dev-col s6 m6 l3 dev-display-container">';
			echo '<img class="dev-border dev-padding-small dev-round" src="tim.php?src='.ROOT_URL.'private/uploads/instituicao/'.$row['logo'].'">';
			echo '<button class="remove_icon_image dev-display-topright" data-url="'.ROOT_URL.'private/uploads/instituicao/'.$row['logo'].'" data-id="'.$row['id'].'"><i class="fa fa-times"></i></button>';
			echo '</div>';
			echo '<div style="clear:both;"></div>';
		endif;
	}
	
	
}