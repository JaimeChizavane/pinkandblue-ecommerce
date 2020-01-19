$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	
	var url = $('meta[name="url"]').attr("content");
	$('.j_cria_novo_banner').click(function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "banners/novo",
			{
				accao : "criar_novo_banner",
				tipo  : $(this).data("tipo")
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "banners/salvar/" + responseText.novo_banner);
				}					
			},"JSON"
		)
	});
	
	function triggerSaveEditor(){
		var frameVAL =  $("#richTextField" ).contents().find( "body").html();
		$('#descricao').val(frameVAL);
	}
	
	//Funcao para salvar os dados do banner
	$('.j_salva_banner').click(function(){
		$('form[name="salva_banner"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_banner';
			$.ajax({
				url 		: url+'banners/salvar',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_banner .j_loading').fadeOut('fast',function(){
						$('.j_banner .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_banner').val('Salvar');
							$('.j_salva_banner').prop("disabled",false);
						});
							$('.j_salva_banner').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_banner .j_loading').fadeIn('fast',function(){
						$('.j_salva_banner').prop("disabled",true);
						$('.j_salva_banner').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
		
	//Funcao para salvar a fotom Principal do banner
	$('.j_salva_foto').click(function()
	{
		$('form[name="foto"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'banners/uploadfoto',
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
			url+'banners/retornafoto',
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