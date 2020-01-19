<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:100%;width:1170px">
			<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="">
				<div class="dev-col l5" id="sticky">
					<div class="dev-border-bottom">
						<h2 class="dev-xlarge dev-margin-0">Endereço de Entrega</h2>
					</div>					
					<div id="endereco_id">
						
					</div>
					<form name="formulario_endereco_de_entrega">
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Cidade</label>
								<input class="dev-input dev-border dev-round-large" name="cidade" type="text" placeholder="Informe Cidade...">
							</div>
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Codigo Postal</label>
								<input class="dev-input dev-border dev-round-large" name="codigo_postal" type="text" placeholder="Informe Codigo Postal...">
							</div>
						</div>
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-col l12">
								<label class="dev-margin-top" style="display:block">Endereço</label>
								<input class="dev-input dev-border dev-round-large" name="endereco" type="text" placeholder="Informe Endereço...">
							</div>
						</div>
						<input type="submit" value="Adicionar" class="dev-btn dev-large dev-round-large dev-flat-alizarin dev-margin-top j_regista_endereco_de_entrega">
					</form>
					<div class="dev-border-bottom dev-margin-top">
						<h2 class="dev-xlarge dev-margin-0">Tipo de Pagamento</h2>
					</div>
					<form name="formulario_tipo_pagamentos">
						<p>
						<input class="dev-radio" type="radio" name="pagamento" id="numerario" value="numerario" checked>
						<label class="dev-validate" for="numerario"><i class="fa fa-money"></i> Numerario</label></p>

						<p>
						<input class="dev-radio" type="radio" name="pagamento" id="mpesa" value="mpesa">
						<label class="dev-validate" for="mpesa"><i class="fa fa-credit-card"></i> Mpesa</label></p>

						<p>
						<input class="dev-radio" type="radio" name="pagamento" id="paypal" value="paypal" >
						<label class="dev-validate" for="paypal"><i class="fa fa-paypal"></i> Paypal</label></p>
						
						<input type="submit" value="Continuar" class="dev-btn dev-large dev-round-large dev-flat-alizarin dev-margin-top j_finaliza_pagamento" <?php if(empty($_SESSION["carrinho_de_compras"])) echo " disabled ";?>>
					</form>
				</div>
				<div class="dev-col l7 dev-right" id="main-content">
					<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
						<div class="dev-col l12">
							<div class="dev-border-bottom">
								<h2 class="dev-xlarge dev-margin-0" style="">Dados do Cliente</h2>
							</div>
							<ul class="dev-ul dev-margin-bottom">
								<li class="dev-padding-0 dev-padding-top dev-padding-bottom"><span class="margin-right"><b>Nome:</b></span> <?php echo $_SESSION["cliente"]["nome"]?></li>
								<li class="dev-padding-0 dev-padding-top dev-padding-bottom"><span class="margin-right"><b>Apelido:</b></span> <?php echo $_SESSION["cliente"]["apelido"]?></li>
								<li class="dev-padding-0 dev-padding-top dev-padding-bottom"><span class="margin-right"><b>Email:</b></span> <?php echo $_SESSION["cliente"]["email"]?></li>
								<li class="dev-padding-0 dev-padding-top dev-padding-bottom"><span class="margin-right"><b>Contacto:</b></span> <?php echo $_SESSION["cliente"]["contacto"]?></li>
							</ul>
							<div class="dev-responsive">
								<table class="dev-table dev-bordered dev-medium" id="">
									<thead>
										<tr>
											<th width="45%" style="cursor:pointer;padding-left:0;">Produto</th>
											<th width="20%" class="dev-right-align" style="padding-left:0;">Preço</th>
											<th width="15%" class="dev-right-align" style="padding-left:0;">Quantidade</th>
											<th width="20%" class="dev-right-align" style="padding-left:0;">Total</th>
										</tr>
									</thead>
									<?php 
										if(!empty($_SESSION["carrinho_de_compras"])):
										$total = 0;
									?>
										<?php foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores):?>
											<tr class="dev-white">
												<td style="padding-left:0">
													<img src="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $valores["produto_foto"]?>" class="dev-img dev-left dev-margin-right dev-round-large dev-border dev-padding dev-lazy" style="width:80px;">
													<p><?php echo $valores["produto_nome"]?></p>
												</td>
												<td class="dev-right-align">
													<?php echo $valores["produto_moeda"]." ". number_format($valores["produto_preco"],2)?>
												</td>
												<td class="dev-right-align"><?php echo $valores["produto_quantidade"]?></td>
												<td class="dev-right-align">
													<?php echo $valores["produto_moeda"]." ".number_format($valores["produto_quantidade"] * $valores["produto_preco"],2) ?>
												</td>
											</tr>
											<?php 
												$total = $total + $valores["produto_quantidade"] * $valores["produto_preco"];
											?>
										<?php endforeach;?>
										<tr class="dev-white">
											<td colspan="2" class="dev-right-align">Total</td>
											<td colspan="2" class="dev-right-align" id="total" data-total="<?php echo $total?>"><?php echo  $valores["produto_moeda"]." ".number_format($total,2)?></td>
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
	<div id="limiteSticky" class="dev-padding-24">
		
	</div>
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script>
$(document).ready(function()
{
	$(document).on("click",".j_adicionar_no_carrinho",function()
	{
		var $this = $(this);
		$.ajax({
			url 		: "<?php echo ROOT?>carrinho/adicionar",
			method		: "POST",
			dataType 	: "JSON",
			data 		: 
			{
				produto_id 			: $this.data("produto_id"),
				produto_nome 		: $this.data("nome"),
				produto_preco 		: $this.data("preco"),
				produto_moeda 		: $this.data("moeda"),
				produto_quantidade 	: $this.data("quantidade"),
				produto_foto 		: $this.data("foto"),
				accao				: "adicionar"
			},
			complete				: function()
			{
											
			},
			success 				: function(responseText)
			{
				$this.prop("disabled",false);
				$this.siblings(".j_adiciona_no_carrinho")
				.find(".dev-tooltip-content")
				.html('<i class="fa fa-check" style="font-size:30px"></i><p class="dev-margin-0">Adicionado...</p>')
				.css({
						"visibility"	: "hidden",
						"opacity"		: 0
				});
				
				$(".total_items").empty().html(responseText.total_items);
				$("#lista_de_compras").empty().html(responseText.lista_de_compras);
			},
			beforeSend 				: function()
			{
				$this.prop("disabled",true);
				$this.siblings(".j_adiciona_no_carrinho")
				.find(".dev-tooltip-content")
				.html('<i class="fa fa-spinner dev-spin"style="font-size:30px"></i><p class="dev-margin-0">Adicionando no carrinho...</p>')
				.css({
					"visibility"	: "visible",
					"opacity"		: 1
				});
			}
		});
	});
	
	$(document).on("keyup change",".j_actualiza_quantidade_item_no_carrinho",function()
	{
		var quantidade = $(this).val();
		if(quantidade > 0)
		{
			$.ajax({
				url 		: "<?php echo ROOT?>carrinho/actualizar",
				method 		: "POST",
				dataType 	: "JSON",
				data 		:
				{
					produto_id 			: $(this).data("produto_id"),
					produto_quantidade 	: quantidade,
					accao				: "actualizar"
				},
				success 	: function(responseText)
				{
					$("#lista_de_compras").empty().html(responseText.lista_de_compras);
				},
				beforeSend 	: function()
				{
					
				}
			});
		}		
	});
	
	$(document).on("click",".j_remove_item_do_carrinho",function()
	{
		$.ajax({
			url 		: "<?php echo ROOT?>carrinho/remover",
			method 		: "POST",
			dataType 	: "JSON",
			data 		:
			{
				produto_id 	: $(this).data("produto_id"),
				accao		: "remover"
			},
			success 	: function(responseText)
			{
				$(".total_items").empty().html(responseText.total_items);
				$("#lista_de_compras").empty().html(responseText.lista_de_compras);
			},
			beforeSend 	: function()
			{
				
			}
		});
	});
	
	$('.j_regista_endereco_de_entrega').click(function(){
		var $this = $(this);
		$('form[name="formulario_endereco_de_entrega"]').one('submit',function(){
			var dados = $(this).serialize()+'&accao=endereco_de_entrega';
			$.ajax({
				url 		: '<?php echo ROOT?>cliente/endereco_de_entrega',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$this.prop("disabled",false);
						$this.val("Salvar");
						retorna_enderecos_relacionados();
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$this.val("Por favor aguarde...");
					$this.prop("disabled",true);
				}
			});
			return false;
		});
	});
	
	retorna_enderecos_relacionados();
	
	function retorna_enderecos_relacionados()
	{
		$.ajax({
			url 		: '<?php echo ROOT?>cliente/retorna_enderecos_relacionados',
			method 		: 'POST',
			dataType 	: "JSON",
			data   		: {},
			cache  		: false,
			success 	: function(responseText){
				//caso retorno verdadeiro
				if(responseText.status == "success" ){
					$("#endereco_id").empty().html(responseText.result);
				}
			},
			complete : function(){
				
			},
			beforeSend : function(){
				
			}
		});
	}
	
	$('.j_finaliza_pagamento').click(function(){
		var $this = $(this);
		var endereco_id;
		
		$(".j_endereco_id").each(function(i, element)
		{
			if($(element).is(":checked"))
			{
				endereco_id = $(element).val();
			}
		});		
		
		var total = $("#total").data("total");
		
		$('form[name="formulario_tipo_pagamentos"]').one('submit',function(){
			var dados = $(this).serialize()+'&endereco_id='+endereco_id+'&total='+total+'&accao=finaliza_pagamento';
			$.ajax({
				url 		: '<?php echo ROOT?>cliente/finaliza_pagamento',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText)
				{
					//caso retorno verdadeiro
					if(responseText.status == "success" )
					{
						$(location).attr("href","<?php echo ROOT?>cliente/pedidos/id/" + responseText.pedido_id);
					}
				},
				complete : function()
				{

				},
				beforeSend : function()
				{
					$this.val("Por favor aguarde...");
					$this.prop("disabled",true);
				}
			});
			return false;
		});
	});
	
	lazy();
	function lazy()
	{
		var $lazyimages = $('.dev-lazy');			
		$lazyimages.each(function(i, img)
		{
			if(elementInViewPort(img))
			{
				$(this).attr('src',$(this).data('src'));
			}				
		});
	}		

	$(window).on('scroll',function()
	{
		lazy();
	});

	function elementInViewPort(el)
	{
		var rect = el.getBoundingClientRect();
		return (
			rect.top 	>= 0 &&
			rect.left 	>= 0 &&
			rect.bottom <= window.innerHeight &&
			rect.right 	<= window.innerWidth
		);
	}
	
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
			var limite 		= $("#limiteSticky").offset().top - stickyHeight - 15;
			var windowTop 	= $(window).scrollTop();
			
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
					"width"		: "41.66666%"
				});
			}			
			
			if(limite < windowTop)
			{
				var  diff = limite - windowTop;
				el.css({
					"top"	: diff + "px"
				});
			}
			
		});		
	}
});
</script>	
<?php include_once "footer.php";?>	