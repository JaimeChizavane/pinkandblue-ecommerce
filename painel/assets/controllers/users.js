$(document).ready(function(){
	var url = $('meta[name="url"]').attr("content");
		$('form[name="login"]').submit(function(evt)
		{
			evt.preventDefault();
			var dados 		= $(this).serialize() + "&accao=login";
			var $j_alert 	= $(".j_alert");
			$.ajax({
				url 		: url + "users/autenticaUser",
				type 		: "POST",
				dataType 	: "JSON",
				data 		: dados,
				success 	: function(responseText)
				{
					if(responseText.status == "success")
					{
						$(".j_spin").fadeOut(function()
						{
							if($j_alert.hasClass("dev-red"))
							{
								$j_alert.addClass("dev-green");
							}
							$j_alert.empty().html('<h4 class="dev-padding">Login efectuado com sucesso...</h4>').fadeIn("fast");
						});						
						setTimeout(function()
						{
							$(location).attr("href",url);
						},1000);
					}
					
					if(responseText.status == "inactive")
					{
						if($j_alert.hasClass("dev-green"))
						{
							$j_alert.removeClass("dev-green");
						}
						$j_alert.addClass("dev-red").empty().html('<h4 class="dev-padding">Usuario inactivo, contacte o administrador para mais informacoes...</h4>').fadeIn("fast");
					}
					
					if(responseText.status == "failed")
					{
						$(".j_spin").fadeOut("fast",function()
						{
							if($j_alert.hasClass("dev-green"))
							{
								$j_alert.removeClass("dev-green");
							}	
							$j_alert.addClass("dev-red").empty().html('<h4 class="dev-padding">Os dados nao conferem, tente novamente...</h4>').fadeIn("fast");	
						});					
					}					
				},
				beforeSend : function()
				{
					$(".j_spin").fadeIn();
				},
				complete : function()
				{
					$(".j_spin").fadeOut();
				}
			});
	});	
});