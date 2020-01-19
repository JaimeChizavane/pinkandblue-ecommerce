<div class="dev-container">	
	<?php 
		$id		= $_GET["id"];
	?>
	<div class="dev-row-padding dev-margin-bottom" style="">
		<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
			<div class="dev-bar-block dev-animate-right" id="automoveis" >
				<div class="dev-bar-item dev-border-bottom dev-white">Automoveis - Salvar</div>
				<ul class="dev-ul dev-hoverable dev-large j_detalhes_do_automovel">		
					<li style="padding:0;"><a href="#descricao_do_automovel" class="dev-bar-item dev-large">Descrição</a></li>
					<li style="padding:0;"><a href="#foto_principal_do_automovel" class="dev-bar-item dev-large">Foto Principal</a></li>
					<li style="padding:0;"><a href="#mais_fotos_do_automovel" class="dev-bar-item dev-large">Mais Fotos</a></li>
				</ul>	
			</div>	
		</div>
		<div class="dev-main" style="margin-left:270px;"><!--Aqui Inicia A Div para cadastro dos dados do Automovel-->			
			<div class="dev-border dev-white dev-padding">
				<h1 class="dev-border-bottom dev-text-grey" id="descricao_do_automovel" style="margin-bottom:0;">Descrição</h1>
				<form name="salva_automovel" class="" style="margin-top:0;margin-bottom:0;" method="POST" id="salva_automovel" action="<?php $_SERVER["PHP_SELF"];?>">
					<div class="dev-row-padding">
						<input type="hidden" value="<?php echo $id;?>" name="id">
						<p>
							<label class="dev-large" for="nome">Titulo do Automovel</label>
							<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="nome" id="nome" value="<?php echo $viewmodel["nome"]?>" placeholder="Informe o Titulo do Automovel" required>
						</p>
											
							<div class="" style="width:100%;">
								<label class="dev-large" for="descricao">Descrição</label><br />
								<button type="button" onclick="execCmd('bold')"><i class="fa fa-bold"></i></button>
								<button type="button" onclick="execCmd('italic')"><i class="fa fa-italic"></i></button>
								<button type="button" onclick="execCmd('underline')"><i class="fa fa-underline"></i></button>
								<button type="button" onclick="execCmd('justifyLeft')"><i class="fa fa-align-left"></i></button>
								<button type="button" onclick="execCmd('justifyRight')"><i class="fa fa-align-right"></i></button>
								<button type="button" onclick="execCmd('justifyCenter')"><i class="fa fa-align-center"></i></button>
								<button type="button" onclick="execCmd('justifyFull')"><i class="fa fa-align-justify"></i></button>
								<button type="button" onclick="execCmd('insertUnorderedList')"><i class="fa fa-list-ul"></i></button>
								<button type="button" onclick="execCmd('insertOrderedList')"><i class="fa fa-list-ol"></i></button>
								<button type="button" onclick="execCmd('insertParagraph')"><i class="fa fa-paragraph"></i></button>
								<select onchange="execCmdArgs('fontSize',this.value)">	
									<option value="1">6</option>
									<option value="2">8</option>
									<option value="3">10</option>
									<option value="4">12</option>
									<option value="5">14</option>
									<option value="6">16</option>
									<option value="7">20</option>
								</select>
								<select onchange="execCmdArgs('formatBlock',this.value)">	
									<option value="H1">H1</option>
									<option value="H2">H2</option>
									<option value="H3">H3</option>
									<option value="H4">H4</option>
									<option value="H5">H5</option>
									<option value="H6">H6</option>
								</select>
							</div>						
							<textarea style="display:none;" class="dev-input dev-border" name="descricao" id="descricao"><?php if(!empty($viewmodel["descricao"])) echo $viewmodel['descricao']?></textarea>
							<iframe name="richTextField" id="richTextField" style="width:100%; height:300px;" class="dev-white dev-border dev-round-large"></iframe>					
					</div>	
					<div class="dev-row-padding" style="padding:0;">
						<div class="dev-half">
							<p>
								<label class="dev-large" for="preco">Preço</label>
								<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="preco" id="preco" placeholder="Informe o preco do Automovel" data-thousands="," data-decimal="." value="<?php if(!empty($viewmodel["preco"])) echo number_format($viewmodel["preco"],2)?>" required>
							</p>
						</div>
						<div class="dev-half">
							<p>
								<label class="dev-large" for="moeda">Moeda</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="moeda" id="moeda">
								<option value="MZN"  
								<?php 
									if($viewmodel["moeda"] == "MZN") 
										echo "selected";
								?> >MZN</option>
								<option value="USD" <?php if($viewmodel["moeda"] == "USD") echo "selected";?>>USD</option>
								<option value="RAND" <?php if($viewmodel["moeda"] == "RAND") echo "selected";?>>RAND</option>
								</select>
							</p>
						</div>
					</div>
					<div class="dev-row-padding" style="padding:0;">
						<div class="dev-half">
							<p>
								<label class="dev-large" for="ano">Ano de Fabrico</label>
								<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="ano"  id="ano" placeholder="Informe o ano" value="<?php if(!empty($viewmodel["ano"])) echo $viewmodel["ano"]?>">
							</p>	
						</div>
						
						<div class="dev-half">
							<p>
								<label class="dev-large" for="kilometros">Kilometros</label>
								<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="kilometros" id="kilometros" placeholder="Informe os kilometros do Automovel" value="<?php if(!empty($viewmodel["kilometros"])) echo $viewmodel["kilometros"]?>">
							</p>
						</div>
					</div>

					<div class="dev-row-padding" style="padding:0">
						<div class="dev-half">
							<p>
								<label class="dev-large" for="bairro_id">Marca</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge j_select_categoria" name="categoria_id" id="categoria_id">
									
								<option value="" disabled selected>Informe a marca</option>
								<?php 
									$uteis = new Uteis;
									$uteis->query('SELECT * FROM categorias WHERE status = 1 AND tipo IN("automovel")');
									$uteis->execute();
									$rows= $uteis->resultSet();
									foreach($rows as $categoria):
										echo '<option value="'.$categoria["id"].'"';
											if($categoria["id"] == $viewmodel["categoria_id"]) echo "selected";
										echo '>';					
										echo $categoria["nome"].'</option>';
									endforeach;
								?>
								</select>
							</p>
						</div>
						<div class="dev-half">
							<p>
								<label class="dev-large" for="subcategoria_id">Modelo</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="subcategoria_id" id="subcategoria_id">
								<option value="" disabled selected>Informe o modelo</option>
								</select>
							</p>
						</div>
					</div>

					<div class="dev-row-padding" style="padding:0;">						
						<div class="dev-half">
							<p>
								<label class="dev-large" for="combustivel">Combustivel</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="combustivel" id="combustivel" required>
									<option value="" disabled selected>Informe o tipo de combustivel</option>
									<option value="gasolina" <?php if($viewmodel["combustivel"] == "gasolina") echo "selected";?>>Gasolina</option>
									<option value="diesel" <?php if($viewmodel["combustivel"] == "diesel") echo "selected";?>>Diesel</option>
									<option value="electrico" <?php if($viewmodel["combustivel"] == "electrico") echo "selected";?>>Electrico</option>
									<option value="gas" <?php if($viewmodel["combustivel"] == "gas") echo "selected";?>>Gas</option>
								</select>
							</p>
						</div>
						<div class="dev-half">
							<p>
								<label class="dev-large" for="bairro_id">Proprietario</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="proprietario_id" id="proprietario_id">
								<option value="" disabled selected>Informe o Proprietario</option>
								<?php 
									$uteis = new Uteis;
									$uteis->query('SELECT * FROM proprietarios status = 1 AND tipo IN("automovel")');
									$uteis->execute();
									$rows= $uteis->resultSet();
									foreach($rows as $proprietario):
										echo '<option value="'.$proprietario["id"].'"';
											if($proprietario["id"] == $viewmodel["proprietario_id"]) echo "selected";
										echo '>';					
										echo $proprietario["nome"].'</option>';
									endforeach;
								?>
								</select>
							</p>
						</div>
					</div>
					<div class="dev-row-padding" style="padding:0;">						
						<div class="dev-half">
							<p>
								<label class="dev-large" for="status">Status</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="status" id="status" required>
									<option value="" disabled selected>Informe o status do Automovel</option>
									<option value="1" <?php if($viewmodel["status"] == 1) echo "selected";?>>Activo</option>
									<option value="2" <?php if($viewmodel["status"] == 2) echo "selected";?>>Não Activo</option>
								</select>
							</p>
						</div>
						<div class="dev-half">
							<p class="j_automovel">
								<label class="dev-large dev-block" for="">&nbsp;</label>
								<input type="submit" class="dev-button dev-flat-belize-hole dev-large  j_salva_automovel" name="salvar_contacto" value="Salvar&nbsp; ❯">
								<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
								<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 					
							</p>
						</div>
					</div>
				</form>
				
			<div class="dev-white" style="padding-top:0;">
				<h1 class="dev-border-bottom dev-text-grey" id="foto_principal_do_automovel" style="margin-bottom:0;margin-top:0;">Foto Principal</h1>
				<form method="POST" name="foto" id="foto" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="">
						<p>
							<input class="dev-input dev-border" type="file" name="foto">
						</p>
						
						<p class="j_foto">
							<input type="submit" class="dev-button dev-flat-belize-hole  j_salva_foto" name="salvar_foto" value="Salvar&nbsp; ❯">
							<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
							<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span>						
						</p>
					</div>
				</form>

				<div class="dev-row-padding foto" style="margin-left:-16px;margin-right:-16px">
					<span><i class="fa fa-spinner dev-spin" style="font-size:70px"></i></span>
				</div>
			</div>
			
			<div class="dev-white dev-margin-top">
				<h1 class="dev-border-bottom dev-text-grey" id="mais_fotos_do_automovel" style="margin-bottom:0;">Mais Fotos</h1>
				<form method="POST" name="galeria" id="galeria" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="dev-padding" style="margin-left:-16px;margin-right:-16px">
						<p>
							<input class="dev-input dev-border" type="file" name="galeria_automovel[]" multiple>
						</p>
						
						<p class="j_galeria">
							<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
							<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span>
							<input type="submit" class="dev-button dev-flat-belize-hole j_salva_galeria" name="salvar_galeria" value="Salvar&nbsp; ❯">
						</p>
					</div>
				</form>
				<div class="dev-row-padding galeria" style="margin-right:-16px;margin-left:-16px">
					<span><i class="fa fa-spinner dev-spin" style="font-size:70px"></i></span>
				</div>
			</div>
			</div>					
		</div><!--Aqui Finaliza A Div para cadastro dos dados do Automovel-->
	</div>
