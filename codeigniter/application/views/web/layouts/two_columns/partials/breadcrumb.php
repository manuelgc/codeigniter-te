<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#element_1").change(	
		function(event){	
		event.preventDefault();
		var id_ciudad = $(this).val();
		if(id_ciudad != ''){
		$.post("<?php echo base_url();?>index.php/busqueda/c_busqueda/cargarZona",
				{'id_ciudad':id_ciudad},
				function(data){
					if(data.zona!='0'){
					$("#element_2").empty().append(data.zona).attr("disabled",false);
					}else{
						$("#element_2").empty().append('<option value="" >Seleccione</option>;').attr("disabled",false);
						alert("La ciudad seleccionada no tiene zonas registtradas");
						}
				},
				'json'
			);
		}else{
			$("#element_2").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
		}	
	});
});

//-->
</script>
<div id="form_container"><!--<form id="form_248918" class="appnitro" method="post" action="">-->
<?php echo form_open('busqueda/c_busqueda');?>
<div class="form_description">
<h2>Busqueda</h2>
<p>Busqueda de restaurantes.</p>
</div>
<ul>

	<li id="li_1"><?php echo lang('busqueda_ciudad','element_1','description');?>
	<div>
		<?php echo form_dropdown('ciudad',$opcion_combos['ciudad'],NULL,'id=element_1 class="element text medium"'); ?>
	</div>
	</li>
	<li id="li_2"><?php echo lang('busqueda_zona','element_2','description');?>
	<div>
		<?php echo form_dropdown('zona',array(''=>''),NULL,'id=element_2 class="element text medium" disabled="disabled"');?>

	</div>
	</li>
	<li id="li_3"><?php echo lang('busqueda_categoria','element_3','description');?>
	<div><?php echo form_dropdown('categoria',$opcion_combos['categoria'],NULL,'id=element_3 class="element text medium"'); ?>

	</div>
	</li>
	<li id="li_4"><?php echo lang('busqueda_tipo_orden','element_4','description');?>
	<div><?php echo form_dropdown('tipo_orden',$opcion_combos['orden'],NULL,'id=element_4 class="element text medium"'); ?>

	</div>
	</li>

	<li class="buttons">
	<input id="campo_busqueda" name="campo_busqueda" type="hidden" value="1" />
	<input id="btn_buscar",
			class="button_text art-button" type="submit" name="btn_buscar"
			value="<?php echo lang('busqueda_boton_buscar');?>" />
		</li>	
</ul>
</form>

</div>


