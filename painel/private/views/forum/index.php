<div class="dev-container">
	<div class="dev-border dev-white dev-padding">
		<button class="dev-button dev-flat-alizarin j_delete_action"><i class="fa fa-trash"></i> Remover</button>
	</div>
	<div class="dev-responsive">
		<div class=" dev-panel dev-padding">
			<div class="dev-responsive">
				<table class="dev-table-all" id="results">
					<thead>
						<tr>
						  <th>Nome</th>
						  <th>Email</th>
						  <th>Contacto</th>
						  <th>codigo</th>
						  <th>Procura</th>
						  <th>Urgencia</th>
						  <th>Estado</th>
						  <th>Data</th>
						  <th>&nbsp;</th>
						</tr>
					</thead>	
					
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo ROOT_URL?>assets/js/export.js"></script>
<link rel="stylesheet" href="<?php echo ROOT_URL?>assets/js/export.css">
<script>
$(document).ready(function()
{
	var dataTable = $('#results').DataTable({
		'serverSide' 		: true,
		'processing' 		: true,
		"order"				: [],
		'language'			: {
			"lengthMenu"	: "Mostar _MENU_ por pagina",
			"zeroRecords"	: "Nenhum registo encontrado",
			"info"			: "Pagina _PAGE_/_PAGES_",
			"infoEmpty"		: "Tabela sem registos",
			"sInfoFiltered"	: " (_MAX_ resultados filtrados)",
			"sProcessing"	: "Por favor aguarde...",
			"sSearch"		: "Pesquisar:",
			"sSearchPlaceholder" : "nome, codigo...",
			"paginate"		: {
				"first"			: "Primeiro",
				"last"			: "Ultimo",
				"next"			: "Proximo",
				"previous"		: "Anterior"
			}
		},
		'ajax'		 		: {
			'url' 			: "<?php echo ROOT_URL?>forum/listarForum/",
			'type' 			: 'POST'
		},
		"columnDefs":[
		   {
			"targets":[1, 2,  4, 6, 8],
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
	
	$(document).on("click",".action",function()
	{
		var $this 				= $(".action");	
		var id					= [];
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
			$(".j_item_count").empty().text('('+id.length+') Linha(s) Seleccionada(s)...').fadeIn("fast");
		}else
		{
			$(".j_item_count").empty().fadeOut("fast");
		}
		store_get_filtered = get_filtered(id);			
	});
	
	$(document).on("click",".j_delete_action",function()
	{
		if(store_get_filtered.length > 0)
		{
			$.ajax({
				url 		: "<?php echo ROOT_URL?>forum/remover/",
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
						$(".action").each(function(index, elemt)
						{
							if($(this).is(":checked"))
							{
								$(this).parent().parent().remove();
							}
						});
						dataTable.ajax.reload();
						$(".j_item_count").fadeOut("fast");
					}
				},
				beforeSend	: function()
				{
					$(".j_delete_action").prop("disabled",true).text("Por favor aguarde...");				
				}
			});
		}		
	});

	$(document).on("click",".j_activar_action",function()
	{
		if(store_get_filtered.length > 0)
		{
			$.ajax({
				url 		: "<?php echo ROOT_URL?>forum/activar/",
				method 		: "POST",
				dataType 	: "JSON",
				data		: {
					accao	: "activar",
					id		: store_get_filtered
				},
				success		: function(responseText)
				{
					if(responseText.status == true)
					{
						$(".j_activar_action").prop("disabled",false).text("Activar");
						dataTable.ajax.reload();
						$(".j_item_count").fadeOut("fast");
					}
				},
				beforeSend	: function()
				{
					$(".j_activar_action").prop("disabled",true).text("Por favor aguarde...");				
				}
			});
		}		
	});
});
</script>	