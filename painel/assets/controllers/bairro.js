$(document).ready(function()
{
	//Funcoes gerais	
	
	$(document).on('click','.j_close_modal',function(){
		$('#modal').hide();
	});
	
	var url = $('meta[name="url"]').attr("content");
	
	$('.j_cria_novo_bairro').click(function(evt)
	{
		evt.preventDefault();
		$.post(
			url + "bairros/novo",
			{
				accao : "criar_novo_bairro"
			},
			function(responseText)
			{
				if(responseText.status == "success")
				{
					$(location).attr("href",url + "bairros/salvar/" + responseText.novo_bairro);
				}					
			},"JSON"
		)
	});
	
	
});	