<div class="dev-container dev-white dev-border dev-padding dev-margin-bottom">
	<h1 class="dev-large dev-left">Variações</h1>
	<a href="" class="dev-button dev-margin-right dev-right dev-padding dev-flat-midnight-blue j_cria_nova_variacao"><i class="fa fa-plus"></i> Adicionar Variações</a>	
	<a href="<?php echo ROOT?>variacoes/modelos"class="dev-button dev-right dev-margin-right dev-padding dev-flat-midnight-blue"><i class="fa fa-folder"></i> Modelos</a>	
</div>
<div class="dev-container dev-padding dev-margin-bottom">	
	<h4 class="dev-small"><a href="#" class="dev-text-green">Produtos</a> / Variações</h4>
</div>
<div class="dev-margin-top dev-margin-bottom">
	<div class="dev-responsive">
		<div class="j_hold_variacao_result">
			<table class="dev-table-all dev-striped dev-small">
				<thead>
					<th style="width:80%">Tipos de Variações</th>
					<th style="width:20%">&nbsp;</th>
				</thead>
			</table>
		</div>
	</div>
</div>

<div id="idVariacao" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idVariacao').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2>Adicionar Variação</h2>
		</header>
		<form name="form_variacao" id="form_variacao" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label>Variação</label>
					<input class="dev-input dev-border" type="text" value="" placeholder="Informe a variação" required>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_variacao">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_salva_variacao">
				</div>	
			</footer>
		</form>	
	</div>	
</div>


<style>
	a{
		text-decoration:none;
	}
	td{
		vertical-align:middle!important;
		text-algin:left!important;
	}
</style>
<script>
	$(document).ready(function()
	{
		$(document).on('click','.j_cria_nova_variacao',function(evt){
			evt.preventDefault();
			$('#idVariacao').show();
		});
	})
</script>
<script src="<?php echo ROOT_URL?>assets/controllers/variacoes.js"></script>