<div class="dev-container">
	<form class="dev-container dev-card-4" method="POST">
		<p>      
			<label class="dev-text-grey">Conteudo da Mensagem</label>
			<textarea class="dev-input dev-border" name="conteudo_da_sms" style="resize:none"></textarea>
		</p>
		<br>
		<div class="dev-row">
			<div class="dev-half">
				<h2>Grupos</h2>
				<?php 
					if( count($viewmodel) ):	
					foreach($viewmodel as $grupo):
				?>
				<p>
					<input id="<?php echo $grupo["id"]?>" value="<?php echo $grupo["id"]?>" class="dev-check" type="checkbox" name="grupo[]">
					<label for="<?php echo $grupo["id"]?>"><?php echo $grupo["nome"]?></label>
				</p>
				<?php endforeach; endif;?>
			</div>
		</div>
		<p><input type="submit" class="dev-btn dev-padding dev-flat-belize-hole" style="width:120px" name="enviar_sms" value="Enviar&nbsp; ❯"></p>
	</form>
</div>