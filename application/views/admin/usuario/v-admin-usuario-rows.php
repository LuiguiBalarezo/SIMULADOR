<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_usuario); ?></td>
	<td><?php echo $modeloRow->nombre." ".$modeloRow->apellidos; ?></td>
	<td><?php echo $modeloRow->usuario; ?></td>
	<td><?php echo $modeloRow->email; ?></td>
	<td><?php echo $modeloRow->nombre_region; ?></td>
	<td><?php echo $modeloRow->nombre_tipo_usuario; ?></td>
	
	<td><?php $fecha_registro = new DateTime($modeloRow->fecha_registro); echo date_format($fecha_registro, "Y-m-d"); ?></td>
	<td>
		<a href="<?php echo base_url().$modulo->base_url.intval($modeloRow->id_usuario); ?>" data-row-type="usuario" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_usuario; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;
		<a href="<?php echo base_url()."admin/operacionusuario/".intval($modeloRow->id_usuario); ?>" data-row-type="operacion" data-row-action="operacion" data-row-id="<?php echo $modeloRow->id_usuario; ?>" class="btnActionRow"><span class="label label-success">Operaciones</span>

		</a>&nbsp;&nbsp;
		<a href="#" data-row-type="usuario" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_usuario; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>