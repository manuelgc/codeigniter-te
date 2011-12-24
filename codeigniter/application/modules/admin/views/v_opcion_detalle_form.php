	<li id="li_op_detalle_<?php echo $id_opcion_detalle;?>" class="li_op_detalle"><label
		class="description"
		for="nombre_opcion_detalle_<?php echo $id_opcion_detalle;?>">Nombre
			opcion detalle <?php echo $id_opcion_detalle;?></label>
		<div>
			<input id="nombre_opcion_detalle_<?php echo $id_opcion_detalle;?>"
				name="nombre_opcion_detalle_<?php echo $id_opcion_detalle;?>"
				class="element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
				value="" />
						<?php echo img(array(
							'src' => base_url().'application/img/icon/delete-icon.png',
							'alt' => 'Eliminar item',
							'id' => 'o_i_d_'.$id_opcion_detalle
							));?>
						<?php echo form_error('nombre_opcion_detalle_'.$id_opcion_detalle,'<p class="error">','</p>');?>
		</div>
		<p class="guidelines">
			<small>Ingresa el nombre de la opcion <?php echo $id_opcion_detalle;?></small>
		</p>
	</li>
