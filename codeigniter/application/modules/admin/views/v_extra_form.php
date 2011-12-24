<fieldset id="content_extra_<?php echo $id_extra;?>">
	<legend> Extra <?php echo $id_extra;?> </legend>
	<ul>
		<li><label class="description" for="nombre_extra_<?php echo $id_extra;?>">Nombre extra</label>
			<div>
				<input id="nombre_extra_<?php echo $id_extra;?>" name="nombre_extra_<?php echo $id_extra;?>"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa el nombre del extra del plato</small>
			</p>
		</li>


		<li><label class="description" for="extra_requirido_<?php echo $id_extra;?>">Requerido </label>
			<div>
			<?php
			echo form_dropdown('extra_requerido_'.$id_extra,array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="extra_requirido_'.$id_extra.'"');
			?>
			</div>
			<p class="guidelines">
				<small>Seleccione si es plato principal o secundario.</small>
			</p></li>
		<li><label class="description" for="minimo_extra_<?php echo $id_extra;?>">Minimo extra</label>
			<div>
				<input id="minimo_extra_<?php echo $id_extra;?>" name="minimo_extra_<?php echo $id_extra;?>"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si es
					requerido y 0 si no).</small>
			</p>
		</li>
		<li><label class="description" for="maximo_extra_<?php echo $id_extra;?>">Maximo extra</label>
			<div>
				<input id="maximo_extra_<?php echo $id_extra;?>" name="maximo_extra_<?php echo $id_extra;?>"
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
