<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_evento_riesgo); ?></td>
	<td><?php echo $modeloRow->nombre_region; ?></td>
	<td><?php echo $modeloRow->nombre_operacion; ?></td>
	<td><?php echo $modeloRow->nombre_ruta; ?></td>
	<td><?php echo $modeloRow->nombre_tramo; ?></td>
	<td><?php echo $modeloRow->placa; ?></td>
	<td><?php $fecha_registro = new DateTime($modeloRow->fecha_registro); echo date_format($fecha_registro, "d-m-Y"); ?></td>
	<td><?php echo $modeloRow->codigo_evento. " - ".$modeloRow->nombre_evento; ?></td>
	<td><?php echo $modeloRow->codigo_categoria. " - ".$modeloRow->nombre_categoria; ?></td>
	<td><?php echo $modeloRow->codigo_tipo. " - ".$modeloRow->nombre_tipo; ?></td>
	<td><?php echo $modeloRow->nombre." ".$modeloRow->apellidos; ?></td>
	<td><?php echo $modeloRow->descripcion; ?></td>
	<td>
		<a href="#" data-row-type="operacion" data-row-action="delete"
		   data-row-id="<?php echo $modeloRow->id_evento_riesgo; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>