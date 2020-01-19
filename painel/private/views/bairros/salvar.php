<div class="dev-container">
	<h2 class="dev-panel dev-topbar dev-white dev-card-2" style="margin-top:0;margin-bottom:0;padding-top:0;">
		<i class="fa fa-pencil"></i> Adicionar novo Grupo
	</h2>
	<form class="dev-panel dev-topbar dev-white dev-card-2" method="POST" action="<?php $_SERVER["PHP_SELF"];?>">
		<input type="hidden" value="<?php echo $_GET["id"]?>" name="id">
		<p>
			<label>Nome</label>
			<input class="dev-input dev-border" type="text" name="nome" value="<?php echo $viewmodel["nome"]?>">
		</p>
		<p>
			<select class="dev-select dev-border" name="provincia_id" required>
				<option value="" disabled selected>Informe a Provincia</option>
				<option value="1" <?php if($viewmodel["provincia_id"] == 1) echo "selected";?>>Maputo Cidade</option>
				<option value="2" <?php if($viewmodel["provincia_id"] == 2) echo "selected";?>>Maputo Provincia</option>
				<option value="3" <?php if($viewmodel["provincia_id"] == 3) echo "selected";?>>Gaza</option>
				<option value="4" <?php if($viewmodel["provincia_id"] == 4) echo "selected";?>>Inhembane</option>
				<option value="5" <?php if($viewmodel["provincia_id"] == 5) echo "selected";?>>Manica</option>
				<option value="6" <?php if($viewmodel["provincia_id"] == 6) echo "selected";?>>Zambezia</option>
				<option value="7" <?php if($viewmodel["provincia_id"] == 7) echo "selected";?>>Sofala</option>
				<option value="8" <?php if($viewmodel["provincia_id"] == 8) echo "selected";?>>Tete</option>
				<option value="9" <?php if($viewmodel["provincia_id"] == 9) echo "selected";?>>Nampula</option>
				<option value="10" <?php if($viewmodel["provincia_id"] == 10) echo "selected";?>>Niassa</option>
				<option value="11" <?php if($viewmodel["provincia_id"] == 11) echo "selected";?>>Cabo Delegado</option>
			</select>
		</p>
		<p>
			<select class="dev-select dev-border" name="status" required>
				<option value="" disabled selected>Informe o Status da Categoria</option>
				<option value="1" <?php if($viewmodel["status"] == 1) echo "selected";?>>Activo</option>
				<option value="2" <?php if($viewmodel["status"] == 2) echo "selected";?>>Nao Activo</option>
			</select>
		</p>
		<p><input type="submit" class="dev-button dev-flat-belize-hole" name="salvar_bairro" value="Salvar&nbsp; ❯"></p>
	</form>
</div>
<script src="<?php echo ROOT_URL;?>assets/controllers/bairro.js"></script>