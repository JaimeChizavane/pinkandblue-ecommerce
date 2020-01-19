<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="margin-right:-16px;margin-left:-16px">
				<div class="dev-col l3" id="sticky">
					<h1 class="dev-large dev-padding dev-flat-alizarin dev-margin-0">Categorias</h1>
					<ul class="dev-margin-bottom dev-ul dev-border">
						<?php foreach($data["lista_categorias"] as $categorias):?>
							<li class="dev-padding-0">
								<a class="dev-padding" style="display:block" href="<?php echo ROOT?>categorias/<?php echo $categorias["link"]?>" data-categoria_id="<?php echo $categorias["id"]?>">
									<?php echo $categorias["nome"]?>
									<span class="dev-badge dev-right dev-flat-alizarin">
										<?php echo $categorias["total"]?>
									</span>
								</a>								
							</li>
						<?php endforeach;?>
					</ul>
				</div>
				<div class="dev-col l9 dev-right" id="main-content">
					<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
						<div class="dev-col l12">
							<div class="dev-responsive" id="lista_de_compras">
								<table class="dev-table dev-bordered dev-medium" id="">
									<thead>
										<th width="40%" style="cursor:pointer">Produto</th>
										<th width="20%" class="dev-right-align">Preço</th>
										<th width="15%" class="dev-right-align">Quantidade</th>
										<th width="20%" class="dev-right-align">Total</th>
										<th width="5%">&nbsp;</th>
									</thead>
									<?php 
										if(!empty($_SESSION["carrinho_de_compras"])):
										$total = 0;
									?>
										<?php foreach($_SESSION["carrinho_de_compras"] as $chaves=>$valores):?>
											<tr class="dev-white">
												<td style="padding-left:0">
													<img src="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $valores["produto_foto"]?>" class="dev-img dev-left dev-margin-right dev-round-large dev-border dev-padding" style="width:80px;">
													<p><?php echo $valores["produto_nome"]?></p>
												</td>
												<td class="dev-right-align">
													<?php echo $valores["produto_moeda"]." ". number_format($valores["produto_preco"],2)?>
												</td>
												<td><input type="number" class="dev-input dev-border dev-round-large dev-center j_actualiza_quantidade_item_no_carrinho" data-produto_id="<?php echo $valores["produto_id"]?>" value="<?php echo $valores["produto_quantidade"]?>"></td>
												<td class="dev-right-align">
													<?php echo $valores["produto_moeda"]." ".number_format($valores["produto_quantidade"] * $valores["produto_preco"],2) ?>
												</td>
												<td><a href="javascript:void(0)" data-produto_id="<?php echo $valores["produto_id"]?>" class="dev-btn dev-flat-alizarin dev-round-large j_remove_item_do_carrinho"><i class="fa fa-trash"></i></a></td>
											</tr>
											<?php 
												$total = $total + $valores["produto_quantidade"] * $valores["produto_preco"];
											?>
										<?php endforeach;?>
										<tr class="dev-white">
											<td colspan="3" class="dev-right-align">Total</td>
											<td colspan="2" class="dev-right-align" class="dev-right-align" id="total" data-total="<?php echo $total?>"><?php echo  $valores["produto_moeda"]." ".number_format($total,2)?></td>
										</tr>
									<?php endif;?>
								</table>
								<div class="dev-margin-top">
									<div class="dev-btn-group dev-center">
										<button data-href="<?php echo ROOT?>cliente/favoritos" <?php if(empty($_SESSION["carrinho_de_compras"])) echo "disabled "; ?> class="dev-btn dev-large dev-round-large dev-margin-right dev-flat-alizarin j_adiciona_favoritos"><i class="fa fa-star dev-margin-right"></i>Favoritos</button>
										<button data-href="<?php echo ROOT?>cliente/pagamentos" <?php if(empty($_SESSION["carrinho_de_compras"])) echo "disabled "; ?> class="dev-btn dev-large dev-round-large dev-flat-alizarin j_finalizar"><i class="fa fa-credit-card dev-margin-right"></i>Finalizar</button>
									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="dev-section" id="limiteSticky">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<h1 class="dev-text-red dev-center">Produtos Recentes</h1>
			<div class="dev-row-padding">
				<?php
					$output = "";
					foreach($data["lista_recentes"] as $produtos):
						$output .= 	'<div class="dev-col l2 m6 s6 dev-margin-bottom dev-display-container">';
							$output .= '<div class="bounce dev-display-topright" id="notificacao_de_adicao_no_carrinho" style="z-index:999;display:none">
								<div class="dev-display-container">
									<a href="'.ROOT.'carrinho"><img src="'. TEMPLATE_PATH.'lojas/img/icons/shopping-bag.png" style="width:40px;" class="dev-margin-right">';
									$output .= '<span class="dev-badge dev-flat-alizarin dev-display-topmiddle total_items">';					
										if(isset($_SESSION["carrinho_de_compras"]))
										{
											$output .= count($_SESSION["carrinho_de_compras"]);
										}
										else
											$output .= "0";
									$output .= '</span>
									</a>
								</div>
							</div>';
							$output .= 	'<div class="dev-center dev-border dev-round-large dev-display-container dev-show-hover">';
								$output .= 	'<a href="'.ROOT.'produto/'.$produtos["link"].'">';
									$output .= 	'<div class="dev-padding-16" style="width:150px;height:200px;margin:0 auto;line-height:200px;max-width: 100%;">';
										$output .= 	'<img src="'.ROOT_URL.'private/uploads/preloader2.gif" data-src="'.ROOT_URL.'private/uploads/produtos/'.$produtos["foto"].'" alt="" class="dev-center dev-lazy" style="width:100%;max-height:100%;">';
									$output .= 	'</div>';
								$output .= 	'</a>';
								$output .= 	'<div class="dev-container dev-center dev-padding-bottom">';			
									$output .= 	'<a href="'.ROOT.'produto/'.$produtos["link"].'">';
										$output .= 	'<h1 class="dev-small dev-margin-0"><strong>'.$produtos["nome"].'</strong></h1>';
										$output .= 	'<h2 class="dev-medium dev-margin-0 dev-text-red"><strong>'.$produtos["moeda"].' '.number_format($produtos["preco"],2).'</strong></h2>';
									$output .= 	'</a>';								
									$output .= 	'<div class="dev-margin-top">';
										$output .= 	'<div class="dev-tooltip j_adiciona_no_carrinho">
														<div class="dev-tooltip-content dev-tooltip-top">
															<i class="fa fa-spinner dev-spin" style="font-size:30px"></i> 
															<p class="dev-margin-0">Adicionando no carrinho...</p>
														</div>
													</div>';
										$output .= 	'<button
											data-produto_id="'.$produtos["id"].'" 
											data-preco="'.$produtos["preco"].'" 
											data-moeda="'.$produtos["moeda"].'" 
											data-nome="'.$produtos["nome"].'" 
											data-quantidade="1" 
											data-foto="'.$produtos["foto"].'" 
										class="dev-btn dev-block dev-flat-alizarin dev-round-large j_adicionar_no_carrinho"><i class="fa fa-shopping-cart"></i> Adicionar</button>';										
										$output .= 	'</div>';						
								$output .= ' </div>';
							$output .= 	'</div>';
						$output .= 	'</div>';
					endforeach;	
					echo $output;
				?>	
			</div>
		</div>
	</div>
	
	<div id="adiciona_favoritos" class="dev-modal">
		<div class="dev-modal-content dev-card-8 dev-animate-zoom" style="max-width:600px">
			<div class="dev-container">
				<div class="dev-margin-top">
					<label><b>Nome</b></label>
					<input class="dev-input dev-border dev-margin-bottom j_favorito" name="favorito" type="text" placeholder="Nome da lista nos favoritos" required>
				</div>
				<div class="dev-panel">
					<div class="dev-margin-top dev-margin-bottom">
						<button type="button" class="dev-btn dev-block dev-flat-alizarin dev-round-large dev-large j_salvar_favoritos"><i class="fa fa-save dev-margin-right"></i>Salvar</button>
						<button type="button" class="dev-btn dev-block dev-flat-alizarin dev-round-large dev-large j_cancela_adiciona_favoritos"><i class="fa fa-power-off dev-margin-right"></i>Cancelar</button>
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
	$(document).on("click",".j_adicionar_no_carrinho",function()
	{
		var $this = $(this);
		var $parent 		= $this.parent().parent().parent().parent();
		var $notificacao 	= $parent.find("#notificacao_de_adicao_no_carrinho");
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
				$notificacao.fadeIn("fast").delay(1000).fadeOut("fast");
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
	
	$(document).on("click",".j_finalizar",function()
	{
		$(location).attr("href",$(this).data("href"));
	});
	
	$(document).on("click",".j_adiciona_favoritos",function()
	{
		var $this = $(this);
		$.ajax({
			url 		: "<?php echo ROOT?>cliente/adicionar_favoritos",
			method 		: "POST",
			dataType 	: "JSON",
			data 		:
			{
				
			},
			success 	: function(responseText)
			{
				if(responseText.status == "sem_sessao")
				{
					$(location).attr("href","<?php echo ROOT?>cliente");
				}
				
				if(responseText.status == "sessao_iniciada")
				{
					$("#adiciona_favoritos").show();
				}
			},
			beforeSend 	: function()
			{
				$this.prop("disabled", true);
				$this.text("Por favor aguarde...");
			}
		});
	});
	
	$(document).on("click",".j_cancela_adiciona_favoritos",function()
	{
		$(".j_adiciona_favoritos").prop("disabled",false).html('<i class="fa fa-star dev-margin-right"></i>Favoritos');
		$("#adiciona_favoritos").hide();
	});
	
	$(document).on("click",".j_salvar_favoritos",function()
	{
		$(this).prop("disabled",true).text("Por favor aguarde...");
		$.post(
			"<?php echo ROOT?>cliente/salvar_favoritos",
			{
				nome	:	$(".j_favorito").val(),
				total	:	$("#total").data("total"),
				accao 	: 	"salvar_favoritos"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(".j_adiciona_favoritos").prop("disabled",false).html('<i class="fa fa-star dev-margin-right"></i>Favoritos');
					$("#adiciona_favoritos").hide();
				}					
			},"JSON"
		)
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
					"width"		: "24.99999%"
				});
			}			
			
			if((limite -15) < windowTop)
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