<div class="dev-container dev-white dev-border dev-padding dev-margin-bottom dev-clearfix">
	<h1 class="dev-large dev-left"><a href="<?php echo ROOT?>variacoes" class="">Variação</a>
		<?php 
			if(!empty($data["variacao"]["variacao"])):
				echo ' / <a href="" class="j_edita_variacao j_variacao_name" 
				data-id="'.$data["variacao_id"].'"
				data-valor="'.$data["variacao"]["variacao"].'"
				>
				'.$data["variacao"]["variacao"].' <i class="fa fa-pencil"></i>
				</a>';
			endif;
		?>	
		
	</h1>
	<a href="" class="dev-button dev-margin-right dev-right dev-padding dev-flat-midnight-blue j_cria_novo_atributo"><i class="fa fa-plus"></i> Adicionar Atributos</a>	
</div>

<div class="dev-container dev-margin-bottom">
	<div class="dev-row-padding j_hold_variacao_atributo_result" style="padding:0">
		<?php 
			foreach($data["atributos"] as $atributos):
		?>
			<div class="dev-half dev-margin-top">
				<div class=" dev-border dev-white" id="atributo_<?php echo $atributos['id']?>">
					<header class="dev-bar dev-flat-midnight-blue dev-padding dev-text-white">			
						<div class="dev-bar-item">
							<h4 style="margin:0" class="j_atributo_nome we-medium"><?php echo $atributos['atributo']?></h4>
						</div>
						<div class="dev-bar-item dev-right">
							<a href="" class="j_edita_atributo dev-buttom dev-padding"  
							data-id="<?php echo $atributos['id']?>" 
							data-value="<?php echo $atributos['atributo']?>">
							<i class="fa fa-pencil fa-2x"></i>
							</a>
							<a href="" class="j_remove_atributo dev-buttom dev-padding"><i class="fa fa-trash fa-2x"></i></a>
						</div>
					</header>
					<div class="j_variacao_atributo_list_item" id="<?php echo $atributos['id']?>">
						
					</div>
				</div>
			</div>		
		<?php endforeach;?>
	</div>
</div>
<div id="idAtributo" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idAtributo').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2>Adicionar Atributo a Variação</h2>
		</header>
		<form name="form_variacao_atributo" id="form_variacao_atributo" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label>Atributo</label>
					<input type="hidden" name="variacao_id" value="<?php echo $data["variacao_id"]?>">
					<input class="dev-input dev-border" type="text" name="atributo" placeholder="Informe atributo desta variação" required>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_variacao_atributo">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_salva_variacao_atributo">
				</div>	
			</footer>
		</form>	
	</div>	
</div>
<div id="idEditaVariacao" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idEditaVariacao').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2 class="j_variacao_titulo"></h2>
		</header>
		<form name="form_edita_variacao" id="form_edita_variacao" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label></label>
					<input type="hidden" name="id" class="j_variacao_id"	value="">
					<input class="dev-input dev-border j_varicao_valor" type="text" name="value" placeholder="" required>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_edita_variacao_loading">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_edita_variacao_submit">
				</div>	
			</footer>
		</form>	
	</div>	
</div>

<div id="idEditaAtributo" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idEditaAtributo').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2 class="j_atributo_titulo"></h2>
		</header>
		<form name="form_edita_atributo" id="form_edita_atributo" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label></label>
					<input type="hidden" name="id" class="j_atributo_id"	value="">
					<input class="dev-input dev-border j_atributo_valor" type="text" name="value" placeholder="" required>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_edita_atributo_loading">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_edita_atributo_submit">
				</div>	
			</footer>
		</form>	
	</div>	
</div>

<div id="idEditaItemAtributo" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idEditaItemAtributo').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2 class="">Editar variação <span class="j_item_to_edit"></span></h2>
		</header>
		<form name="form_edita_item_atributo" id="form_edita_item_atributo" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label>Editar variação <span class="j_item_to_edit"></span></label>
					<input type="hidden" name="id" value="">
					<div class="dev-row-padding" style="padding:0">
						<div class="dev-half">
							<input class="dev-input dev-border" type="text" name="value" placeholder="Informe o nome" required>
						</div>
						<div class="dev-half">
							<input class="dev-input dev-border" type="text" name="referencia" placeholder="Informe a referencia">
						</div>
					</div>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_edita_item_atributo_loading">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_edita_item_atributo_submit">
				</div>	
			</footer>
		</form>	
	</div>	
