$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	
	var url = $('meta[name="url"]').attr("content");
	/* $('body').on('click','.j_menu_controller',function(evt)
	{
		evt.preventDefault();
		var viewmodel = $(this).attr("href");
		$.ajax({
			url : viewmodel,
			type : "POST",
			success : function(responseText)
			{
				$("#viewmodel").empty().html(responseText);
			},
			beforeSend : function()
			{
				
			},
			complete : function()
			{
				
			}
		});
	});
	 */
	 

	//Funcao para fazer o share no facebook
	$('.j_share_facebook').click(function()
	{
		var urlshare = $(this).data('link');
		window.open('http://www.facebook.com/sharer.php?u='+urlshare,'VECA : Venda e Compra Aqui',"width=500,height=400,status=yes,toolbar=no,menubar=no,location=no");
		return false;
	});	
	
	$(document).on('click','.j_cria_novo_usuario', function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "users/novo",
			{
				accao : "criar_novo_usuario"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "users/salvar/" + responseText.novo_usuario);
				}					
			},"JSON"
		)
	});
	
	//Funcao para salvar a foto usuario
	$('.j_salva_foto_do_user').click(function()
	{
		$('form[name="foto"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'users/uploadfoto',
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
							$('.j_salva_foto_do_user').val('Salvar');
							$('.j_foto .j_salva_foto_do_user').prop("disabled",false);
						});
							$('.j_salva_foto_do_user').val('Concluido....');
						});
						retorna_foto_do_user();
					}
				},
				complete 	: function(){

				},
				beforeSubmit : function(){
					$('.j_foto .j_loading').fadeIn('fast',function(){
						$('.j_foto .j_salva_foto_do_user').prop("disabled",true);
						$('.j_foto .j_salva_foto_do_user').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});

	$(document).on('click','.j_cria_nova_definicao', function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "definicoes/nova",
			{
				accao : "criar_nova_definicao"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "definicoes/salvar/" + responseText.nova_definicao);
				}					
			},"JSON"
		)
	});
	
	
	
	
	
	
	$(document).on('click','.j_cria_novo_banner', function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "banners/novo",
			{
				accao : "criar_novo_banner"
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
	
	$('form[name="salvar_caption_banner"]').submit(function(evt)
	{
		evt.preventDefault();
		var dados = $(this).serialize()+'&accao=salvar_banner';
		$.ajax({
			url 		: url+'banners/salvarBanner',
			method 		: 'POST',
			dataType 	: "JSON",
			data   		: dados,
			cache  		: false,
			success 	: function(responseText){
				//caso retorno verdadeiro
				if(responseText.status == "success" ){
					$('.j_banner .j_loading').fadeOut('fast',function(){
					$('.j_banner .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salvar_caption_banner').val('Salvar');
						$('.j_salvar_caption_banner').prop("disabled",false);
					});
						$('.j_salvar_caption_banner').val('Salvo....');
					});
				}
			},
			complete : function(){

			},
			beforeSend : function(){
				$('.j_banner .j_loading').fadeIn('fast',function(){
					$('.j_salvar_caption_banner').prop("disabled",true);
					$('.j_salvar_caption_banner').val('Aguarde....');
				});
			}
		});
	});
	
	//Funcao para salvar a fotom Principal do imovel
	$('.j_salva_banner').click(function()
	{
		$('form[name="banner_form"]').one('submit',function(evt)
		{
			evt.preventDefault();
			$(this).ajaxSubmit({
				url 		: url+'banners/uploadBanner',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: {accao : 'upload_banner'},
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('#banner_form')[0].reset();
						$('.j_imagem_banner .j_loading').fadeOut('fast',function(){
						$('.j_imagem_banner .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_banner').val('Salvar');
							$('.j_imagem_banner .j_salva_banner').prop("disabled",false);
						});
							$('.j_salva_banner').val('Concluido....');
						});
						retornaBanner();
					}
				},
				complete 	: function(){

				},
				beforeSubmit : function(){
					$('.j_imagem_banner .j_loading').fadeIn('fast',function(){
						$('.j_imagem_banner .j_salva_banner').prop("disabled",true);
						$('.j_imagem_banner .j_salva_banner').val('Aguarde....');
					});
				}
			});
		});
	});
	
	//funcao para remover foto principal
	$(document).on('click','.remove_icon_imagem',function()
	{
		$.post(
			url+'banners/removeBanner',
			{
				url 	: $(this).data('url'),
				id   	: $(this).data('id')
			},
			function(responseText){
				if(responseText.status == "success"){
					$('#imagem_'+responseText.id+'').remove();
				}
			},
			"JSON"
		)
	});
	
	$('form[name="link_banner_form"]').submit(function(evt)
	{
		evt.preventDefault();
		var dados = $(this).serialize()+'&accao=salvar_link_banner';
		$.ajax({
			url 		: url+'banners/salvarLinkBanner',
			method 		: 'POST',
			dataType 	: "JSON",
			data   		: dados,
			cache  		: false,
			success 	: function(responseText){
				//caso retorno verdadeiro
				if( responseText.status == "success" ){
					$('.j_link_banner_loading .j_loading').fadeOut('fast',function(){
					$('.j_link_banner_loading .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_link_banner').val('Salvar');
						$('.j_salva_link_banner').prop("disabled",false);
					});
						$('.j_salva_link_banner').val('Salvo....');
					});
				}
				if( responseText.status == "failed" )
				{
					$('.j_link_banner_loading .j_loading').fadeOut('fast',function(){
					$('.j_link_banner_loading .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_link_banner').val('Salvar');
						$('.j_salva_link_banner').prop("disabled",false);
					});
						$('.j_salva_link_banner').val('Nenhuma alteracao feita.');
					});
				}
			},
			complete : function(){

			},
			beforeSend : function(){
				$('.j_link_banner_loading .j_loading').fadeIn('fast',function(){
					$('.j_salva_link_banner').prop("disabled",true);
					$('.j_salva_link_banner').val('Aguarde....');
				});
			}
		});
	});
	
	
	//funcao para retornar a foto do banner
	retornaBanner();
	function retornaBanner()
	{
		$.post(
			url+'banners/retornaBanner',
			{id : $('form[name="banner_form"] input[name="id"]').val()},
			function(responseText)
			{
				$('.banner').empty().html('');
				if(responseText.status == "success"){
					$('.banner').html(responseText.result);
				}
			},
			"JSON"
		)
	}
	
	$('.j_enable_link_banner').change(function(evt)
	{
		evt.preventDefault();
		$.post(
			url + 'banners/showSelectedLinkBanner',
			{
				to 		: $(this).val(),
				accao 	: "show_selected_link_banner"
				
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$('.j_link_banner').empty().html(responseText.links_to);
				}				
			},"JSON"
		);
	});
	
});