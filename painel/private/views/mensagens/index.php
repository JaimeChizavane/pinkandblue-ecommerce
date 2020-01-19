<div class="dev-container">
	<div class="dev-border dev-white dev-padding dev-margin-bottom">
		
	</div>
	<div class="dev-responsive">
		<table class="dev-table-all" id="results">
			<thead>
				<tr>
				  <th width="40%">Mensagem</th>
				  <th width="30%">email</th>
				  <th width="20%">Data de Registo</th>
				  <th width="10%">&nbsp;</th>
				</tr>
			</thead>
		</table>	
	</div>	
</div>
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
			"sSearchPlaceholder" : "nome, codigo...",
			"paginate"		: {
				"first"			: "Primeiro",
				"last"			: "Ultimo",
				"next"			: "Proximo",
				"previous"		: "Anterior"
			}
		},
		'ajax'		 		: {
			'url' 			: "<?php echo ROOT_URL?>mensagens/listarMensagens/",
			'type' 			: 'POST'
		},
		"columnDefs":[
		   {
			"targets":[0, 2,  3],
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
});
</script>