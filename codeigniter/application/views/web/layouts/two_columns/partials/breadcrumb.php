<script type="text/javascript">
<!--
$(document).ready(function(){
	$("#element_1").change(	
		function(event){	
		event.preventDefault();
		var id_ciudad = $(this).val();
		if(id_ciudad != ''){
		$.post("<?php echo base_url();?>index.php/busqueda/c_busqueda/cargarZonaAjax",
				{'id_ciudad':id_ciudad},
				function(data){
					if(data.zona!='0'){
					$("#element_2").empty().append(data.zona).attr("disabled",false);
					}else{
						$("#element_2").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
						alert("La ciudad seleccionada no tiene zonas registtradas");
						}
				},
				'json'
			);
		}else{
			$("#element_2").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
		}	
	});
	$("#frm_busqueda").submit(function() {
		if(($("#element_1").val() == '') && ($("#element_2").val() == '') && ($("#element_3").val() == '') &&($("#element_4").val() == '')){

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

	<li id="li_1"><?php echo lang('busqueda_ciudad','element_1','description');?>
	<div><?php echo form_dropdown('ciudad',$opcion_combos['ciudad'],$opcion_combos['select_ciudad'],'id=element_1 class="element text medium"'); ?>
	<small class="guidelines" id="guide_1">Seleciona la ciudad donde te en
	cuentras</small></div>

	</li>
	<li id="li_2"><?php echo lang('busqueda_zona','element_2','description');?>
	<div><?php 
	$disb=(sizeof($opcion_combos['zona'])==0)?'disabled="disabled"':'';
	echo form_dropdown('zona',$opcion_combos['zona'],$opcion_combos['select_zona'],'id=element_2 class="element text medium" '.$disb);?>
	<small class="guidelines" id="guide_2">Seleciona la zona donde te en
	cuentras</small></div>

	</li>
	<li id="li_3"><?php echo lang('busqueda_categoria','element_3','description');?>
	<div><?php echo form_dropdown('categoria',$opcion_combos['categoria'],$opcion_combos['select_categoria'],'id=element_3 class="element text medium"'); ?>
	<small class="guidelines" id="guide_3">Seleciona el tipo de comida</small>
	</div>
	</li>
	<li id="li_4"><?php echo lang('busqueda_tipo_orden','element_4','description');?>
	<div><?php echo form_dropdown('tipo_orden',$opcion_combos['orden'],$opcion_combos['select_orden'],'id=element_4 class="element text medium"'); ?>
	<small class="guidelines" id="guide_4">Seleciona el tipo de orden</small>
	</div>
	</li>

	<li class="buttons"><input id="campo_busqueda" name="campo_busqueda"
		type="hidden" value="1" />
	<p class="error" style="display: none;" id="error_combos_vacios"></p>
	<input id="btn_buscar" ,
			class="button_text art-button"
		type="submit" name="btn_buscar"
		value="<?php echo lang('busqueda_boton_buscar');?>" /></li>

</ul>
</form>

</div>


