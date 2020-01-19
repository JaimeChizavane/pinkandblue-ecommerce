$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	
	var url = $('meta[name="url"]').attr("content");
	$('.j_cria_nova_subcategoria').click(function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "subcategorias/novo",
			{
				accao : "criar_nova_subcategoria",
				tipo  : $(this).data("tipo")
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "subcategorias/salvar/" + responseText.nova_subcategoria+"?tipo="+responseText.tipo);
				}					
			},"JSON"
		)
	});
	
	function triggerSaveEditor(){
		var theForm = $("#salva_subcategoria");
		var frameVAL =  $("#richTextField" ).contents().find( "body").html();
		$('#descricao').val(frameVAL);
	}
	
	//Funcao para salvar os dados do subcategoria
	$('.j_salva_subcategoria').click(function(){
		$('form[name="salva_subcategoria"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_subcategoria';
			$.ajax({
				url 		: url+'subcategorias/salvar',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_subcategoria .j_loading').fadeOut('fast',function(){
						$('.j_subcategoria .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_subcategoria').val('Salvar');
							$('.j_salva_subcategoria').prop("disabled",false);
						});
							$('.j_salva_subcategoria').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_subcategoria .j_loading').fadeIn('fast',function(){
						$('.j_salva_subcategoria').prop("disabled",true);
						$('.j_salva_subcategoria').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
		
	//Funcao para salvar a fotom Principal do subcategoria
	$('.j_salva_foto').click(function()
	{
		$('form[name="foto"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'subcategorias/uploadfoto',
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
	//funcao para retornar a foto principal
	retornafoto();
	function retornafoto()
	{
		$.post(
			url+'subcategorias/retornafoto',
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
	
});	