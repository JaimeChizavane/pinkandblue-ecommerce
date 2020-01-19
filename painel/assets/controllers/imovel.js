$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	var url = $('meta[name="url"]').attr("content");
	$(document).on('click','.j_cria_novo_imovel', function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "imoveis/novo",
			{
				accao : "criar_novo_imovel"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "imoveis/salvar/" + responseText.novo_imovel);
				}					
			},"JSON"
		)
	});
	
	function triggerSaveEditor(){
		var theForm = $("#salva_imovel");
		var frameVAL =  $("#richTextField" ).contents().find( "body").html();
		$('#descricao').val(frameVAL);
	}
	
	//Funcao para salvar os dados do imovel
	$('.j_salva_imovel').click(function(){
		$('form[name="salva_imovel"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_imovel';
			$.ajax({
				url 		: url+'imoveis/salvar',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_imovel .j_loading').fadeOut('fast',function(){
						$('.j_imovel .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_imovel').val('Salvar');
							$('.j_salva_imovel').prop("disabled",false);
						});
							$('.j_salva_imovel').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_imovel .j_loading').fadeIn('fast',function(){
						$('.j_salva_imovel').prop("disabled",true);
						$('.j_salva_imovel').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
	
	//Funcao para salvar os dados do imovel
	$('.j_salva_imovel_mapa').click(function(){
		$('form[name="salva_imovel_mapa"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_mapa';
			$.ajax({
				url 		: url+'imoveis/salvarMapa',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_imovel_mapa .j_loading').fadeOut('fast',function(){
						$('.j_imovel_mapa .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_imovel_mapa').val('Salvar');
							$('.j_salva_imovel_mapa').prop("disabled",false);
						});
							$('.j_salva_imovel_mapa').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_imovel_mapa .j_loading').fadeIn('fast',function(){
						$('.j_salva_imovel_mapa').prop("disabled",true);
						$('.j_salva_imovel_mapa').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
	
	//Funcao para salvar a fotom Principal do imovel
	$('.j_salva_foto').click(function()
	{
		$('form[name="foto"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'imoveis/uploadfoto',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: {accao : 'uploadfoto'},
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('#foto')[0].reset();
						$('.j_foto .j_loading').fadeOut('fast',function(){
						$('.j_foto .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_foto').val('Salvar');
							$('.j_foto .j_salva_foto').prop("disabled",false);
						});
							$('.j_salva_foto').val('Concluido....');
						});
						retornafoto();
					}
				},
				complete 		: function(){

				},
				beforeSubmit 	: function(){
					$('.j_foto .j_loading').fadeIn('fast',function(){
						$('.j_foto .j_salva_foto').prop("disabled",true);
						$('.j_foto .j_salva_foto').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});

	//Funcao para salvar a fotom Galeria do imovel
	$('.j_salva_galeria').click(function()
	{
		$('form[name="galeria"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'imoveis/uploadGaleria',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: {accao : 'uploadGaleria'},
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success"){
						$('#galeria')[0].reset();
						$('.j_galeria .j_loading').fadeOut('fast',function(){
						$('.j_galeria .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_galeria').val('Salvar');
							$('.j_galeria .j_salva_galeria').prop("disabled",false);
							retornaGaleria();
						});
							$('.j_salva_galeria').val('Concluido....');
						});
					}
				},
				complete 		: function(){

				},
				beforeSubmit 	: function(){
					$('.j_galeria .j_loading').fadeIn('fast',function(){
						$('.j_galeria .j_salva_galeria').prop("disabled",true);
						$('.j_galeria .j_salva_galeria').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});

	//funcao para remover foto principal
	$(document).on('click','.remove_icon_foto',function()
	{
		$.post(
			url+'imoveis/removefoto',
			{
				url 	: $(this).data('url'),
				id   	: $(this).data('id')
			},
			function(responseText){
				if(responseText.status == "success"){
					$('#foto_'+responseText.id+'').remove();
				}
			},
			"JSON"
		)
	});
	
	//funcao para remover foto da galeria
	$(document).on('click','.remove_icon_foto_galeria',function()
	{
		$.post(
			url+'imoveis/removeGaleria',
			{
				url 	: $(this).data('url'),
				id   	: $(this).data('id')
			},
			function(responseText){
				if(responseText.status == "success"){
					$('#foto_galeria_'+responseText.id+'').remove();
				}
			},
			"JSON"
		)
	});

	//funcao para retornar mais imovels/
	$(document).on('click','.j_load_more_imoveis',function()
	{
		var id 		= $(this).data('id');
		var nivel 	= $(this).data('nivel');
		if(id != ''){
			$(this).text('Aguarde...');
			$.post(
				url+'loadMore',
				{
					id 		: id,
					nivel 	: nivel
				},
				function(responseText){
					if(responseText.status == "success"){
						$('.j_load_more_imoveis').remove();
						$('.j_imoveis_container').append(responseText.result);
					}
				}
			);
		}else{
			$('.j_load_more_imoveis').remove();
		}
		return false;
	});
	
	//funcao para retornar a galeria
	retornaGaleria();
	function retornaGaleria(){
		$.post(
			url+'imoveis/retornaGaleria',
			{id : $('form[name="galeria"] input[name="id"]').val()},
			function(responseText){
				$('.galeria').empty();
				if(responseText.status == "success")
				{
					$('.galeria').html(responseText.result);
				}
			},
			"JSON"
		)
	}

	//funcao para retornar a foto principal
	retornafoto();
	function retornafoto()
	{
		$.post(
			url+'imoveis/retornafoto',
			{id : $('form[name="foto"] input[name="id"]').val()},
			function(responseText)
			{
				$('.foto').empty().html('');
				if(responseText.status == "success"){
					$('.foto').html(responseText.result);
				}
			},
			"JSON"
		)
	}
	
	$('.j_agrupar').change(function(evt)
	{
		evt.preventDefault();
		$('.j_pesquisa').empty().html('<p class="dev-center"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "imoveis/agrupar",
			{
				categoria 		: get_filter("categorias"),
				proprietario 	: get_filter("proprietarios"),
				accao 			: "filtrar"
			},
			function(responseText)
			{
				$('.j_pesquisa').empty().html(responseText);					
			}
		)
	});
	
	function get_filter(className)
	{
		let filter = $("."+className+" option:selected").val();
		return filter;
	}
	
	$('.j_agrupar_imovel_titulo').keyup(function(evt)
	{
		evt.preventDefault();
		$('.j_pesquisa').empty().html('<p class="dev-center"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "imoveis/agrupar",
			{
				nome : $(this).val(),
				accao : "filtrar"
			},
			function(responseText)
			{
				$('.j_pesquisa').empty().html(responseText);					
			}
		)
	});
	
	$('.j_agrupar_imovel_titulo').keyup(function(evt)
	{
		evt.preventDefault();
		$('.j_pesquisa').empty().html('<p class="dev-center"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "imoveis/agrupar",
			{
				nome : $(this).val(),
				accao : "filtrar"
			},
			function(responseText)
			{
				$('.j_pesquisa').empty().html(responseText);					
			}
		)
	});
	
	$(document).on("click",".j_page",function(evt)
	{
		evt.preventDefault();
		$('.j_page_button_loading').empty().html('<p class="dev-center j_page_loading"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "imoveis/agrupar",
			{
				page 			: $(this).attr("id"),
				categoria 		: get_filter("categorias"),
				proprietario 	: get_filter("proprietarios"),
				nome 			: $(this).val(),
				accao 			: "filtrar"
			},
			function(responseText)
			{
				$(".j_page_loading").remove();
				$('.j_pesquisa').append(responseText);				
			}
		)
	});
	
	$(document).on('change','.j_check_imoveis_all',function()
	{
		var $input = $(".j_check_contactos");
		if($(this).is(":checked"))
		{
			$input.prop("checked",true);
		}else{
			$input.prop("checked",false);
		}		
	});
	
	$(document).on('click','.j_remove_imovel',function(evt)
	{
		evt.preventDefault();
		var id 				= $(this).attr("href");
		$.ajax({
				url 		: url+"imoveis/remover",
				dataType 	: "JSON",
				type 		: "POST",
				data 		: {
					id 		: id,
					accao 	: "remover"
				},
				success 	: function(responseText)
				{
					if(responseText.status == "success")
					{
						$('#imoveis_'+id+'').css('background','#ccc').fadeOut('slow');
					}					
				},
				complete 	: function()
				{
					
				},
				beforeSend 	: function()
				{
					
				}
				
			});	
	});	
	
});	