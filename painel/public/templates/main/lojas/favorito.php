<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
<div class="dev-section">
	<div class="dev-content dev-container" style="max-width:1170px;">
		<div class="dev-margin-bottom">
			<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> <a href="<?php echo ROOT ?>cliente/favoritos" class="dev-xlarge dev-text-red">Favoritos / </a><span class="dev-xlarge"><?php echo $data["lista_favorito"]["nome"]?></span>
		</div>
		<div class="dev-margin-bottom">
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin"><i class="fa fa-print"></i> Imprimir</button>
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin"><i class="fa fa-envelope"></i> Enviar por email</button>
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin"><i class="fa fa-shopping-cart"></i> Adicionar ao Carrinho</button>
			<div class="dev-right dev-display-container">
				<input type="text" class="dev-input" value="" placeholder="Nome do Favorito...">
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin dev-display-topright"><i class="fa fa-search"></i></button>
			</div>
		</div>
		<div class="dev-section" id="lista_produtos_por_categoria" >
			<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
				<div class="dev-col l3 dev-border dev-round-large" id="sticky">
					<?php include_once "cliente_menu.php";?>
				</div>
				<div class="dev-col l9 dev-right"  id="main-content">	
					<div class="dev-reponsive" id="lista_de_compras">
						<table class="dev-table dev-bordered dev-medium" id="tabela_lista_produtos_adicionados">
							<thead>
								<tr>
									<th width="45%" onclick="sortTable(0)" class=" dev-large" style="cursor:pointer;padding-left:0">Produto</th>
									<th width="20%" class="dev-right-align dev-large">Preço</th>
									<th width="15%" class="dev-right-align dev-large">Quantidade</th>
									<th width="20%" class="dev-right-align dev-large">Total</th>
								</tr>
							</thead>
							<?php 
								if(!empty($data["lista_favorito_detalhes"])):
								$total = 0;
							?>
								<?php foreach($data["lista_favorito_detalhes"] as $valores):?>
									<tr class="dev-white">
										<td class="dev-medium" style="cursor:pointer;padding-left:0">
											<?php echo $valores["nome"]?>
										</td>
										<td class="dev-right-align dev-medium">
											<?php echo number_format($valores["preco"],2)?>
										</td>
										<td class="dev-right-align  dev-medium"><?php echo $valores["quantidade"]?></td>
										<td class="dev-right-align  dev-medium">
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
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script>
$(document).ready(function()
{
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