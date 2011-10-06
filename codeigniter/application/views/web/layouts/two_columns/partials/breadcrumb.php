<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#cmb_ciudad").change(	
		function(event){	
		event.preventDefault();
		var id_ciudad = $(this).val();
		if(id_ciudad != ''){
		$.post("<?php echo base_url();?>index.php/busqueda/c_busqueda/cargarZonaAjax",
				{'id_ciudad':id_ciudad},
				function(data){
					if(data.zona!='0'){
					$("#cmb_zona").empty().append(data.zona).attr("disabled",false);
					}else{
						$("#cmb_zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
						alert("La ciudad seleccionada no tiene zonas registtradas");
						}
				},
				'json'
			);
		}else{
			$("#cmb_zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
		}	
	});
	$("#frm_busqueda").submit(function() {
		if(($("#cmb_ciudad").val() == '') && ($("#cmb_zona").val() == '') && ($("#cmb_categoria").val() == '') &&($("#cmb_tipo_orden").val() == '')){

			$('#error_combos_vacios').empty().append('Debe seleccionar al menos 1 criterio de busqueda').show();	
			return false;	
		}else{
			$('#error_combos_vacios').empty();
			return true;
		}	
	});
});

//-->
</script>
<div
	id="form_container"><!--<form id="form_248918" class="appnitro" method="post" action="">-->
<?php echo form_open('busqueda/c_busqueda',array('id' => 'frm_busqueda'));?>
<div class="form_description">
<h2>Busqueda</h2>
<p>Busqueda de restaurantes.</p>
</div>
<ul>

	<li id="li_1"><?php echo lang('busqueda_ciudad','cmb_ciudad','description');?>
	<div><?php echo form_dropdown('ciudad',$opcion_combos['ciudad'],$opcion_combos['select_ciudad'],'id=cmb_ciudad class="element text medium"'); ?>
	<small class="guidelines" id="guide_1">Seleciona la ciudad donde te en
	cuentras</small></div>

	</li>
	<li id="li_2"><?php echo lang('busqueda_zona','cmb_zona','description');?>
	<div class="combo-zona"><?php 
	$disb=(sizeof($opcion_combos['zona'])==0)?'disabled="disabled"':'';
	echo form_dropdown('zona',$opcion_combos['zona'],$opcion_combos['select_zona'],'id=cmb_zona class="element text medium" '.$disb);?>
	</div>
	<small class="guidelines" id="guide_2">Seleciona la zona donde te en
	cuentras</small>

	</li>
	<li id="li_3"><?php echo lang('busqueda_categoria','cmb_categoria','description');?>
	<div>
	<?php echo form_dropdown('categoria',$opcion_combos['categoria'],$opcion_combos['select_categoria'],'id=cmb_categoria class="element text medium"'); ?>
	<small class="guidelines" id="guide_3">Seleciona el tipo de comida</small>
	</div>
	</li>
	<li id="li_4"><?php echo lang('busqueda_tipo_orden','cmb_tipo_orden','description');?>
	<div><?php echo form_dropdown('tipo_orden',$opcion_combos['orden'],$opcion_combos['select_orden'],'id=cmb_tipo_orden class="element text medium"'); ?>
	<small class="guidelines" id="guide_4">Seleciona el tipo de orden</small>
	</div>
	</li>

	<li class="buttons">
	<input id="campo_busqueda" name="campo_busqueda" type="hidden" value="1" />
	<p class="error" style="display: none;" id="error_combos_vacios"></p>
	<input id="btn_buscar" ,
			class="button_text art-button"
		type="submit" name="btn_buscar"
		value="<?php echo lang('busqueda_boton_buscar');?>" /></li>

</ul>
<?php echo form_close();?>
</div>


