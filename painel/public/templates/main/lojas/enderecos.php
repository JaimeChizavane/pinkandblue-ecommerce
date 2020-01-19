<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
	<div class="dev-section">
		<div class="dev-content dev-container" style="max-width:100%;width:1170px">
			<div class="dev-margin-bottom">
				<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> 
				<span class="dev-xlarge">Endereços</span>
			</div>
			<div class="dev-margin-bottom">
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_print_btn j_salva_endereco" data-inserir="true">
					<i class="fa fa-save"></i> Adicionar
				</button>
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_salva_endereco" data-inserir="false"><i class="fa fa-pencil"></i> Editar</button>
				<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_remove_enderecos" <?php if(count($data["lista_enderecos"]) <= 1) echo " disabled";?>><i class="fa fa-trash"></i> Remover</button>
			</div>
			<div class="dev-section dev-row-padding"  style="margin-right:-16px;margin-left:-16px">
				<div class="dev-col l3 dev-border dev-round-large" id="sticky">
					<?php include_once "cliente_menu.php";?>
				</div>
				<div class="dev-col l9 dev-right" id="main-content">								
					<?php 
						$i = 1;
						foreach($data["lista_enderecos"] as $lista_enderecos):?>
						<h3 class="dev-light-grey dev-padding dev-margin-0 dev-large dev-border">
							<input type="radio" 
								data-endereco_id 	= "<?php echo $lista_enderecos["id"]?>"
								data-cidade 		= "<?php echo $lista_enderecos["cidade"]?>"
								data-codigo_postal 	= "<?php echo $lista_enderecos["codigo_postal"]?>"
								data-endereco 		= "<?php echo $lista_enderecos["endereco"]?>"
							class="dev-radio dev-border dev-margin-right j_endereco_action" name="endereco" value="<?php echo $lista_enderecos["id"]?>" <?php if($lista_enderecos["padrao"] == 1) echo "checked"; ?> id="<?php echo $i?>"><?php echo $i?>º <label for="<?php echo $i?>">Endereço de Entrega <?php if($lista_enderecos["padrao"] == 1) echo "(Padrão)"; ?></label>
						</h3>
						
						<table class="dev-table dev-border dev-bordered dev-small dev-margin-bottom">
							<tr>
								<td width="30%">Cidade:</td> <td width="70%"><?php echo $lista_enderecos["cidade"]?></td>
							</tr>
							<tr>
								<td width="30%">Codigo Postal:</td> <td width="70%"><?php echo $lista_enderecos["codigo_postal"]?></td>
							</tr>	
							<tr>	
								<td width="30%">Endereço:</td> <td width="70%"><?php echo $lista_enderecos["endereco"]?></td>
							</tr>
						</table>
					<?php 
						$i++;
						endforeach;
					?>
				</div>			
				
			</div>
		</div>
	</div>	
	
	<div id="salvar_enderecos" class="dev-modal">
		<div class="dev-modal-content dev-animate-top dev-card-8 dev-border dev-round-xlarge">
			<header class="dev-container dev-border-bottom"> 
				<span class="dev-closebtn j_fecha_endereco_no_painel_cliente">×</span>
				<h2>Salvar Endereços</h2>
			</header>
			<div class="dev-container">
				<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Cidade</label>
						<input class="dev-input dev-border dev-round-large" id="cidade" name="cidade" type="text" placeholder="Informe Cidade...">
					</div>
					<div class="dev-half">
						<label class="dev-margin-top" style="display:block">Codigo Postal</label>
						<input class="dev-input dev-border dev-round-large" id="codigo_postal" name="codigo_postal" type="text" placeholder="Informe Codigo Postal...">
					</div>
				</div>
				<div class="dev-row-padding" style="margin-left:-16px;margin-right:-16px">
					<div class="dev-col l12">
						<label class="dev-margin-top" style="display:block">Endereço</label>
						<input class="dev-input dev-border dev-round-large" id="endereco" name="endereco" type="text" placeholder="Informe Endereço...">
					</div>
				</div>
			</div>	
			<footer class="dev-container dev-border-top dev-margin-top dev-margin-bottom">
				<button class="dev-btn dev-round-large dev-flat-alizarin dev-margin-top j_salva_endereco_no_painel_cliente"><i class="fa fa-save"></i> Salvar</button>
				<button class="dev-btn dev-round-large dev-flat-alizarin dev-margin-top j_fecha_endereco_no_painel_cliente">Fechar</button>
			</footer>
		</div>
	</div>	
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script>
$(document).ready(function()
{
	var endereco_id = 0;
	var inserir		= true;
	$(".j_salva_endereco").click(function(e)
	{
		inserir 			= $(this).data("inserir");
		var cidade			= $("#cidade");
		var codigo_postal	= $("#codigo_postal");
		var endereco		= $("#endereco");
		if(inserir == false)
		{
			$(".j_endereco_action").each(function(i, elem)
			{
				if($(elem).is(":checked"))
				{
					endereco_id = $(this).data("endereco_id");
					cidade.val($(this).data("cidade"));
					codigo_postal.val($(this).data("codigo_postal"));
					endereco.val($(this).data("endereco"));
				}				
			});
		}else
		{
			cidade.val($(this).data(""));
			codigo_postal.val($(this).data(""));
			endereco.val($(this).data(""));
		}		
		$("#salvar_enderecos").show();
	});
	
	$(".j_fecha_endereco_no_painel_cliente").click(function()
	{
		$("#salvar_enderecos").hide();
		$(".j_salva_endereco_no_painel_cliente").prop("disabled",false).html('<i class="fa fa-save"></i> Salvar');
	});
	
	$(document).on("click",".j_remove_enderecos",function(e)
	{
		e.preventDefault();
		var $this = $(this);
		$(".j_endereco_action").each(function(i, elem)
		{
			if($(elem).is(":checked"))
			{
				endereco_id = $(this).data("endereco_id");
			}				
		});
		
		if(endereco_id < 1)
		{			
			return false;
		}
		
		$.ajax({
			url			: "<?php echo ROOT ?>cliente/remover_enderecos",
			method 		: "POST",
			dataType 	: "JSON",
			data		: 
			{
				endereco_id		: endereco_id
			},
			success		: function(responseTxt)
			{
				if(responseTxt.status == "success")
				{
					$this.prop("disabled",false).html('<i class="fa fa-trash"></i> Remover');
					$(location).attr("href","<?php echo ROOT ?>cliente/enderecos");
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
	
	$(document).on("click",".j_salva_endereco_no_painel_cliente",function(e)
	{
		e.preventDefault();
		var $this = $(this);
		$.ajax({
			url			: "<?php echo ROOT ?>cliente/salvar_enderecos",
			method 		: "POST",
			dataType 	: "JSON",
			data		: 
			{
				endereco_id		: endereco_id,	
				cidade			: $("#cidade").val(),
				codigo_postal	: $("#codigo_postal").val(),
				endereco		: $("#endereco").val(),
				inserir			: inserir
			},
			success		: function(responseTxt)
			{
				if(responseTxt.status == "success")
				{
					$this.prop("disabled",false).html('<i class="fa fa-save"></i> Salvar');
					$(location).attr("href","<?php echo ROOT ?>cliente/enderecos");
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