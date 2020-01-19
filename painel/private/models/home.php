<?php
class HomeModel extends Model{
	public function index()
	{
		$this->query('SELECT * FROM mensagem ORDER BY id DESC');
		$this->execute();
		$rows = $this->resultSet();
		return $rows;
	}
}