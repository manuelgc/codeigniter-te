<fieldset id="content_extra_<?php echo $id_extra;?>">
	<legend> Extra <?php echo $id_extra;?> </legend>
	<ul>
		<li><label class="description" for="e_<?php echo $id_extra;?>_nombre">Nombre extra</label>
			<div>
				<input id="e_<?php echo $id_extra;?>_nombre" name="e_<?php echo $id_extra;?>_nombre"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa el nombre del extra del plato</small>
			</p>
		</li>


		<li><label class="description" for="e_<?php echo $id_extra;?>_requirido">Requerido </label>
			<div>
			<?php
			echo form_dropdown('e_'.$id_extra.'_requerido',array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="e_'.$id_extra.'_requerido"');
			?>
			</div>
			<p class="guidelines">
				<small>Seleccione si es plato principal o secundario.</small>
			</p></li>
		<li><label class="description" for="e_<?php echo $id_extra;?>_minimo">Minimo extra</label>
			<div>
				<input id="e_<?php echo $id_extra;?>_minimo" name="e_<?php echo $id_extra;?>_minimo"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si es
					requerido y 0 si no).</small>
			</p>
		</li>
		<li><label class="description" for="e_<?php echo $id_extra;?>_maximo">Maximo extra</label>
			<div>
				<input id="e_<?php echo $id_extra;?>_maximo" name="e_<?php echo $id_extra;?>_maximo"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad maxima de opcion (0 sin limite).</small>
			</p>
		</li>
	</ul>
	<input id="e_d_<?php echo $id_extra;?>" type="button" class="art-button"
		value="Nueva Extra Detalle" />
</fieldset>
