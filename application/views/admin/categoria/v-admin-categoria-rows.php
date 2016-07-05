<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_categoria); ?></td>
	<td><?php echo $modeloRow->codigo_categoria; ?></td>
	<td><?php echo $modeloRow->nombre_categoria; ?></td>
	<td>
		<a href="<?php echo base_url().$modulo->base_url."edit/".intval($modeloRow->id_categoria); ?>" data-row-type="ruta" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_categoria; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>

		</a>&nbsp;&nbsp;
		<a href="<?php echo base_url()."admin/tipo/".intval($modeloRow->id_categoria); ?>" data-row-type="tipos" data-row-action="tipos" data-row-id="<?php echo $modeloRow->id_categoria; ?>" class="btnActionRow"><span class="label label-success">Tipos</span>

		</a>&nbsp;&nbsp;
		<a href="#" data-row-type="ruta" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_categoria; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>