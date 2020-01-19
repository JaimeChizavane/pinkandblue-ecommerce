<div class="dev-container">
	<div class="dev-border dev-white dev-padding dev-margin-bottom">
		<div class="dev-col l3">
			<h1 class="dev-large dev-margin-0"><i class="fa fa-shopping-cart"></i> Produtos - Home</h1>
		</div>
		<div class="dev-col l9">
			<button class="mybtn dev-padding"><i class="fa fa-plus"></i> Acção</button>
			<div class="dropdown">
			  <button class="mybtn dev-padding" style="border-left:1px solid navy">
				<i class="fa fa-caret-down"></i>
			  </button>
			  <div class="dropdown-content">
				<a href="javascript:void(0)" class="j_cria_novo_produto" style="border-radius:0;">Adicionar Novo</a>
			  </div>
			</div>
		</div>	
	</div>
	<div class="dev-margin-top dev-clear">		
		<select class="dev-select dev-col l3 dev-border dev-large dev-round-xlarge j_select_categoria categorias j_agrupar" name="categoria_id" id="categoria_id">				
			<option value="" disabled selected>Selecciona Categoria</option>
			<?php 
				$uteis = new Uteis;
				$uteis->query('SELECT * FROM categorias WHERE status = 1 AND tipo IN("produto")');
				$uteis->execute();
				$rows= $uteis->resultSet();
				foreach($rows as $categoria):
					echo '<option value="'.$categoria["id"].'">'.$categoria["nome"].'</option>';
				endforeach;
			?>
		</select>
		<select class="dev-select dev-border dev-col l3 dev-large dev-round-xlarge j_select_subcategoria subcategorias j_agrupar" name="subcategoria_id" id="subcategoria_id">
			<option value="" disabled selected>Selecciona Subcategoria</option>	
		</select>
		<select class="dev-select dev-border dev-col l3 dev-large dev-round-xlarge j_select_marca marcas j_agrupar" name="marca_id" id="marca_id">
			<option value="" disabled selected>Selecciona Marcas</option>
		</select>
		<select class="dev-select dev-border dev-col l3 dev-large dev-round-xlarge proprietarios j_agrupar" name="proprietario_id" id="proprietario_id">
		<option value="" disabled selected>Selecciona Proprietario</option>
		<?php 
			$uteis = new Uteis;
			$uteis->query('SELECT * FROM proprietarios WHERE status = 1 AND tipo IN("produto")');
			$uteis->execute();
			$rows= $uteis->resultSet();
			foreach($rows as $proprietario):
				echo '<option value="'.$proprietario["id"].'">'.$proprietario["nome"].'</option>';
			endforeach;
		?>
		</select>
		<div class="dev-col l12 dev-margin-top">
			<input type="text" id="myInput"class="dev-round-large j_agrupar_produto_titulo" placeholder="Pesquise Por titulo..">
		</div>	
	</div>

	<div class="dev-row" style="margin-left:-15px;margin-right:-15px;">
		<div class="j_pesquisa">
			<?php
				$last_id = "";
				foreach($viewmodel as $model):
				$last_id = $model["id"];
			?>
			<div class="dev-col l3 m6 s6 dev-margin-bottom" style="padding-left:15px;padding-right:15px;" id="produtos_<?php echo $model["id"]?>">
				<div class="dev-border dev-round-large dev-white dev-display-container">
					<div style="" class="dev-center">
						<img src="<?php echo ROOT_URL."private/uploads/produtos/".$model["foto"]?>" alt="<?php echo $model["nome"]?>" class="dev-image dev-padding-small" style="max-width:200px;max-height:180px;">
					</div>
					<div class="dev-padding">						
						<p style="min-height:50px;height:50px;overflow: hidden;  text-overflow: ellipsis; margin-top:0" class="dev-center"><a href="<?php echo ROOT.'produtos/'.$model['link']?>" target="_blank" class="dev-text-blue" style="text-decoration:none;"><?php echo $model["nome"]?></a></p>
						<p class="dev-margin-0"><span class="dev-padding-small dev-small dev-flat-belize-hole">
							<?php echo $model["c_nome"]?>
						</span></p>
						<p style="margin:0;" class="dev-large"><?php echo $model["moeda"]?> <?php echo number_format($model["preco"],2)?></p>
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
							<a href="<?php echo ROOT_URL."produtos/salvar/".$model["id"]?>" class="" style="border-radius:0;"><i class="fa fa-pencil"></i> Editar</a>
							<a class="j_remove_produto" href="<?php echo $model["id"]?>" style="border-radius:0;"><i class="fa fa-trash"></i> Remover</a>
							<a class="" href="<?php echo ROOT.'produtos/'.$model['link']?>" target="_blank" style="border-radius:0;"><i class="fa fa-search"></i> Ver</a>
						  </div>
						</div>
					</div>
					<div class="dev-display-topleft" style="">
						<span class="dev-padding-small dev-small dev-flat-belize-hole">
							<?php 
								if($model["status"] == 1)
								{
									echo "Activo";
								}else if($model["status"] == 0)
								{
									echo "Não Activo";
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
<script src="<?php echo ROOT_URL;?>assets/controllers/produto.js"></script>
<script>
$(document).ready(function()
{
	$(".j_select_categoria").on("change", function()
	{
		var categoria_id = $(this).val();
		if(categoria_id)
		{
			$.ajax({
				method:	'POST',
				url: 	'<?php echo ROOT_URL?>categorias/retornaSubcategoriaseMarcas',
				data:	'categoria_id='+categoria_id,
				dataType: "JSON",
				success:	function(responseText)
				{
					if(responseText.status == "success")
					{
						$('.j_select_subcategoria').html(responseText.subcategorias);
						$('.j_select_marca').html(responseText.marcas);
					}
				},
				beforeSend : function()
				{
					$('.j_select_subcategoria').html('<option value="">Carregando...</option>');
				}
			}); 
		}else{
			$('.j_select_subcategoria').html('<option value="">Selecciona a categoria</option>');
		}
	});
});
</script>