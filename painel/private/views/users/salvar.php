<div class="dev-container">
	<div class="dev-row-padding dev-margin-bottom" style="">
		<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
			<div class="dev-bar-block dev-animate-right" id="imoveis" >
				<div class="dev-bar-item dev-border-bottom dev-white dev-large">Usuario - Salvar</div>
				<ul class="dev-ul dev-hoverable dev-large j_detalhes_do_usuario">		
					<li style="padding:0;"><a href="#dados_do_usuario" class="dev-bar-item dev-large">Meus Dados</a></li>
					<li style="padding:0;"><a href="#imagem_do_usuario" class="dev-bar-item dev-large">Minha Imagem</a></li>
				</ul>	
			</div>	
		</div>
		<div class="dev-main" style="margin-left:270px;">
			<div class="dev-border dev-white dev-padding">
			<h1 class="dev-border-bottom dev-text-grey" id="dados_do_usuario" style="margin-bottom:0;">Meus Dados</h1>
				<form class="" method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
					<input type="hidden" value="<?php echo $_GET["id"]?>" name="id">
					<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px;">
						<div class="dev-half">
							<label class="dev-large">Nome</label>
							<input class="dev-input dev-border dev-large dev-round-large" type="text" name="nome" value="<?php echo $viewmodel["nome"]?>">
						</div>
						<div class="dev-half">
							<label class="dev-large">Email</label>
							<input class="dev-input dev-border dev-large dev-round-large" type="email" name="email" value="<?php echo $viewmodel["email"]?>">
						</div>
					</div>
					<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px;">
						<div class="dev-half">
							<label class="dev-large">Contacto</label>
							<input class="dev-input dev-border dev-large dev-round-large" type="contacto" name="contacto" value="<?php echo $viewmodel["contacto"]?>">
						</div>
						<div class="dev-half">
							<label class="dev-large">Senha</label>
							<input class="dev-input dev-border dev-large dev-round-large" type="text" name="senha_visivel" value="<?php echo $viewmodel["senha_visivel"]?>">
						</div>
					</div>
					<?php if($_SESSION["manage_user"]["nivel"] == 1):?>
					<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px;">
						<div class="dev-half">
							<label class="dev-large">Nivel</label>
							<select class="dev-select dev-border dev-large dev-round-large" name="nivel">
								<option value="" disabled selected>Seleccione o Grupo</option>
								<?php 
									$rows= array(
										"1"=>"administrador","2"=>"editor"
									);
									foreach($rows as $keys=>$values):
										echo '<option value="'.$keys.'"';
											if($keys == $viewmodel["nivel"]) echo "selected";
										echo '>';					
										echo $values.'</option>';
									endforeach;
								?>
							</select>
						</div>
						<div class="dev-half">
						<?php endif;?>
							<label class="dev-large">Estado</label>
							<select class="dev-select dev-border dev-large dev-round-large" name="status">
							<option value="" disabled selected>Seleccione o Status</option>
								<?php 
									$rows= array(
										"1"=>"Activo","2"=>"Inactivo"
									);
									foreach($rows as $keys=>$values):
										echo '<option value="'.$keys.'"';
											if($keys == $viewmodel["status"]) echo "selected";
										echo '>';					
										echo $values.'</option>';
									endforeach;
								?>
							</select>
						</div>
					</div>
					
					<p><input type="submit" class="dev-button dev-round-large dev-flat-belize-hole" name="salvar_usuario" value="Salvar&nbsp; ❯"></p>
				</form>
				
			<div class="dev-white" style="padding-top:0;">
				<h1 class="dev-border-bottom dev-text-grey" id="imagem_do_usuario" style="margin-bottom:0;margin-top:0;">Minha Imagem</h1>
				<form method="POST" name="foto" id="foto" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="">
						<p>
							<input class="dev-input dev-border" type="file" name="foto">
						</p>
						
						<p class="j_foto">
							<input type="submit" class="dev-button dev-flat-belize-hole  j_salva_foto_do_user" name="salvar_foto" value="Salvar&nbsp; ❯">
							<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
							<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span>				
						</p>
					</div>
				</form>

				<div class="dev-row-padding foto" style="margin-left:-16px;margin-right:-16px">
					<span><i class="fa fa-spinner dev-spin" style="font-size:70px"></i></span>
				</div>
			</div>
				
			</div>
		</div>
	</div>	
</div>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $(".j_detalhes_do_usuario > li > a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
</script>