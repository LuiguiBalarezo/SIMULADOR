<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_placa); ?></td>
	<td><?php echo $modeloRow->placa; ?></td>
	
	<td>
		<a href="<?php echo base_url().$modulo->base_url."edit/".intval($modeloRow->id_placa); ?>" data-row-type="operacion" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_placa; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;
		
		<a href="#" data-row-type="operacion" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_placa; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>