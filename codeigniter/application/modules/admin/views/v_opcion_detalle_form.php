	<li id="li_op_detalle_<?php echo $id_opcion;?>_<?php echo $id_opcion_detalle;?>" class="li_op_detalle"><label
		class="description"
		for="o_<?php echo $id_opcion;?>_<?php echo $id_opcion_detalle;?>_nombre_detalle">Nombre
			opcion detalle <?php echo $id_opcion_detalle;?></label>
		<div>
			<input id="o_<?php echo $id_opcion;?>_<?php echo $id_opcion_detalle;?>_nombre_detalle"
				name="o[<?php echo $id_opcion;?>][nombre_detalle][]"
				class="element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
				value="" />
						<?php echo img(array(
							'src' => base_url().'application/img/icon/delete-icon.png',
							'alt' => 'Eliminar item',
							'id' => 'o_i_d_'.$id_opcion_detalle
							));?>						
		</div>
		<p class="guidelines">
			<small>Ingresa el nombre de la opcion <?php echo $id_opcion_detalle;?></small>
		</p>
	</li>
