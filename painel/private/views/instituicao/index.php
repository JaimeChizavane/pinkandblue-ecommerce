<div class="dev-container">		
	<div class="dev-row-padding dev-margin-bottom" style="">
		<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
			<div class="dev-sidebar dev-collapse dev-border dev-grey" style="z-index:43;width:270px;" >
				<div class="dev-bar-block dev-animate-right" id="imoveis" >
					<div class="dev-bar-item dev-border-bottom dev-white">Instituição</div>
					<div class="dev-bar-item dev-border-bottom">Dados do Instituição</div>
					<ul class="dev-ul dev-hoverable dev-large j_detalhes_da_instituicao">		
						<li style="padding:0;"><a href="#descricao_da_instituicao" class="dev-bar-item dev-small">Dados da Instituição</a></li>
						<li style="padding:0;"><a href="#mapa_da_instituicao" class="dev-bar-item dev-small">Mapa</a></li>
						<li style="padding:0;"><a href="#logotipo_da_instituicao" class="dev-bar-item dev-small">Logotipo</a></li>
						<li style="padding:0;"><a href="#redes_sociais_da_instituicao" class="dev-bar-item dev-small">Redes Sociais</a></li>
					</ul>	
				</div>	
			</div>
		</div>
		<div class="dev-main" style="margin-left:270px;"><!--Aqui Inicia A Div para cadastro dos dados do Imovel-->			
			<div class="dev-border dev-white dev-padding">
				<h1 class="dev-border-bottom dev-text-grey" id="descricao_da_instituicao" style="margin-bottom:0;">Dados da Instituição</h1>
				<label class="dev-text-grey">Quem somos</label>
				<form name="salva_instituicao" class="dev-white" style="margin-top:0;margin-bottom:0;" method="POST" id="salva_instituicao" action="">
					<div class="" style="width:100%;">
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
					<textarea class="dev-input dev-border" style="display:none;" name="quem_somos" id="quem_somos"  style="height: 222px; width: 100%;">
						<?php echo $viewmodel['quem_somos']?>
					</textarea>
					<iframe name="richTextField" id="richTextField" style="border:#ddd 1px solid; width:100%; height:300px;background-color:#fff;"></iframe>    
					<label class="dev-text-grey">Missão</label>
					<div class="" style="width:100%;">
						<button type="button" onclick="execCmd1('bold')"><i class="fa fa-bold"></i></button>
						<button type="button" onclick="execCmd1('italic')"><i class="fa fa-italic"></i></button>
						<button type="button" onclick="execCmd1('underline')"><i class="fa fa-underline"></i></button>
						<button type="button" onclick="execCmd1('strikeThrough')"><i class="fa fa-strikethrough"></i></button>
						<button type="button" onclick="execCmd1('justifyLeft')"><i class="fa fa-align-left"></i></button>
						<button type="button" onclick="execCmd1('justifyRight')"><i class="fa fa-align-right"></i></button>
						<button type="button" onclick="execCmd1('justifyCenter')"><i class="fa fa-align-center"></i></button>
						<button type="button" onclick="execCmd1('justifyFull')"><i class="fa fa-align-justify"></i></button>
						<button type="button" onclick="execCmd1('cut')"><i class="fa fa-cut"></i></button>
						<button type="button" onclick="execCmd1('copy')"><i class="fa fa-copy"></i></button>
						<button type="button" onclick="execCmd1('indent')"><i class="fa fa-indent"></i></button>
						<button type="button" onclick="execCmd1('outdent')"><i class="fa fa-dedent"></i></button>
						<button type="button" onclick="execCmd1('subscript')"><i class="fa fa-subscript"></i></button>
						<button type="button" onclick="execCmd1('superscript')"><i class="fa fa-superscript"></i></button>
						<button type="button" onclick="execCmd1('undo')"><i class="fa fa-undo"></i></button>
						<button type="button" onclick="execCmd1('redo')"><i class="fa fa-repeat"></i></button>
						<button type="button" onclick="execCmd1('insertUnorderedList')"><i class="fa fa-list-ul"></i></button>
						<button type="button" onclick="execCmd1('insertOrderedList')"><i class="fa fa-list-ol"></i></button>
						<button type="button" onclick="execCmd1('insertParagraph')"><i class="fa fa-paragraph"></i></button>
						<select onchange="execCmdArgs1('fontSize',this.value)">	
							<option value="1">6</option>
							<option value="2">8</option>
							<option value="3">10</option>
							<option value="4">12</option>
							<option value="5">14</option>
							<option value="6">16</option>
							<option value="7">20</option>
						</select>
						<select onchange="execCmdArgs1('formatBlock',this.value)">	
							<option value="H1">H1</option>
							<option value="H2">H2</option>
							<option value="H3">H3</option>
							<option value="H4">H4</option>
							<option value="H5">H5</option>
							<option value="H6">H6</option>
						</select>
						<button type="button" onclick="execCmdArgs1('createlink',prompt('Informe a URL:', 'http://'))"><i class="fa fa-link"></i></button>
						<button type="button" onclick="execCmd1('unlink')"><i class="fa fa-unlink"></i></button>
						<button type="button" onclick="execCmdArgs1('insertImage',prompt('Informe a URL da Imagem:', ''))"><i class="fa fa-image"></i></button>
					</div>
					<textarea class="dev-input dev-border" style="display:none;" name="missao" id="missao"  style="height: 222px; width: 100%;">
						<?php echo $viewmodel['missao']?>
					</textarea>
					<iframe name="richTextField1" id="richTextField1" style="border:#ddd 1px solid; width:100%; height:300px;background-color:#fff;"></iframe>
					<label class="dev-text-grey">Visão</label>
					<div class="" style="width:100%;">
						<button type="button" onclick="execCmd2('bold')"><i class="fa fa-bold"></i></button>
						<button type="button" onclick="execCmd2('italic')"><i class="fa fa-italic"></i></button>
						<button type="button" onclick="execCmd2('underline')"><i class="fa fa-underline"></i></button>
						<button type="button" onclick="execCmd2('strikeThrough')"><i class="fa fa-strikethrough"></i></button>
						<button type="button" onclick="execCmd2('justifyLeft')"><i class="fa fa-align-left"></i></button>
						<button type="button" onclick="execCmd2('justifyRight')"><i class="fa fa-align-right"></i></button>
						<button type="button" onclick="execCmd2('justifyCenter')"><i class="fa fa-align-center"></i></button>
						<button type="button" onclick="execCmd2('justifyFull')"><i class="fa fa-align-justify"></i></button>
						<button type="button" onclick="execCmd2('cut')"><i class="fa fa-cut"></i></button>
						<button type="button" onclick="execCmd2('copy')"><i class="fa fa-copy"></i></button>
						<button type="button" onclick="execCmd2('indent')"><i class="fa fa-indent"></i></button>
						<button type="button" onclick="execCmd2('outdent')"><i class="fa fa-dedent"></i></button>
						<button type="button" onclick="execCmd2('subscript')"><i class="fa fa-subscript"></i></button>
						<button type="button" onclick="execCmd2('superscript')"><i class="fa fa-superscript"></i></button>
						<button type="button" onclick="execCmd2('undo')"><i class="fa fa-undo"></i></button>
						<button type="button" onclick="execCmd2('redo')"><i class="fa fa-repeat"></i></button>
						<button type="button" onclick="execCmd2('insertUnorderedList')"><i class="fa fa-list-ul"></i></button>
						<button type="button" onclick="execCmd2('insertOrderedList')"><i class="fa fa-list-ol"></i></button>
						<button type="button" onclick="execCmd2('insertParagraph')"><i class="fa fa-paragraph"></i></button>
						<select onchange="execCmdArgs2('fontSize',this.value)">	
							<option value="1">6</option>
							<option value="2">8</option>
							<option value="3">10</option>
							<option value="4">12</option>
							<option value="5">14</option>
							<option value="6">16</option>
							<option value="7">20</option>
						</select>
						<select onchange="execCmdArgs2('formatBlock',this.value)">	
							<option value="H1">H1</option>
							<option value="H2">H2</option>
							<option value="H3">H3</option>
							<option value="H4">H4</option>
							<option value="H5">H5</option>
							<option value="H6">H6</option>
						</select>
						<button type="button" onclick="execCmdArgs2('createlink',prompt('Informe a URL:', 'http://'))"><i class="fa fa-link"></i></button>
						<button type="button" onclick="execCmd2('unlink')"><i class="fa fa-unlink"></i></button>
						<button type="button" onclick="execCmdArgs2('insertImage',prompt('Informe a URL da Imagem:', ''))"><i class="fa fa-image"></i></button>
					</div>
					<textarea class="dev-input dev-border" style="display:none;" name="visao" id="visao"  style="height: 222px; width: 100%;">
						<?php echo $viewmodel['visao']?>
					</textarea>
					<iframe name="richTextField2" id="richTextField2" style="border:#ddd 1px solid; width:100%; height:300px;background-color:#fff;"></iframe>  
					<label class="dev-text-grey">Localização</label>
					<input class="dev-input dev-border" name="localizacao" id="localizacao" value="<?php echo $viewmodel['localizacao']?>" type="text">
						<p>      
							<label class="dev-text-grey">Email</label>
							<input class="dev-input dev-border" name="email" value="<?php echo $viewmodel['email']?>" type="text">
						</p>
						<p>      
							<label class="dev-text-grey">Contacto</label>
							<input class="dev-input dev-border" name="contacto" value="<?php echo $viewmodel['contacto']?>" type="text">
						</p>
						<p class="j_instituicao">
							<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
							<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span> 
							<input type="submit" class="dev-button dev-flat-belize-hole  j_salva_instituicao" name="" value="Salvar&nbsp; ❯">
						</p>
				</form>
				<h1 class="dev-border-bottom dev-text-grey" id="mapa_da_instituicao" style="margin-bottom:0;">Mapa</h1>
				<form name="salva_instituicao_mapa" method="POST" style="margin-top:0;margin-bottom:0;" class="salva_imovel_mapa dev-white" id="salva_imovel_mapa">
					<p>
						<input class="dev-input dev-border" name="endereco" id="txtEndereco"   value="<?php echo $viewmodel['localizacao']?>" type="hidden">
					</p>	
					<p>
						<input type="button" class="dev-button dev-flat-belize-hole" id="btnEndereco" class="btn" name="btnEndereco" value="Mostrar Endereço no mapa" />
					</p>
					<div id="mapa"></div>                    
                    <input type="hidden" id="txtLatitude" name="latitude" value="<?php echo $viewmodel['latitude']?>"/>
                    <input type="hidden" id="txtLongitude" name="longitude" value="<?php echo $viewmodel['longitude']?>" />
					<p class="j_imovel_mapa">
						<input type="submit" class="dev-button dev-flat-belize-hole j_salva_imovel_mapa" name="salvar_imovel_mapa" value="Salvar&nbsp; ❯">
						<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
						<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 					
					</p>
				</form>					
				<h1 class="dev-border-bottom dev-text-grey" id="descricao_do_imovel" style="margin-bottom:0;">Logo da Instituição</h1>
				<form method="POST" name="logo" id="logotipo_da_instituicao" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<div class="dev-row-padding">
						<p>
							<input class="dev-input dev-border" type="file" name="logo">
						</p>
						
						<p class="j_logo">
							<input type="submit" class="dev-button dev-flat-belize-hole  j_salva_logo" name="salvar_logo" value="Salvar&nbsp; ❯">
							<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
							<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span>						
						</p>
					</div>
				</form>

				<div class="dev-row-padding logo">
					<span><i class="fa fa-spinner dev-spin" style="font-size:70px"></i></span>
				</div>
				<h1 class="dev-border-bottom dev-text-grey" id="redes_sociais_da_instituicao" style="margin-bottom:0;">Redes sociais da Instituição</h1>
				<form method="POST" name="salva_instituicao_redes" id="salva_instituicao_redes" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<p>      
						<label class="dev-text-grey">Facebook</label>
						<input class="dev-input dev-border" name="facebook" value="<?php echo $viewmodel['facebook']?>" type="text">
					</p>
					
					<p>      
						<label class="dev-text-grey">Google Plus</label>
						<input class="dev-input dev-border" name="google" value="<?php echo $viewmodel['google']?>" type="text">
					</p>
					
					<p>      
						<label class="dev-text-grey">Twitter</label>
						<input class="dev-input dev-border" name="twitter" value="<?php echo $viewmodel['twitter']?>" type="text">
					</p>
					
					<p>      
						<label class="dev-text-grey">Youtube</label>
						<input class="dev-input dev-border" name="youtube" value="<?php echo $viewmodel['youtube']?>" type="text">
					</p>
					
					<p>      
						<label class="dev-text-grey">Instagram</label>
						<input class="dev-input dev-border" name="instagram" value="<?php echo $viewmodel['instagram']?>" type="text">
					</p>
					<p class="j_instituicao_redes">
						<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
						<span class="j_done" style="display:none;"><i class="fa fa-check" style="font-size:30px"></i></span> 
						<input type="submit" class="dev-button dev-flat-belize-hole  j_salva_instituicao_redes" name="" value="Salvar&nbsp; ❯">
					</p>
				</form>
			</div>	
		</div><!--Aqui Finaliza A Div para cadastro dos dados do Imovel-->
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
	.remove_icon_image{
		position:absolute;
		top:.4em;
		right:.4em;
		z-index:1;
		background-color:#fff;
		padding:.5em;
		border:1px solid #ddd;
		cursor:pointer;
	}
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDNzbw5cYdq47c_ZaC7I1mwE9CujmQ1dlw"></script>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/controllers/mapa.js"></script>
<script src="<?php echo ROOT_URL;?>assets/js/form.js"></script>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/js/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/js/jquery-ui.js"></script>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $(".j_detalhes_da_instituicao > li > a").on('click', function(event) {

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
<script type="text/javascript">
<?php if($viewmodel['latitude'] && $viewmodel['longitude']):?>
	var mapa = document.getElementById("mapa");
	function initialize(){
		var latlng = new google.maps.LatLng(<?php echo $viewmodel['latitude']?>,<?php echo $viewmodel['longitude']?>);
		var options = {
			zoom: 16,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		map = new google.maps.Map(mapa, options);
		
		geocoder = new google.maps.Geocoder();
		
		marker = new google.maps.Marker({
			map: map,
			draggable: true,
		});								
		marker.setPosition(latlng);
	}
	window.addEventListener("load",initialize);
<?php endif;?>
//criando um editor de text wysiwyg
//criando um editor de text wysiwyg para quem somos
var theForm = document.getElementById("salva_instituicao");
window.frames["richTextField"].document.body.innerHTML = theForm.elements["quem_somos"].value;
window.frames["richTextField"].document.body.style.fontFamily = "Montserrat, Arial, Helvetica, sans-serif";
enableEditMode();
enableEditMode1();
enableEditMode2();
function enableEditMode(){
	richTextField.document.designMode = 'on';
}

function execCmd(cmd){
	richTextField.document.execCommand(cmd,false,null);
}
function execCmdArgs(cmd,value){
	richTextField.document.execCommand(cmd,false,value);
}

//Editor para missao
var theForm = document.getElementById("salva_instituicao");
window.frames["richTextField1"].document.body.innerHTML = theForm.elements["missao"].value;
window.frames["richTextField1"].document.body.style.fontFamily = "Montserrat, Arial, Helvetica, sans-serif";
function enableEditMode1(){
	richTextField1.document.designMode = 'on';
}

function execCmd1(cmd){
	richTextField1.document.execCommand(cmd,false,null);
}
function execCmdArgs1(cmd,value){
	richTextField1.document.execCommand(cmd,false,value);
}

//Editor para visao
var theForm = document.getElementById("salva_instituicao");
window.frames["richTextField2"].document.body.innerHTML = theForm.elements["visao"].value;
window.frames["richTextField2"].document.body.style.fontFamily = "Montserrat, Arial, Helvetica, sans-serif";
function enableEditMode2(){
	richTextField2.document.designMode = 'on';
}

function execCmd2(cmd){
	richTextField2.document.execCommand(cmd,false,null);
}
function execCmdArgs2(cmd,value){
	richTextField2.document.execCommand(cmd,false,value);
}
$(document).ready(function(evt){
	$('#localizacao').on('keydown keypress keyup',function()
	{
		$('#txtEndereco').val($(this).val());
	});
});
</script>
<script type="text/javascript" src="<?php echo ROOT_URL;?>assets/controllers/instituicao.js"></script>