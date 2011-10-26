<?php if (isset($error)): ?>
	<div class="message"><?php echo $error;?></div>
<?php endif;?>
<div id="form_container_login">

<?php 
$oculto = array('oculto'=>'1');
echo form_open('admin/c_login_admin','id="form-login"',$oculto);?>
	<div class="form_description">
		<h2>Ingresa a tu cuenta</h2>
		<p></p>
	</div>
	<ul>

		<li id="nombre-correo">					
		<?php echo lang('logincliente_usuario','nombre_usuario','descripcion');?>
			<div>
				<input id="nombre_usuario" name="nombre_usuario" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo set_value('nombre_usuario');?>" />
					<?php echo form_error('nombre_usuario','<p class="error">','</p>');?>
			</div>
			<small class="guidelines" id="guide_nombre_usuario">Ingresa tu nombre de usuario o
				correo electronico</small></li>
		<li id="contrasena">			
		<?php echo lang('logincliente_pass','contrasena','description');?>
			<div>
				<input id="contrasena" name="contrasena" class="element text medium"
					type="password" maxlength="255" value="" />
					<?php echo form_error('contrasena','<p class="error">','</p>');?>
			</div>
			<small class="guidelines" id="guide_2">Ingresa tu contrasena</small>
		</li>
		<li class="buttons"><input id="ingresar"
			class="button_text art-button" type="submit" name="submit"
			value="Ingresar" /></li>
			<?php echo anchor('admin/c_recordar_password','Problemas para acceder a tu cuenta?');?>
	</ul>
	<?php echo form_close();?>
</div>

