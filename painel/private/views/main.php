
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<title>Painel Administrativo - Casa Coimbra Maputo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="url" content="<?php echo ROOT_URL;?>">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/dev.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/dev-theme.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo ROOT_URL;?>assets/font-awesome/css/font-awesome.min.css">
<script src="<?php echo ROOT_URL;?>assets/js/jquery.js"></script>
<style>
.dev-display-inline-block{margin-right:4px!important;margin-bottom:4px!important;vertical-align:middle;}
</style>
<body class="" style="background-color:#e2dfdf66!important">
<!-- Sidebar/menu -->
<nav class="dev-sidebar dev-collapse dev-flat-midnight-blue dev-animate-left" style="z-index:43;width:270px;" id="mySidebar">
  <div class="dev-row-padding dev-padding" onclick="accordionDropDown('conta')" style="cursor:pointer;">
		<div>
						
		</div>	
		<div >
			<div class="dev-display-inline-block" style="vertical-align:middle;width:80%">
				<span class="dev-small dev-block" style="font-weight:bold"><?php echo $_SESSION["manage_user"]["nome"]?></span>
				<span class="dev-small dev-block" style="font-weight:bold"><?php echo $_SESSION["manage_user"]["email"]?></span>
			</div>
			<div class="dev-display-inline-block" style="vertical-align:bottom;width:10%">
				<span>
					<i class="fa fa-caret-down" id="menu_config_caret"></i>
				</span>
			</div>
		</div>									
	</div>

	<div id="conta" class="dev-bar-block dev-hide dev-white dev-card-4 dev-animate-right">
		<ul class="dev-ul dev-hoverable">
			<li style="padding-left:0;padding-right:0;"><a href="<?php echo ROOT_URL?>users/salvar/<?php echo $_SESSION["manage_user"]["id"]?>" class="dev-bar-item dev-small"><i class="fa fa-user fa-1x"></i>  Minha Conta</a></li>
			<li style="padding-left:0;padding-right:0;"><a href="<?php echo ROOT_URL?>users/logout" class="dev-bar-item dev-small dev-hover"><i class="fa fa-power-off fa-1x"></i>  Sair</a></li>
		</ul>
	</div>
	<div class="dev-bar-block">
		<a href="<?php echo ROOT_URL?>home" class="dev-bar-item dev-padding"><i class="fa fa-bar-chart-o"></i> Dashboard</a>
	</div>	
	
	<div class="dev-bar-block dev-animate-right" id="" >
		
		<div class="dev-bar-item dev-button " onclick="myAccFunc('automoveis')">
			<i class="fa fa-car"></i> Gerir Automveis <i class="fa fa-caret-down"></i>
		</div>
		<div id="automoveis" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">		
				<li><a href="<?php echo ROOT_URL."automoveis/dashboard"?>" class="dev-bar-item dev-small">Dashboard</a></li>			
				<li><a href="<?php echo ROOT_URL."automoveis"?>" class="dev-bar-item dev-small">Automoveis</a></li>			
				<li><a href="<?php echo ROOT_URL."categorias?tipo=automovel"?>" class="dev-bar-item dev-small">Marcas</a></li>
				<li><a href="<?php echo ROOT_URL."subcategorias?tipo=automovel"?>" class="dev-bar-item dev-small">Modelos</a></li>
				<li><a href="<?php echo ROOT_URL."banners?tipo=automovel"?>" class="dev-bar-item dev-small">Gerir Banners</a></li>		
				<li><a href="<?php echo ROOT_URL."proprietarios?tipo=automovel"?>" class="dev-bar-item dev-small">Proprietarios</a></li>
			</ul>
		</div>
		<div class="dev-bar-item dev-button " onclick="myAccFunc('imoveis')">
			<i class="fa fa-home"></i> Gerir Imoveis <i class="fa fa-caret-down"></i>
		</div>
		<div id="imoveis" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">
				<li><a href="<?php echo ROOT_URL."imoveis/dashbord"?>" class="dev-bar-item dev-small">Dashboard</a></li>
				<li><a href="<?php echo ROOT_URL."imoveis"?>" class="dev-bar-item dev-small">Imoveis</a></li>			
				<li><a href="<?php echo ROOT_URL."categorias?tipo=imovel"?>" class="dev-bar-item dev-small">Categorias</a></li>
				<li><a href="<?php echo ROOT_URL."bairros"?>" class="dev-bar-item dev-small">Bairros</a></li>
				<li><a href="<?php echo ROOT_URL."banners?tipo=imovel"?>" class="dev-bar-item dev-small">Gerir Banners</a></li>		
				<li><a href="<?php echo ROOT_URL."proprietarios?tipo=imovel"?>" class="dev-bar-item dev-small">Proprietarios</a></li>
			</ul>
		</div>
		
		<div class="dev-bar-item dev-button " onclick="myAccFunc('produtos')">
			<i class="fa fa-shopping-cart"></i> Gerir Produtos <i class="fa fa-caret-down"></i>
		</div>
		<div id="produtos" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">
				<li><a href="<?php echo ROOT_URL."produtos/dashboard"?>" class="dev-bar-item dev-small">Dashboard</a></li>
				<li><a href="<?php echo ROOT_URL."produtos"?>" class="dev-bar-item dev-small">Produtos</a></li>			
				<li><a href="<?php echo ROOT_URL."categorias?tipo=produto"?>" class="dev-bar-item dev-small">Categorias</a></li>
				<li><a href="<?php echo ROOT_URL."subcategorias?tipo=produto"?>" class="dev-bar-item dev-small">subcategorias</a></li>
				<li><a href="<?php echo ROOT_URL."marcas?tipo=produto"?>" class="dev-bar-item dev-small">Marcas</a></li>
				<li><a href="<?php echo ROOT_URL."pedidos"?>" class="dev-bar-item dev-small">Pedidos</a></li>
				<li><a href="<?php echo ROOT_URL."clientes"?>" class="dev-bar-item dev-small">Clientes</a></li>
				<li><a href="<?php echo ROOT_URL."banners?tipo=produto"?>" class="dev-bar-item dev-small">Gerir Banners</a></li>		
				<li><a href="<?php echo ROOT_URL."proprietarios?tipo=produto"?>" class="dev-bar-item dev-small">Proprietarios</a></li>
			</ul>
		</div>
		
		<div class="dev-bar-item dev-button " onclick="myAccFunc('blogs')">
			<i class="fa fa-book"></i> Gerir Blogs <i class="fa fa-caret-down"></i>
		</div>
		<div id="blogs" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">
				<li><a href="<?php echo ROOT_URL."blog/dashbord"?>" class="dev-bar-item dev-small">Dashboard</a></li>
				<li><a href="<?php echo ROOT_URL."blog"?>" class="dev-bar-item dev-small">Blogs</a></li>			
				<li><a href="<?php echo ROOT_URL."categorias?tipo=blog"?>" class="dev-bar-item dev-small">Categorias</a></li>
				<li><a href="<?php echo ROOT_URL."subcategorias?tipo=blog"?>" class="dev-bar-item dev-small">subcategorias</a></li>
				<li><a href="<?php echo ROOT_URL."banners?tipo=blog"?>" class="dev-bar-item dev-small">Gerir Banners</a></li>		
				<li><a href="<?php echo ROOT_URL."proprietarios?tipo=blog"?>" class="dev-bar-item dev-small">Autores</a></li>
			</ul>
		</div>
		<div class="dev-bar-item dev-button " onclick="myAccFunc('template')">
			<i class="fa fa-address-book"></i> Gerir Templates <i class="fa fa-caret-down"></i>
		</div>
		<div id="template" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">		
				<li><a href="<?php echo ROOT_URL."produtos"?>" class="dev-bar-item dev-small">Menus</a></li>			
				<li><a href="<?php echo ROOT_URL."categorias"?>" class="dev-bar-item dev-small">Paginas</a></li>
				<li><a href="<?php echo ROOT_URL."subcategorias"?>" class="dev-bar-item dev-small">Galerias</a></li>
			</ul>
		</div>
		
		<div class="dev-bar-item dev-button " onclick="myAccFunc('configuracoes')">
			<i class="fa fa-gear"></i> Configurações <i class="fa fa-caret-down"></i>
		</div>
		<div id="configuracoes" class="dev-hide dev-white">
			<ul class="dev-ul dev-white dev-hoverable">					
				<li><a href="<?php echo ROOT_URL."mensagens"?>" class="dev-bar-item dev-small">Gerir Mensagens</a></li>
				<li><a href="<?php echo ROOT_URL."newsletters"?>" class="dev-bar-item dev-small"> Gerir Newsletter</a></li>
				<li><a href="<?php echo ROOT_URL."forum"?>" class="dev-bar-item dev-small">Gerir Forum</a></li>
				<li><a href="<?php echo ROOT_URL."users"?>" class="dev-bar-item dev-small">Gerir Usuarios</a></li>
				<li><a href="<?php echo ROOT_URL."instituicao"?>" class="dev-bar-item dev-small">Gerir Instituição</a></li>				
			</ul>
		</div>
	</div>
</nav>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="dev-overlay dev-hide-large dev-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="dev-main" style="margin-left:270px;">
	<div class="dev-container dev-flat-midnight-blue" style="z-index:4">
		<button class="dev-bar-item dev-button dev-hide-large dev-flat-peter-river dev-large dev-margin-top dev-margin-bottom" style="box-shadow:inset 0 -3px rgba(0,0,0,.25);" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>		
	</div>
	<div id="viewmodel"><?php require_once($view);?></div>
</div>

<script>
function myAccFunc(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("dev-show") == -1) {
    x.className += " dev-show";
    x.previousElementSibling.className += " dev-dark-grey";
  } else { 
    x.className = x.className.replace(" dev-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" dev-dark-grey", "");
  }
}
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
function accordionDropDown(id) {
	var x 		= document.getElementById(id);
	var caret 	= document.getElementById("menu_config_caret");
	if (x.className.indexOf("dev-show") == -1) {
		x.className += " dev-show";
		caret.className = "fa fa-caret-up";	
		
	} else { 
		x.className = x.className.replace(" dev-show", "");
		caret.className = "fa fa-caret-down";	
	}
	return false;
}
</script>

</body>
</html>
