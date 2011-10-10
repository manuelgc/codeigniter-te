
<div id="form_editar_usuario">
<?php if (isset($error_bd)) {?>
	<div id="error-bd" class="error"><?php echo $error_bd;?></div>
<?php }?>
<?php $oculto = array('oculto_registro'=>'1');
echo form_open('usuario/c_editar_usuario','',$oculto);?>
	<div class="form_description">
		<h2>Edita tus datos</h2>
		<p>Puedes editar tus datos personales, ademas de crear, editar y eliminar direcciones de envio.</p>
	</div>
	<ul>

		<li class="section_break">
			<h3>
			<?php echo lang('regcliente_datos_usuario')?>
			</h3>
		</li>
		<li id="li_1"><?php echo lang('regcliente_usuario','element_1','description');?>
			<div>
				<span>Datos de <?php echo $nombre_usuario;?></span>
			</div>

		</li>
		<li id="li_7"><?php echo lang('regcliente_contrasena','element_7','description');?>
			<div>
				<input id="element_7" name="password" class="element text medium"
					type="password" maxlength="255" value="" />
					<?php echo form_error('password','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_7">Su contraseña debe
				poseer minimo 8 caracteres</small>
		</li>
		
		<li class="section_break">
			<h3>
			<?php echo lang('regcliente_datos_generales')?>
			</h3>
			<p></p>
		</li>
		<li id="li_2"><?php echo lang('regcliente_nombre','element_2','description');?>
			<div>
				<input id="element_2" name="nombre" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo (!empty($nombre)) ? $nombre : set_value('nombre') ;?>" />
					<?php echo form_error('nombre','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_2">Ingresa tu nombre</small>

		</li>
		<li id="li_3"><?php echo lang('regcliente_apellidos','element_3','description');?>
			<div>
				<input id="element_3" name="apellidos" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo (!empty($apellidos)) ? $apellidos : set_value('apellidos');?>" />
					<?php echo form_error('apellidos','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_3">Ingresa tus apellidos</small>

		</li>
		<li id="li_5"><?php echo lang('regcliente_email','element_5','description');?>
			<div>
				<input id="element_5" name="correo" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo (!empty($correo)) ? $correo : set_value('correo');?>" />
					<?php echo form_error('correo','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_5">Es importante que
				ingreses una direccion de correo electronico valida ya que a traves
				de esta te enviaremos informacion de tus pedidos.</small>
		</li>
		<li id="li_9"><?php echo lang('regcliente_tlf_fijo','element_9','description');?>
			<span> 
				<input id="element_9_1" name="tlf_fijo_1" class="element text"
					size="3" maxlength="3" value="<?php echo (!empty($tlf_fijo_1)) ? $tlf_fijo_1 : set_value('tlf_fijo_1');?>"
					type="text"> - <label for="element_9_1">(251)</label> 
			</span> 
			<span>
				<input id="element_9_2" name="tlf_fijo_2" class="element text"
					size="3" maxlength="3" value="<?php echo (!empty($tlf_fijo_2)) ? $tlf_fijo_2 : set_value('tlf_fijo_2');?>"
					type="text"> - <label for="element_9_2">255</label> 
			</span> 
			<span> 
				<input id="element_9_3" name="tlf_fijo_3" class="element text" size="4"
					maxlength="4" value="<?php echo (!empty($tlf_fijo_3)) ? $tlf_fijo_3 : set_value('tlf_fijo_3');?>"
					type="text"> <label for="element_9_3">5555</label> 
			</span> 
				<?php echo form_error('tlf_fijo_1','<p class="error">','</p>');?>
			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				fijo tal como se te indica.</small>
		</li>
		<li id="li_4"><?php echo lang('regcliente_celular','element_4','description');?>
			<span> 
				<input id="element_4_1" name="celular_1" class="element text"
					size="3" maxlength="3" value="<?php echo (!empty($celular_1)) ? $celular_1 : set_value('celular_1');?>"
					type="text"> - <label for="element_4_1">(416)</label> 
			</span> 
			<span>
				<input id="element_4_2" name="celular_2" class="element text"
					size="3" maxlength="3" value="<?php echo (!empty($celular_2)) ? $celular_2 : set_value('celular_2');?>"
					type="text"> - <label for="element_4_2">555</label> 
			</span> 
			<span> 
				<input id="element_4_3" name="celular_3" class="element text" size="4"
					maxlength="4" value="<?php echo (!empty($celular_3)) ? $celular_3 : set_value('celular_3');?>"
					type="text"> <label for="element_4_3">5555</label> 
			</span> 
			<?php echo form_error('celular_1','<p class="error">','</p>');?>

			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				celular tal como se te indica.</small>
		</li>		
		<li id="li_16">
			<label for="element_16" class="description">Direccion de envio </label>
			
			<div><?php 
				echo form_dropdown('ciudad',$ciudad,NULL,'class="element select medium" id="element_16"');
				echo form_error('ciudad','<p class="error">','</p>');
				?>								
				<small class="guidelines" id="guide_16_1">Seleccione la ciudad
				donde se encuentra ubicado</small>
				<?php echo lang('regcliente_ciudad','element_16_1','description');?>
			</div>
		
			<div>
				<?php
				echo form_dropdown('zona',array(),NULL,'class="element select medium" id="element_17"');
				echo form_error('zona','<p class="error">','</p>');
				?>
				<small class="guidelines" id="guide_16_2">Seleccione la zona
				donde se encuentra ubicado</small>
				<?php echo lang('regcliente_zona','element_16_2','description');?>
			</div>
		
			<div class="left">
				<input id="element_16_3" name="calle_carrera"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo (!empty($calle_carrera)) ? $calle_carrera : set_value('calle_carrera');?>" />
					<?php echo form_error('calle_carrera','<p class="error">','</p>');?>
				
				<?php echo lang('regcliente_calle_carr','element_16_3','description');?>
				<small class="guidelines" id="guide_11">Ingrese la
				calle/carrera/vereda de ubicacion</small>
			</div>
		
			<div class="right">
				<input id="element_12" name="urb_edif" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo (!empty($urb_edif)) ? $urb_edif : set_value('urb_edif');?>" />
					<?php echo form_error('urb_edif','<p class="error">','</p>');?>
				
				<?php echo lang('regcliente_urb_edif','element_16_4','description');?>
				<small class="guidelines" id="guide_12">Seleccione la
				urbanizacion o edificio de ubicacion</small>
			</div>
		
			<div class="left">
				<input id="element_16_5" name="nroCasa_apt"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo (!empty($nroCasa_apt)) ? $nroCasa_apt : set_value('nroCasa_apt');?>" />
					<?php echo form_error('nroCasa_apt','<p class="error">','</p>');?>
				<?php echo lang('regcliente_numcasa_apto','element_16_5','description');?>
				<small id="guide_13" class="guidelines">Ingrese el numero de
				casa o apartamento</small>
			</div>
		
			<div class="right">
				<input id="element_16_6" name="lugar_referencia"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo (!empty($lugar_referencia)) ? $lugar_referencia : set_value('lugar_referencia');?>" />
					<?php echo form_error('lugar_referencia','<p class="error">','</p>');?>
			<?php echo lang('regcliente_lugar_referencia','element_16_6','description');?>
			<small id="guide_13" class="guidelines">Ingrese el numero de
				casa o apartamento</small>
		</div> 
		</li>																
		<li class="buttons"><input id="saveForm"
			class="button_text art-button" type="submit" name="submit"
			value="<?php echo lang('regcliente_boton');?>" />
		</li>

	</ul>
	</form>
</div>