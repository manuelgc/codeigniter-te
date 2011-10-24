<div id="form_container">
<?php echo form_open('autenticacion/c_recordar_datos/nuevoPassword','id="recordar-datos"',array('oculto'=>'1'));?>
	<div class="form_description">
		<h2>Nueva contrasena</h2>		
	</div>
	<ul>
		<li id="li_1"><label class="description" for="nuevo_password">Nueva Contrasena </label>
			<div>				
				<input id="nuevo_password" name="nuevo_password" class="element text medium"
					type="text" maxlength="255" value="<?php echo set_value('nuevo_password');?>" />
					<?php echo form_error('nuevo_password','<p class="error">','</p>');?>
			</div>
			<p class="guidelines" id="guide_nueva_contrasena">
				<small>Ingresa tu nueva contrasena</small>
			</p>
		</li>
		<li id="li_2"><label class="description" for="confirmar_password">Confirmar Contrasena </label>
			<div>				
				<input id="confirmar_password" name="confirmar_password" class="element text medium"
					type="text" maxlength="255" value="<?php echo set_value('confirmar_password');?>" />
					<?php echo form_error('confirmar_password','<p class="error">','</p>');?>
			</div>
			<p class="guidelines" id="guide_correo">
				<small>Repite la contrasena</small>
			</p>
		</li>

		<li class="buttons"><input id="enviar"
			class="button_text art-button" type="submit" name="submit"
			value="Enviar" /></li>
	</ul>

	<?php echo form_close();?>
</div>
