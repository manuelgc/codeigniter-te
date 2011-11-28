<script type="text/javascript">
$(document).ready(function(){
	var id_tienda = '';
	
	$('#popup').dialog({
		'autoOpen':false,
		width:800,
		title:'Tiendas',
		height: 600,
		modal:true,
		show:"blind",
		hide:"explode",
		buttons:{			
			'Cerrar' : function(){
				$(this).dialog('close');
			}
		},
		close: function(){
			$('#form-filtro-tiendas').each (function(){
				this.reset();
			});
		}	
	});
	
	$('#ciudad').change(function(e){		
		e.preventDefault();
		var id_ciudad = $(this).val();	
		
		if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/admin/c_tienda_com_admin/cargarZona",
					{'id_ciudad':id_ciudad},
					function(data){
						if(data.zona!='0'){
							$("#zona").empty().append(data.zona).attr("disabled",false);
						}else{
							$("#zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
								alert("La ciudad seleccionada no tiene zonas registradas");
							}
					},
					'json'
				);
		}else{
				$("#zona").empty().append('<option value="">Seleccione</option>;').attr("disabled",true);
		}
	});	
		
	$('#boton-catalogo').live('click',function(e){
		e.preventDefault();		
		$('#popup').dialog('open');
	});

	$('#ciudad_popup').live('change',function(e){						
		var id_ciudad = $(this).val();	
		
		if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/admin/c_tienda_com_admin/cargarZona",
					{'id_ciudad':id_ciudad},
					function(data){
						if(data.zona!='0'){
							$("#zona_popup").empty().append(data.zona).attr("disabled",false);
						}else{
							$("#zona_popup").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
								alert("La ciudad seleccionada no tiene zonas registradas");
							}
					},
					'json'
				);
		}else{
				$("#zona").empty().append('<option value="">Seleccione</option>;').attr("disabled",true);
		}
	});	

	$('ul.link > li a').live('click', function(e){
		e.preventDefault();
		var vinculo = $(this).attr('href');
		 $.ajax({
			url: vinculo,
			type: 'GET',
			dataType: 'json',
			beforeSend: function(data){
				preCargador('.content-tiendas');
			},				
			success: function (data) {					
				cargarTablaTienda(data);
			}				
		});			
	});

	function preCargador(selector){
		$(selector).block({ //'.content-pedidos'
			message: 'Cargando ...'		
		});
	}

	function cargarTablaTienda(html){
		window.setTimeout( function(){
			$('div.content-tiendas').html(html.lista_ped);
			$('ul.link').html(html.link_pag);
		}, 1000);
	}

	$('input:checked').live('click',function(){
		var id_tienda_selec = $(this).val();
		$.ajax({
			url:'<?php base_url()?>c_tienda_com_admin/getTiendaById/',
			dataType:'json',
			type:'POST',
			data: {id_tienda : id_tienda_selec},
			success:function(data){	
				$('#id_tienda').val(data.id);
				$('#nombre_tienda').val(data.nombre);
				$('#descrip_tienda').val(data.descripcion);
				$('#tlf_1_1').val(data.tlf_1.substring(1,4));
				$('#tlf_1_2').val(data.tlf_1.substring(4,7));
				$('#tlf_1_3').val(data.tlf_1.substring(7,11));
				$('#tlf_2_1').val(data.tlf_2.substring(1,4));
				$('#tlf_2_2').val(data.tlf_2.substring(4,7));
				$('#tlf_2_3').val(data.tlf_2.substring(7,11));
				$('#razon_social').val(data.razonsocial);
				$('#ci_rif').val(data.ci_rif);
				$('#min_ord_cant').val(data.min_ord_cant);
				$('#min_ord_precio').val(data.min_ord_precio);
				(data.estacionamiento == 0) ? $('#estacionamiento').removeAttr('checked') : $('#estacionamiento').attr('checked',true);
				$('#ciudad').val(data.ciudad);
				$('#zona').replaceWith(data.zona);
				$('#min_tiempo_ent').val(data.min_tiempo_ent);
				$('#min_tiempo_esp').val(data.min_tiempo_esp);
				$('#costo_envio').val(data.costoenvio);
			}
		});
		$('#popup').dialog('close');
	});
	
	$('#boton-catalogo-reset').live('click',function(){
		$('#form-filtro-tiendas').each (function(){
			this.reset();
		});
		$.ajax({
			url:'<?php base_url()?>c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});
	
	$('#ciudad_popup').live('change',function(){
		if($('#ciudad_popup').val() != ''){
			var id_ciudad = $('#ciudad_popup').val(); 
		}
		if($('#zona_popup').val() != ''){
			var id_zona = $('#zona_popup').val(); 
		}
		$.ajax({
			url:'<?php base_url()?>c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			data:{
				id_tienda : id_tienda ,
				id_ciudad : id_ciudad,
				id_zona : id_zona
			},
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});

	$('#zona_popup').live('change',function(){
		if($('#ciudad_popup').val() != ''){
			var id_ciudad = $('#ciudad_popup').val(); 
		}
		if($('#zona_popup').val() != ''){
			var id_zona = $('#zona_popup').val(); 
		}
		$.ajax({
			url:'<?php base_url()?>c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			data:{
				id_tienda : id_tienda ,
				id_ciudad : id_ciudad,
				id_zona : id_zona
			},
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});
	
	$('#nombre_tienda_catalogo').live('keyup', function(){		
		$(this).autocomplete({
			source:function(req,resp){
				$.ajax({
					url:'<?php base_url()?>c_tienda_com_admin/getNombreTiendas',
					dataType:'json',
					type:'POST',
					data:{term : req.term},
					success:function(data){
						resp($.map(data,function(item){	
							id_tienda = item.id;						
							return {
								value: item.label,
								label: item.label							
							}
						}));
					}					
				});
			},
			minLength: 2,
			select:function(event,ui){		
				if($('#ciudad_popup').val() != ''){
					var id_ciudad = $('#ciudad_popup').val(); 
				}
				if($('#zona_popup').val() != ''){
					var id_zona = $('#zona_popup').val(); 
				}
						
				$.ajax({
					url:'<?php base_url()?>c_tienda_com_admin/catalogoTienda/',
					dataType:'json',
					type:'POST',
					data: { id_tienda : id_tienda ,
							id_ciudad : id_ciudad,
							id_zona : id_zona
						},
					beforeSend:function(data){
						preCargador('.content-tiendas');
					},
					success:function(data){
						cargarTablaTienda(data);
					}
				});
			}
		});
	});		
});
</script>
<?php if (isset($mensaje)):?>
	<div class="message"><?php echo $mensaje;?></div>
<?php endif;?>
<div id="form_container">

	<h1>
		<a>Tienda de Comida</a>
	</h1>	
	<?php echo form_open_multipart('admin/c_tienda_com_admin/','id="form_tiendas_comida"',array('oculto'=>'1','id_tienda'=>''));?>
		<div class="form_description">
			<h2>Tienda de Comida</h2><div><input id="boton-catalogo" class="button_text art-button"
				type="button" name="boton-catalogo" value="Buscar" /></div>
			<p>Ingresa la informancion a continuacion para registrar un
				restaurante dentro de TodoExpress</p>
		</div>
		<ul>

			<li id="li_1"><label class="description" for="nombre_tienda">Nombre
					Tienda </label>
				<div>
					<input id="nombre_tienda" name="nombre_tienda" class="element text medium"
						type="text" maxlength="255" value="<?php 
						if (form_error('nombre_tienda','<p class="error">','</p>') != '') {
							echo set_value('nombre_tienda');
						}else{
							if(isset($tienda_nueva) && $tienda_nueva == 0){								
								echo set_value('nombre_tienda');
							}else {
								echo '';
							}
						}
						?>" />
						<?php echo form_error('nombre_tienda','<p class="error">','</p>');?>
				</div>
				<p class="guidelines" id="guide_1">
					<small>Ingresa el nombre de la tienda tal como es conocida por el
						publico en general</small>
				</p></li>
			<li id="li_2"><label class="description" for="descrip_tienda">Descripcion
					de la tienda </label>
				<div>
					<input id="descrip_tienda" name="descrip_tienda" class="element text medium"
						type="text" maxlength="255" value="<?php 
						if (form_error('descrip_tienda','<p class="error">','</p>') != '') {
							echo set_value('descrip_tienda');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('descrip_tienda');
							}else {
								echo '';
							}
						}						
						?>" />
						<?php echo form_error('descrip_tienda','<p class="error">','</p>');?>
				</div>
				<p class="guidelines" id="guide_2">
					<small>Ingresa una breve descripcion de lo que hace el restaurante</small>
				</p></li>
			<li id="li_3"><label class="description" for="tlf_1_1">Telefono 1 </label>
				<span> 
					<input id="tlf_1_1" name="tlf_1_1" 
						class="element text" size="3" maxlength="3" value="<?php 
						if (form_error('tlf_1_1','<p class="error">','</p>') != '') {
							echo set_value('tlf_1_1');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_1_1');
							}else {
								echo '';
							}							
						}						
						?>" type="text"> -
						<label for="tlf_1_1">(###)</label> 						
				</span>			
				<span> 
					<input id="tlf_1_2" name="tlf_1_2" class="element text" size="3"
						maxlength="3" value="<?php 
						if (form_error('tlf_1_2','<p class="error">','</p>') != '') {
							echo set_value('tlf_1_2');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_1_2');
							}else {
								echo '';
							}							
						}								
						?>" type="text"> - <label for="tlf_1_2">###</label>											
				</span> 
				<span> 
					<input id="tlf_1_3" name="tlf_1_3"
					class="element text" size="4" maxlength="4" value="<?php 
					if (form_error('tlf_1_3','<p class="error">','</p>') != '') {
							echo set_value('tlf_1_3');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_1_3');
							}else {
								echo '';
							}							
						}		
					?>" type="text"> <label for="tlf_1_3">####</label> 
				</span>
				<?php echo form_error('tlf_1_1','<p class="error">','</p>');?>
				<p class="guidelines" id="guide_3">
					<small>Ingresa un numero de telefono valido</small>
				</p></li>
			<li id="li_4"><label class="description" for="tlf_2_1">Telefono 2 </label>
				<span> 
					<input id="tlf_2_1" name="tlf_2_1"
						class="element text" size="3" maxlength="3" value="<?php 
						if (form_error('tlf_2_1','<p class="error">','</p>') != '') {
							echo set_value('tlf_2_1');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_2_1');
							}else {
								echo '';
							}							
						}
						?>" type="text"> -
						<label for="tlf_2_1">(###)</label>						
				</span> 
				<span> 
					<input id="tlf_2_2" name="tlf_2_2" class="element text" size="3"
					maxlength="3" value="<?php 
					if (form_error('tlf_2_2','<p class="error">','</p>') != '') {
							echo set_value('tlf_2_2');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_2_2');
							}else {
								echo '';
							}							
						}
					?>" type="text"> - <label for="tlf_2_2">###</label>					
				</span> 
				<span> 
					<input id="tlf_2_3" name="tlf_2_3"
					class="element text" size="4" maxlength="4" value="<?php 
					if (form_error('tlf_2_3','<p class="error">','</p>') != '') {
							echo set_value('tlf_2_3');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('tlf_2_3');
							}else {
								echo '';
							}							
						}
					?>" type="text"> <label
					for="tlf_2_3">####</label> </span>
					<?php 
					echo form_error('tlf_2_1','<p class="error">','</p>');
					?>
				<p class="guidelines" id="guide_4">
					<small>Ingresa un numero de telefono valido, puedes ingresar numero
						local o celular</small>
				</p></li>
			<li id="li_5"><label class="description" for="razon_social">Razon Social
			</label>
				<div>
					<input id="razon_social" name="razon_social" class="element text medium"
						type="text" maxlength="255" value="<?php 
						if (form_error('razon_social','<p class="error">','</p>') != '') {
							echo set_value('razon_social');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('razon_social');
							}else {
								echo '';
							}							
						}
						;?>" 
						/>
						<?php echo form_error('razon_social','<p class="error">','</p>');?>
				</div>
				<p class="guidelines" id="guide_5">
					<small>Ingresa el nombre juridico del restaurante</small>
				</p></li>
			<li id="li_6"><label class="description" for="ci_rif">Cedula/RIF </label>
				<div>
					<input id="ci_rif" name="ci_rif" class="element text medium"
						type="text" maxlength="10" value="<?php 
						if (form_error('ci_rif','<p class="error">','</p>') != '') {
							echo set_value('ci_rif');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('ci_rif');
							}else {
								echo '';
							}							
						}
						?>" 
						/>
						<?php echo form_error('ci_rif','<p class="error">','</p>');?>
				</div>
				<p class="guidelines" id="guide_6">
					<small>Ingresa el RIF de la empresa o el numero de cedula del
						representante legal sin guiones ni puntos.</small>
				</p></li>
			<li id="li_7"><label class="description" for="min_ord_cant">Minimo orden
					(cantidad) </label>
				<div>
					<input id="min_ord_cant" name="min_ord_cant" class="element text medium"
						type="text" maxlength="255" value="<?php 
						if (form_error('min_ord_cant','<p class="error">','</p>') != '') {
							echo set_value('min_ord_cant');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('min_ord_cant');
							}else {
								echo '';
							}							
						}
						?>" 
						/>
						<?php echo form_error('min_ord_cant','<p class="error">','</p>');?>
				</div>
				<p class="guidelines" id="guide_7">
					<small>Ingresa la cantidad minima de platos que el restaurante
						podra despachar a traves de todoexpress.com</small>
				</p></li>
			<li id="li_8"><label class="description" for="min_ord_precio">Minimo orden (precio)</label> 
				<span class="symbol">Bs</span> 
				<span> <input id="min_ord_precio" name="min_ord_precio" class="element text currency"
					size="10" value="<?php 
					if (form_error('min_ord_precio','<p class="error">','</p>') != '') {
							echo set_value('min_ord_precio');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('min_ord_precio');
							}else {
								echo '';
							}							
						}
					?>" type="text" /> . <label for="element_8_1">Bolivares</label>
					<?php echo form_error('min_ord_precio','<p class="error">','</p>');?>
			</span>
				<p class="guidelines" id="guide_8">
					<small>Ingresa el minino en bolivares que el restaurante podra
						despachar a traves de todoexpress.com.ve</small>
				</p></li>
			<li id="li_11"><label class="description" for="estacionamiento">Posee
					estacionamiento </label> <span> <input id="estacionamiento"
					name="estacionamiento" class="element checkbox" type="checkbox"
					value="<?php echo set_checkbox('estacionamiento');?>" /> 
					<label class="choice" for="element_11_1">Si</label> </span>
			<p class="guidelines" id="guide_11">
					<small>Selecciona si el restaurante posee estacionamiento</small>
				</p></li>
			<li id="li_13"><label class="description" for="ciudad">Ciudad </label>
				<div>
					<?php
					if (form_error('ciudad','<p class="error">','</p>') != '') {
						echo form_dropdown('ciudad',$ciudades,set_select('ciudad'),'class="element select medium" id="ciudad"');
					}else {
						if (isset($tienda_nueva) && $tienda_nueva == 0) {
							echo form_dropdown('ciudad',$ciudades,set_select('ciudad'),'class="element select medium" id="ciudad"');
						}else {
							echo form_dropdown('ciudad',$ciudades,null,'class="element select medium" id="ciudad"');
						}
					}					
					?>
					<?php echo form_error('ciudad','<p class="error">','</p>');?>
				</div></li>
			<li id="li_14"><label class="description" for="element_14">Zona </label>
				<div>
					<?php
					if (form_error('zona','<p class="error">','</p>') != '') {
						echo form_dropdown('zona',array(),null,'class="element select medium" id="zona"');
					}else {
						if (isset($tienda_nueva) && $tienda_nueva == 0) {
							echo form_dropdown('zona',$zonas,set_select('zona'),'class="element select medium" id="zona"');
						}else {
							echo form_dropdown('zona',array(),NULL,'class="element select medium" id="zona"');
						}
					}	 					
					?>
					<?php echo form_error('zona','<p class="error">','</p>');?>
				</div></li>
			<li id="li_9">
				<label class="description" for="min_tiempo_ent">Minimo tiempo entrega </label> 
					<span> <input id="min_tiempo_ent" name="min_tiempo_ent" class="element text " size="2" type="text"
					maxlength="2" value="<?php 
					if (form_error('min_tiempo_ent','<p class="error">','</p>') != '') {
							echo set_value('min_tiempo_ent');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('min_tiempo_ent');
							}else {
								echo '';
							}							
						}					
					?>" /><label>HH</label> 
					</span> 					
			<p class="guidelines" id="guide_9">
					<small>Ingrese el tiempo minimo para la entrega de un producto</small>
				</p>
			</li>
			<li id="li_10">
				<label class="description" for="min_tiempo_esp">Minimo tiempo espera </label> 
					<span> <input id="min_tiempo_esp" name="min_tiempo_esp" class="element text " size="2" type="text"
						maxlength="2" value="<?php 
						if (form_error('min_tiempo_esp','<p class="error">','</p>') != '') {
							echo set_value('min_tiempo_esp');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('min_tiempo_esp');
							}else {
								echo '';
							}							
						}
						?>" /><label>HH</label> </span> 					
			<p class="guidelines" id="guide_10">
					<small>Tiempo minimo de espera para entregar un pedido tipo "Yo lo
						Busco"</small>
				</p></li>
			<li id="li_11">
				<label class="description" for="costo_envio">Costo de envio</label> 
					<span> <input id="costo_envio" name="costo_envio" class="element text " size="10" type="text"
						maxlength="3" value="<?php 
						if (form_error('costo_envio','<p class="error">','</p>') != '') {
							echo set_value('costo_envio');
						}else{
							if (isset($tienda_nueva) && $tienda_nueva == 0) {
								echo set_value('costo_envio');
							}else {
								echo '';
							}							
						}
						?>" /></span> 					
			<p class="guidelines" id="guide_10">
					<small>Costo de envio</small>
				</p></li>
			<li id="li_12">
				<label class="description" for="img_tienda">Imagen:</label> 
					<span> <input id="img_tienda" name="img_tienda" class="element text " size="20" type="file" />
					</span> 					
			<p class="guidelines" id="guide_11">
					<small>Ingresa una imagen en formato JPG/PNG</small>
				</p></li>
			<li class="buttons"> 
			<input id="guardar" class="button_text art-button"
				type="submit" name="guardar" value="Guardar" />
			<input id="eliminar" class="button_text art-button"
				type="button" name="eliminar" value="Eliminar" />
				</li>
		</ul>
	<?php echo form_close();?>
</div>
<div id="popup">
<?php echo $catalogo_default;?>
</div>