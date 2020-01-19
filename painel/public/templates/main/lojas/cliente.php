<?php 
	include_once "header.php";
?>
<script src="https://apis.google.com/js/platform.js" async defer></script>	
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:1170px;">
			<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="margin-right:-16px;margin-left:-16px">
				<div class="dev-col l4">
					<div class="w3-container">
						<h2>Login</h2>
					</div>
										
					<form name="formulario_login_cliente">
						<div>
							<div class="">
								<label class="dev-margin-top" style="display:block">Email</label>
								<input class="dev-input dev-border dev-round-large" type="text" placeholder="Informe Email..." name="email">
							</div>
							<div class="">
								<label class="dev-margin-top" style="display:block">Senha</label>
								<input class="dev-input dev-border dev-round-large" type="text" placeholder="Informe Senha..." name="senha">
							</div>
						</div>
						<button class="dev-btn dev-large dev-round-large dev-flat-alizarin dev-margin-top j_login_cliente">Entrar</button>
					</form>					
				</div>
				<div class="dev-col l8">
					<div class="w3-container">
						<h2>Crie sua conta ja</h2>
					</div>
					<form name="formulario_registo_cliente">
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Primeiro Nome</label>
								<input class="dev-input dev-border dev-round-large" name="nome" type="text" placeholder="Informe Primeiro..." >
							</div>
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Apelido</label>
								<input class="dev-input dev-border dev-round-large" name="apelido" type="text" placeholder="Informe Apelido...">
							</div>
						</div>
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Email</label>
								<input class="dev-input dev-border dev-round-large" name="email" type="text" placeholder="Informe Email...">
							</div>
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Contacto</label>
								<input class="dev-input dev-border dev-round-large" name="contacto" type="text" placeholder="Informe Contacto...">
							</div>
						</div>
						<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Senha</label>
								<input class="dev-input dev-border dev-round-large" id="senha" name="senha" type="text" placeholder="Informe Senha...">
							</div>
							<div class="dev-half">
								<label class="dev-margin-top" style="display:block">Confirmar Senha</label>
								<input class="dev-input dev-border dev-round-large" name="confirmar_senha" id="confirmar_senha" type="text" placeholder="Confirmar Senha...">
							</div>
						</div>
						<input type="submit" value="Registar" class="dev-btn dev-large dev-round-large dev-flat-alizarin dev-margin-top j_regista_cliente">
					</form>
				</div>
			</div>
		</div>
	</div>

<script>
function Google_signIn(googleUser) 
{
	var profile = googleUser.getBasicProfile();
	update_user_data(profile);
}

function update_user_data(response)
{
	$.ajax({
		type		: "POST",
		dataType	: 'json',
		data		: response,
		url			: '<?php echo ROOT?>cliente/google_profile_login',
		success: function(msg) 
		{
		   if(msg.status == "success")
		   {
				$(location).attr("href","<?php echo ROOT?>cliente/pagamentos");
		   }
		   
		   if(msg.error == 1)
		   {
				alert('Algo deu errado!');
		   }
		}
	});
}
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
	
	$('.j_regista_cliente').click(function(){
		var $senha 				= $("#senha");
		var $confirmar_senha 	= $("#confirmar_senha");
		var $this				= $(this);
		if($senha.val() == "")
		{
			$senha.css("outline","1px solid red").focus();			
			return false;
		}else
		{
			$senha.css("outline","none");
		}
		
		if($confirmar_senha.val() == "")
		{
			$confirmar_senha.css("outline","1px solid red");
			return false;
		}else
		{
			$confirmar_senha.css("outline","none");
		}
		
		if($senha.val() != $confirmar_senha.val())
		{
			$senha.css("outline","1px solid red").focus();	
			$confirmar_senha.css("outline","1px solid red").focus();
			return false;
		}else
		{
			$senha.css("outline","none");	
			$confirmar_senha.css("outline","none");
		}		
		
		
		$('form[name="formulario_registo_cliente"]').one('submit',function(){
			var dados = $(this).serialize()+'&accao=salvar_cliente';
			$.ajax({
				url 		: '<?php echo ROOT?>cliente/registo',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$this.prop("disabled",false);
						$this.val("Registar");
						$(location).attr("href","<?php echo ROOT?>cliente/pagamentos");
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
	
	$('.j_login_cliente').click(function(e){
		var $this = $(this);
		$('form[name="formulario_login_cliente"]').one('submit',function(){
			var dados = $(this).serialize()+'&accao=login';
			$.ajax({
				url 		: '<?php echo ROOT?>cliente/login',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$this.prop("disabled",false);
						$this.text("Entrar");
						$(location).attr("href","<?php echo ROOT?>cliente/pagamentos");
					}
					if(responseText.status == "failed")
					{
						
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$this.text("Por favor aguarde...");
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