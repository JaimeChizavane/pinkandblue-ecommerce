<?php 

class Carrinho extends Controller
{	
	public function index($link = "")
	{
		$model 							=   $this->model('DataModel');		
		
		$data = array(
			'lista_recentes'			=>	$model->list_all_result("produtos p",
											"p.*, c.nome as c_nome, c.link as c_link",
											" INNER JOIN categorias c ON c.id = p.categoria_id WHERE p.status = 1 ORDER BY p.data_alterado ASC LIMIT 12"),
			'lista_categorias' 			=> 	$model->list_all_result(
				"categorias c",
				"c.nome, c.id, c.link, c.foto,count(p.categoria_id) as total",
				" LEFT OUTER JOIN produtos p ON p.categoria_id = c.id WHERE c.status = 1 AND c.tipo IN('produto') GROUP BY c.id ASC"
			)
		);
		$this->returnView('lojas/carrinho',$data,false, "/lojas/");
	}

	public function adicionar()
	{	
		if(isset($_SESSION["carrinho_de_compras"]))
		{
			$disponivel = 0;
			foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
			{
				if($_SESSION["carrinho_de_compras"][$chaves]["produto_id"] == $_POST["produto_id"])
				{
					$disponivel = $disponivel + 1;
					$_SESSION["carrinho_de_compras"][$chaves]["produto_quantidade"] = $_SESSION["carrinho_de_compras"][$chaves]["produto_quantidade"] + $_POST["produto_quantidade"];		
				}						
			}
			if($disponivel < 1)
			{
				$item_array = array(
					"produto_id" 			=> $_POST["produto_id"],
					"produto_nome" 			=> $_POST["produto_nome"],
					"produto_quantidade" 	=> $_POST["produto_quantidade"],
					"produto_preco"			=> $_POST["produto_preco"],
					"produto_moeda"			=> $_POST["produto_moeda"],
					"produto_foto" 			=> $_POST["produto_foto"]
				);
				$_SESSION["carrinho_de_compras"][] = $item_array;
			}
		}else
		{
			$item_array = array(
				"produto_id" 			=> $_POST["produto_id"],
				"produto_nome" 			=> $_POST["produto_nome"],
				"produto_quantidade" 	=> $_POST["produto_quantidade"],
				"produto_preco"			=> $_POST["produto_preco"],
				"produto_moeda"			=> $_POST["produto_moeda"],
				"produto_foto" 			=> $_POST["produto_foto"]
			);
			$_SESSION["carrinho_de_compras"][] = $item_array;
		}	
		$this->lista_de_compras();		
	}

	public function actualizar()
	{
		if(!empty($_SESSION["carrinho_de_compras"]))
		{
			foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
			{
				if($_SESSION["carrinho_de_compras"][$chaves]["produto_id"] == $_POST["produto_id"])
				{
					$_SESSION["carrinho_de_compras"][$chaves]["produto_quantidade"] = $_POST["produto_quantidade"];
				}
			}			
		}
		$this->lista_de_compras();
	}
	
	public function remover()
	{
		if(!empty($_SESSION["carrinho_de_compras"]))
		{
			foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
			{
				if($_SESSION["carrinho_de_compras"][$chaves]["produto_id"] == $_POST["produto_id"])
				{
					unset($_SESSION["carrinho_de_compras"][$chaves]);
				}
			}			
		}
		$this->lista_de_compras();
	}
	
	public function lista_de_compras()
	{
		$total 		= 0;
		$output 	= "";
		$output .= '<table class="dev-table dev-bordered dev-medium" id="tabela_lista_produtos_adicionados">
						<thead>
							<tr>
								<th width="40%" onclick="sortTable(0)" style="cursor:pointer">Produto</th>
								<th width="20%" class="dev-right-align">Preço</th>
								<th width="15%" class="dev-right-align">Quantidade</th>
								<th width="20%" class="dev-right-align">Total</th>
								<th width="5%">&nbsp;</th>
							</tr>
						</thead>';
		if(!empty($_SESSION["carrinho_de_compras"]))
		{				
			foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores)
			{
				$output .= 
				'<tr class="dev-white">
					<td style="padding-left:0">
						<img src="'.ROOT_URL.'private/uploads/produtos/'.$valores["produto_foto"].'" class="dev-img dev-left dev-margin-right dev-round-large dev-border dev-padding" style="width:80px;">
						<p>'.$valores["produto_nome"].'</p>
					</td>
					<td class="dev-right-align">
						'.$valores["produto_moeda"].' '.number_format($valores["produto_preco"],2).'
					</td>
					<td><input type="number" class="dev-input dev-border dev-round-large dev-center  j_actualiza_quantidade_item_no_carrinho" data-produto_id="'.$valores["produto_id"].'" value="'.$valores["produto_quantidade"].'"></td>
					<td class="dev-right-align">
						'.$valores["produto_moeda"].' '.number_format($valores["produto_quantidade"] * $valores["produto_preco"],2) .'
					</td>
					<td><a href="javascript:void(0)" data-produto_id="'.$valores["produto_id"].'" class="dev-btn dev-flat-alizarin dev-round-large j_remove_item_do_carrinho"><i class="fa fa-trash"></i></a></td>
				</tr>';
				$total = $total + $valores["produto_quantidade"] * $valores["produto_preco"];
			}
			$output .= '<tr class="dev-white">
							<td colspan="3" class="dev-right-align">Total</td>
							<td colspan="2" class="dev-right-align">'.$valores["produto_moeda"].' '.number_format($total,2).'</td>
						</tr>';
		}
		$output .= '</table>';
		$disabled = (empty($_SESSION["carrinho_de_compras"])) ? " disabled " : "";
		$output .= '<div class="dev-margin-top">
						<div class="dev-btn-group dev-center">
							<button data-href="'.ROOT.'cliente/favoritos" '.$disabled.' class="dev-btn dev-large dev-round-large dev-margin-right dev-flat-alizarin j_adiciona_favoritos"><i class="fa fa-star dev-margin-right"></i>Favoritos</button>
							<button data-href="'.ROOT.'cliente/pagamentos" '.$disabled.' class="dev-btn dev-large dev-round-large dev-flat-alizarin j_finalizar"><i class="fa fa-credit-card dev-margin-right"></i>Finalizar</button>
						</div>
					</div>';
		echo json_encode(
			array(
				"lista_de_compras" 			=> $output,
				"total_no_carrinho" 		=> $total,
				"total_items"				=> count($_SESSION["carrinho_de_compras"])
			)
		);
	}
	
}