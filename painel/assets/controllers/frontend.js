$(document).ready(function()
{
	var url = $('meta[name="url"]').attr('content');	
	$('.j_pesquisar').click(function(evt)
	{
		evt.preventDefault();
		var $j_select_bairro 				= $('.j_select_bairro').val();
		var $j_select_imovel 				= $('.j_select_imovel').val();
		var $j_select_preco_min 			= $('.j_select_preco_min').val();
		var $j_select_preco_max 			= $('.j_select_preco_max').val();
		var $j_select_finalidade 			= $('.j_select_finalidade').val();
		var $j_select_finalidade_decoded;
		if($j_select_finalidade == 1)
		{
			$j_select_finalidade_decoded = 'venda';
		}else if($j_select_finalidade == 2)
		{
			$j_select_finalidade_decoded = 'arrendar';
		}else{
			$j_select_finalidade_decoded = 'nulo';
		}		
		$j_select_bairro 		= ($j_select_bairro === null) ? 'nulo' : $j_select_bairro;
		$j_select_imovel 		= ($j_select_imovel === null) ? 'nulo' : $j_select_imovel;
		$j_select_preco_min 	= ($j_select_preco_min === null) ? 'nulo' : $j_select_preco_min;
		$j_select_preco_max 	= ($j_select_preco_max === null) ? 'nulo' : $j_select_preco_max;		
		var $pesquisa_query 		= 'pesquisa/';
		if($j_select_bairro != 'nulo')
		{
		    $pesquisa_query += 'bairro='+$j_select_bairro+'/';
		}
	    if($j_select_imovel != 'nulo')
	    {
	        $pesquisa_query += 'tipo_de_imovel='+$j_select_imovel+'/';
	    }
	    
		if($j_select_preco_min != 'nulo')
		{
		   $pesquisa_query += 'preco_minimo='+$j_select_preco_min+'/'; 
		}
		if($j_select_preco_max != 'nulo')
		{
		    $pesquisa_query += 'preco_maximo='+$j_select_preco_max+'/';
		}
		if($j_select_finalidade_decoded != 'nulo')
		{
		   $pesquisa_query += 'finalidade='+$j_select_finalidade_decoded+'/'; 
		}
				
		if($pesquisa_query !== 'nulo')
		{
			$(location).attr('href',url + $pesquisa_query);
		}		
	});
	
	$('.j_pesquisar_forum').click(function(evt)
	{
		evt.preventDefault();
		var $j_select_bairro 				= $('.j_select_bairro').val();
		var $j_select_categoria 			= $('.j_select_categoria').val();
		var $j_select_preco_min 			= $('.j_select_preco_min').val();
		var $j_select_preco_max 			= $('.j_select_preco_max').val();
		var $j_select_finalidade 			= $('.j_select_finalidade').val();
		var $j_select_urgencia 				= $('.j_select_urgencia').val();
		
		$j_select_bairro 		= ($j_select_bairro === null) ? 'nulo' : $j_select_bairro;
		$j_select_categoria 	= ($j_select_categoria === null) ? 'nulo' : $j_select_categoria;
		$j_select_preco_min 	= ($j_select_preco_min === null) ? 'nulo' : $j_select_preco_min;
		$j_select_preco_max 	= ($j_select_preco_max === null) ? 'nulo' : $j_select_preco_max;		
		$j_select_finalidade 	= ($j_select_finalidade === null) ? 'nulo' : $j_select_finalidade;		
		$j_select_urgencia 		= ($j_select_urgencia === null) ? 'nulo' : $j_select_urgencia;	
		
		var $pesquisa_query 	= 'procuro/forum/';
		if($j_select_bairro != 'nulo')
		{
		    $pesquisa_query += 'bairro='+$j_select_bairro+'/';
		}
	    if($j_select_categoria != 'nulo')
	    {
	        $pesquisa_query += 'categoria='+$j_select_categoria+'/';
	    }
	    
		if($j_select_preco_min != 'nulo')
		{
		   $pesquisa_query += 'preco_minimo='+$j_select_preco_min+'/'; 
		}
		
		if($j_select_preco_max != 'nulo')
		{
		    $pesquisa_query += 'preco_maximo='+$j_select_preco_max+'/';
		}
		
		if($j_select_finalidade != 'nulo')
		{
		   $pesquisa_query += 'finalidade='+$j_select_finalidade+'/'; 
		}
		
		if($j_select_urgencia != 'nulo')
		{
		   $pesquisa_query += 'urgencia='+$j_select_urgencia+'/'; 
		}
				
		if($pesquisa_query !== 'nulo')
		{
			$(location).attr('href',url + $pesquisa_query);
		}		
	});
	
	$('form[name="imovel_contacto"]').on('submit',function(evt){
		evt.preventDefault();
		$.ajax({
			url 		: url + 'painel/mensagens/salvar',
			method 		: "POST",
			dataType	: 'JSON',
			data 		: $(this).serialize() + '&accao=salvar_mensagem',
			success		: function(responseText)
			{
				if(responseText.status == 'success')
				{
					$('.j_msg_loading').empty().html('<p><i class="fa fa-check"></i> Enviado com sucesso.</p>');
				}
			},
			beforeSend 	: function()
			{
				$('.j_msg').fadeIn('fast',function()
				{
					$('.j_msg_loading').fadeIn('fast');
				})
			},
			complete 	: function()
			{
				
			}
		})
	});
	
	
	$('.j_pesquisa_por_termos').click(function(evt)
	{
		evt.preventDefault();
		var $j_termo 			= $('.j_termo').val();	
		var $pesquisa_query 	= 'pesquisa/';
		$j_termo 				= ($j_termo === null || $j_termo === '') ? 'nulo' : $j_termo;
		if($j_termo != 'nulo')
		{
		    $pesquisa_query += 'termo='+$j_termo.replace(/ /g,"-");
		}	
		if($pesquisa_query !== 'nulo')
		{
			$(location).attr('href',url + $pesquisa_query);
		}		
	});
	
	$('form[name="imovel_contacto"]').on('submit',function(evt){
		evt.preventDefault();
		$.ajax({
			url 		: url + 'painel/mensagens/salvar',
			method 		: "POST",
			dataType	: 'JSON',
			data 		: $(this).serialize() + '&accao=salvar_mensagem',
			success		: function(responseText)
			{
				if(responseText.status == 'success')
				{
					$('.j_msg_loading').empty().html('<p><i class="fa fa-check"></i> Enviado com sucesso.</p>');
				}
			},
			beforeSend 	: function()
			{
				$('.j_msg').fadeIn('fast',function()
				{
					$('.j_msg_loading').fadeIn('fast');
				})
			},
			complete 	: function()
			{
				
			}
		})
	});
	
	$('form[name="newsletter"]').submit(function(evt)
	{
		evt.preventDefault();
		$.ajax({
			url 		: url + 'painel/users/newsletterSubscribe',
			method 		: "POST",
			dataType	: 'JSON',
			data 		: $(this).serialize() + '&accao=salvar_newsletter_user',
			success		: function(responseText)
			{
				if(responseText.status == 'success')
				{
					$('.j_msg_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Subscrito com sucesso.</p>');
				}
				
				if(responseText.status == 'failed')
				{
					$('.j_msg_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Opss! Email ja existente.</p>');
				}
				
			},
			beforeSend 	: function()
			{
				$('.j_msg').fadeIn('fast',function()
				{
					$('.j_msg_loading').fadeIn('fast');
				})
			},
			complete 	: function()
			{
				
			}
		})	
	});
		
	$('form[name="pesquisa_contacto"]').submit(function(evt)
	{
		evt.preventDefault();
		$.ajax({
			url 		: url + 'painel/users/pesquisaContacto',
			method 		: "POST",
			dataType	: 'JSON',
			data 		: $(this).serialize() + '&accao=pesquisa_contacto',
			success		: function(responseText)
			{
				if(responseText.status == 'success')
				{
					$('.j_msg_pesquisa_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Enviado com sucesso, em breve entraremos em contacto.</p><p>Casa coimbra Real Estate agradece o contacto.</p>');
				}
				else
				{
					$('.j_msg_pesquisa_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Opss! Erro no envio, actualize a pagina e tente novamente.</p>');
				}
				
			},
			beforeSend 	: function()
			{
				$('.j_msg_pesquisa').fadeIn('fast',function()
				{
					$('.j_msg_pesquisa_loading').fadeIn('fast');
				})
			},
			complete 	: function()
			{
				
			}
		})
	});
	
	
	$('form[name="procuro"]').submit(function(evt)
	{
		evt.preventDefault();
		$.ajax({
			url 		: url + 'painel/users/procuro',
			method 		: "POST",
			dataType	: 'JSON',
			data 		: $(this).serialize() + '&accao=procuro',
			success		: function(responseText)
			{
				if(responseText.status == 'success')
				{
					$('.j_msg_pesquisa_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Enviado com sucesso, em breve entraremos em contacto.</p><p>Casa coimbra Real Estate agradece o contacto.</p>');
				}
				else
				{
					$('.j_msg_pesquisa_loading').empty().html('<p class="dev-xlarge"><i class="fa fa-check"></i> Opss! Erro no envio, actualize a pagina e tente novamente.</p>');
				}
				
			},
			beforeSend 	: function()
			{
				$('.j_msg_pesquisa').fadeIn('fast',function()
				{
					$('.j_msg_pesquisa_loading').fadeIn('fast');
				})
			},
			complete 	: function()
			{
				
			}
		})
	});
	
});