<div class="dev-container">	
	<?php 
		$uteis 		= new Uteis;
		$id 		= (int) $_GET['id'];
	?>
	<div class="dev-row-padding dev-margin-bottom" style="">
		<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
			<div class="dev-bar-block dev-animate-right" id="imoveis" >
				<div class="dev-bar-item dev-border-bottom dev-white">Produtos - Salvar</div>
				<ul class="dev-ul dev-hoverable dev-large j_detalhes_do_produto">		
					<li style="padding:0;"><a href="#descricao_do_produto" class="dev-bar-item dev-large">Descrição</a></li>
					<li style="padding:0;"><a href="#foto_principal_do_produto" class="dev-bar-item dev-large">Foto Principal</a></li>
					<li style="padding:0;"><a href="#mais_fotos_do_produto" class="dev-bar-item dev-large">Mais Fotos</a></li>
				</ul>	
			</div>	
		</div>
		<div class="dev-main" style="margin-left:270px;"><!--Aqui Inicia A Div para cadastro dos dados do produto-->			
			<div class="dev-border dev-white dev-padding">
				<h1 class="dev-border-bottom dev-text-grey" id="descricao_do_produto" style="margin-bottom:0;">Descrição</h1>
				<form name="salva_produto" class="" style="margin-top:0;margin-bottom:0;" method="POST" id="salva_produto" action="<?php $_SERVER["PHP_SELF"];?>">
					<div class="dev-row-padding">
						<input type="hidden" value="<?php echo $id;?>" name="id">
						<p>
							<label class="dev-large" for="nome">Titulo</label>
							<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="nome" id="nome" value="<?php echo $viewmodel["nome"]?>" placeholder="Informe o Titulo" required>
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
							<textarea style="display:none;" class="dev-input dev-border dev-round-xlarge" name="descricao" id="descricao"><?php if(!empty($viewmodel["descricao"])) echo $viewmodel['descricao']?></textarea>
							<iframe name="richTextField" id="richTextField" style="width:100%; height:300px;background-color:#fff;" class="dev-border dev-round-xlarge"></iframe>					
					</div>	
					<div class="dev-row-padding" style="padding:0;">
						<div class="dev-half">
							<p>
								<label class="dev-large" for="preco">Preço</label>
								<input class="dev-input dev-border dev-large dev-round-xlarge" type="text" name="preco" id="preco" placeholder="Informe o preco do produto" data-thousands="," data-decimal="." value="<?php if(!empty($viewmodel["preco"])) echo number_format($viewmodel["preco"],2)?>" required>
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
					
					<div class="dev-row-padding" style="padding:0">
						<div class="dev-third">
							<p>
								<label class="dev-large" for="categoria_id">Categorias</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge j_select_categoria" name="categoria_id" id="categoria_id">				
									<option value="" disabled selected>Informe a categoria</option>
									<?php 
										$uteis = new Uteis;
										$uteis->query('SELECT * FROM categorias WHERE status = 1 AND tipo IN("produto")');
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
						<div class="dev-third">
							<p>
								<label class="dev-large" for="subcategoria_id">Subcategorias</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge j_select_subcategoria" name="subcategoria_id" id="subcategoria_id">
									<?php 
										$uteis = new Uteis;
										$uteis->query('SELECT * FROM subcategorias WHERE id = '.$viewmodel["subcategoria_id"].' ');
										$subcategoria = $uteis->single();				
										echo '<option value="'.$subcategoria["id"].'" selected>'.$subcategoria["nome"].'</option>';
									?>
								</select>
							</p>
						</div>
						<div class="dev-third">
							<p>
								<label class="dev-large" for="marca_id">Marcas</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge j_select_marca" name="marca_id" id="marca_id">
									<?php 
										$uteis = new Uteis;
										$uteis->query('SELECT mc.* FROM marcas mc WHERE mc.id = '.$viewmodel["marca_id"].'');
										$marca = $uteis->single();				
										echo '<option value="'.$marca["id"].'" selected>'.$marca["nome"].'</option>';
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
									<option value="" disabled selected>Informe o status do produto</option>
									<option value="1" <?php if($viewmodel["status"] == 1) echo "selected";?>>Activo</option>
									<option value="0" <?php if($viewmodel["status"] == 0) echo "selected";?>>Não Activo</option>
								</select>
							</p>
						</div>
						<div class="dev-half">
							<p>
								<label class="dev-large" for="proprietario_id">Proprietario</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="proprietario_id" id="proprietario_id">
								<option value="" disabled selected>Informe o Modelo</option>
									<?php 
										$uteis = new Uteis;
										$uteis->query('SELECT * FROM proprietarios WHERE status = 1 AND tipo IN("produto")');
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
						<div class="">
							<p class="j_produto">
								<input type="submit" class="dev-button dev-flat-belize-hole j_salva_produto" name="salvar_contacto" value="Salvar&nbsp; ❯">
								<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
								<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 					
							</p>
						</div>
					</div>					
				</form>
			<div class="dev-white" style="padding-top:0;">
				<h1 class="dev-border-bottom dev-text-grey" id="foto_principal_do_produto" style="margin-bottom:0;margin-top:0;">Foto Principal</h1>
				<form method="POST" name="foto" id="foto" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="">
						<p>
							<input class="dev-input dev-border dev-large dev-round-xlarge" type="file" name="foto">
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
				<h1 class="dev-border-bottom dev-text-grey" id="mais_fotos_do_produto" style="margin-bottom:0;">Mais Fotos</h1>
				<form method="POST" name="galeria" id="galeria" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="dev-padding" style="margin-left:-16px;margin-right:-16px">
						<p>
							<input class="dev-input dev-border dev-large dev-round-xlarge" type="file" name="galeria_produto[]" multiple>
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
		</div><!--Aqui Finaliza A Div para cadastro dos dados do produto-->
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
  $(".j_detalhes_do_produto > li > a").on('click', function(event) {

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
  
  $(".j_select_categoria").on("change", function()
	{
		var categoria_id = $(this).val();
		if(categoria_id)
		{
			$.ajax({
                method:	'POST',
                url: 	'<?php echo ROOT_URL?>categorias/retornaSubcategoriaseMarcas',
                data:	'categoria_id='+categoria_id,
				dataType: "JSON",
                success:	function(responseText)
				{
					if(responseText.status == "success")
					{
						$('.j_select_subcategoria').html(responseText.subcategorias);
						$('.j_select_marca').html(responseText.marcas);
					}
                },
				beforeSend : function()
				{
					$('.j_select_subcategoria').html('<option value="">Carregando...</option>');
				}
            }); 
		}else{
			$('.j_select_subcategoria').html('<option value="">Selecciona a categoria</option>');
		}
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
var theForm 		= document.getElementById("salva_produto");

window.frames["richTextField"].document.body.innerHTML 				= theForm.elements["descricao"].value;
window.frames["richTextField"].document.body.style.fontFamily 		= "Arial";
window.frames["richTextField"].document.body.style.fontSize 		= "18px";

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
$("#preco").maskMoney();
</script>
<script src="<?php echo ROOT_URL;?>assets/js/form.js"></script>
<script src="<?php echo ROOT_URL;?>assets/controllers/produto.js"></script>