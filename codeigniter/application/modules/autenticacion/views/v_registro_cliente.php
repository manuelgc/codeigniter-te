<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#btn_comprobar_usuario").click(function(event){		
		event.preventDefault();
		var txt_usuario = $("#element_1").val();
		if(txt_usuario != ''){
		$('#error_nombre_usuario').hide('slow');
		$.post("<?php echo base_url();?>index.php/autenticacion/c_registro_usuario/comprobarNombreUsuario",
				{'usuario':txt_usuario},
				function(data){
					var nombre = data.nombre_usuario;
					if(nombre == '0'){						
						$('span#error_nombre_usuario').slideToggle().html('Puedes usar el nombre seleccionado');
					}else{
						$('span#error_nombre_usuario').addClass('error').slideToggle().html('El nombre de usuario '+nombre+' ya se esta usando, selecciona otro nombre de usuario').css('display','block');
					}
				},
				'json'
			);
		}else{
			$('#error_nombre_usuario').addClass('error').fadeToggle().append('Debe ingresar un nombre de usuario');
		}	
	});
	$("#element_16").change(	
			function(event){	
			event.preventDefault();
			var id_ciudad = $(this).val();
			if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/autenticacion/c_registro_usuario/cargarZona",
					{'id_ciudad':id_ciudad},
					function(data){
						if(data.zona!='0'){
						$("#element_17").empty().append(data.zona).attr("disabled",false);
						}else{
							$("#element_17").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
							alert("La ciudad seleccionada no tiene zonas registtradas");
							}
					},
					'json'
				);
			}else{
				$("#element_17").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
			}	
		});
	$("div img.cambiar-captcha").click(					
			function(){					
				$("div img.img-captcha").slideUp('fast');				
				$.post("<?php echo base_url();?>index.php/autenticacion/c_registro_usuario/crearCaptcha",
						function(data){							
							$('img.img-captcha').replaceWith(data);													
					});				
				$("div img.img-captcha").slideDown('fast');
	});
});
//-->
</script>
<div id="form_container">
<?php $oculto = array('oculto_registro'=>'1');
echo form_open('autenticacion/c_registro_usuario','',$oculto);?>
	<div class="form_description">
		<h2>Registro de clientes todoexpress</h2>
		<p>Crea tu cuenta para poder disfrutar de nuestros servicios.</p>
	</div>
	<ul>

		<li class="section_break">
			<h3>
			<?php echo lang('regcliente_datos_usuario')?>
			</h3>
		</li>
		<li id="li_1"><?php echo lang('regcliente_usuario','element_1','description');?>
			<div>
				<input id="element_1" name="usuario" style="float: left;"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo set_value('usuario');?>" />
					<?php echo form_error('usuario','<p class="error">','</p>');?>
				<input id="btn_comprobar_usuario" class="button_text art-button"
					type="button" name="btn_comprobar_usuario"
					value="<?php echo lang('regcliente_comprobar_usuario');?>" /> <span
					class="error" style="display: none;" id="error_nombre_usuario"></span>
			</div> <small class="guidelines" id="guide_1">Ingresa un nombre de
				usuario con el cual podras identificarte dentro de Todoexpress.com</small>

		</li>
		<li id="li_7"><?php echo lang('regcliente_contrasena','element_7','description');?>
			<div>
				<input id="element_7" name="password" class="element text medium"
					type="password" maxlength="255" value="" />
					<?php echo form_error('password','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_7">Su contraseña debe
				poseer minimo 8 caracteres</small>
		</li>
		<li id="li_8"><?php echo lang('regcliente_contrasena_confirm','element_8','description');?>
			<div>
				<input id="element_8" name="passwordConfirm"
					class="element text medium" type="password" maxlength="255"
					value="" />
					<?php echo form_error('passwordConfirm','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_8">Repita la contraseña</small>
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
					value="<?php echo set_value('nombre');?>" />
					<?php echo form_error('nombre','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_2">Ingresa tu nombre</small>

		</li>
		<li id="li_3"><?php echo lang('regcliente_apellidos','element_3','description');?>
			<div>
				<input id="element_3" name="apellidos" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo set_value('apellidos');?>" />
					<?php echo form_error('apellidos','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_3">Ingresa tus apellidos</small>

		</li>
		<li id="li_5"><?php echo lang('regcliente_email','element_5','description');?>
			<div>
				<input id="element_5" name="correo" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo set_value('correo');?>" />
					<?php echo form_error('correo','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_5">Es importante que
				ingreses una direccion de correo electronico valida ya que a traves
				de esta te enviaremos informacion de tus pedidos.</small>
		</li>
		<li id="li_9"><?php echo lang('regcliente_tlf_fijo','element_9','description');?>
			<span> <input id="element_9_1" name="tlf_fijo_1" class="element text"
				size="3" maxlength="3" value="<?php echo set_value('tlf_fijo_1');?>"
				type="text"> - <label for="element_9_1">(251)</label> </span> <span>
				<input id="element_9_2" name="tlf_fijo_2" class="element text"
				size="3" maxlength="3" value="<?php echo set_value('tlf_fijo_2');?>"
				type="text"> - <label for="element_9_2">255</label> </span> <span> <input
				id="element_9_3" name="tlf_fijo_3" class="element text" size="4"
				maxlength="4" value="<?php echo set_value('tlf_fijo_3');?>"
				type="text"> <label for="element_9_3">5555</label> </span> <?php echo form_error('tlf_fijo_1','<p class="error">','</p>');?>

			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				fijo tal como se te indica.</small>
		</li>
		<li id="li_4"><?php echo lang('regcliente_celular','element_4','description');?>
			<span> <input id="element_4_1" name="celular_1" class="element text"
				size="3" maxlength="3" value="<?php echo set_value('celular_1');?>"
				type="text"> - <label for="element_4_1">(416)</label> </span> <span>
				<input id="element_4_2" name="celular_2" class="element text"
				size="3" maxlength="3" value="<?php echo set_value('celular_2');?>"
				type="text"> - <label for="element_4_2">555</label> </span> <span> <input
				id="element_4_3" name="celular_3" class="element text" size="4"
				maxlength="4" value="<?php echo set_value('celular_3');?>"
				type="text"> <label for="element_4_3">5555</label> </span> <?php echo form_error('celular_1','<p class="error">','</p>');?>

			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				celular tal como se te indica.</small>
		</li>
		<li class="section_break">
			<h3>
			<?php echo lang('regcliente_datos_envio');?>
			</h3>
			<p>
			<?php echo lang('regcliente_datos_envio_descrip');?>
			</p>
		</li>
		<li id="li_16"><?php echo lang('regcliente_ciudad','element_16','description');?>
			<div>
			<?php
			echo form_dropdown('ciudad',$ciudad,NULL,'class="element select medium" id="element_16"');
			echo form_error('ciudad','<p class="error">','</p>');
			?>
			</div> <small class="guidelines" id="guide_16">Seleccione la zona
				donde se encuentra ubicado</small>
		</li>

		<li id="li_17"><?php echo lang('regcliente_zona','element_17','description');?>
			<div>
			<?php
			echo form_dropdown('zona',array(),NULL,'class="element select medium" id="element_17"');
			echo form_error('zona','<p class="error">','</p>');
			?>
			</div> <small class="guidelines" id="guide_17">Seleccione la zona
				donde se encuentra ubicado</small>
		</li>
		<li id="li_11"><?php echo lang('regcliente_calle_carr','element_11','description');?>
			<div>
				<input id="element_11" name="calle_carrera"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo set_value('calle_carrera');?>" />
					<?php echo form_error('calle_carrera','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_11">Ingrese la
				calle/carrera/vereda de ubicacion</small>
		</li>
		<li id="li_12"><?php echo lang('regcliente_urb_edif','element_12','description');?>
			<div>
				<input id="element_12" name="urb_edif" class="element text medium"
					type="text" maxlength="255"
					value="<?php echo set_value('urb_edif');?>" />
					<?php echo form_error('urb_edif','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_12">Seleccione la
				urbanizacion o edificio de ubicacion</small>
		</li>
		<li id="li_13"><?php echo lang('regcliente_numcasa_apto','element_13','description');?>
			<div>
				<input id="element_13" name="nroCasa_apt"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo set_value('nroCasa_apt');?>" />
					<?php echo form_error('nroCasa_apt','<p class="error">','</p>');?>
			</div> <small id="guide_13" class="guidelines">Ingrese el numero de
				casa o apartamento</small>
		</li>
		<li id="li_20"><?php echo lang('regcliente_lugar_referencia','element_20','description');?>
			<div>
				<input id="element_20" name="lugar_referencia"
					class="element text medium" type="text" maxlength="255"
					value="<?php echo set_value('lugar_referencia');?>" />
					<?php echo form_error('lugar_referencia','<p class="error">','</p>');?>
			</div> <small id="guide_13" class="guidelines">Ingrese el numero de
				casa o apartamento</small>
		</li>
		<li id="li_21">
			<div style="width:200px;float:left" id="content-captcha">
			<?php echo (isset($captcha)) ? $captcha : '';?>
			</div>
			<img alt="Cambiar Codigo" class="cambiar-captcha" src="<?php echo base_url();?>application/img/arrow_double.png" style="float:left;cursor: pointer;">
		</li>
		<li id="li_22"><?php echo lang('regcliente_cod_captcha','element_22','description');?>
			<div>
				<input id="element_22" name="cod_captcha"
					class="element text medium" type="text" maxlength="255" value="" />
					<?php echo form_error('cod_captcha','<p class="error">','</p>');?>
			</div> <small id="guide_22" class="guidelines">Ingrese el codigo tal
				como se indica en la imagen</small>
		</li>
		<li class="buttons"><input id="saveForm"
			class="button_text art-button" type="submit" name="submit"
			value="<?php echo lang('regcliente_boton');?>" />
		</li>

	</ul>
	</form>
</div>
