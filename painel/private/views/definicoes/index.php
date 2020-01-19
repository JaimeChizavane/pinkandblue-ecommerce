<div class="dev-container">
	<div style="margin:15px 0">
		<button onclick="document.getElementById('id01').style.display='block'" class="dev-button dev-flat-belize-hole j_cria_nova_definicao"><i class="fa fa-cog"></i> Definicoes</button>
	</div>
	<div class="dev-responsive">
		<div class=" dev-panel dev-topbar dev-white dev-padding">
			<table class="dev-table-all">
				<tr>
				  <th>Provedor</th>
				  <th>API KEY</th>
				  <th>Cliente</th>
				  <th>&nbsp;</th>
				</tr>
				<?php 
					$uteis = new Uteis;
					foreach($viewmodel as $definicoes):
				?>
				<tr>
				  <td><?php echo $definicoes["definicoes_provedor"]?></td>
				  <td><?php echo $definicoes["definicoes_api_key"]?></td>
				  <td><?php
						if($definicoes["definicoes_status"] == 1)
						{
							echo '<span class="dev-button small dev-flat-belize-hole">Activo</span>';
						}else{
							echo '<span class="dev-button small dev-flat-alizarin">Inactivo</span>';
						} 

					?></td>
				  <td>
					<a class="dev-button small dev-flat-belize-hole " href="<?php echo ROOT_URL?>definicoes/salvar/<?php echo $definicoes["definicoes_id"]?>">
						<i class="fa fa-edit"></i> Editar
					</a>
					<a class="dev-button small dev-flat-alizarin" href="<?php echo ROOT_URL?>definicoes/remover/<?php echo $definicoes["definicoes_id"]?>">
						<i class="fa fa-trash"></i> Remover
					</a>
				  </td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>	
	</div>	
</div>