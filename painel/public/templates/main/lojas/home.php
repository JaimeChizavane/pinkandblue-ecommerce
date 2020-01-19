<?php include_once "header.php";?>
	
	<div class="dev-content dev-container" style="max-width:1170px;">
		<style>		
			.mySlides {display:none;max-height:380px}
			.fade { -webkit-animation-name: fade; -webkit-animation-duration: 1.5s;  animation-name: fade;		  animation-duration: 1.5s;	}@-webkit-keyframes fade { from {opacity: .4} to {opacity: 1}}
			@keyframes fade {from {opacity: .4} to {opacity: 1}	}.dev-left, .dev-right, .dev-badge {cursor:pointer}
			.categoria_activa{color: #fff;background-color: #e70291;}
		</style>
		<div class="dev-padding-24">	
			<div class="dev-display-container" id="slideContainer" style="width:100%">
				<?php foreach($data["lista_banners"] as $banners):?>
					<img class="mySlides fade" src="<?php echo ROOT_URL?>tim.php?src=<?php echo ROOT_URL?>private/uploads/banners/<?php echo $banners["foto"]?>&w=1138&h=380">
				<?php endforeach;?>
				<div class="dev-large dev-text-white dev-display-middle" style="width:100%">
					<div class="dev-btn-floating dev-flat-alizarin dev-display-left" id="prevSlide">&#10094;</div>
					<div class="dev-btn-floating dev-flat-alizarin dev-display-right" id="nextSlide">&#10095;</div>
				</div>
			</div>
		</div>
		
		<script>
			let slideIndex 	= 1;
			let nextSlide	= document.getElementById("nextSlide");
			let prevSlide	= document.getElementById("prevSlide");
			let autoSlide, slideDuration = 6000, slideContainer = document.getElementById("slideContainer");
			
			showDivs(slideIndex);
			
			nextSlide.onclick = function()
			{				
				showDivs(slideIndex += 1);
				clearInterval(autoSlide);
			}
			
			prevSlide.onclick = function()
			{				
				showDivs(slideIndex += -1);
				clearInterval(autoSlide);
			}
			
			slideContainer.onmouseover = function()
			{
				clearInterval(autoSlide);
			}
			
			slideContainer.onmouseout = function()
			{
				autoSlide = setTimeout(function()
				{
					showDivs(slideIndex += 1);
				}, slideDuration);
			}			
			
			function showDivs(n) 
			{
				var i;
				var x = document.getElementsByClassName("mySlides");
				if (n > x.length) {slideIndex = 1}    
					if (n < 1) {slideIndex = x.length} ;
					for (i = 0; i < x.length; i++) 
					{
					 x[i].style.display = "none";  
					}
				x[slideIndex-1].style.display = "block";  
				autoSlide = setTimeout(function()
				{
					showDivs(slideIndex += 1);
				}, slideDuration);
			}
		</script>		
	</div>

	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<div class="dev-row-padding" style="margin-left:-8px;margin-right:-8px">
				<nav class="dev-nav-wrapper">
					<ul class="dev-navbar">
						<?php $i = 1; foreach($data["lista_categorias"] as $categorias):?>
							<li class="dev-display-container">
								<a class="dev-padding-16 j_categoria <?php if($i == 1) echo "
								categoria_activa"?>" href="javascript:void(0)" data-categoria_id="<?php echo $categorias["id"]?>">
									<?php echo $categorias["nome"]?>
								</a>
								<span class="dev-badge dev-display-topright dev-flat-alizarin">
									<?php echo $categorias["total"]?>
								</span>
							</li>
						<?php $i++; endforeach;?>
					</ul>
				</nav>
			</div>
			<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="margin-right:-16px;margin-left:-16px;z-index:1!important;">
				
			</div>
			<div class="dev-center j_mais_produtos">
				
			</div>
		</div>
	</div>
<style>
	@media screen and (max-width: 601px)
	{
		.dev-navbar li{float:left}
		.dev-navbar div.dev-right,
		.dev-navbar li.dev-right{float:left !important;}
	}
	.nav__dropdown-wrapper
	{
		float:right!important;
	}
	.dev-navbar li a:hover {
		color: #fff!important;
		background-color: #e70291!important;
	}
</style>
<link rel="stylesheet" href="<?php echo TEMPLATE_PATH?>lojas/css/priority-nav-core.css">
<link rel="stylesheet" href="<?php echo TEMPLATE_PATH?>lojas/css/main.css">
<!--[if lte IE 9]>
<script src="<?php echo TEMPLATE_PATH?>lojas/js/classList.js"></script>
<script src="<?php echo TEMPLATE_PATH?>lojas/js/html5shiv.min.js"></script>
<![endif]-->
<script src="<?php echo TEMPLATE_PATH?>lojas/js/priority-nav.js"></script>	
<script>
$(document).ready(function()
{		
	var nav2 = priorityNav.init({
		mainNavWrapper: ".dev-nav-wrapper", // mainnav wrapper selector (must be direct parent from mainNav)
		mainNav: ".dev-navbar", // mainnav selector. (must be inline-block)
		navDropdownLabel: 'Mais categorias <i class="fa fa-navicon"></i>',
		navDropdownClassName: "nav__dropdown", // class used for the dropdown.
		navDropdownBreakpointLabel: 'Mais categorias <i class="fa fa-navicon"></i>',//button label for navDropdownToggle when the breakPoint is reached.
		navDropdownToggleClassName: "nav__dropdown-toggle", // class used for the dropdown toggle.
		count: true
	});
	
	$(document).on("click",".j_adicionar_no_carrinho",function()
	{
		var $this 			= $(this);
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
	
	retorna_lista_produtos_por_categoria();
	
	$(".j_categoria").click(function()
	{
		$(".j_categoria").removeClass("categoria_activa");
		$(this).addClass("categoria_activa");
		retorna_lista_produtos_por_categoria();
	});
	
	
	function retorna_lista_produtos_por_categoria()
	{
		let mais_produtos_btn 	= 	$(".j_mais_produtos");
		let categoria_activa 	= 	$(".categoria_activa");
		let lista_produtos		=	$("#lista_produtos_por_categoria");
		$.ajax({
			url 		: "<?php echo ROOT?>home/lista_produtos_por_categoria",
			method		: "POST",
			dataType 	: "JSON",
			data 		: 
			{
				categoria_id : categoria_activa.data("categoria_id")
			},
			success: function(responseText)
			{
				if(responseText.status == "success")
				{
					lista_produtos.empty().html(responseText.result);
					mais_produtos_btn.empty();
					if(responseText.total > 0)
					{
						mais_produtos_btn.html(responseText.mais_produtos_btn);
						lazy();
					}				
				}				
			},
			complete : function()
			{
				
			},
			beforeSend : function()
			{
				lista_produtos.empty().html('<div class="dev-center"><img src="<?php echo ROOT_URL?>private/uploads/preloader.gif"></div>');
			}
		});
	}

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
});
</script>	
<?php include_once "footer.php";?>	