</div>
<style>
	button{
		border:none;
		outline:none;
		background-color:#ccc;
		cursor:pointer;
		display:inline-block;
		padding:2px 10px;
		margin:5px 0;
	}
	button:hover{
		background-color:#ddd;
	}
	#mapa{
		width:100%;
		max-height:400px;	
		min-height:200px;	
		height:400px;
	}
	#richTextField body{
		font-family:'Montserrat', sans-serif!important;
	}
</style>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/js/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/js/jquery-ui.js"></script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $(".j_detalhes_do_automovel > li > a").on('click', function(event) {

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


function myFunction(id){
    var x = document.getElementById(id);
    if (x.className.indexOf("dev-show") == -1) {
        x.className += " dev-show";
    }else{
        x.className = x.className.replace(" dev-show", "");
    }
}

//criando um editor de text wysiwyg
var theForm 		= document.getElementById("salva_automovel");
window.frames["richTextField"].document.body.innerHTML = theForm.elements["descricao"].value;
window.frames["richTextField"].document.body.style.fontFamily = "";
window.frames["richTextField"].document.body.style.fontSize = "16px";
enableEditMode();
function enableEditMode(){
	window.frames["richTextField"].document.designMode = 'on';
}

function execCmd(cmd){
	window.frames["richTextField"].document.execCommand(cmd,false,null);
}
function execCmdArgs(cmd,value){
	window.frames["richTextField"].document.execCommand(cmd,false,value);
}
var showSourceCode = false;
var isEditMode = true;
function toggleSource(){
	if(showSourceCode){
		window.frames["richTextField"].document.body.innerHTML = window.frames["richTextField"].document.body.textContent;
		showSourceCode = false;
	}else{
		window.frames["richTextField"].document.body.textContent = window.frames["richTextField"].document.body.innerHTML;
		showSourceCode = true;
	}
}
$(document).ready(function(evt){
	$('#endereco').on('keydown keypress keyup',function()
	{
		$('#txtEndereco').val($(this).val());
	});
});
$("#preco").maskMoney();
</script>
<script src="<?php echo ROOT_URL;?>assets/js/form.js"></script>
<script src="<?php echo ROOT_URL;?>assets/controllers/automovel.js"></script>