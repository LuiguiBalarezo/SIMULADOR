<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_ruta); ?></td>
	<td><?php echo $modeloRow->nombre_ruta; ?></td>
	
	<td>
		<a href="<?php echo base_url().$modulo->base_url."edit/".intval($modeloRow->id_ruta); ?>" data-row-type="ruta" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_ruta; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;
		<a href="<?php echo base_url()."admin/tramos/".intval($modeloRow->id_ruta); ?>" data-row-type="tramos" data-row-action="tramos" data-row-id="<?php echo $modeloRow->id_ruta; ?>" class="btnActionRow"><span class="label label-warning">Tramos</span>

		</a>&nbsp;&nbsp;
		<a href="#" data-row-type="ruta" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_ruta; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>