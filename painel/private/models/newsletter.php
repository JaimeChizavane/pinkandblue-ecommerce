<?php
class NewsletterModel extends Model{
	public function index()
	{
		$this->query('SELECT * FROM newsletter ORDER BY id DESC');
		$this->execute();
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function listarnewsletters($post)
	{
		$uteis 				= new Uteis;
		$totalRecords       = 0;
		$where				= "";
		$order              = "";
		$limit              = "";
		$order_array        = array(
								"newsletter.nome",
								"newsletter.email",	
								NULL,		
								NULL		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " WHERE newsletter.nome LIKE '%".$post["search"]["value"]."%' ";
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
				SELECT * FROM newsletter 
				{$where}
				{$order}
				{$limit}
			"
		);
		$rows = $this->resultSet();
		$status = "";
		$bg = "";
		$totalRecords 	 = count($rows);
		$data = array();
		foreach($rows as $newsletter):
			$status = ($newsletter["status"] == 1) ? "Activo" : "Não Activo";
			$bg = ($newsletter["status"] == 1) ? "dev-flat-belize-hole" : "dev-flat-alizarin";
			$output = array();
			$output[] = '<td>'.$newsletter["nome"].'</td>';
			$output[] = '<td>'.$newsletter["email"].'</span></td>';
			$output[] =  '<td><span class="dev-padding dev-small '.$bg.' dev-round">'.$status.'</span></td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($newsletter["data_registo"])).'</td>';
			$output[] =  '<td><input type="checkbox" class="dev-check"></td>';
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
		$this->query('SELECT * FROM newsletter');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function remover()
	{
		$id = $_GET['id'];
		$this->query('DELETE FROM newsletter WHERE id = :id');
		$this->bind(':id',$id);
		$this->execute();
		header("location:".ROOT_URL."newsletters");
	}
}