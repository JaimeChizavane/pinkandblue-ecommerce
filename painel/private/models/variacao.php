<?php 
class VariacaoModel extends Model
{
	public function index()
	{
		$this->listaVariacoes();
	}
	
	public function listaVariacoes($cond = null)
	{
		$this->query("SELECT * FROM variacoes {$cond}");
		return $this->resultSet();
	}
	
	public function listaVariacaoAtributosProduto($idVariacao)
	{
		$this->query("SELECT * FROM variacao_atributos INNER JOIN variacoes ON variacao_atributos.variacao_id = variacoes.id WHERE variacoes.id = $idVariacao");
		return $this->resultSet();
	}
	
	public function variacaoProduto($idProduto)
	{
		$this->query("SELECT variacoes.variacao as variacao, variacoes.id as variacao_id FROM variacoes INNER JOIN produtos on variacoes.id = produtos.variacao_id WHERE produtos.id = $idProduto");
		return $this->single();
	}
	
	public function listaVariacaoAtributos($cond = null)
	{
		$this->query("SELECT * FROM variacao_atributos {$cond}");
		return $this->resultSet();
	}
	
	public function listaItemAtributos($post)
	{
		$output 		= '';
		$atributo_id 	= $post["id"];
		$this->query('SELECT * FROM variacao_atributo_item WHERE variacao_atributo_id =:atributo_id');
		$this->bind(':atributo_id',$atributo_id);
		$this->execute();
		$atributo 	 = '';
		$output 	.= '<ul class="dev-ul dev-hoverable">';
		foreach($this->resultSet() as $item)
		{
			$output.= '<li class="dev-bar" id="item_'.$item['id'].'">';
				$output.= '<div class="dev-bar-item">';
					$output.= '<b><span class="j_item_atributo_name">'.$item['item'].'</span></b>';
					$output.= '<div class="dev-small j_item_atributo_referencia">'.$item['referencia'].'</div>';
				$output.= '</div>';
				$output.= '<div class="dev-bar-item dev-right">';
					$output.= '<a href="" class="j_edita_item dev-buttom dev-padding"
					data-value="'.$item['item'].'"
					data-referencia="'.$item['referencia'].'"
					data-id="'.$item['id'].'"
					><i class="fa fa-pencil fa-2x"></i></a>';
					$output.= '<a href="" class="j_remove_atributo_item dev-buttom dev-padding"><i class="fa fa-trash fa-2x"></i></a>';
				$output.= '</div>';
			$output.= '</li>';
		}
		$output 	.= '</ul>';
		$output 	.= '<button class="dev-button dev-block dev-flat-midnight-blue j_salvar_item" data-atributo_id="'.$atributo_id.'" data-atributo="'.$atributo.'">+ Adicionar variação a este Atributo</button>';
		
		echo json_encode(
			array(
				"result"=>true,
				"new_select" => $output
			)
	   ); 
	}	
	
	public function listaItemAtributosInterfaceDetalhes($post)
	{
		$output 		= '';
		$atributo_id 	= $post["id"];
		$this->query('SELECT * FROM variacao_atributo_item WHERE variacao_atributo_id =:atributo_id');
		$this->bind(':atributo_id',$atributo_id);
		$this->execute();
		$atributo 	 = '';
		$output 	.= '<ul class="dev-ul dev-hoverable">';
		foreach($this->resultSet() as $item)
		{
			$output.= '<li class="dev-bar" id="item_'.$item['id'].'">';
				$output.= '<div class="dev-bar-item">';
					$output.= '<b><span class="j_item_atributo_name">'.$item['item'].'</span></b>';
					$output.= '<div class="dev-small j_item_atributo_referencia">'.$item['referencia'].'</div>';
				$output.= '</div>';
			$output.= '</li>';
		}
		$output 	.= '</ul>';
		
		echo json_encode(
			array(
				"result"=>true,
				"new_select" => $output
			)
	   ); 
	}	
	
	public function limpaMemoriaNoBanco()
	{
		$this->query('DELETE FROM variacoes WHERE marca is null');
		$this->execute();
	}
	
	public function recuperaMarcaPorId($id_value)
	{
		$this->query('SELECT * FROM variacoes WHERE id =:id');
		$this->bind(":id",$id_value);
		return $this->single();
	}
	
   
	public function salvarVariacao($post)
	{
		$output = '';
	   if(isset($post['accao']) && $post['accao'] == 'salvar_variacao')
	   {
			$data = date("Y-m-d");
			$this->query('INSERT INTO variacoes(variacao, estado, data_registro,data_alterado) 		VALUES(:variacao,:estado,:data_registro,:data_alterado)');
			$this->bind(":variacao",$post['variacao']);
			$this->bind(":estado", 1);
			$this->bind(":data_registro",$data);
			$this->bind(":data_alterado",$data);
			$this->execute();
			$id = $this->lastInsertId();
			$output .= '<table class="dev-table-all dev-striped dev-small">
							<thead>
								<th style="width:80%">Tipos de Variações</th>
								<th style="width:20%">&nbsp;</th>
							</thead>
						<tbody>';	
			foreach($this->listaVariacoes() as $variacoes):
				$output .= '<tr>
						<td style="width:80%">'.$variacoes['variacao'].'</td>
						<td style="width:20%">
							<a href="'.ROOT.'variacoes/gerir/id/'.$variacoes['id'].'"class="dev-button small dev-padding dev-flat-midnight-blue"><i class="fa fa-edit"></i> Editar</a>
							<a href="#"class="dev-button small dev-padding dev-flat-midnight-blue"><i class="fa fa-trash"></i> Apagar</a>
						</td>
					</tr>';
			endforeach;	
			$output	.= '</tbody>
						</table>';
		   if($id)
		   {
			   echo json_encode(
					array(
						"result"=>true,
						"new_select" => $output
					)
			   );
		   }else{
			   echo json_encode(array("result"=>false));
		   }
	   }	   
	}
	
