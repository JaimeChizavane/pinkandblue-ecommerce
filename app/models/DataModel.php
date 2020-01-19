<?php 
class DataModel extends Model
{
	public function list_all_result($tabela, $col = "*", $cond = null)
	{
		$this->query('SELECT '.$col.' FROM '.$tabela.' '.$cond.' ');
		return $this->resultSet();
	}

	public function list_one_result($tabela, $col = "*", $cond = null)
	{
		$this->query('SELECT '.$col.' FROM '.$tabela.' '.$cond.' ');
		return $this->single();
	}
	
	public function get_total_result($tabela, $col = "*", $cond = null)
	{
		$this->query('SELECT '.$col.' FROM '.$tabela.' '.$cond.' ');
		return count($this->resultSet());
	}
}
	