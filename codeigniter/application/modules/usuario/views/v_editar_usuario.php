<script type="text/javascript">
<!--
$(document).ready(function(){			
	<?php 
			if (isset($editar_dir)) {
		?>
			var id_direccion = <?php echo $editar_dir;?>;	
		<?php
			}else{
		?>
			var id_direccion = '';
		<?php
			}
		?>	

	$('fieldset').each(function(){
		var id = $(this).attr('id');
		if(id_direccion == ''){
			$(this).collapse({closed:true});
		}else{
			if(id_direccion == id){
				$(this).collapse();
			}else{
				$(this).collapse({closed:true});
			}
		}
	});	

	$('.ciudad').each(function (){
		$(this).change(function(e){
			e.preventDefault();
			var id_ciudad = $(this).val();
			var id = $(this).attr('id').substr(7,8);
			
			if(id_ciudad != ''){
				$.post("<?php echo base_url();?>index.php/usuario/c_editar_usuario/cargarZona",
						{'id_ciudad':id_ciudad},
						function(data){
							if(data.zona!='0'){
							$("#zona_"+id).empty().append(data.zona).attr("disabled",false);
							}else{
								$("#zona_"+id).empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
									alert("La ciudad seleccionada no tiene zonas registradas");
								}
						},
						'json'
					);
			}else{
					$("#zona_"+id).empty().append('<option value="">Seleccione</option>;').attr("disabled",true);
			}
		});
	});
});
//-->
</script>
<div id="form_editar_usuario">
<?php if (isset($error_bd)) {?>
	<div id="error-bd" class="error">
	<?php echo $error_bd;?>
	</div>
	<?php }?>
	<?php $oculto = array('oculto_edicion_usuario'=>'1','cant_dir' => $cant_dir);
	echo form_open('usuario/c_editar_usuario','',$oculto);?>
	<div class="form_description">
		<h2>Edita tus datos</h2>
		<p>Puedes editar tus datos personales, ademas de crear, editar y
			eliminar direcciones de envio.</p>
	</div>
	<ul>

		<li class="section_break">
			<h3>
			<?php echo lang('regcliente_datos_usuario')?>
			</h3>
		</li>
		<li id="li_1"><?php echo lang('regcliente_usuario','element_1','description');?>
			<div>
				<span>Datos de <?php echo $nombre_usuario;?> </span>
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
					value="<?php 
						if (form_error('nombre','<p class="error">','</p>') == '') {
							if (set_value('nombre') == '') {
								echo $nombre;
							}else {
								echo set_value('nombre');
							}
						}
					?>" />
					<?php echo form_error('nombre','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_2">Ingresa tu nombre</small>

		</li>
		<li id="li_3"><?php echo lang('regcliente_apellidos','element_3','description');?>
			<div>
				<input id="element_3" name="apellidos" class="element text medium"
					type="text" maxlength="255"
					value="<?php 
					if (form_error('apellidos','<p class="error">','</p>') == '') {
						if (set_value('apellidos') == '') {
							echo $apellidos;
						}else {
							echo set_value('apellidos');
						}
					}
					?>" />
					<?php echo form_error('apellidos','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_3">Ingresa tus apellidos</small>

		</li>
		<li id="li_5"><?php echo lang('regcliente_email','element_5','description');?>
			<div>
				<input id="element_5" name="correo" class="element text medium"
					type="text" maxlength="255"
					value="<?php 
					if (form_error('correo','<p class="error">','</p>') == '') {
						if (set_value('correo') == '') {
							echo $correo;
						}else {
							echo set_value('correo');
						}
					}
					?>" />
					<?php echo form_error('correo','<p class="error">','</p>');?>
			</div> <small class="guidelines" id="guide_5">Es importante que
				ingreses una direccion de correo electronico valida ya que a traves
				de esta te enviaremos informacion de tus pedidos.</small>
		</li>
		<li id="li_9"><?php echo lang('regcliente_tlf_fijo','element_9','description');?>
			<span> <input id="element_9_1" name="tlf_fijo_1" class="element text"
				size="3" maxlength="3"
				value="<?php 
				if (form_error('tlf_fijo_1','<p class="error">','</p>') == '') {
					if (set_value('tlf_fijo_1') == '') {
						echo $tlf_fijo_1;
					}else {
						echo set_value('tlf_fijo_1');
					}
				}
				?>"
				type="text"> - <label for="element_9_1">(251)</label> </span> <span>
				<input id="element_9_2" name="tlf_fijo_2" class="element text"
				size="3" maxlength="3"
				value="<?php 
				if (form_error('tlf_fijo_1','<p class="error">','</p>') == '') {
					if (set_value('tlf_fijo_2') == '') {
						echo $tlf_fijo_2;
					}else {
						echo set_value('tlf_fijo_2');
					}
				}							
				?>"
				type="text"> - <label for="element_9_2">255</label> </span> <span> <input
				id="element_9_3" name="tlf_fijo_3" class="element text" size="4"
				maxlength="4"
				value="<?php 
				if (form_error('tlf_fijo_1','<p class="error">','</p>') == '') {
					if (set_value('tlf_fijo_3') == '') {
						echo $tlf_fijo_3;
					}else {
						echo set_value('tlf_fijo_3');
					}
				}					
				?>"
				type="text"> <label for="element_9_3">5555</label> </span> <?php echo form_error('tlf_fijo_1','<p class="error">','</p>');?>
			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				fijo tal como se te indica.</small>
		</li>
		<li id="li_4"><?php echo lang('regcliente_celular','element_4','description');?>
			<span> <input id="element_4_1" name="celular_1" class="element text"
				size="3" maxlength="3"
				value="<?php 
				if (form_error('celular_1','<p class="error">','</p>') == '') {
					if (set_value('celular_1') == '') {
						echo $celular_1;
					}else {
						echo set_value('celular_1');
					}
				}					
				?>"
				type="text"> - <label for="element_4_1">(416)</label> </span> <span>
				<input id="element_4_2" name="celular_2" class="element text"
				size="3" maxlength="3"
				value="<?php 
				if (form_error('celular_1','<p class="error">','</p>') == '') {
					if (set_value('celular_2') == '') {
						echo $celular_2;
					}else {
						echo set_value('celular_2');
					}
				}					
				?>"
				type="text"> - <label for="element_4_2">555</label> </span> <span> <input
				id="element_4_3" name="celular_3" class="element text" size="4"
				maxlength="4"
				value="<?php 
				if (form_error('celular_1','<p class="error">','</p>') == '') {
					if (set_value('celular_3') == '') {
						echo $celular_3;
					}else {
						echo set_value('celular_3');
					}
				}					
				?>"
				type="text"> <label for="element_4_3">5555</label> </span> <?php echo form_error('celular_1','<p class="error">','</p>');?>

			<small class="guidelines" id="guide_4">Ingresa tu numero de telefono
				celular tal como se te indica.</small>
		</li>
		<li id="li_16"><?php
		$i = 1;
		$contador_zona = 0;
		foreach ($direcciones as $direccion):
		?>
			<fieldset id="<?php echo $direccion['id'];?>">
				<?php echo form_hidden('dir_id_'.$i,$direccion['id']);?>
				<legend>
					Direccion de envio
					<?php echo $i;?>
				</legend>

				<div>
				<?php
				if (form_error('ciudad_'.$i,'<p class="error">','</p>') == '') {
					if (set_select('ciudad_'.$i) == '') {
						echo form_dropdown('ciudad_'.$i,$ciudades,$direccion['ciudad'],'class="element select medium ciudad" id="ciudad_'.$i.'"');
					}else {
						echo form_dropdown('ciudad_'.$i,$ciudades,set_select('ciudad_'.$i),'class="element select medium ciudad" id="ciudad_'.$i.'"');
					}
				}else {
					echo form_dropdown('ciudad_'.$i,$ciudades,array(),'class="element select medium ciudad" id="ciudad_'.$i.'"');
				}				
				echo form_error('ciudad_'.$i,'<p class="error">','</p>');
				?>
					<small class="guidelines" id="guide_ciudad_<?php echo $i;?>">Seleccione
						la ciudad donde se encuentra ubicado</small>
						<?php echo lang('regcliente_ciudad','ciudad_'.$i,'description');?>
				</div>

				<div>
				<?php
				if (form_error('zona_'.$i,'<p class="error">','</p>') == '') {
					if (set_select('zona_'.$i) == '') {
						echo form_dropdown('zona_'.$i,$zonas_ciudad[$contador_zona],$direccion['zona'],'class="element select medium" id="zona_'.$i.'"');
					}else {
						echo form_dropdown('zona_'.$i,$zonas_ciudad[$contador_zona],set_select('zona_'.$i),'class="element select medium" id="zona_'.$i.'"');
					}
				}else {
					echo form_dropdown('zona_'.$i,$zonas_ciudad[$contador_zona],array(),'class="element select medium" id="zona_'.$i.'"');
				}	
				
				echo form_error('zona_'.$i,'<p class="error">','</p>');
				?>
					<small class="guidelines" id="guide_zona_<?php echo $i;?>">Seleccione
						la zona donde se encuentra ubicado</small>
						<?php echo lang('regcliente_zona','zona_'.$i,'description');?>
				</div>

				<div class="left">
					<input id="calle_carrera_<?php echo $i;?>"
						name="calle_carrera_<?php echo $i;?>" class="element text medium"
						type="text" maxlength="255"
						value="<?php 
						if (form_error('calle_carrera_'.$i,'<p class="error">','</p>') == '') {
							if (set_value('calle_carrera_'.$i) == '') {
								echo $direccion['calle_carrera'];
							}else {
								echo set_value('calle_carrera_'.$i);
							}
						}													
						?>" />
						<?php echo form_error('calle_carrera_'.$i,'<p class="error">','</p>');?>

						<?php echo lang('regcliente_calle_carr','calle_carrera_'.$i,'description');?>
					<small class="guidelines" id="guide_11">Ingrese la
						calle/carrera/vereda de ubicacion</small>
				</div>

				<div class="right">
					<input id="urb_edif_<?php echo $i;?>"
						name="urb_edif_<?php echo $i;?>" class="element text medium"
						type="text" maxlength="255"
						value="<?php 
						if (form_error('urb_edif_'.$i,'<p class="error">','</p>') == '') {
							if (set_value('urb_edif_'.$i) == '') {
								echo $direccion['casa_urb'];
							}else {
								echo set_value('urb_edif_'.$i);
							}
						}							
						?>" />
						<?php echo form_error('urb_edif_'.$i,'<p class="error">','</p>');?>

						<?php echo lang('regcliente_urb_edif','urb_edif_'.$i,'description');?>
					<small class="guidelines" id="guide_12">Seleccione la urbanizacion
						o edificio de ubicacion</small>
				</div>

				<div class="left">
					<input id="nroCasa_apt_<?php echo $i;?>"
						name="nroCasa_apt_<?php echo $i;?>" class="element text medium"
						type="text" maxlength="255"
						value="<?php 
						if (form_error('nroCasa_apt_'.$i,'<p class="error">','</p>') == '') {
							if (set_value('nroCasa_apt_'.$i) == '') {
								echo $direccion['numeroCasaApto'];
							}else {
								echo set_value('nroCasa_apt_'.$i);
							}
						}													
						?>" />
						<?php echo form_error('nroCasa_apt_'.$i,'<p class="error">','</p>');?>
						<?php echo lang('regcliente_numcasa_apto','nroCasa_apt_'.$i,'description');?>
					<small id="guide_13" class="guidelines">Ingrese el numero de casa o
						apartamento</small>
				</div>

				<div class="right">
					<input id="lugar_referencia_<?php echo $i;?>"
						name="lugar_referencia_<?php echo $i;?>"
						class="element text medium" type="text" maxlength="255"
						value="<?php 
						if (form_error('lugar_referencia_'.$i,'<p class="error">','</p>') == '') {
							if (set_value('lugar_referencia_'.$i) == '') {
								echo $direccion['lugarreferencia'];
							}else {
								echo set_value('lugar_referencia_'.$i);
							}
						}							
						?>" />
						<?php echo form_error('lugar_referencia_'.$i,'<p class="error">','</p>');?>
						<?php echo lang('regcliente_lugar_referencia','lugar_referencia_'.$i,'description');?>
					<small id="guide_13" class="guidelines">Ingrese el numero de casa o
						apartamento</small>
				</div>
			</fieldset> <?php 
			$contador_zona++;
			$i++;
			endforeach;
			?>
		</li>
		<li class="buttons"><input id="saveForm"
			class="button_text art-button" type="submit" name="submit"
			value="<?php echo lang('regcliente_boton');?>" />
		</li>

	</ul>
	</form>
</div>
