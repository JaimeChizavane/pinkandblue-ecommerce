<?php 
class SobreModel extends Model
{
	public function instituicao()
	{
		$this->query('SELECT * FROM instituicao');
		$this->execute();
		return $this->single();
	}

}
	