<?php 
class Uteis extends Model
{		
	public static function getNivel($param)
	{
		switch($param):
			case 1;
				return 'Administrador';
			break;
			
			case 2;
				return 'Editor';
			break;
			
		endswitch;
	}

	public static function setUri($string)
	{
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';	
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		$string = strip_tags(trim($string));
		$string = str_replace(" ","-",$string);
		$string = str_replace(array("-----","----","---","--"),"-",$string);
		return strtolower(utf8_encode($string));
	}
	
	public 	function limitaPalavras($string, $palavras = '100'){
		$string 	= strip_tags($string);
		$count		= strlen($string);
		
		if($count <= $palavras){
			return $string;	
		}else{
			$strpos = strrpos(substr($string,0,$palavras),' ');
			return substr($string,0,$strpos).'(...)';
		}
	
	}

	public function recuperaNomeGrupoPeloId($id)
	{
		$this->query("SELECT nome FROM grupos WHERE id =:id AND usuario_id =".$_SESSION["sms_manage_user"]["id"]."");
		$this->bind(":id",$id);
		$this->execute();
		$row = $this->single();
		return $row["nome"];
	}
	
	public function recuperaNomeClientePeloId($id)
	{
		$this->query('SELECT nome FROM usuarios WHERE id =:id');
		$this->bind(":id",$id);
		$this->execute();
		$row = $this->single();
		return $row["nome"];
	}

	public function recuperaTotal($tabela,$cond = null )
	{
		$total = 0;
		$this->query("SELECT count(id) as total_registos FROM {$tabela} {$cond}");
		$this->execute();
		$rows = $this->resultSet();
		foreach($rows as $row):
			$total = $row["total_registos"];
		endforeach;
		return $total;
	}
}
