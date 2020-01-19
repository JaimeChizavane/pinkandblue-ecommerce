$(document).ready(function()
{
	var url = $('meta[name="url"]').attr("content");
	$(document).on('click','.j_salva_variacao',function(evt)
	{
		evt.preventDefault();
		var variacao		=	$('form[name="form_variacao"] input[type="text"]').val();
		$.ajax({
			url 		: url + "variacoes/salvar_nova_variacao/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: {
				variacao 	: 	variacao,
				accao	:	'salvar_variacao'
			},
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('.j_variacao .j_loading').fadeOut('fast',function(){
					$('.j_variacao .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_variacao').val('Salvar');
						$('.j_salva_variacao').prop("disabled",false);
						$('.j_hold_variacao_result').empty().html(responseText.new_select);
						$('#form_variacao')[0].reset();
						$('#idVariacao').hide();
					});
						$('.j_salva_variacao').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_variacao .j_loading').fadeIn('fast',function(){
					$('.j_salva_variacao').prop("disabled",true);
					$('.j_salva_variacao').val('Aguarde....');
				});
			}
		});
	});
$(document).on('click','.j_salva_variacao',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_edita"] input[type="text"]').val();
		$.ajax({
			url 		: url + "variacoes/salvar_nova_variacao/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: {
				variacao 	: 	variacao,
				accao	:	'salvar_variacao'
			},
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('.j_variacao .j_loading').fadeOut('fast',function(){
					$('.j_variacao .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_variacao').val('Salvar');
						$('.j_salva_variacao').prop("disabled",false);
						$('.j_hold_variacao_result').empty().html(responseText.new_select);
						$('#form_edita')[0].reset();
						$('#idEdita').hide();
					});
						$('.j_salva_variacao').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_variacao .j_loading').fadeIn('fast',function(){
					$('.j_salva_variacao').prop("disabled",true);
					$('.j_salva_variacao').val('Aguarde....');
				});
			}
		});
	});
	
//#####################VARIACAO######################
$(document).on('click','.j_salva_variacao_atributo',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_variacao_atributo"]').serialize() + "&accao=salvar_variacao_atributo";
		$.ajax({
			url 		: url + "variacoes/salvar_variacao_atributo/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('.j_variacao_atributo .j_loading').fadeOut('fast',function(){
					$('.j_variacao_atributo .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_variacao_atributo').val('Salvar');
						$('.j_salva_variacao_atributo').prop("disabled",false);
						$('.j_hold_variacao_atributo_result').empty().html(responseText.new_select);
						$('#idAtributo').hide();
						$('.j_variacao_atributo_list_item').each(function(i, el)
						{
							listaItemAtributos($(this).attr('id'));
							$('#form_variacao_atributo')[0].reset();
						});
					});
						$('.j_salva_variacao_atributo').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_variacao_atributo .j_loading').fadeIn('fast',function(){
					$('.j_salva_variacao_atributo').prop("disabled",true);
					$('.j_salva_variacao_atributo').val('Aguarde....');
				});
			}
		});
	});
	
	$(document).on('click','.j_salva_item_atributo',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_salva_item_atributo"]').serialize() + "&accao=salvar_item_atributo";
		var id 			= 	$('form[name="form_salva_item_atributo"] input[name="atributo_id"]').val();
		$.ajax({
			url 		: url + "variacoes/salvar_item_atributo/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('.j_item_atributo .j_loading').fadeOut('fast',function(){
					$('.j_item_atributo .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_item_atributo').val('Salvar');
						$('.j_salva_item_atributo').prop("disabled",false);
						listaItemAtributos(id);
						$('#form_salva_item_atributo')[0].reset();
						$('#idSalvaItemAtributo').hide();
					});
						$('.j_salva_item_atributo').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_item_atributo .j_loading').fadeIn('fast',function(){
					$('.j_salva_item_atributo').prop("disabled",true);
					$('.j_salva_item_atributo').val('Aguarde....');
				});
			}
		});
	});
	
