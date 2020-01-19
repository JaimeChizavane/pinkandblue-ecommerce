<div class="dev-container">
	<div class="dev-responsive">
		<table class="dev-table-all">
			<tr>
			  <th>assunto</th>
			  <th>email</th>
			  <th>Data de Registo</th>
			  <th>&nbsp;</th>
			</tr>
			<?php 
				$uteis = new Uteis;
				foreach($viewmodel as $mensagem):
			?>
			<tr>
			  <td><?php echo $mensagem["mensagens_assunto"]?></td>
			  <td><?php echo $mensagem["mensagens_email"]?></td>
			  <td><?php echo date("d/m/Y",strtotime($mensagem["mensagens_data_registo"]));?></td>
			  <td>
				<a class="dev-button dev-flat-belize-hole small" href="<?php echo ROOT_URL?>mensagens/ver/<?php echo $mensagem["mensagens_id"]?>">
					<i class="fa fa-search"></i> Ver
				</a>

				<a class="dev-button dev-flat-alizarin small" href="<?php echo ROOT_URL?>mensagens/remover/<?php echo $mensagem["mensagens_id"]?>">
					<i class="fa fa-trash"></i> Remover
				</a>
			  </td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>	
</div>