<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_tipo); ?></td>
	<td><?php echo $modeloRow->codigo_tipo; ?></td>
	<td><?php echo $modeloRow->nombre_tipo; ?></td>
	<td>
		<a href="<?php echo base_url().$modulo->base_url."edit/".intval($modeloRow->id_tipo); ?>" data-row-type="tipo" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_tipo; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;

		<a href="#" data-row-type="tipo" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_tipo; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>