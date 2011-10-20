<div id="form_container">
<?php echo form_open('autenticacion/c_recordar_datos','id="recordar-datos"',array('oculto'=>'1'));?>
	<div class="form_description">
		<h2>Recordar Contrasena</h2>		
	</div>
	<ul>
		<li id="li_1"><label class="description" for="correo">Correo </label>
			<div>				
				<input id="correo" name="correo" class="element text medium"
					type="text" maxlength="255" value="<?php echo set_value('correo');?>" />
					<?php echo form_error('correo','<p class="error">','</p>');?>
			</div>
			<p class="guidelines" id="guide_correo">
				<small>Ingresa tu direccion de correo electronico</small>
			</p>
		</li>

		<li class="buttons"><input id="enviar"
			class="button_text art-button" type="submit" name="submit"
			value="Enviar" /></li>
	</ul>

	<?php echo form_close();?>
</div>