</div>

<div id="idSalvaItemAtributo" class="dev-modal" style="z-index:999999999">
	<div class="dev-modal-content dev-animate-zoom dev-card-4">
		<header class="dev-container dev-bottombar"> 
			<span onclick="document.getElementById('idSalvaItemAtributo').style.display='none'" 
			class="dev-button dev-display-topright dev-xxlarge">&times;</span>
			<h2 class="">Adicionar variação ao Atributo <span class="j_atributo_pai"></span></h2>
		</header>
		<form name="form_salva_item_atributo" id="form_salva_item_atributo" method="Post">	
			<div class="dev-container">				
				<div class="dev-padding">
					<label>Adicionar variação a Atriubo <span class="j_atributo_to_add_item"></span></label>
					<input type="hidden" name="atributo_id" value="">
					<div class="dev-row-padding" style="padding:0">
						<div class="dev-half">
							<input class="dev-input dev-border j_item_atributo_nome" type="text" name="item_nome" placeholder="Informe o nome" required>
						</div>
						<div class="dev-half">
							<input class="dev-input dev-border j_item_atributo_referencia" type="text" name="item_referencia" placeholder="Informe a referencia">
						</div>
					</div>
				</div>
			</div>
			<footer class="dev-container dev-topbar dev-padding">
				<div class="dev-row-padding dev-margin-top j_item_atributo">
					<span class="j_loading" style="display:none;"><i class="fa fa-spinner dev-spin" style="font-size:30px"></i></span>
					<span class="j_done" style="display:none"><i class="fa fa-check" style="font-size:30px"></i></span> 
					<input type="submit" value="Salvar&nbsp; ❯" class="dev-button dev-flat-midnight-blue j_salva_item_atributo">
				</div>	
			</footer>
		</form>	
	</div>	
</div>
<script>
	$(document).ready(function()
	{		
		$('.j_cria_novo_atributo').click(function(evt){
			evt.preventDefault();
			$('#idAtributo').show();
		});
		
		$('.j_edita_variacao').click(function(evt){
			evt.preventDefault();
			var $this = $(this);			
			$('.j_variacao_titulo').text('Editar Variação '+$this.data('valor'));
			$('.j_variacao_id').val($this.data('id'));
			$('.j_varicao_valor').val($this.data('valor'));
			$('#idEditaVariacao').show();
		});
		
		$('.j_edita_atributo').click(function(evt){
			evt.preventDefault();
			var $this = $(this);			
			$('#idEditaAtributo .j_atributo_titulo').text('Editar Atributo '+$this.data('value'));
			$('.j_atributo_id').val($this.data('id'));
			$('.j_atributo_valor').val($this.data('value'));
			$('#idEditaAtributo').show();
		});
		
		$(document).on('click','.j_edita_item',function(evt){
			evt.preventDefault();
			$('form[name="form_edita_item_atributo"] input[name="id"]').val($(this).data('id'));
			$('form[name="form_edita_item_atributo"] input[name="value"]').val($(this).data('value'));
			$('.j_item_to_edit').text($(this).data('value'));
			$('form[name="form_edita_item_atributo"] input[name="referencia"]').val($(this).data('referencia'));
			$('#idEditaItemAtributo').show();
		});
	
		$(document).on('click','.j_salvar_item',function(evt){
			evt.preventDefault();
			$('form[name="form_salva_item_atributo"] input[name="atributo_id"]').val($(this).data('atributo_id'));
			$('.j_atributo_pai').text($(this).data('atributo'));
			$('#idSalvaItemAtributo').show();
		});
	});
	function dropdown(id) {
		var x = document.getElementById(id);
		if (x.className.indexOf("dev-show") == -1) {  
			x.className += " dev-show";
		} else { 
			x.className = x.className.replace(" dev-show", "");
		}
	}
</script>
<script src="<?php echo ROOT_URL?>assets/controllers/variacoes.js"></script>