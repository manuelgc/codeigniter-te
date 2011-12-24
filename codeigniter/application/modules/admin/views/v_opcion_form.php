<fieldset id="content_<?php echo $id_opcion;?>">
	<legend> Opcion <?php echo $id_opcion;?> </legend>
	<ul>
		<li><label class="description" for="nombre_opcion_<?php echo $id_opcion;?>">Nombre opcion</label>
			<div>
				<input id="nombre_opcion_<?php echo $id_opcion;?>" name="nombre_opcion_<?php echo $id_opcion;?>"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa el nombre de la opcion</small>
			</p>
		</li>


		<li><label class="description" for="opcion_requirido_<?php echo $id_opcion;?>">Requerido </label>
			<div>
			<?php
			echo form_dropdown('opcion_requerido_'.$id_opcion,array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="opcion_requirido_'.$id_opcion.'"');
			?>
			</div>
			<p class="guidelines">
				<small>Seleccione si es plato principal o secundario.</small>
			</p></li>
		<li><label class="description" for="minimo_opcion_<?php echo $id_opcion;?>">Minimo opcion</label>
			<div>
				<input id="minimo_opcion_<?php echo $id_opcion;?>" name="minimo_opcion_<?php echo $id_opcion;?>"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si es
					requerido y 0 si no).</small>
			</p>
		</li>
		<li><label class="description" for="maximo_opcion_<?php echo $id_opcion;?>">Maximo opcion</label>
			<div>
				<input id="maximo_opcion_<?php echo $id_opcion;?>" name="maximo_opcion_<?php echo $id_opcion;?>"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad maxima de opcion (0 sin limite).</small>
			</p>
		</li>
	</ul>
	<input id="o_d_<?php echo $id_opcion;?>" type="button" class="art-button"
		value="Nueva Opcion Detalle" />
</fieldset>
