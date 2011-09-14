<div id="form_container"><!--<form id="form_248918" class="appnitro" method="post" action="">-->
<?php echo form_open('busqueda/c_busqueda');?>
<div class="form_description">
<h2>Busqueda</h2>
<p>Busqueda de restaurantes.</p>
</div>
<ul>

	<li id="li_1"><?php echo lang('busqueda_ciudad','element_1','description');?>
	<div>
		<?php echo form_dropdown('ciudad',$opcion_combos['ciudad'],NULL,'id=element_1'); ?>
	</div>
	</li>
	<li id="li_2"><?php echo lang('busqueda_zona','element_2','description');?>
	<div><select class="element select medium" id="element_2"
		name="zona">
		<option value="" selected="selected"></option>
		<option value="1">Third option</option>


	</select></div>
	</li>
	<li id="li_3"><?php echo lang('busqueda_categoria','element_3','description');?>
	<div><?php echo form_dropdown('categoria',$opcion_combos['categoria'],NULL,'id=element_3'); ?>

	</div>
	</li>
	<li id="li_4"><?php echo lang('busqueda_tipo_orden','element_4','description');?>
	<div><?php echo form_dropdown('tipo_oreden',$opcion_combos['orden'],NULL,'id=element_4'); ?>

	</div>
	</li>

<!--	<li class="buttons"><input type="hidden" name="form_id" value="248918" />-->
<!---->
<!--	<input id="saveForm" class="button_text" type="submit" name="submit"-->
<!--		value="Buscar" /></li>-->
	<li class="buttons"><input id="saveForm",
			class="button_text art-button" type="submit" name="submit"
			value="<?php echo lang('busqueda_boton_buscar');?>" />
		</li>	
</ul>
</form>

</div>