	public function salvarVariacaoAtributo($post)
	{
		$output = '';
	   if(isset($post['accao']) && $post['accao'] == 'salvar_variacao_atributo')
	   {
			$data = date("Y-m-d");
			$this->query('INSERT INTO variacao_atributos(variacao_id, atributo) 		VALUES(:variacao_id,:atributo)');
			$this->bind(":variacao_id",$post['variacao_id']);
			$this->bind(":atributo", $post['atributo']);
			$this->execute();
			$id = $this->lastInsertId();
				foreach($this->listaVariacaoAtributos("WHERE variacao_id = ".$post['variacao_id']."") as $atributos):
					$output .= '<div class="dev-half dev-margin-top">';
						$output .= '<div class=" dev-border dev-white ">';
							$output .= '<header class="dev-bar dev-flat-midnight-blue dev-padding dev-text-white">';
								$output .= '<div class="dev-bar-item">';
									$output .= '<h4 style="margin:0" data-atributo_id="'.$atributos['id'].'">'.$atributos['atributo'].'</h4>';
									$output .= '</div>';
									$output .= '<div class="dev-bar-item dev-right">';
									$output .= '<a href="" class="j_edita dev-buttom dev-padding" data-atributo="'. $atributos['atributo'].'" data-id="'.$atributos['id'].'"><i class="fa fa-pencil fa-2x"></i></a>';
									$output .= '<a href="" class="j_remove_atributo dev-buttom dev-padding"><i class="fa fa-archive fa-2x"></i></a>';
								$output .= '</div>';
							$output .= '</header>';
							$output .= '<div class="j_variacao_atributo_list_item" id="'.$atributos['id'].'">';
							$output .= '</div>';
						$output .= '</div>';
					$output .= '</div>';
				endforeach;
		   if($id)
		   {
			   echo json_encode(
					array(
						"result"=>true,
						"new_select" => $output
					)
			   );
		   }else{
			   echo json_encode(array("result"=>false));
		   }
	   }	   
	}
	
	public function salvarItemAtributo($post)
	{
	   if(isset($post['accao']) && $post['accao'] == 'salvar_item_atributo')
	   {
			$data = date("Y-m-d");
			$this->query('INSERT INTO variacao_atributo_item(variacao_atributo_id, item, referencia) 		VALUES(:variacao_atributo_id,:item, :referencia)');
			$this->bind(":variacao_atributo_id",	$post['atributo_id']);
			$this->bind(":item", 					$post['item_nome']);
			$this->bind(":referencia", 				$post['item_referencia']);
			$this->execute();
			$id = $this->lastInsertId();
		   if($id)
		   {
			   echo json_encode(
					array(
						"result"=>true
					)
			   );
		   }else{
			   echo json_encode(array("result"=>false));
		   }
	   }	   
	}
	
	public function editarVariacao($post)
	{
		if(isset($post['accao']) && $post['accao'] == 'editar_variacao')
		{
			$data = date("Y-m-d");
			$this->query('UPDATE variacoes SET variacao =:variacao, data_alterado =:data_alterado WHERE id =:id');
			$this->bind(":variacao",$post['value']);
			$this->bind(":data_alterado",$data);
			$this->bind(":id",$post["id"]);
			$this->execute();
			echo json_encode(
				array(
					"result"=> true,
					"variacao_new_name"=> $post['value']
				)
		   );
		}	
	}
	
	public function editarAtributo($post)
	{
		if(isset($post['accao']) && $post['accao'] == 'editar_atributo')
		{
			$this->query('UPDATE variacao_atributos SET atributo =:atributo WHERE id =:id');
			$this->bind(":atributo",$post['value']);
			$this->bind(":id",$post["id"]);
			$this->execute();
			echo json_encode(
				array(
					"result"=> true,
					"atributo_new_name"=> $post['value']
				)
		   );
		}	
	}
	
	public function editarItemAtributo($post)
	{
		if(isset($post['accao']) && $post['accao'] = 'editar_item_atributo')
		{
			$this->query('UPDATE variacao_atributo_item SET item =:item, referencia =:referencia WHERE id =:id');
			$this->bind(":item",$post['value']);
			$this->bind(":referencia",$post['referencia']);
			$this->bind(":id",$post['id']);
			$this->execute();
			echo json_encode(
				array(
					"result"=> true,
					"variacao_atributo_item_new_name"=> $post['value'],
					"referencia" => $post['referencia']
				)
		   );
		}
	}
	
}
	