<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>

<div class="dev-container">
	<div class="dev-row dev-row-padding" style="margin-bottom:15px;">
		<div class="dev-col l12">
			<div class="dev-panel dev-leftbar dev-white dev-card-2">
				<h2 class="dev-medium"><i class="fa fa-comment"></i> <?php echo $viewmodel['mensagens_mensagem']?></h2>
			</div>
				<div class="dev-panel dev-leftbar dev-white dev-card-2">
					<p class="">
						<i class="fa fa-envelope"></i> <?php echo $viewmodel['mensagens_email']?>&nbsp;
						 <i class="fa fa-phone"></i> <?php echo $viewmodel['mensagens_contacto']?>
					</p>
				</div>	
				<div class="dev-row-padding" style="margin-left:-15px;margin-right:-15px;margin-bottom:15px;">
					<div class="dev-half">
						<?php 
							$uteis = new Uteis;
							$uteis->query('SELECT * FROM galeria_imovel WHERE imovel_id = '.$viewmodel["imoveis_id"].'');
							$uteis->execute();
							echo '<div class="fotorama" data-nav="thumbs" data-max-height="400">';
							foreach($uteis->resultSet() as $rows)
							{								
								echo '<a href="'.ROOT_URL.'private/uploads/imoveis/'.$rows["nome"].'">
									<img src="'.ROOT_URL.'private/uploads/imoveis/'.$rows["nome"].'">
								</a>';								
							}
							echo '</div>';
						?>
					</div>
					<div class="dev-half">
						<div class="dev-panel dev-topbar dev-white dev-card-2">
							<p><i class="fa fa-check"></i> <?php echo $viewmodel['imoveis_nome']?></p> 
							<p><i class="fa fa-check"></i> <?php echo number_format($viewmodel['imoveis_preco'],2)." ".$viewmodel['imoveis_moeda']?></p>
							<p><i class="fa fa-check"></i> <?php echo $viewmodel['imoveis_endereco']?></p>
						</div>						
					</div>
				</div>
					
				<form name="enviar_mensagem" id="enviar_mensagem" class="dev-panel dev-topbar dev-white dev-card-2 dev-padding">
					<div style="width:100%" class="">
					<button type="button" onclick="execCmd('bold')"><i class="fa fa-bold"></i></button>
							<button type="button" onclick="execCmd('italic')"><i class="fa fa-italic"></i></button>
							<button type="button" onclick="execCmd('underline')"><i class="fa fa-underline"></i></button>
							<button type="button" onclick="execCmd('strikeThrough')"><i class="fa fa-strikethrough"></i></button>
							<button type="button" onclick="execCmd('justifyLeft')"><i class="fa fa-align-left"></i></button>
							<button type="button" onclick="execCmd('justifyRight')"><i class="fa fa-align-right"></i></button>
							<button type="button" onclick="execCmd('justifyCenter')"><i class="fa fa-align-center"></i></button>
							<button type="button" onclick="execCmd('justifyFull')"><i class="fa fa-align-justify"></i></button>
							<button type="button" onclick="execCmd('cut')"><i class="fa fa-cut"></i></button>
							<button type="button" onclick="execCmd('copy')"><i class="fa fa-copy"></i></button>
							<button type="button" onclick="execCmd('indent')"><i class="fa fa-indent"></i></button>
							<button type="button" onclick="execCmd('outdent')"><i class="fa fa-dedent"></i></button>
							<button type="button" onclick="execCmd('subscript')"><i class="fa fa-subscript"></i></button>
							<button type="button" onclick="execCmd('superscript')"><i class="fa fa-superscript"></i></button>
							<button type="button" onclick="execCmd('undo')"><i class="fa fa-undo"></i></button>
							<button type="button" onclick="execCmd('redo')"><i class="fa fa-repeat"></i></button>
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
							<button type="button" onclick="execCmdArgs('createlink',prompt('Informe a URL:', 'http://'))"><i class="fa fa-link"></i></button>
							<button type="button" onclick="execCmd('unlink')"><i class="fa fa-unlink"></i></button>
							<button type="button" onclick="execCmdArgs('insertImage',prompt('Informe a URL da Imagem:', ''))"><i class="fa fa-image"></i></button>
						</div>						
						<textarea style="display:none;" class="dev-input dev-border" name="descricao" id="descricao"></textarea>
						<iframe name="richTextField" id="richTextField" class="" style="border:#ddd 1px solid; width:100%; height:300px;background-color:#fff;"></iframe>	
						<input type="submit" class="dev-button dev-flat-belize-hole" name="" value="Enviar&nbsp; ❯">
				</form>
		</div>		
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
	#richTextField body{
		font-family:'Montserrat', sans-serif!important;
	}
</style>
<script type="text/javascript">
//criando um editor de text wysiwyg
var theForm = document.getElementById("enviar_mensagem");
window.frames["richTextField"].document.body.innerHTML = theForm.elements["descricao"].value;
window.frames["richTextField"].document.body.style.fontFamily = "'Montserrat', sans-serif";
window.frames["richTextField"].document.body.style.fontSize = "16px";
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