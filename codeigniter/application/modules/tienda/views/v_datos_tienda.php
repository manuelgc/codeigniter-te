
<script>
	$(function() {
		
		$( "#tabs_tienda" ).tabs();
		$("#popup-zona").dialog({
			title:'Seleccionar Zona',
			autoOpen: false,
			modal:true,
			resizable: false,
			show:"blind",
			hide:"explode",
			buttons: {
			'Cancelar' : function(){
			$(this).dialog('close');
				}
			}							
		});
		
		$(".a-plato").click(function(event){	
			event.preventDefault();
			var id_tienda = $("#id_tienda").val() ;
			
			$.post("<?php echo base_url();?>index.php/tienda/c_datos_tienda/validarDatos",
					{'id_tienda':id_tienda},
					function(data){
						if(!data.abierto){
//						if(data.abierto){	
							$("#popup-tienda").html(data.html).dialog({
								title:'Cerrado',
								modal:true,
								resizable: false,
								show:"blind",
								hide:"explode",
								buttons: {
								'Cerrar' : function(){
								$(this).dialog('close');
									}
								}

												
							}).dialog('open');
						}else if(!data.zona){
							$("#popup-tienda").html(data.html)
							.dialog({
								title:'Seleccionar Zona',
								autoOpen: false,
								modal:true,
								resizable: false,
								show:"blind",
								hide:"explode",
								buttons: {
								'Cancelar' : function(){
								$(this).dialog('close');
									}
								}

												
							})
							.dialog('open');
						}	
							
					},
					'json'
				);
				
		});
	});
</script>



<div class="tienda">
<div id="cabecera_tienda">
			<input id="id_tienda" name="id_tienda" type="hidden" value="<?php echo $id;?>" />
			<div class="titulo_tienda" name="" width="70%">
				<h2><span class="text"><?php echo $nombre ?> </span></h2>
				<span class="text"><?php echo $tipo_comida?> </span><br>
				<span class="text">Telefonos: <?php echo $telefono;?></span><br>
				<span class="text">Cant. Minima: <?php echo $min_cant;?></span><br>
				<span class="text">Gasto Minimo: <?php echo $min_cost;?></span><br>
				<span class="text"><?php echo $tipo_venta;?></span><br>
			</div>
			<div class="imagenes_tienda" name="" width="30%">
				<div>
					<img src="<?php echo $imagen;?>" class="">
				</div>
				<div>
					<img src="<?php echo $imagen_horario;?>" class="">
				</div>
					
			</div>			
</div>
<div id="tabs_tienda">
	<ul>
		<li><a href="#tab_menu">Menu</a></li>
		<li><a href="#tab_info">Informaci&oacute;n</a></li>
	</ul>
	<div id="tab_menu">

		<?php 
		if(is_array($menu)){
		foreach ($menu as $categoia => $plato):?>
		<h3><?php echo $categoia;?></h3>
		<ul>

			<?php foreach ($plato as $id => $p):?>	
				<li>
					<a class="a-plato" name="<?php echo $id;?>" value="<?php echo $id;?>" href="">
						<span class="text"><?php echo $p['nombre'];?> </span>
						<span class="text"><?php echo $p['precio'];?> Bs. </span>
					</a>
				</li>
			<?php endforeach;?>	

		</ul>
		<?php endforeach;
		}else{?>
			<span class="text"><?php echo $menu ?></span><br>
		<?php }//end else?>
		
	</div>
	<div id="tab_info">		
		<span class="text">Descripci&oacute;n: <?php echo $descripcion?> </span><br>
		<span class="text">Direcci&oacute;n: <?php echo $direccion?> </span><br>
		<span class="text">Horarios:</span><br>
		<?php if(is_array($horario)){
		 foreach ($horario as $key => $value):?>
			<span class="text"><?php echo $key ?></span>
			<span class="text"><?php echo $value ?></span><br>
		<?php endforeach;
		}else{?>
			<span class="text"><?php echo $horario ?></span><br>
		<?php }//end else?>
	</div>
</div>

</div>
<div id="popup-tienda"></div>
<div id="popup-zona" title="Create new user">
	<p>Aun no ha seleccionado la zona donde se encuentra</p>
	<form>
	<fieldset>
	
	<?php echo lang('busqueda_ciudad','cmb_ciudad','description');?>
	<div><?php echo form_dropdown('ciudad',$ciudad,null,'id=cmb_ciudad class="element text medium"'); ?>
	<small class="guidelines" id="guide_1">Seleciona la ciudad donde te encuentras</small></div>

	
	<?php echo lang('busqueda_zona','cmb_zona','description');?>
	<div class="combo-zona"><?php 
	$disb=(sizeof($opcion_combos['zona'])==0)?'disabled="disabled"':'';
	echo form_dropdown('zona',$opcion_combos['zona'],$opcion_combos['select_zona'],'id=cmb_zona class="element text medium" '.$disb);?>
	</div>
	<small class="guidelines" id="guide_2">Seleciona la zona donde te encuentras</small>
	</ul>
		</fieldset>
	</form>
</div>


