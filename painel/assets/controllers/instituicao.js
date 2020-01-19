$(document).ready(function(){
	var url = $('meta[name="url"]').attr('content');
	
	function triggerSaveEditor(){
		var theForm 	= $("#salva_instituicao");
		var frameVAL 	=  $("#richTextField" ).contents().find( "body").html();
		var frameVAL1 	=  $("#richTextField1" ).contents().find( "body").html();
		var frameVAL2 	=  $("#richTextField2" ).contents().find( "body").html();
		$('#quem_somos').val(frameVAL);
		$('#missao').val(frameVAL1);
		$('#visao').val(frameVAL2);
	}
	
	//Funcao para salvar os dados do produto
		$('form[name="salva_instituicao"]').submit(function(evt){
			evt.preventDefault();
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salva_instituicao';
			$.ajax({
				url : url+'instituicao/salvar',
				method : 'POST',
				dataType : 'JSON',
				data   : dados,
				cache  : false,
				success : function(retorno){
					//caso retorno verdadeiro
					if(retorno.status == 'success' ){
						$('.j_instituicao .j_loading').fadeOut('fast',function(){
						$('.j_instituicao .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_instituicao').val('Salvar');
							$('.j_salva_instituicao').prop("disabled",false);
						});
							$('.j_salva_instituicao').val('Salvo....');
						});
					}
					
					//caso retorne falso
					if(retorno.status == 'failed' ){
						
					}
				},
				complete : function(){
					
				},
				beforeSend : function(){
					$('.j_instituicao .j_loading').fadeIn('fast',function(){
						$('.j_salva_instituicao').prop("disabled",true);
						$('.j_salva_instituicao').val('Aguarde....');						
					});
				}
			});
		});
	
	
	//Funcao para salvar os dados do imovel
		$('form[name="salva_instituicao_mapa"]').submit(function(evt){
			// Saves all contents
			evt.preventDefault();
			var dados = $(this).serialize()+'&accao=salvar_mapa';
			$.ajax({
				url 		: url+'instituicao/salvarMapa',
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
		});
	
	//Funcao para salvar os dados do produto
		$('form[name="salva_instituicao_redes"]').submit(function(evt){
			evt.preventDefault();
			var dados = $(this).serialize()+'&accao=salva_instituicao_redes';
			$.ajax({
				url : url +'instituicao/redes',
				method : 'POST',
				dataType : 'JSON',
				data   : dados,
				cache  : false,
				success : function(retorno){
					//caso retorno verdadeiro
					if(retorno.status == 'success' ){
						$('.j_instituicao_redes .j_loading').fadeOut('fast',function(){
						$('.j_instituicao_redes .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_instituicao_redes').val('Salvar');
							$('.j_salva_instituicao_redes').prop("disabled",false);
						});
							$('.j_salva_instituicao_redes').val('Salvo....');
						});
					}
					
					//caso retorne falso
					if(retorno.status == 'failed' ){
						
					}
				},
				complete : function(){
					
				},
				beforeSend : function(){
					$('.j_instituicao_redes .j_loading').fadeIn('fast',function(){
						$('.j_salva_instituicao_redes').prop("disabled",true);
						$('.j_salva_instituicao_redes').val('Aguarde....');
					});
				}
			});
		});		
	
	//Funcao para salvar a logotipo
	$('form[name="logo"]').submit(function(evt){
		evt.preventDefault();
		$(this).ajaxSubmit({
			url : url +'instituicao/uploadLogo',
			method : 'POST',
			dataType : 'JSON',
			data   : {accao : 'uploadLogo'},
			cache  : false,
			success : function(retorno){
				//caso retorno verdadeiro
				if(retorno.status == 'success' ){
					$('#logo')[0].reset();
					$('.j_logo .j_loading').fadeOut('fast',function(){
					$('.j_logo .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
						$('.j_salva_logotipo').val('Salvar');
						retornaLogo();
					});
						$('.j_salva_logo').val('Concluido....');
					});	
				}
				
				//caso retorne falso
				if(retorno.status == 'failed' ){
					
				}
			},
			complete : function(){
				
			},
			beforeSubmit : function(){
				$('.j_logo .j_loading').fadeIn('fast',function(){
					$('.j_logo .j_salva_logo').val('Aguarde....');
				});
			} 
		});
	});	
		
	//funcao para retornar a imagem logotipo
	retornaLogo();
	function retornaLogo(){
		$.post(
			url+'instituicao/retornaLogo',
			{},
			function(retorno){
				$('.logo').empty().html('');
				if(retorno !=''){
					$('.logo').html(retorno);
				}
			}
		)
	}
	
});