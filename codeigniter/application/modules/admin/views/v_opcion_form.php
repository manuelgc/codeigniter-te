<fieldset id="content_<?php echo $id_opcion;?>">
	<legend> Opcion <?php echo $id_opcion;?> </legend>
	<ul>		 
		<li><label class="description" for="o_<?php echo $id_opcion;?>_nombre">Nombre opcion</label>
			<div>
				<input id="o_<?php echo $id_opcion;?>_nombre" name="o_<?php echo $id_opcion;?>_nombre"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="255"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa el nombre de la opcion</small>
			</p>
		</li>


		<li><label class="description" for="o_<?php echo $id_opcion;?>_requirido">Requerido </label>
			<div>
			<?php
			echo form_dropdown('o_'.$id_opcion.'_requerido',array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="o_'.$id_opcion.'_requerido"');
			?>
			</div>
			<p class="guidelines">
				<small>Seleccione si es plato principal o secundario.</small>
			</p></li>
		<li><label class="description" for="o_<?php echo $id_opcion;?>_minimo">Minimo opcion</label>
			<div>
				<input id="o_<?php echo $id_opcion;?>_minimo" name="o_<?php echo $id_opcion;?>_minimo"
					class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default" type="text" maxlength="3"
					value="" />						
			</div>
			<p class="guidelines">
				<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si es
					requerido y 0 si no).</small>
			</p>
		</li>
		<li><label class="description" for="o_<?php echo $id_opcion;?>_maximo">Maximo opcion</label>
			<div>
				<input id="o_<?php echo $id_opcion;?>_maximo" name="o_<?php echo $id_opcion;?>_maximo"
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
