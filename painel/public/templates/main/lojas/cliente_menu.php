<div class="dev-padding-32" style="">
	<img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/user.png" style="width:50px" class="dev-image dev-left dev-margin-right"/>
	<p class="dev-margin-0"><?php echo $_SESSION["cliente"]["nome"]?></p>
	<p class="dev-margin-0"><?php echo $_SESSION["cliente"]["email"]?></p>				
</div>
<ul class="dev-ul dev-margin-top">
	<li><a href="<?php echo ROOT?>cliente/favoritos" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/star.png" style="width:20px;" class="dev-margin-right">Meus Favoritos</a></li>
	<li><a href="<?php echo ROOT?>cliente/pedidos" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/cart.png" style="width:20px;" class="dev-margin-right">Meus Pedidos</a></li>
	<li><a href="<?php echo ROOT?>cliente/perfil" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/user.png" style="width:20px;" class="dev-margin-right">Meu Perfil</a></li>
	<li><a href="<?php echo ROOT?>cliente/enderecos" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/address.png" style="width:20px;" class="dev-margin-right">Meus Endereços</a></li>
	<li><a href="<?php echo ROOT?>cliente/perfil/id/<?php echo $_SESSION["cliente"]["id"]?>" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/medal.png" style="width:20px;" class="dev-margin-right">Promoções</a></li>
	<li><a href="<?php echo ROOT?>cliente/perfil/id/<?php echo $_SESSION["cliente"]["id"]?>" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/newsletter.png" style="width:20px;" class="dev-margin-right">Newsletters</a></li>
	<li><a href="<?php echo ROOT?>cliente/logout" class="dev-bar-item dev-button"><img src="<?php echo TEMPLATE_PATH?>lojas/img/icons/logout.png" style="width:20px;" class="dev-margin-right">Sair</a></li>
</ul>