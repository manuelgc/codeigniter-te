	<li id="li_ext_detalle_<?php echo $id_extra_detalle;?>" class="li_ext_detalle">
		<div style="width: 50%;">
		<label class="description" for="nombre_extra_detalle_<?php echo $id_extra_detalle;?>">Nombre
			extra detalle <?php echo $id_extra_detalle;?></label>
			<input id="nombre_extra_detalle_<?php echo $id_extra_detalle;?>"
				name="nombre_extra_detalle_<?php echo $id_extra_detalle;?>"
				class="element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
				value="" />											
		</div>
		<p class="guidelines">
			<small>Ingresa el nombre de la extra <?php echo $id_extra_detalle;?></small>
		</p>
				
		<div style="width: 50%;">
		<label class="description" for="precio_extra_detalle_<?php echo $id_extra_detalle;?>">Precio
			extra detalle <?php echo $id_extra_detalle;?></label>
			<input id="precio_extra_detalle_<?php echo $id_extra_detalle;?>"
				name="precio_extra_detalle_<?php echo $id_extra_detalle;?>"
				class="element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
				value="" />												
		</div>
		<p class="guidelines">
			<small>Ingresa el nombre de la extra <?php echo $id_extra_detalle;?></small>
		</p>
		<?php echo img(array(
							'src' => base_url().'application/img/icon/delete-icon.png',
							'alt' => 'Eliminar item',
							'id' => 'e_i_d_'.$id_extra_detalle
							));?>
		<p class="guidelines">
			<small>Ingresa el precio del item extra <?php echo $id_extra_detalle;?></small>
		</p>
	</li>
