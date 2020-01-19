$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	var url = $('meta[name="url"]').attr("content");
	$(document).on('click','.j_cria_novo_produto', function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "produtos/novo",
			{
				accao : "criar_novo_produto"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "produtos/salvar/" + responseText.novo_produto);
				}					
			},"JSON"
		)
	});
	
	function triggerSaveEditor(){
		var theForm = $("#salva_produto");
		var frameVAL =  $("#richTextField" ).contents().find( "body").html();
		$('#descricao').val(frameVAL);
	}
	
	//Funcao para salvar os dados do produto
	$('.j_salva_produto').click(function(){
		$('form[name="salva_produto"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_produto';
			$.ajax({
				url 		: url+'produtos/salvar',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_produto .j_loading').fadeOut('fast',function(){
						$('.j_produto .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_produto').val('Salvar');
							$('.j_salva_produto').prop("disabled",false);
						});
							$('.j_salva_produto').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_produto .j_loading').fadeIn('fast',function(){
						$('.j_salva_produto').prop("disabled",true);
						$('.j_salva_produto').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
	
	//Funcao para salvar os dados do produto
	$('.j_salva_produto_mapa').click(function(){
		$('form[name="salva_produto_mapa"]').one('submit',function(){
			// Saves all contents
			triggerSaveEditor();
			var dados = $(this).serialize()+'&accao=salvar_mapa';
			$.ajax({
				url 		: url+'produtos/salvarMapa',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: dados,
				cache  		: false,
				success 	: function(responseText){
					//caso retorno verdadeiro
					if(responseText.status == "success" ){
						$('.j_produto_mapa .j_loading').fadeOut('fast',function(){
						$('.j_produto_mapa .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							$('.j_salva_produto_mapa').val('Salvar');
							$('.j_salva_produto_mapa').prop("disabled",false);
						});
							$('.j_salva_produto_mapa').val('Salvo....');
						});
					}
				},
				complete : function(){

				},
				beforeSend : function(){
					$('.j_produto_mapa .j_loading').fadeIn('fast',function(){
						$('.j_salva_produto_mapa').prop("disabled",true);
						$('.j_salva_produto_mapa').val('Aguarde....');
					});
				}
			});
			return false;
		});
	});
	
	//Funcao para salvar a fotom Principal do produto
	$('.j_salva_foto').click(function()
	{
		$('form[name="foto"]').one('submit',function()
		{
			$(this).ajaxSubmit({
				url 		: url+'produtos/uploadfoto',
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

	//Funcao para salvar a fotom Galeria do produto
	var count = 0;
	var list = $(".galeria");
	function showUploadedItem(source,index) {        
        list.append('<div class="dev-col s6 m3 l3" style="padding:8px;position:relative;" id="foto_galeria_'+count+'"><img class="dev-border dev-padding-small dev-round foto_galeria_'+count+'" src="" style="max-width:100%;max-height:100%;"></div>');
        $(".foto_galeria_" + count + "").attr("src",source);
        count++;
    }

    $('form[name="galeria"] input[type="file"]').change(function() {
        var file = this.files;

        $.each(file, function(i, filename) {
            reader = new FileReader();
            reader.onloadend = function (e) {
                showUploadedItem(e.target.result, filename.name);
            };

            reader.readAsDataURL(filename);
        });
    });
	
	$('.j_salva_galeria').click(function(e)
	{
		e.preventDefault();
		var files = $('form[name="galeria"] input[type="file"]')[0].files;
		$.each(files, function(i, file) {
			
			var formdata = new FormData();
			formdata.append('galeria_produto[]', file);
			formdata.append("accao","uploadGaleria");
			console.log(formdata);

			$.ajax({
				url 		: url+'produtos/uploadGaleria',
				method 		: 'POST',
				dataType 	: "JSON",
				data   		: formdata,
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
		}); 
		
		// $('form[name="galeria"]').one('submit',function()
		// {
			// $(this).ajaxSubmit({
				// url 		: url+'produtos/uploadGaleria',
				// method 		: 'POST',
				// dataType 	: "JSON",
				// data   		: {accao : 'uploadGaleria'},
				// cache  		: false,
				// success 	: function(responseText){
					// //caso retorno verdadeiro
					// if(responseText.status == "success"){
						// $('#galeria')[0].reset();
						// $('.j_galeria .j_loading').fadeOut('fast',function(){
						// $('.j_galeria .j_done').fadeIn('fast').delay(3000).fadeOut('normal',function(){
							// $('.j_salva_galeria').val('Salvar');
							// $('.j_galeria .j_salva_galeria').prop("disabled",false);
							// retornaGaleria();
						// });
							// $('.j_salva_galeria').val('Concluido....');
						// });
					// }
				// },
				// complete 		: function(){

				// },
				// beforeSubmit 	: function(){
					// $('.j_galeria .j_loading').fadeIn('fast',function(){
						// $('.j_galeria .j_salva_galeria').prop("disabled",true);
						// $('.j_galeria .j_salva_galeria').val('Aguarde....');
					// });
				// }
			// });
			// return false;
		// });
	});

	//funcao para remover foto principal
	$(document).on('click','.remove_icon_foto',function()
	{
		$.post(
			url+'produtos/removefoto',
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
			url+'produtos/removeGaleria',
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

	//funcao para retornar mais produtos/
	$(document).on('click','.j_load_more_produtos',function()
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
						$('.j_load_more_produtos').remove();
						$('.j_produtos_container').append(responseText.result);
					}
				}
			);
		}else{
			$('.j_load_more_produtos').remove();
		}
		return false;
	});
	
	//funcao para retornar a galeria
		
	retornaGaleria();
	
	function retornaGaleria(){
		$.post(
			url+'produtos/retornaGaleria',
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
			url+'produtos/retornafoto',
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
			url + "produtos/agrupar",
			{
				categoria 		: get_filter("categorias"),
				subcategoria	: get_filter("subcategorias"),
				marca	 		: get_filter("marcas"),				
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
	
	$('.j_agrupar_produto_titulo').keyup(function(evt)
	{
		evt.preventDefault();
		$('.j_pesquisa').empty().html('<p class="dev-center"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "produtos/agrupar",
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
	
	$('.j_agrupar_produto_titulo').keyup(function(evt)
	{
		evt.preventDefault();
		$('.j_pesquisa').empty().html('<p class="dev-center"><i class="fa fa-spinner dev-spin" style="font-size:5em"></i></p>');
		$.post(
			url + "produtos/agrupar",
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
			url + "produtos/agrupar",
			{
				page 			: $(this).attr("id"),
				categoria 		: get_filter("categorias"),
				subcategoria 	: get_filter("subcategorias"),
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
	
	$(document).on('change','.j_check_produtos_all',function()
	{
		var $input = $(".j_check_contactos");
		if($(this).is(":checked"))
		{
			$input.prop("checked",true);
		}else{
			$input.prop("checked",false);
		}		
	});
	
	$(document).on('click','.j_remove_produto',function(evt)
	{
		evt.preventDefault();
		var id 				= $(this).attr("href");
		$.ajax({
				url 		: url+"produtos/remover",
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
						$('#produtos_'+id+'').css('background','#ccc').fadeOut('slow');
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