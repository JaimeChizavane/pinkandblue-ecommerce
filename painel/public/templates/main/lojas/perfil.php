<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:100%;width:1170px">
			<div class="dev-margin-bottom">
				<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> 
				<span class="dev-xlarge">Perfil</span>
			</div>
			<div class="dev-margin-bottom">
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_abre_editar_cliente" data-inserir="false"><i class="fa fa-pencil"></i> Editar</button>
			</div>
			<div class="dev-section dev-row-padding"  style="margin-right:-16px;margin-left:-16px">
				<div class="dev-col l3 dev-border dev-round-large" id="sticky">
					<?php include_once "cliente_menu.php";?>
				</div>
				<div class="dev-col l9 dev-right" id="main-content">	
					<h3 class="dev-light-grey dev-padding dev-margin-0 dev-large dev-border">Meu Perfil</label>
					</h3>					
					<table class="dev-table dev-border dev-bordered dev-small dev-margin-bottom">
						<tr>
							<td width="30%">Nome:</td> <td width="70%"><?php echo $data["lista_perfil"]["nome"]?></td>
						</tr>
						<tr>
							<td width="30%">Apelido:</td> <td width="70%"><?php echo $data["lista_perfil"]["apelido"]?></td>
						</tr>
						<tr>
							<td width="30%">Email:</td> <td width="70%"><?php echo $data["lista_perfil"]["email"]?></td>
						</tr>	
						<tr>	
							<td width="30%">Contacto:</td> <td width="70%"><?php echo $data["lista_perfil"]["contacto"]?></td>
						</tr>
					</table>
					<h3 class="dev-light-grey dev-padding dev-margin-0 dev-large dev-border">Mudar Senha</label>
					</h3>	
					<form class="dev-row-padding" name="mudar_senha" style="margin-right:-16px;margin-left:-16px;">
						<div class="dev-half">
							<label class="dev-margin-top" style="display:block">Senha</label>
							<input class="dev-input dev-border dev-round-large" id="senha" name="senha" value="" type="text" placeholder="Informe nova senha...">
						</div>
						<div class="dev-half">
							<label class="dev-margin-top" style="display:block">Confirmar Senha</label>
							<input class="dev-input dev-border dev-round-large" value="" id="confirmar_senha" name="confirmar_senha" type="text" placeholder="Confirmar nova senha...">
						</div>
						<div class="dev-half">
							<input type="submit" class="dev-btn dev-round-large dev-flat-alizarin dev-margin-top j_mudar_senha" value="Salvar">
						</div>
					</form>					
				</div>
			</div>
		</div>
	</div>	
	
	<div id="editar_cliente" class="dev-modal">
		<div class="dev-modal-content dev-animate-top dev-card-8 dev-border dev-round-xlarge">
			<header class="dev-container dev-border-bottom"> 
				<span class="dev-closebtn j_fecha_endereco_no_painel_cliente">×</span>
				<h2>Salvar Perfil</h2>
			</header>
			<div class="dev-container">
				<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Primeiro Nome</label>
						<input class="dev-input dev-border dev-round-large" id="primeiro_nome" name="primeiro_nome" value="<?php echo $data["lista_perfil"]["nome"]?>" type="text" placeholder="Informe Primeiro Nome...">
					</div>
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Apelido</label>
						<input class="dev-input dev-border dev-round-large" value="<?php echo $data["lista_perfil"]["apelido"]?>" id="apelido" name="apelido" type="text" placeholder="Informe apelido...">
					</div>
				</div>
				<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Email</label>
						<input class="dev-input dev-border dev-round-large" value="<?php echo $data["lista_perfil"]["email"]?>" id="email" name="email" type="text" placeholder="Informe email...">
					</div>
					
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Contacto</label>
						<input class="dev-input dev-border dev-round-large" value="<?php echo $data["lista_perfil"]["contacto"]?>" id="contacto" name="contacto" type="text" placeholder="Informe contacto...">
					</div>
				</div>
			</div>	
			<footer class="dev-container dev-border-top dev-margin-top dev-margin-bottom">
				<button class="dev-btn dev-round-large dev-flat-alizarin dev-margin-top j_editar_cliente" data-cliente_id="<?php echo $data["lista_perfil"]["id"]?>"><i class="fa fa-save"></i> Salvar</button>
				<button class="dev-btn dev-round-large dev-flat-alizarin dev-margin-top j_fecha_editar_cliente">Fechar</button>
			</footer>
		</div>
	</div>	
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script>
$(document).ready(function()
{
	$(".j_abre_editar_cliente").click(function(e)
	{	
		$("#editar_cliente").show();
	});
	
	$(".j_fecha_editar_cliente").click(function()
	{
		$("#editar_cliente").hide();
		$(".j_editar_cliente").prop("disabled",false).html('<i class="fa fa-save"></i> Salvar');
	});
	
	$(document).on("click",".j_editar_cliente",function(e)
	{
		e.preventDefault();
		var $this = $(this);
		$.ajax({
			url			: "<?php echo ROOT ?>cliente/editar_cliente",
			method 		: "POST",
			dataType 	: "JSON",
			data		: 
			{
				cliente_id		: $this.data("cliente_id"),
				primeiro_nome	: $("#primeiro_nome").val(),	
				apelido			: $("#apelido").val(),
				email			: $("#email").val(),
				contacto		: $("#contacto").val()
			},
			success		: function(responseTxt)
			{
				if(responseTxt.status == "success")
				{
					$this.prop("disabled",false).html('<i class="fa fa-save"></i> Salvar');
					$(location).attr("href","<?php echo ROOT ?>cliente/perfil");
				}				
			},
			beforeSend	: function()
			{
				$this.prop("disabled",true).text("Por favor aguarde..");				
			},
			complete	: function()
			{
				
			}
		});
	});
	
	$(document).on("click",".j_mudar_senha",function(e)
	{		
		var $senha 				= $("#senha");
		var $confirmar_senha 	= $("#confirmar_senha");
		var $this				= $(this);
		if($senha.val() == "")
		{
			$senha.css("outline","1px solid red").focus();			
			return false;
		}else
		{
			$senha.css("outline","none");
		}
		
		if($confirmar_senha.val() == "")
		{
			$confirmar_senha.css("outline","1px solid red");
			return false;
		}else
		{
			$confirmar_senha.css("outline","none");
		}
		
		if($senha.val() != $confirmar_senha.val())
		{
			$senha.css("outline","1px solid red").focus();	
			$confirmar_senha.css("outline","1px solid red").focus();
			return false;
		}else
		{
			$senha.css("outline","none");	
			$confirmar_senha.css("outline","none");
		}		
		
		$('form[name="mudar_senha"]').one('submit',function()
		{
			
			var dados = $(this).serialize()+'&accao=mudar_senha';
			$.ajax({
				url 		: '<?php echo ROOT?>cliente/mudar_senha',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText)
				{
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$this.prop("disabled",false);
						$this.val("Registar");
						$(location).attr("href","<?php echo ROOT?>cliente/perfil");
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$this.val("Por favor aguarde...");
					$this.prop("disabled",true);
				}
			});
			return false;
		});
		
	});
	
	if($("#sticky").length)
	{
		if($(window).innerWidth() < 990)
		{
			return false;
		}
		
		var el 				= $("#sticky");
		var stickyTop 		= el.offset().top;
		var stickyHeight 	= el.outerHeight();
		var stickyWidth 	= el.outerWidth();
		var contentHeight	= $("#main-content").outerHeight();
		
		if(contentHeight < stickyHeight)
		{
			return false;
		}
		
		$(window).scroll(function()
		{
			var limite = $("#footer").offset().top - stickyHeight - 15;
			var windowTop = $(window).scrollTop();
			
			if((stickyTop -15) < windowTop)
			{
				el.css({
					"position"	: "fixed",
					"top"		: "15px",
					"width"		: stickyWidth + "px"
				});
			}else
			{
				el.css({
					"position"	: "static",
					"width"		: "24.99999%"
				});
			}
			
			
			if((limite -15) < windowTop)
			{
				var  diff = limite - windowTop;
				console.log("limite : "+ limite+", windowTop : "+windowTop+", diff : "+ diff);
				
				el.css({
					"top"	: diff + "px"
				});
			}
			
		});		
	}
	
	
});
</script>	
<?php include_once "footer.php";?>	