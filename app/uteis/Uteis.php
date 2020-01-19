<?php 

class Uteis extends Model
{
	public function recuperaNomeCategoriaPorId($id)
	{
		$this->query('SELECT nome FROM categorias WHERE id = "'.$id.'"');
		$this->execute();
		return $this->single();
	}
	
	public static function setUri($string){
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';	
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		$string = strip_tags(trim($string));
		$string = str_replace(" ","-",$string);
		$string = str_replace(array("-----","----","---","--"),"-",$string);
		return strtolower(utf8_encode($string));
	}

	//Funcao que limita numero de palavras
	public 	function limitaPalavras($string, $words = '100'){
		$string 	= strip_tags($string);
		$count		= strlen($string);			
		if($count <= $words){
			return $string;	
		}else{
			$strpos = strrpos(substr($string,0,$words),' ');
			return substr($string,0,$strpos).'(...)';
		}		
	}
	
	//Funcao responsavel por contar as visualizacoes dos post
	public function views($link){
		if(!isset($_SESSION['imovel_manage_user'])){	
			$this->query("SELECT * FROM imoveis WHERE link = :link");
			$this->bind(':link',$link);
			$resultado = $this->single();
			if($resultado):
				$views = $resultado['visitas'];
				$views = $views + 1;
				$this->query("UPDATE imoveis SET visitas = :visitas WHERE link = :link");
				$this->bind(':visitas',$views);
				$this->bind(':link',$link);
				$this->execute();
			endif;
		}
	}
	
	//funcao responsavel pela gestao de acesso do website
	public function gerenciaAcessos(){
		$data = date('Y-m-d');
		if(!isset($_SESSION['imovel_manage_user'])){
			$ip_address=$_SERVER['REMOTE_ADDR'];
			$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
			if($geopluginURL):
				@$addrDetailsArr = unserialize(file_get_contents($geopluginURL)); 
				$city = $addrDetailsArr['geoplugin_city']; 
				$country = $addrDetailsArr['geoplugin_countryName'];			
				if($country){
					$this->query("INSERT INTO siteviewinfo (pais,dispositivo,ip) VALUES (:pais,:cidade,:navegador,:ip)");
					$this->bind(':pais',$country);	
					$this->bind(':dispositivo',"");	
					$this->bind(':ip',$ip_address);	
					$this->execute();
				}
			endif;
			
			$this->query("SELECT * FROM siteviews WHERE data = :data");
			$this->bind(':data',$data);
			$resultadoQuery = $this->single();		
			if(!$resultadoQuery){
				$this->query("INSERT INTO siteviews (data,usuarios,visitas,pageviews) VALUES (:data,:usuarios,:visitas,:pageviews)");
				$this->bind(':data',$data);
				$this->bind(':usuarios',1);
				$this->bind(':visitas',1);
				$this->bind(':pageviews',1);				
				$this->execute();
			}else{
				$this->query("SELECT * FROM siteviews WHERE data = :data");
				$this->bind(':data',$data);
				$this->execute();
				$resultado = $this->single();
				
				//Actualiza page views
				$pageviews = $resultado['pageviews'] + 1;
				$this->query("UPDATE siteviews SET pageviews = :pageviews WHERE data = :data");
				$this->bind(':pageviews',$pageviews);
				$this->bind(':data',$data);					
				$this->execute();
				
				//Actualiza visitas				
				if(empty($_SESSION['viewUserOnline']['id'])){
					$_SESSION['viewUserOnline']['id']		= session_id();
					$_SESSION['viewUserOnline']['time'] 	= time() + 1200;					
					$visitas = $resultado['visitas'] + 1;			
					$this->query("UPDATE siteviews SET visitas = :visitas WHERE data = :data");
					$this->bind(':visitas',$visitas);
					$this->bind(':data',$data);					
					$this->execute();
				}elseif($_SESSION['viewUserOnline']['time'] < time()){
					unset($_SESSION['viewUserOnline']);
				}else{
					$_SESSION['viewUserOnline']['time'] 	= time() + 1200;
				}//Finaliza gestor de visitas
				//Actualiza usuarios
				if(empty($_COOKIE['viewUser'])){					
					setcookie("viewUser",time(), time()+84600);
					$usuarios = $resultado['usuarios'] + 1;			
					$this->query("UPDATE siteviews SET usuarios = :usuarios WHERE data = :data");
					$this->bind(':usuarios',$usuarios);
					$this->bind(':data',$data);					
					$this->execute();
				}//finaliza gestor de usuarios
				
			}//finaliza gestor de acesso no site
		}
	}
	
}