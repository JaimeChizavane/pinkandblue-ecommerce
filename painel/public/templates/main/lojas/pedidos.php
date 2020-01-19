<?php include_once "header.php";?>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/fotorama/fotorama.css">
<script src="<?php echo ROOT_URL?>assets/fotorama/fotorama.js"></script>
<div class="dev-section">
	<div class="dev-content dev-container" style="max-width:1170px;">
		<div class="dev-margin-bottom">
			<a href="<?php echo ROOT ?>" class="dev-xlarge dev-text-red">Home / </a><a href="javascript:void(0)" class="dev-xlarge dev-text-red">Cliente / </a> <span class="dev-xlarge">Pedidos</span>
		</div>
		<div class="dev-margin-bottom">
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_print_btn">
				<i class="fa fa-envelope"></i> Enviar por Email
			</button>
			<button class="dev-btn dev-round-xlarge dev-flat-alizarin j_remove_orders">
				<i class="fa fa-trash"></i> Remover
			</button>
		</div>
		<div class="dev-section dev-row-padding" id="" style="margin-right:-16px;margin-left:-16px">
			<div class="dev-col l3 dev-border dev-round-large" id="sticky">
				<?php include_once "cliente_menu.php";?>
			</div>
			<div class="dev-col l9 dev-right"  id="main-content">
				<table class="dev-table dev-bordered dev-medium" id="">
						<thead>
							<th width="5%" style="cursor:pointer;padding-left:0"><input type="checkbox" class="dev-check dev-border j_action_check_to_all_orders"></th>
							<th width="30%" style="cursor:pointer;padding-left:0">Pedido Nº</th>
							<th width="5%" class="dev-right-align">Items</th>
							<th width="20%" class="dev-right-align">Total</th>							
							<th width="15%" class="dev-center">Data</th>
							<th width="15%" class="dev-center">Tipo de Pagamento</th>
							<th width="10%" class="dev-center">Estado</th>
						</thead>	
						<?php foreach($data["lista_pedidos"] as $pedidos):?>
							<tr>
								<td style="cursor:pointer;padding-left:0"><input type="checkbox" data-id="<?php echo $pedidos["id"]?>" class="dev-check dev-border j_action_check_order"></td>
								<td style="cursor:pointer;padding-left:0"><a href="<?php echo ROOT?>cliente/pedido/id/<?php echo $pedidos["id"]?>" class="dev-text-red"><?php echo $pedidos["ordem"]?></a></td>
								<td class="dev-right-align"><?php echo $pedidos["items"]?></td>
								<td class="dev-right-align"><?php echo $pedidos["total"]?></td>
								<td class="dev-center"><?php echo date("d/m/Y",strtotime($pedidos["data_registo"]));?></td>
								<td class="dev-center"><?php echo $pedidos["tipo_pagamento"]?></td>
								<td class="dev-center"><?php if($pedidos["estado"] == 1)echo "Finalizado"; else echo "Pendente";?></td>
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
	var pedido_id 	= 	[];
	$(document).on("click",".j_action_check_to_all_orders",function()
	{
		let order		=	$(".j_action_check_order");
		if($(this).is(":checked"))
		{
			$(order).prop("checked",true);
		}else
		{
			$(order).prop("checked",false);
		}
		
		$(order).each(function(index, elemento)
		{
			if($(elemento).is(":checked"))
			{
				pedido_id.push($(this).data("id"));
			}			
		});	
		$(".j_remove_orders").html('<i class="fa fa-trash"></i> Remover<span class="dev-badge dev-white dev-margin-left">'+count_checked_orders(order)+'</span>');
	});	
	
	$(document).on("change",".j_action_check_order",function()
	{		
		let order		=	$(".j_action_check_order");
		$(order).each(function(index, elemento)
		{
			if($(elemento).is(":checked"))
			{
				pedido_id.push($(this).data("id"));
			}			
		});	
		
		$(".j_remove_orders").html('<i class="fa fa-trash"></i> Remover<span class="dev-badge dev-white dev-margin-left">'+count_checked_orders(order)+'</span>');
	});
	
	$(document).on("click",".j_remove_orders",function(e)
	{
		e.preventDefault();
		var $this = $(this);
		$.ajax({
			url			: "<?php echo ROOT ?>cliente/remover_pedidos",
			method 		: "POST",
			dataType 	: "JSON",
			data		: 
			{
				pedido_id		: pedido_id
			},
			success		: function(responseTxt)
			{
				if(responseTxt.status == "success")
				{
					$this.prop("disabled",false).html('<i class="fa fa-trash"></i> Remover');
					$(location).attr("href","<?php echo ROOT ?>cliente/pedidos");
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
	
	function count_checked_orders(className)
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