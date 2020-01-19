<div class="dev-container">	
	<?php 
		$uteis 		= new Uteis;
		$id 		= (int) $_GET['id'];
		$uteis->query('SELECT * FROM categorias WHERE id =:id');
		$uteis->bind(':id',$id);
		$uteis->execute();
		$viewmodel 	= $uteis->single();
		$id			= $_GET["id"];
	?>
	<div class="dev-row-padding dev-margin-bottom" style="">
		<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
			<div class="dev-bar-block dev-animate-right" id="categorias" >
				<div class="dev-bar-item dev-border-bottom dev-white">Categorias - Salvar</div>
				<ul class="dev-ul dev-hoverable dev-large j_detalhes_da_categoria">		
					<li style="padding:0;"><a href="#descricao_da_categoria" class="dev-bar-item dev-large">Descrição</a></li>
					<li style="padding:0;"><a href="#foto_principal_da_categoria" class="dev-bar-item dev-large">Foto Principal</a></li>
				</ul>	
			</div>	
		</div>
		<div class="dev-main" style="margin-left:270px;"><!--Aqui Inicia A Div para cadastro dos dados da Categoria-->			
			<div class="dev-border dev-white dev-padding">
				<h1 class="dev-border-bottom dev-text-grey" id="descricao_da_categoria" style="margin-bottom:0;">Descrição</h1>
				<form name="salva_categoria" class="" style="margin-top:0;margin-bottom:0;" method="POST" id="salva_categoria" action="<?php $_SERVER["PHP_SELF"];?>">
					<div class="dev-row-padding">
						<input type="hidden" value="<?php echo $id;?>" name="id">
						<p>
							<label class="dev-large" for="nome">Nome</label>
							<input class="dev-input dev-border dev-large dev-round-large" type="text" name="nome" id="nome" value="<?php echo $viewmodel["nome"]?>" placeholder="Informe o nome da Categoria" required>
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
							<iframe name="richTextField" id="richTextField" style="border:#ddd 1px solid; width:100%; height:300px;background-color:#fff;" class="dev-border dev-round-xlarge"></iframe>					
					</div>	
					
					<div class="dev-row-padding" style="padding:0;">
						<div class="dev-half">
							<p>
								<label class="dev-large" for="tipo">Tipo</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="tipo" id="tipo" required>
									<option value="" disabled selected>Informe o tipo de categoria</option>
									<option value="imovel" <?php if($viewmodel["tipo"] == "imovel") echo "selected";?>>Imovel</option>
									<option value="automovel" <?php if($viewmodel["tipo"] == "automovel") echo "selected";?>>Automovel</option>
									<option value="produto" <?php if($viewmodel["tipo"] == "produto") echo "selected";?>>Produto</option>
									<option value="blog" <?php if($viewmodel["tipo"] == "blog") echo "selected";?>>Blog</option>
								</select>
							</p>
						</div>
						<div class="dev-half">
							<p>
								<label class="dev-large" for="status">Status</label>
								<select class="dev-select dev-border dev-large dev-round-xlarge" name="status" id="status" required>
									<option value="" disabled selected>Informe o status da Categoria</option>
									<option value="1" <?php if($viewmodel["status"] == 1) echo "selected";?>>Activo</option>
									<option value="0" <?php if($viewmodel["status"] == 0) echo "selected";?>>Não Activo</option>
								</select>
							</p>
						</div>
					</div>
					<p class="j_categoria">
						<input type="submit" class="dev-button dev-flat-belize-hole j_salva_categoria" name="salvar_contacto" value="Salvar&nbsp; ❯">
						<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
						<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 					
					</p>
				</form>
								
				<div class="dev-white" style="padding-top:0;">
					<h1 class="dev-border-bottom dev-text-grey" id="foto_principal_da_categoria" style="margin-bottom:0;margin-top:0;">Foto Principal</h1>
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
			</div>					
		</div><!--Aqui Finaliza A Div para cadastro dos dados da Categoria-->
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
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $(".j_detalhes_da_categoria > li > a").on('click', function(event) {

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
var theForm = document.getElementById("salva_categoria");
window.frames["richTextField"].document.body.innerHTML = theForm.elements["descricao"].value;
window.frames["richTextField"].document.body.style.fontFamily 		= "Arial";
window.frames["richTextField"].document.body.style.fontSize 		= "18px";
enableEditMode();
function enableEditMode(){
	richTextField.document.designMode = 'on';
}

function execCmd(cmd){
	richTextField.document.execCommand(cmd,false,null);
}
function execCmdArgs(cmd,value){
	richTextField.document.execCommand(cmd,false,value);
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
</script>
<script src="<?php echo ROOT_URL;?>assets/js/form.js"></script>
<script src="<?php echo ROOT_URL;?>assets/controllers/categoria.js"></script>