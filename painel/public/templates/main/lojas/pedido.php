<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
<div class="dev-section">
	<div class="dev-content dev-container" style="max-width:1170px;">
		<div class="dev-margin-bottom">
			<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> <a href="<?php echo ROOT ?>cliente/pedidos" class="dev-xlarge dev-text-red">Pedidos / </a><span class="dev-xlarge"><?php echo $data["lista_pedido"]["ordem"]?></span>
		</div>
		<div class="dev-margin-bottom">
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_print_btn">
				<i class="fa fa-print"></i> Imprimir
			</button>
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin"><i class="fa fa-envelope"></i> Enviar por email</button>
			<div class="dev-right dev-display-container">
				<input type="text" class="dev-input" value="" placeholder="Pedido Nº...">
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin dev-display-topright"><i class="fa fa-search"></i></button>
			</div>
		</div>
		<div class="dev-section" id="lista_produtos_por_categoria" >
			<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
				<div class="dev-col l3 dev-border dev-round-large" id="sticky">
					<?php include_once "cliente_menu.php";?>
				</div>
				<div class="dev-col l9 dev-right"  id="main-content">						
					<div id="pedido_container">
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-half">
								<div class="">
									<h2 class="dev-xlarge dev-margin-0 " style="">Dados do Cliente</h2>
								</div>
								<table class="dev-table dev-border dev-bordered dev-small" style="max-width:100%;width:100%;">
									<tr>
										<td width="30%" class="dev-right-align">Nome:</td>
										<td width="70%"><?php echo $_SESSION["cliente"]["nome"]?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Apelido:</td> 
										<td width="70%"><?php echo $_SESSION["cliente"]["apelido"]?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Email:</td> 
										<td width="70%"><?php echo $_SESSION["cliente"]["email"]?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Contacto:</td> 
										<td width="70%"><?php echo $_SESSION["cliente"]["contacto"]?></td>
									</tr>	
								</table>
							</div>
							<div class=" dev-half">
								<div class="">
									<h2 class="dev-xlarge dev-margin-0 " style="">Endereço de Entrega</h2>
								</div>
								<table class="dev-table dev-border dev-bordered dev-small">
									<tr>
										<td width="30%" class="dev-right-align">Cidade:</td> <td width="70%"><?php echo $data['lista_endereco']["cidade"]?></td>
									</tr>
									<tr>
										<td width="30%"  class="dev-right-align">Codigo Postal:</td> <td width="70%"><?php echo $data['lista_endereco']["codigo_postal"]?></td>
									</tr>	
									<tr>	
										<td width="30%"  class="dev-right-align">Endereço:</td> <td width="70%"><?php echo $data['lista_endereco']["endereco"]?></td>
									</tr>
								</table>
							</div>
							<div class="dev-margin-top dev-margin-bottom dev-half">
								<div class="">
									<h2 class="dev-xlarge dev-margin-0 " style="">Sumário do Pedido</h2>
								</div>
								<table class="dev-table dev-border dev-bordered dev-small">
									<tr>
										<td width="30%" class="dev-right-align">Pedido Nº:</td> 
										<td width="70%" class="dev-left-align"><?php echo $data["lista_pedido"]["ordem"]?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Total :</td> 
										<td width="70%" class="dev-left-align">Mzn <?php echo $data["lista_pedido"]["total"]?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Tipo de Pagamento:</td> 
										<td width="70%" class="dev-left-align"><?php echo ucfirst($data["lista_pedido"]["tipo_pagamento"])?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Data:</td> 
										<td width="70%" class="dev-left-align"><?php echo date("d/m/Y",strtotime($data["lista_pedido"]["data_registo"]))?></td>
									</tr>	
									<tr>	
										<td width="30%" class="dev-right-align">Estado:</td> 
										<td width="70%" class="dev-left-align"><?php if($data["lista_pedido"]["estado"]) {echo "Finalizado";} 
										else{echo "Pendente";}?></td>
									</tr>	
								</table>
							</div>							
						</div>
						<div class="dev-reponsive dev-margin-top" id="lista_de_compras">
							<table class="dev-table dev-bordered" id="">
								<thead>
									<th width="45%" onclick="sortTable(0)" class="dev-large" style="cursor:pointer;padding-left:0">Produto</th>
									<th width="20%" class="dev-right-align dev-large">Preço</th>
									<th width="15%" class="dev-right-align dev-large">Quantidade</th>
									<th width="20%" class="dev-right-align dev-large">Total</th>
								</thead>
								<?php 
									if(!empty($data["lista_pedido_destalhes"])):
									$total = 0;
								?>
									<?php foreach($data["lista_pedido_destalhes"] as $valores):?>
										<tr class="dev-white">
											<td class="dev-medium" style="cursor:pointer;padding-left:0">
												<?php echo $valores["nome"]?>
											</td>
											<td class="dev-right-align dev-medium">
												<?php echo number_format($valores["preco"],2)?>
											</td>
											<td class="dev-right-align dev-medium"><?php echo $valores["quantidade"]?></td>
											<td class="dev-right-align dev-medium">
												<?php echo number_format($valores["quantidade"] * $valores["preco"],2) ?>
											</td>
										</tr>
										<?php 
											$total = $total + $valores["quantidade"] * $valores["preco"];
										?>
									<?php endforeach;?>
									<tr class="dev-white">
										<td colspan="3" class="dev-right-align">Total</td>
										<td colspan="2" class="dev-right-align" id="total" data-total="<?php echo $total?>"><?php echo number_format($total,2)?></td>
									</tr>
								<?php endif;?>
							</table>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script src="<?php echo TEMPLATE_PATH?>lojas/js/printThis.js"></script>
<script>
$(document).ready(function()
{
	$(".j_print_btn").click(function()
	{
		$("#pedido_container").printThis({
			header : "Pedido Nº.  <?php echo $data["lista_pedido"]["ordem"]?>"
		});
	});
	if($("#sticky").length)
	{
		if($(window).innerWidth() < 990)
		{
			return false;
		}
		
		var el 				= $("#sticky");
		var stickyTop 		= el.offset().top;
		var stickyHeight 	= el.outerHeight();
		var stickyWidth 	= el.outerWidth();
		var contentHeight	= $("#main-content").outerHeight();
		
		if(contentHeight < stickyHeight)
		{
			return false;
		}
		
		$(window).scroll(function()
		{
			var limite = $("#footer").offset().top - stickyHeight - 15;
			var windowTop = $(window).scrollTop();
			
			if((stickyTop -15) < windowTop)
			{
				el.css({
					"position"	: "fixed",
					"top"		: "15px",
					"width"		: stickyWidth + "px"
				});
			}else
			{
				el.css({
					"position"	: "static",
					"width"		: "24.99999%"
				});
			}
			
			
			if((limite -15) < windowTop)
			{
				var  diff = limite - windowTop;
				console.log("limite : "+ limite+", windowTop : "+windowTop+", diff : "+ diff);
				
				el.css({
					"top"	: diff + "px"
				});
			}
			
		});		
	}
});		
</script>
	
<?php include_once "footer.php";?>	