//#####################Editar######################
$(document).on('click','.j_edita_variacao_submit',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_edita_variacao"]').serialize() + "&accao=editar_variacao";
		$.ajax({
			url 		: url + "variacoes/editar_variacao/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					var variacao_name = $('.j_variacao_name');
					variacao_name.empty().html(responseText.variacao_new_name + ' <i class="fa fa-pencil"></i>');
					variacao_name.data('valor',responseText.variacao_new_name);
					$('.j_edita_variacao_loading .j_loading').fadeOut('fast',function(){
					$('.j_edita_variacao_loading .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_edita_variacao_submit').val('Salvar');
						$('.j_edita_variacao_submit').prop("disabled",false);
						$('.j_hold_variacao_result').empty().html(responseText.new_select);
						$('#form_edita_variacao')[0].reset();
						$('#idEditaVariacao').hide();
					});
						$('.j_edita_variacao_submit').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_edita_variacao_loading .j_loading').fadeIn('fast',function(){
					$('.j_edita_variacao_submit').prop("disabled",true);
					$('.j_edita_variacao_submit').val('Aguarde....');
				});
			}
		});
	});
	
	$(document).on('click','.j_edita_atributo_submit',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_edita_atributo"]').serialize() + "&accao=editar_atributo";
		var id			=	$('.j_atributo_id').val();
		$.ajax({
			url 		: url + "variacoes/editar_atributo/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('#atributo_'+id+' .j_atributo_nome').empty().text(responseText.atributo_new_name);
					$('#atributo_'+id+' .j_edita_atributo').data('value',responseText.atributo_new_name);
					$('.j_edita_atributo_loading .j_loading').fadeOut('fast',function(){
					$('.j_edita_atributo_loading .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_edita_atributo_submit').val('Salvar');
						$('.j_edita_atributo_submit').prop("disabled",false);
						$('#form_edita_atributo')[0].reset();
						$('#idEditaAtributo').hide();
					});
						$('.j_edita_atributo_submit').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_edita_atributo_loading .j_loading').fadeIn('fast',function(){
					$('.j_edita_atributo_submit').prop("disabled",true);
					$('.j_edita_atributo_submit').val('Aguarde....');
				});
			}
		});
	});
	
$(document).on('click','.j_edita_item_atributo_submit',function(evt)
	{
		evt.preventDefault();
		var dados		=	$('form[name="form_edita_item_atributo"]').serialize() + "&accao=editar_item_atributo";
		var id			=	$('form[name="form_edita_item_atributo"] input[name="id"]').val();
		
		$.ajax({
			url 		: url + "variacoes/editar_item_atributo/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					
					$('#item_'+id+' .j_item_atributo_name').empty().text(responseText.variacao_atributo_item_new_name);
					$('#item_'+id+' .j_item_atributo_referencia').empty().text(responseText.referencia);
					$('#item_'+id+' .j_edita_item').data('value',responseText.variacao_atributo_item_new_name);
					$('#item_'+id+' .j_edita_item').data('referencia',responseText.referencia);
					$('.j_edita_variacao_loading .j_loading').fadeOut('fast',function(){
					$('.j_edita_variacao_loading .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_edita_item_atributo_submit').val('Salvar');
						$('.j_edita_item_atributo_submit').prop("disabled",false);
						
						$('#idEditaItemAtributo').hide();
					});
						$('.j_edita_item_atributo_submit').val('Salvo....');
					});
				}
			},
			beforeSend 	: function()
			{
				$('.j_edita_variacao_loading .j_loading').fadeIn('fast',function(){
					$('.j_edita_item_atributo_submit').prop("disabled",true);
					$('.j_edita_item_atributo_submit').val('Aguarde....');
				});
			}
		});
	});	
	
	$('.j_variacao_atributo_list_item').each(function(i, el)
	{
		listaItemAtributos($(this).attr('id'));
	});
	
	function listaItemAtributos(id)
	{
		var dados = "id="+id+"&accao=lista_item_atributo";
		
		$.ajax({
			url 		: url + "variacoes/lista_item_atributo/",
			method 		: "POST",
			dataType 	: "JSON",
			data		: dados,
			success 	: function(responseText)
			{
				if(responseText.result == true)
				{
					$('#'+id+'').empty().html(responseText.new_select);
				}
			},
			beforeSend : function()
			{
				
			}
			
		})
	}
});