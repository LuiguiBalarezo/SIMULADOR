<?php if (is_array($modulo->registros)) {
	foreach ($modulo->registros as $modeloRow) { ?>
	
	<tr>
	<td><?php echo intval($modeloRow->id_evento); ?></td>
	<td><?php echo $modeloRow->codigo_evento; ?></td>
	<td><?php echo $modeloRow->nombre_evento; ?></td>
	<td>
		<a href="<?php echo base_url().$modulo->base_url.intval($modeloRow->id_evento); ?>" data-row-type="evento" data-row-action="edit" data-row-id="<?php echo $modeloRow->id_evento; ?>" class="btnActionRow"><span class="label label-primary">Editar</span>
		</a>&nbsp;&nbsp;

		<a href="<?php echo base_url()."admin/categoria/".intval($modeloRow->id_evento); ?>" data-row-type="categoria" data-row-action="categoria" data-row-id="<?php echo $modeloRow->id_evento; ?>" class="btnActionRow"><span class="label label-warning">Categorias</span>
		</a>&nbsp;&nbsp;

		<a href="#" data-row-type="evento" data-row-action="delete"
		data-row-id="<?php echo $modeloRow->id_evento; ?>" class="btnActionRow"><span class="label label-danger">Eliminar</span></a>
	</td>
	</tr>
	
<?php }}
?>