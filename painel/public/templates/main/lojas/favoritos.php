<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
<div class="dev-section">
	<div class="dev-content dev-container" style="max-width:1170px;">
		<div class="dev-margin-bottom">
			<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> <span class="dev-xlarge">Favoritos</span>
		</div>
		<div class="dev-margin-bottom">
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_print_btn">
				<i class="fa fa-envelope"></i> Enviar por Email
			</button>
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_remove_favoritos">
				<i class="fa fa-trash"></i> Remover</button>
		</div>
		<div class="dev-section dev-row-padding" id="lista_produtos_por_categoria" style="margin-right:-16px;margin-left:-16px">
			<div class="dev-col l3 dev-border dev-round-large" id="sticky">
				<?php include_once "cliente_menu.php";?>
			</div>
			<div class="dev-col l9 dev-right"  id="main-content">
				<table class="dev-table dev-bordered dev-medium" id="">
						<thead>
							<th width="5%" style="cursor:pointer;padding-left:0"><input type="checkbox" class="dev-check dev-border j_action_check_to_all_favoritos"></th>
							<th width="30%" style="cursor:pointer;padding-left:0">Nome</th>
							<th width="15%" class="dev-right-align">Items</th>
							<th width="25%" class="dev-right-align">Total</th>
							<th width="25%" class="dev-center">Data</th>
						</thead>
						<?php foreach($data["lista_favorito"] as $favoritos):?>
							<tr>
								<td style="cursor:pointer;padding-left:0"><input type="checkbox" data-id="<?php echo $favoritos["id"]?>" class="dev-check dev-bfavorito j_action_check_favorito"></td>
								<td style="cursor:pointer;padding-left:0"><a href="<?php echo ROOT?>cliente/favorito/id/<?php echo $favoritos["id"]?>" class="dev-text-red"><?php echo $favoritos["nome"]?></a></td>
								<td class="dev-right-align"><?php echo $favoritos["items"]?></td>
								<td class="dev-right-align"><?php echo $favoritos["total"]?></td>
								<td class="dev-center"><?php echo date("d/m/Y",strtotime($favoritos["data_registo"]))?></td>
							</tr>
						<?php endforeach;?>
				</table>		
			</div>
		</div>
	</div>
</div>
<style>
	td{vertical-align:middle!important;font-size:1.2em;}
</style>
<script>
$(document).ready(function()
{
	var favorito_id 	= 	[];
	$(document).on("click",".j_action_check_to_all_favoritos",function()
	{
		let favorito		=	$(".j_action_check_favorito");
		if($(this).is(":checked"))
		{
			$(favorito).prop("checked",true);
		}else
		{
			$(favorito).prop("checked",false);
		}
		
		$(favorito).each(function(index, elemento)
		{
			if($(elemento).is(":checked"))
			{
				favorito_id.push($(this).data("id"));
			}			
		});	
		$(".j_remove_favoritos").html('<i class="fa fa-trash"></i> Remover<span class="dev-badge dev-white dev-margin-left">'+count_checked_favoritos(favorito)+'</span>');
	});	
	
	$(document).on("change",".j_action_check_favorito",function()
	{		
		let favorito		=	$(".j_action_check_favorito");
		$(favorito).each(function(index, elemento)
		{
			if($(elemento).is(":checked"))
			{
				favorito_id.push($(this).data("id"));
			}			
		});	
		
		$(".j_remove_favoritos").html('<i class="fa fa-trash"></i> Remover<span class="dev-badge dev-white dev-margin-left">'+count_checked_favoritos(favorito)+'</span>');
	});
	
	$(document).on("click",".j_remove_favoritos",function(e)
	{
		e.preventDefault();
		var $this = $(this);
		$.ajax({
			url			: "<?php echo ROOT ?>cliente/remover_favoritos",
			method 		: "POST",
			dataType 	: "JSON",
			data		: 
			{
				favorito_id		: favorito_id
			},
			success		: function(responseTxt)
			{
				if(responseTxt.status == "success")
				{
					$this.prop("disabled",false).html('<i class="fa fa-trash"></i> Remover');
					$(location).attr("href","<?php echo ROOT ?>cliente/favoritos");
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
	
	function count_checked_favoritos(className)
	{
		let i = 0;
		$(className).each(function(index, elemento)
		{
			if($(elemento).is(":checked"))
			{
				i++;
			}			
		});		
		return i;
	}
});
</script>		
<?php include_once "footer.php";?>	