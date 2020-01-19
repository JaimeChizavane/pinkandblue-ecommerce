<?php
class ForumModel extends Model
{	
	public function Index()
	{
		$this->query('SELECT * FROM procuras ORDER BY data DESC');
		$rows = $this->resultSet();
		return $rows;
	}
	
	public function listarForum($post)
	{
		$uteis = new Uteis;
		$totalRecords       = 0;
		$filteredRecords    = 0;
		$hospedagens_color  = "";
		$where				= "";
		$order              = "ORDER BY data DESC";
		$limit              = "";
		$order_array        = array(
								"p.nome",
								NULL,								
								NULL,	
								"p.codigo",
								NULL,								
								"p.urgencia",	
								NULL,		
								"p.data",		
							);
		if(isset($post["search"]["value"]) && !empty($post["search"]["value"]))
		{
			$where .= " WHERE p.nome LIKE '%".$post["search"]["value"]."%' ";
			$where .= " OR p.codigo =".$post["search"]["value"]." ";
			$where .= " OR p.contacto =".$post["search"]["value"]." ";
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
				SELECT p.codigo,
					p.id,
					p.nome,
					p.email,
					p.contacto,
					p.mensagem,
					p.preco_minimo,
					p.preco_maximo,
					p.finalidade,
					p.urgencia,
					p.data,
					b.nome as bairro,
					case when (p.status = 1) then 'Activo' else 'Inactivo' END as 'estado',
					c.nome as categoria FROM procuras p 
					LEFT OUTER JOIN bairros b ON b.link = p.bairro
					LEFT OUTER JOIN categorias c ON c.link = p.categoria
				{$where}
				{$order}
				{$limit}
			"
		);
		$rows = $this->resultSet();
		
		$filteredRecords = count($rows);
		$totalRecords 	 = count($rows);
		$data = array();
		foreach($rows as $procura):
			$output = array();
			$output[] = '<td>'.$procura["nome"].'</td>';
			$output[] = '<td>'.$procura["email"].'</td>';
			$output[] =  '<td>'.$procura["contacto"].'</td>';
			$output[] = '<td>'.$procura["codigo"].'</td>';
			$output[] = '<td>
				'.$procura["bairro"].', '.$procura["categoria"].'<br />
				'.number_format($procura["preco_minimo"],2).'-
				'.number_format($procura["preco_minimo"],2).'
			</td>';
			$output[] = '<td>'.$procura["urgencia"].'</td>';
			$output[] = '<td>'.$procura["estado"].'</td>';
			$output[] = '<td>'.date("d/m/Y",strtotime($procura["data"])).'</td>';
			$output[] =  '<td>
					<input type="checkbox" class="dev-check action" id="'.$procura["id"].'" value="'.$procura["id"].'">
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
		$this->query('SELECT * FROM procuras');
		$rows = $this->resultSet();
		return count($rows);
	}
	
	public function remover($post)
	{
		if(isset($post["accao"]) && $post["accao"] == "delete")
		{
			$id = implode(",",$post["id"]);
			$this->query("DELETE FROM procuras WHERE id IN({$id})");
			$this->execute();
			echo json_encode(array("status"=>true));
		}		
	}
	
	public function activar($post)
	{
		if(isset($post["accao"]) && $post["accao"] == "activar")
		{
			$id = implode(",",$post["id"]);
			$this->query("UPDATE procuras SET status = 1 WHERE id IN({$id})");
			$this->execute();
			echo json_encode(array("status"=>true));
		}		
	}
}