<?php echo form_open('pedido/c_pedido/guardarDireccion','id="form_agregar_dir"');?>
<fieldset>
	<legend> Direccion de envio </legend>

	<div class="left">
		<?php echo lang('regcliente_calle_carr','calle_carrera','description');?>
		<input id="calle_carrera"
			name="calle_carrera" class="element text medium"
			type="text" maxlength="255"
			value="<?php echo set_value('calle_carrera');?>" />
			<?php echo form_error('calle_carrera','<p class="error">','</p>');?>
		<small class="guidelines" id="guide_calle_carrera">Ingrese la
			calle/carrera/vereda de ubicacion</small>
	</div>

	<div class="right">
		<?php echo lang('regcliente_urb_edif','urb_edif','description');?>
		<input id="urb_edif" name="urb_edif"
			class="element text medium" type="text" maxlength="255"
			value="<?php echo set_value('urb_edif');?>" />
			<?php echo form_error('urb_edif','<p class="error">','</p>');?>

						
		<small class="guidelines" id="guide_urb_edif">Seleccione la urbanizacion o
			edificio de ubicacion</small>
	</div>

	<div class="left">
		<?php echo lang('regcliente_numcasa_apto','nroCasa_apt','description');?>
		<input id="nroCasa_apt"
			name="nroCasa_apt" class="element text medium"
			type="text" maxlength="255"
			value="<?php echo set_value('nroCasa_apt');	?>" />
			<?php echo form_error('nroCasa_apt','<p class="error">','</p>');?>
			
		<small id="guide_nroCasa_apt" class="guidelines">Ingrese el numero de casa o
			apartamento</small>
	</div>

	<div class="right">
		<?php echo lang('regcliente_lugar_referencia','lugar_referencia','description');?>
		<input id="lugar_referencia"
			name="lugar_referencia" class="element text medium"
			type="text" maxlength="255"
			value="<?php echo set_value('lugar_referencia'); ?>" />
			<?php echo form_error('lugar_referencia','<p class="error">','</p>');?>
			
		<small id="guide_lugar_referencia" class="guidelines">Ingrese el numero de casa o
			apartamento</small>
	</div>
</fieldset>
<span class="art-button-wrapper">
	<span class="art-button-l"> </span>
	<span class="art-button-r"> </span>
<?php echo form_input(array(
				'id'=>'guardar-dir',
				'name'=>'guardar-dir',
				'value'=>'Guardar',
				'type'=>'button',
				'class' => 'button_text art-button'
			)); 
?>	
</span>
<span class="art-button-wrapper">
	<span class="art-button-l"> </span>
	<span class="art-button-r"> </span>
<?php echo form_input(array(
	'id'=>'cancelar',
	'name' => 'cancelar',
	'value'=> 'Cancelar',
	'type' => 'button',
	'class' => 'button_text art-button'
));?>	
</span>
<?php echo form_close();?>