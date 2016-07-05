<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_operacion); ?></td>
	<td><?php echo $modeloRow->nombre_operacion; ?></td>
	
	<td>
		<a href="#" data-row-type="ruta" data-row-action="delete"
		data-row-id-user="<?php echo $modeloRow->id_usuario; ?>" data-row-id-ope="<?php echo $modeloRow->id_operacion; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>