<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="margin-right:-16px;margin-left:-16px">
				<div class="dev-col l3" id="sticky">
					<h1 class="dev-large dev-padding dev-flat-alizarin dev-margin-0"><?php echo $data["lista_categoria"]["nome"]?></h1>
					<ul class="dev-border dev-ul">
						<?php foreach($data["lista_subcategorias"] as $subcategorias):?>
							<li class="dev-padding-0">
								<a class="dev-padding" style="display:block"  href="<?php echo ROOT?>categorias/<?php echo $subcategorias["c_link"]?>/<?php echo $subcategorias["link"]?>">
									<?php echo $subcategorias["nome"]?>
									<span class="dev-badge dev-right dev-flat-alizarin">
										<?php echo $subcategorias["total"]?>
									</span>
								</a>
							</li>
						<?php endforeach;?>
					</ul>
					
					<h1 class="dev-large dev-padding dev-flat-alizarin dev-margin-0 dev-margin-top">Categorias</h1>
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
						<?php 
							$output = "";
							$produto = $data["single_produto"];
						?>	
						<div class="dev-col l6 m6 s12 dev-margin-bottom">
							<div class="dev-center dev-border dev-round-large dev-display-container dev-show-hover">
								<div class="fotorama" data-width="100%" data-max-height="400" data-nav="thumbs">
									<a href="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $data["single_produto"]["foto"]?>">
										<img src="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $data["single_produto"]["foto"]?>">
									</a>
									<?php foreach($data['lista_galeria'] as $rows)
									{	
									?>
										<a href="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $rows["nome"]?>">
											<img src="<?php echo ROOT_URL?>private/uploads/produtos/<?php echo $rows["nome"]?>" class="dev-padding dev-border">
										</a>								
									<?php } ?>
								</div>		
							</div>		
						</div>
						<div class="dev-col l6 m6 s12 dev-margin-bottom">
							<h1 class="dev-text-red"><?php echo $produto["nome"]?></h1>
							<h2 class="dev-text-red"><strong><?php echo $produto["moeda"]?> <?php echo number_format($produto["preco"],2)?></strong></h2>
							<div>
								<?php echo $produto["descricao"]?>
							</div>
							<div class="dev-margin-top" style="width:auto;display:inline-block">
								<div class="dev-tooltip j_adiciona_no_carrinho">
									<div class="dev-tooltip-content dev-tooltip-top">
										<i class="fa fa-spinner dev-spin" style="font-size:30px"></i> 
										<p class="dev-margin-0">Adicionando no carrinho...</p>
									</div>
								</div>
								<button 
									data-produto_id="<?php echo $produto["id"]?>" 
									data-preco="<?php echo $produto["preco"]?>" 
									data-moeda="<?php echo $produto["moeda"]?>" 
									data-nome="<?php echo $produto["nome"]?>" 
									data-quantidade="1" 
									data-foto="<?php echo $produto["foto"]?>" 
								class="dev-btn dev-block dev-flat-alizarin dev-round-large j_adicionar_no_carrinho"><i class="fa fa-shopping-cart"></i> Adicionar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="dev-section" id="limiteSticky">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<h1 class="dev-text-red dev-center">Produtos Relacionados</h1>
			<div class="dev-row-padding">
				<?php
					foreach($data["lista_relacionados"] as $produtos):
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
			var limite = $("#limiteSticky").offset().top - stickyHeight - 15;
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
			
			
			if(limite < windowTop)
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