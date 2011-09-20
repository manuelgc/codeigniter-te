<div id="form_container">

<?php echo form_open('autenticacion/c_login','id="form-login"');?>
	<div class="form_description">
		<h2>Ingresa a tu cuenta</h2>
		<p></p>
	</div>
	<ul>

		<li id="li_1">
			<!-- <label class="description" for="element_1">Nombre de usuario o Correo electronico </label>  -->
		<?php echo lang('logincliente_usuario','element_1','descripcion');?>
			<div>
				<input id="element_1" name="usuario" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo set_value('usuario');?>" />
					<?php echo form_error('usuario','<p class="error">','</p>');?>
			</div>
			<small class="guidelines" id="guide_1">Ingresa tu nombre de usuario o
				correo electronico</small></li>
		<li id="li_2">
			<!-- <label class="description" for="element_2">Contrasena </label>  -->
		<?php echo lang('logincliente_pass','element_2','description');?>
			<div>
				<input id="element_2" name="contrasena" class="element text medium"
					type="password" maxlength="255" value="" />
					<?php echo form_error('contrasena','<p class="error">','</p>');?>
			</div>
			<small class="guidelines" id="guide_2">Ingresa tu contrasena</small>
		</li>
		<li class="buttons"><input id="saveForm"
			class="button_text art-button" type="submit" name="submit"
			value="Ingresar" /></li>
	</ul>
	<?php echo form_close();?>
</div>
