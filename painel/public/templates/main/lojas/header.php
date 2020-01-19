<!DOCTYPE html>
<html>
<head>
	<title>Theme</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo TEMPLATE_PATH?>lojas/css/dev.css">
	<link rel="stylesheet" href="<?php echo TEMPLATE_PATH?>lojas/css/theme/dev-theme-flat.css">
	<link rel="stylesheet" href="<?php echo TEMPLATE_PATH?>lojas/font-awesome/css/font-awesome.css">
	<script src="<?php echo ROOT_URL?>assets/js/jquery.js"></script>
	<meta name="google-signin-client_id" content="1008928385481-60dhrn3jjiheq9oo2djh9rjunlj15qi9.apps.googleusercontent.com">

</head>
<body>
	<div class="bounce" id="notificacao_de_adicao_no_carrinho" style="position:fixed;bottom:10px;right:10px;z-index:999;display:none">
		<div class="dev-display-container">
			<a href="<?php echo ROOT?>carrinho"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/shopping-bag.png" style="width:40px;" class="dev-margin-right">
			<span class="dev-badge dev-flat-alizarin dev-display-topmiddle total_items"><?php 
				if(isset($_SESSION["carrinho_de_compras"]))
				{
					echo count($_SESSION["carrinho_de_compras"]);
				}
				else
				{
					echo "0";
				}
			?></span>
			</a>
		</div>
	</div>
	<div class="dev-border">
		<div class="dev-container dev-content" style="max-width:1170px;">
			<div class="dev-bar">	
				<ul class="dev-theme dev-navbar">
					<li class="dev-dropdown-hover">
						<a class="dev-small"> <img src="<?php echo TEMPLATE_PATH?>lojas/img/flags/mozambique.png" style="width:16px;" class="dev-margin-right">Portugues <i class="fa fa-caret-down dev-margin-left"></i></a>
						<div class="dev-dropdown-content dev-bar-block dev-border">
							<a href="#" class="dev-bar-item"><img src="<?php echo TEMPLATE_PATH?>lojas/img/flags/mozambique.png" style="width:20px;" class="dev-margin-right">Portugues</a>
							<a href="#" class="dev-bar-item"><img src="<?php echo TEMPLATE_PATH?>lojas/img/flags/united-states.png" style="width:20px;" class="dev-margin-right">English</a>
						</div>
					</li>
					<li>
						<a href="#" class="dev-bar-item dev-border-right dev-small"> <img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/contact.png" style="width:16px;" class="dev-margin-right">+258 84 210 3963</a>
					</li>
					<?php if(empty($_SESSION["cliente"])):?>
						<li>
							<a href="<?php echo ROOT?>cliente" class="dev-bar-item dev-border-right dev-small"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/password.png" style="width:16px;" class="dev-margin-right">Entrar</a>
						</li>
					<?php endif;?>	
					<?php if(!empty($_SESSION["cliente"]) && isset($_SESSION["cliente"])):?>
						<li class="">
							<a href="<?php echo ROOT?>cliente/perfil" class="dev-small" style="display:block"> <img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/user.png" style="width:16px;" class="dev-margin-right">Minha Conta</a>	
						</li>						
					<?php endif;?>
					<li class="dev-right dev-padding-top">
						<?php if(!empty($_SESSION["cliente"]) && isset($_SESSION["cliente"])):?>
							<span>Ola <?php echo $_SESSION["cliente"]["nome"]?>, seja bem vindo</span>
						<?php else:?>
							<span>Ola visitante, seja bem vindo</span>
						<?php endif;?>
					</li>	
				</ul>					
			</div>			
		</div>
	</div>
	
	<div class="dev-bar dev-padding-24 dev-padding-bottom" id="header-brand">
		<div class="dev-container dev-content" style="max-width:1170px;">	
			<div class="dev-clear">					
				<div class="dev-half">
					<a href="<?php echo ROOT?>">
						<img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/logo.png" style="width:80px;" class="dev-left dev-margin-right">
						<div class="dev-left">
							<h1 style="margin:0;" class="dev-xlarge">Pink & Blue</h1>
							<h1 style="margin:0;" class="dev-medium">Maior compra de cosméticos online!</h1>
						</div>	
					</a>	
				</div>
				<div class="dev-quarter">
					<div class="dev-margin-top">
						<ul class="dev-ul dev-theme">
							<li class="">
								<a href="<?php echo ROOT?>carrinho" class="dev-button dev-medium"> 
									<i class="fa fa-shopping-basket fa-2x"></i> <span class="dev-badge dev-flat-alizarin total_items bounce"><?php 
										if(isset($_SESSION["carrinho_de_compras"]))
										{
											echo count($_SESSION["carrinho_de_compras"]);
										}
										else
										{
											echo "0";
										}
									?></span>
									<span></span>
									<p class="" style="margin:0;">Carrinho de Compras</p> 
								</a>
							</li>
						</ul>
					</div>	
				</div>
				<div class="dev-quarter">
					<div class="dev-margin-top dev-display-container">
						<input type="text" class="dev-input dev-border j_termo" placeholder="Procurar productos">
						<button class="dev-display-bottomright dev-btn dev-flat-alizarin j_pesquisa_por_termos" style="top:0;"><i class="fa fa-search"></i></button>
					</div>	
				</div>
			</div>	
		</div>
	</div>
	
	
	<!--<div class="dev-bar dev-flat-alizarin">
		<div class="dev-container dev-content dev-mainnav-wrapper" style="max-width:1170px;">
			<ul class="dev-navbar dev-theme dev-left-align dev-mainnav">
				<li class="dev-hide-medium dev-hide-large dev-opennav dev-right">
					<a href="javascript:void(0);" onclick="myFunction()"><i class="fa fa-navicon"></i></a>
				</li>
				<?php foreach($data["lista_categorias"] as $categorias):?>
					<li><a class="dev-padding-16" href="javascript:void(0)"><?php echo $categorias["nome"]?></a></li>						
				<?php endforeach;?>
			</ul>
		</div>
	</div>-->