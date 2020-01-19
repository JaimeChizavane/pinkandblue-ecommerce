<div class="dev-container">
	<div class="dev-border dev-white dev-padding dev-margin-bottom">
		<div class="dev-col l3">
				<h1 class="dev-large dev-margin-0"><i class="fa fa-tag"></i> Subcategorias - Home</h1>
		</div>
		<div class="dev-col l9">
			<button class="btn dev-padding"><i class="fa fa-plus"></i> Acção</button>
			<div class="dropdown">
			  <button class="btn dev-padding" style="border-left:1px solid navy">
				<i class="fa fa-caret-down"></i>
			  </button>
			  <div class="dropdown-content">
				<a href="#" class="j_cria_nova_marca" data-tipo="<?php echo $_GET["tipo"]?>">Adicionar Nova</a>
				<a href="#">Adicionar em Bulk</a>
			  </div>
			</div>
		</div>
	</div>
	<div class="dev-responsive">
		<table class="dev-table-all" id="results">
			<thead>
				<tr>
					<th>Marca</th>
					<th>Categoria</th>
					<th>Total</th>
					<th>Status</th>
					<th>Data do Registo</th>
					<th>&nbsp;</th>
				</tr>
			</thead>			
		</table>
	</div>
</div>
<div class="dev-display-middle dev-border dev-padding-64 dev-white dev-round j_delete_popup" style="width:300px;display:none">
	<div class="dev-padding dev-center">
		<p class="dev-large j_delete_item_count"></p>
		<p>Deseja realmente remover as informacoes seleccionadas do sistema?</p>
		<button class="dev-button dev-flat-alizarin dev-block j_delete_action">Apagar</button>
	</div>
</div>
<style>
	/* Dropdown Button */
.btn {
  background-color: #2980b9;
  color: white;
  font-size: 16px;
  border: none;
  outline: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: absolute;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #fff;
  border:1px solid #ccc;
  min-width: 160px;
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 5px 10px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.btn:hover, .dropdown:hover .btn  {
  background-color: #0b7dda;
}
</style>
<script src="<?php echo ROOT_URL?>assets/js/export.js"></script>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/js/export.css">
<script>
$(document).ready(function()
{
	$('#results').DataTable({
		'serverSide' 		: true,
		'processing' 		: true,
		"order"				: [],
		'language'			: {
			"lengthMenu"	: "Mostar _MENU_ por pagina",
			"zeroRecords"	: "Nenhum registo encontrado",
			"info"			: "Pagina _PAGE_/_PAGES_",
			"sInfoFiltered"	: " (_MAX_ resultados filtrados)",
			"infoEmpty"		: "Tabela sem registos",
			"sProcessing"	: "Por favor aguarde...",
			"sSearch"		: "Pesquisar:",
			"sSearchPlaceholder" : "nome do marca...",
			"paginate"		: {
				"first"			: "Primeiro",
				"last"			: "Ultimo",
				"next"			: "Proximo",
				"previous"		: "Anterior"
			}
		},
		'ajax'		 		: {
			'url' 			: "<?php echo ROOT_URL?>marcas/listarMarcas/",
			'type' 			: 'POST',
			'data'			: {
				'tipo'		: "<?php echo $_GET["tipo"]?>"
			}
		},
		"columnDefs":[
		   {
			"targets":[1, 3,  4],
			"orderable":false,
		   }],
		"dom": 'lBfrtip',
		"buttons": [
            {
                extend: 'collection',
                text: 'Exportar',
                buttons: [
                    'excel',
                    'csv',
                    'pdf'
                ]
            }
        ]	
	});	
	
	var store_get_filtered;
	function get_filtered(param)
	{
		return param;
	}	
	
	$(document).on("click",".delete",function()
	{
		if($(".j_delete_action").is(":disabled"))
		{
			return false;
		}
		var $this 				= $(".delete");	
		var id					= [];
		var $j_delete_popup		= $(".j_delete_popup");
		$this.each(function(index, elemt)
		{
			if($(this).is(":checked"))
			{
				$(this).parent().parent().addClass('dev-yellow');
				id.push($(this).attr("id"));
			}else
			{
				$(this).parent().parent().removeClass('dev-yellow');
			}
		});
		if(id.length > 0)
		{
			$j_delete_popup.fadeIn("fast", function()
			{
				$(".j_delete_item_count").empty().text('('+id.length+') Linha(s) Seleccionada(s)...')
			});
		}else
		{
			$j_delete_popup.fadeOut("fast");
		}
		store_get_filtered = get_filtered(id);		
	});
	
	$(document).on("click",".j_delete_action",function()
	{
		$.ajax({
			url 		: "<?php echo ROOT_URL?>marcas/removerMarcas/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: {
				accao	: "delete",
				id		: store_get_filtered
			},
			success		: function(responseText)
			{
				if(responseText.status == true)
				{
					$(".j_delete_action").prop("disabled",false).text("Apagar");
					$(".delete").each(function(index, elemt)
					{
						if($(this).is(":checked"))
						{
							$(this).parent().parent().remove();
						}
					});
					$(".j_delete_popup").fadeOut("fast");
				}
			},
			beforeSend	: function()
			{
				$(".j_delete_action").prop("disabled",true).text("Por favor aguarde...");				
			}
		});
	});
});
</script>
<script src="<?php echo ROOT_URL;?>assets/controllers/marca.js"></script>