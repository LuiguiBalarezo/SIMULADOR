<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_operacion); ?></td>
	<td><?php echo $modeloRow->nombre_region; ?></td>
	<td><?php echo $modeloRow->nombre_operacion; ?></td>
	<td>
		<a href="<?php echo base_url().$modulo->base_url.intval($modeloRow->id_operacion); ?>" data-row-type="operacion" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_operacion; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;
		<a href="<?php echo base_url()."admin/rutas/".intval($modeloRow->id_operacion); ?>" data-row-type="rutas" data-row-action="rutas" data-row-id="<?php echo $modeloRow->id_operacion; ?>" class="btnActionRow"><span class="label label-warning">Rutas</span>

		</a>&nbsp;&nbsp;
		<a href="<?php echo base_url()."admin/placas/".intval($modeloRow->id_operacion); ?>" data-row-type="operacion" data-row-action="placas" data-row-id="<?php echo $modeloRow->id_operacion; ?>" class="btnActionRow"><span class="label label-info">Placas</span>

		</a>&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="#" data-row-type="operacion" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_operacion; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>