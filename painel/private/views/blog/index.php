<div class="dev-container">
	<div class="dev-row-padding dev-margin-top dev-margin-bottom" style="margin-left:-16px;margin-right:-16px">
		<div class="">
		<?php 
			$uteis = new Uteis;
		?>
		<a href="" class="dev-button dev-display-inline-block dev-flat-belize-hole j_cria_novo_imovel"><i class="fa fa-plus"></i> Adicionar</a>		
		<select class="dev-select dev-border dev-display-inline-block categorias j_agrupar" name="categorias">
			<option value="" selected disabled>Agrupar por Categorias</option>
			<option value="">Mostrar todos</option>
			<?php 
				$uteis->query('SELECT * FROM categorias WHERE status = 1');
				foreach($uteis->resultSet() as $row):				
					echo '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
				endforeach;
			?>
		</select>
		<select class="dev-select dev-border dev-display-inline-block proprietarios j_agrupar" name="proprietarios">
			<option value="" selected disabled>Agrupar por Proprietarios</option>
			<option value="">Mostrar todos</option>
			<?php 
				$uteis->query('SELECT * FROM proprietarios');
				foreach($uteis->resultSet() as $row):				
					echo '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
				endforeach;
			?>
		</select>
		</div>
		<div class="dev-padding">
			<input type="text" id="myInput"class="j_agrupar_imovel_titulo" placeholder="Pesquise Por titulo..">
		</div>	
	</div>

	<div class="dev-row" style="margin-left:-15px;margin-right:-15px;">
		<div class="j_pesquisa">
			<?php
				$last_id = "";
				foreach($viewmodel as $model):
				$last_id = $model["id"];
			?>
			<div class="dev-col l3 m6 dev-margin-bottom" style="padding-left:15px;padding-right:15px;" id="imoveis_<?php echo $model["id"]?>">
				<div class="dev-border dev-round-large dev-white dev-display-container">
					<div style="">
						<img src="tim.php?src=<?php echo ROOT_URL."private/uploads/imoveis/".$model["foto"]?>&w=317&h=224&a=c" alt="<?php echo $model["nome"]?>" class="dev-image dev-padding-small" style="max-height:224px;width:100%;">
					</div>
					<div class="dev-padding">
						<p style="min-height:50px;height:100px;overflow: hidden;  text-overflow: ellipsis; " class="dev-center"><a href="<?php echo ROOT.'imovel/'.$model['link']?>" target="_blank" class="dev-text-blue" style="text-decoration:none;"><?php echo $model["nome"]?></a></p>
						<p style="margin:0;" class="dev-small"><i class="fa fa-money"></i> <?php echo number_format($model["preco"],2)?> <?php echo $model["moeda"]?></p>
						<p style="margin:0;" class="dev-small">
							<span><i class="fa fa-bed"></i> <?php echo $model["quartos"]?></span>&nbsp;&nbsp;
							<span><i class="fa fa-shower"></i> <?php echo $model["casas_de_banho"]?></span>
						</p>
						<a href="#" class="dev-small" style="text-decoration:none;"><i class="fa fa-eye"></i> <?php echo $model["visitas"]?> visitas </a>
						
						<a href="#" class="dev-small" style="text-decoration:none;"><i class="fa fa-calendar"></i> <?php echo date("d/m/Y",strtotime($model["data_registo"]));?></a>
					</div>					
					<div class="dev-padding">
						<button class="mybtn dev-padding"><i class="fa fa-plus"></i> Acção</button>
						<div class="dropdown">
						  <button class="mybtn dev-padding" style="border-left:1px solid navy">
							<i class="fa fa-caret-down"></i>
						  </button>
						  <div class="dropdown-content">
							<a href="<?php echo ROOT_URL."imoveis/salvar/".$model["id"]?>" class="" style="border-radius:0;"><i class="fa fa-pencil"></i> Editar</a>
							<a class="j_remove_imovel" href="<?php echo $model["id"]?>" style="border-radius:0;"><i class="fa fa-trash"></i> Remover</a>
							<a class="" href="<?php echo ROOT.'imovel/'.$model['link']?>" target="_blank" style="border-radius:0;"><i class="fa fa-search"></i> Ver</a>
						  </div>
						</div>
					</div>
					<div class="dev-display-topleft" style="">
						<span class="dev-padding-small dev-small dev-flat-belize-hole">
						<?php 
							if($model["status"] == 1)
							{
								echo "Activo";
							}else if($model["status"] == 2)
							{
								echo "Não Activo";
							}else if($model["status"] == 3)
							{
								echo "Vendido";
							}else if($model["status"] == 4)
							{
								echo "Arrendado";
							}else if($model["status"] == 5)
							{
								echo "Em negociação";
							}
						?>
						</span>
					</div>
				</div>				
			</div>			
			<?php endforeach;?>
			<div class="dev-center dev-margin-top dev-margin-bottom j_page_button_loading">
				<button class="dev-button dev-flat-belize-hole j_page" <?php if(count($viewmodel) < 12) echo " disabled ";?> id="<?php echo $last_id?>">Mostrar mais Resultados</button>
			</div>	
		</div>
	</div>
</div>
<style>
#myInput {
  background-image: url('<?php echo ROOT_URL?>assets/icons/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}
	/* Dropdown Button */
.mybtn {
  background-color: #2980b9;
  color: white;
  font-size: 16px;
  border: none;
  outline: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: absolute;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #fff;
  border:1px solid #ccc;
  min-width: 160px;
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 5px 10px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #ddd}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.mybtn:hover, .dropdown:hover .mybtn  {
  background-color: #0b7dda;
}
</style>
<script src="<?php echo ROOT_URL;?>assets/controllers/blog.js"></script>