<div class="dev-container">
	<form class="" method="POST" action="<?php $_SERVER["PHP_SELF"];?>" style="margin-bottom:30px;">
		<fieldset>
			<legend>Definicoes do sistema</legend>
			<input type="hidden" value="<?php echo $_GET["id"]?>" name="id">
			<p>
				<label>Provedor</label>
				<input class="dev-input dev-border" type="text" name="provedor" value="<?php echo $viewmodel["provedor"]?>">
			</p>
			<p>
				<label>Api Key</label>
				<input class="dev-input dev-border" type="text" name="api_key" value="<?php echo $viewmodel["api_key"]?>">
			</p>
			<p>
				<label>Sid</label>
				<input class="dev-input dev-border" type="text" name="sid" value="<?php echo $viewmodel["sid"]?>">
			</p>
			<p>
				<label>Token</label>
				<input class="dev-input dev-border" type="text" name="token" value="<?php echo $viewmodel["token"]?>">
			</p>
			<p>
				<select class="dev-select dev-border" name="status">
					<option value="" disabled selected>Informe o Status</option>
					<option value="1" <?php if($viewmodel["status"] == 1) echo "selected"?>>Activo</option>
					<option value="2" <?php if($viewmodel["status"] == 2) echo "selected"?>>Nao Activo</option>
				</select>
			</p>
			<p><input type="submit" class="dev-button dev-flat-belize-hole" name="salvar_definicoes" value="Salvar&nbsp; ❯"></p>
		</fieldset>
	</form>
</div>