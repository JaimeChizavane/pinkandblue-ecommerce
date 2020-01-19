<div class="dev-padding-24 dev-dark-grey" style="margin-bottom:0;" id="footer">
	<div class="dev-content" style="max-width:1170px">
		<div class="dev-row-padding dev-padding-16 dev-center" id="food">
			<div class="dev-third">
			  <div class="">
				<i class="fa fa-truck fa-4x dev-text-red"></i>
			  </div>
			  <h3>Entrega Gratuita</h3>
			  <p>Entrega gratuita em toda cidade de Maputo. Taxa adicional para todas as provincias.</p>
			</div>
			<div class="dev-third">
			  <div class="">
				<i class="fa fa-clock-o fa-4x dev-text-red"></i>
			  </div>
			  <h3>Facildade de Pagamento</h3>
			  <p>Pode pagar usando sua carteira móvel de preferencia ou pode mesmo pagar na recepcao.</p>
			</div>
			<div class="dev-third">
			  <div class="">
				<i class="fa fa-phone fa-4x dev-text-red"></i>
			  </div>
			  <h3>Suporte de Disputas</h3>
			  <p>Pode disputar o producto a qualquer altura, temos uma politica de uso clara e simples, nao esta satifeito garantimos
                  a devolucao do dinheiro imediatamente.</p>
			</div>
		</div>	
	</div>	
</div>

<div class="dev-padding-24 dev-white" style="margin-bottom:0;">
	<div class="dev-content" style="max-width:500px">
		<div class="dev-padding-16 dev-center" >
			<h3>Receba Novidades</h3>
			<div class="dev-display-container">					
				<input type="text" class="dev-input dev-border" placeholder="Insira seu email para newsletter">
				<button class="dev-display-bottomright dev-btn dev-flat-alizarin" style="top:0;">SUBSCREVER</button>
			</div>	
		</div>	
	</div>	
</div>	

<div class="dev-padding-24 dev-dark-grey" style="margin-bottom:0;">
	<div class="dev-content" style="max-width:1170px">
		<div class="dev-row-padding dev-padding-16" id="food">
			<div class="dev-quarter">
				<h3>Saiba Mais</h3>
				<ul class="dev-ul">
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>">Home</a></li>
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>sobre">Quem Somos</a></li>
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>blog">Blog</a></li>
				</ul>
			</div>
			<div class="dev-quarter">
				<h3>Saiba Como</h3>
				<ul class="dev-ul">
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>pagamentos">Pagamentos</a></li>
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>delivery">Entrega</a></li>
					<li class="dev-border-0 dev-padding-0"><a href="<?php echo ROOT?>faq">FAQ</a></li>
				</ul>
			</div>
			<div class="dev-quarter">
				<h3>Meios de Pagamento</h3>
					<span class="fa fa-cc-mastercard fa-3x"></span>
					<span class="fa fa-cc-visa fa-3x"></span>
					<span class="fa fa-paypal fa-3x"></span>
					<span class="fa fa-cc-discover fa-3x"></span>
			</div>
			<div class="dev-quarter">
				<h3>Contacto</h3>
				<ul class="dev-ul">
<!--					<li class="dev-border-0 dev-padding-0"><a href=""><i class="fa fa-map-marker dev-margin-right"></i>Rua da Amizade</a></li>-->
					<li class="dev-border-0 dev-padding-0"><a href=""><i class="fa fa-phone dev-margin-right"></i>+258 84 210 3963</a></li>
					<li class="dev-border-0 dev-padding-0"><a href=""><i class="fa fa-envelope dev-margin-right"></i>info@pinkandblue-cosmeticos.com</a></li>
				</ul>
				<div class="dev-section">
					<a href="javascript:void(0)" class="dev-btn"><span class="fa fa-facebook"></span></a>
					<a href="javascript:void(0)" class="dev-btn"><span class="fa fa-twitter"></span></a>
					<a href="javascript:void(0)" class="dev-btn"><span class="fa fa-google-plus"></span></a>
					<a href="javascript:void(0)" class="dev-btn"><span class="fa fa-youtube"></span></a>
				</div>
			</div>
		</div>	
	</div>	
</div>
<style>
	a{text-decoration:none}
	.bounce{
		animation: bounce 0.8s;
		animation-direction: alternate;
		animation-iteration-count: infinite;
	}
	@keyframes bounce {
		from { transform: translate3d(0, -5px, 0); }
		to   { transform: translate3d(0, 5px, 0); }
	}
	
</style>
<script>
$(document).ready(function()
{
	var header_brand 				= $("#header-brand")
	var header_brand_altura_abaixo 	= header_brand.offset().top + header_brand.outerHeight();
	$(window).scroll(function()
	{
		var windowTop		= $(this).scrollTop();	
		if(header_brand_altura_abaixo < windowTop)
		{
			$("#notificacao_de_adicao_no_carrinho").css("display","block");
		}else
		{
			$("#notificacao_de_adicao_no_carrinho").css("display","none");
		}
	});
	
	$(document).on('click','.j_pesquisa_por_termos',function(e){	
		e.preventDefault();
		var termo = $('.j_termo').val();
		if(termo !== ''){
			var url = termo.replace(/ /g,"-");
			$(location).attr('href',"<?php echo ROOT?>pesquisa/termo="+url);
		}
	});
	
	$(document).on('keyup','.j_termo',function(e){	
		// e.preventDefault();
		// var key = $('.j_termo').val();
		// if(termo !== ''){
			// var url = termo.replace(/ /g,"-");
			// $(location).attr('href',"<?php echo ROOT?>pesquisa/termo="+url);
		// }
	});
	
});
</script>
</body>
</html>
