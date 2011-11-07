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
			'Seleccionar' : function(){
				//algo
			},
			'Cancelar' : function(){
				$(this).dialog('close');
			},
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
				var tlf_1_1 = data.tlf_1;			
				$('#nombre_tienda').val(data.nombre);
				$('#descrip_tienda').val(data.descripcion);
				$('#tlf_1_1').val(tlf_1_1.substring(1,3));
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
<div id="form_container">

	<h1>
		<a>Tienda de Comida</a>
	</h1>	
	<?php echo form_open('admin/c_tienda_com_admin',array('oculto'=>'1'));?>
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
						type="text" maxlength="255" value="<?php echo set_value('nombre_tienda');?>" />
						<?php echo form_error('nombre_tienda','<p>','</p>');?>
				</div>
				<p class="guidelines" id="guide_1">
					<small>Ingresa el nombre de la tienda tal como es conocida por el
						publico en general</small>
				</p></li>
			<li id="li_2"><label class="description" for="descrip_tienda">Descripcion
					de la tienda </label>
				<div>
					<input id="descrip_tienda" name="descrip_tienda" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('descrip_tienda');?>" />
						<?php echo form_error('descrip_tienda','<p>','</p>');?>
				</div>
				<p class="guidelines" id="guide_2">
					<small>Ingresa una breve descripcion de lo que hace el restaurante</small>
				</p></li>
			<li id="li_3"><label class="description" for="tlf_1_1">Telefono 1 </label>
				<span> 
					<input id="tlf_1_1" name="tlf_1_1" 
						class="element text" size="3" maxlength="3" value="<?php echo set_value('tlf_1_1');?>" type="text"> -
						<label for="tlf_1_1">(###)</label> 
						<?php echo form_error('tlf_1_1','<p>','</p>');?>
				</span> 
				<span> 
					<input id="tlf_1_2" name="tlf_1_2" class="element text" size="3"
						maxlength="3" value="<?php echo set_value('tlf_1_2');?>" type="text"> - <label for="tlf_1_2">###</label>						
				</span> 
				<span> 
					<input id="tlf_1_3" name="tlf_1_3"
					class="element text" size="4" maxlength="4" value="<?php echo set_value('tlf_1_3');?>" type="text"> <label for="tlf_1_3">####</label> 
				</span>
				<p class="guidelines" id="guide_3">
					<small>Ingresa un numero de telefono valido</small>
				</p></li>
			<li id="li_4"><label class="description" for="tlf_2_1">Telefono 2 </label>
				<span> 
					<input id="tlf_2_1" name="tlf_2_1"
						class="element text" size="3" maxlength="3" value="<?php echo set_value('tlf_2_1');?>" type="text"> -
						<label for="tlf_2_1">(###)</label>
						<?php echo form_error('tlf_2_1','<p>','</p>');?> 
				</span> 
				<span> 
					<input id="tlf_2_2" name="tlf_2_2" class="element text" size="3"
					maxlength="3" value="<?php echo set_value('tlf_2_2');?>" type="text"> - <label for="tlf_2_2">###</label>
				</span> 
				<span> 
					<input id="tlf_2_3" name="tlf_2_3"
					class="element text" size="4" maxlength="4" value="<?php echo set_value('tlf_2_3');?>" type="text"> <label
					for="tlf_2_3">####</label> </span>
				<p class="guidelines" id="guide_4">
					<small>Ingresa un numero de telefono valido, puedes ingresar numero
						local o celular</small>
				</p></li>
			<li id="li_5"><label class="description" for="razon_social">Razon Social
			</label>
				<div>
					<input id="razon_social" name="razon_social" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('razon_social');?>" />
				</div>
				<p class="guidelines" id="guide_5">
					<small>Ingresa el nombre juridico del restaurante</small>
				</p></li>
			<li id="li_6"><label class="description" for="ci_rif">Cedula/RIF </label>
				<div>
					<input id="ci_rif" name="ci_rif" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('ci_rif');?>" />
				</div>
				<p class="guidelines" id="guide_6">
					<small>Ingresa el RIF de la empresa o el numero de cedula del
						representante legal</small>
				</p></li>
			<li id="li_7"><label class="description" for="min_ord_cant">Minimo orden
					(cantidad) </label>
				<div>
					<input id="min_ord_cant" name="min_ord_cant" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('min_ord_cant');?>" />
				</div>
				<p class="guidelines" id="guide_7">
					<small>Ingresa la cantidad minima de platos que el restaurante
						podra despachar a traves de todoexpress.com</small>
				</p></li>
			<li id="li_8"><label class="description" for="min_ord_precio">Minimo orden (precio)</label> 
				<span class="symbol">Bs</span> 
				<span> <input id="min_ord_precio" name="min_ord_precio" class="element text currency"
					size="10" value="<?php echo set_value('min_ord_cant');?>" type="text" /> . <label for="element_8_1">Bolivares</label>
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
					<?php echo form_dropdown('ciudad',$ciudades,array(),'class="element select medium" id="ciudad"');?>
				</div></li>
			<li id="li_14"><label class="description" for="element_14">Zona </label>
				<div>
					<?php echo form_dropdown('zona',array(),null,'class="element select medium" id="zona"');?>
				</div></li>
			<li id="li_9">
				<label class="description" for="min_tiempo_ent">Minimo tiempo entrega </label> 
					<span> <input id="min_tiempo_ent_1" name="min_tiempo_ent_1" class="element text " size="2" type="text"
					maxlength="2" value="<?php echo set_value('min_tiempo_ent_1');?>" /> : <label>HH</label> 
					</span> 
					<span> <input id="min_tiempo_ent_2" name="min_tiempo_ent_2" class="element text " size="2" type="text" 
					maxlength="2" value="<?php echo set_value('min_tiempo_ent_2');?>" /> : <label>MM</label> 
					</span> 
					<span> <input id="min_tiempo_ent_3" name="min_tiempo_ent_3" class="element text " size="2" type="text" 
					maxlength="2" value="<?php echo set_value('min_tiempo_ent_3');?>" /> <label>SS</label> 
					</span>
					<span> 
						<select class="element select" style="width: 4em" id="min_tiempo_ent_4" name="min_tiempo_ent_4">
							<option value="AM">AM</option>
							<option value="PM">PM</option>
						</select> <label>AM/PM</label> 
					</span>
			<p class="guidelines" id="guide_9">
					<small>Ingrese el tiempo minimo para la entrega de un producto</small>
				</p>
			</li>
			<li id="li_10">
				<label class="description" for="min_tiempo_esp">Minimo tiempo espera </label> 
					<span> <input id="min_tiempo_esp_1" name="min_tiempo_esp_1" class="element text " size="2" type="text"
						maxlength="2" value="<?php echo set_value('min_tiempo_esp_1');?>" /> : <label>HH</label> </span> 
					<span> <input id="min_tiempo_esp_2" name="min_tiempo_esp_2" class="element text " size="2" type="text" 
						maxlength="2" value="<?php echo set_value('min_tiempo_esp_2');?>" /> : <label>MM</label>
					</span> 
					<span> <input id="min_tiempo_esp_3" name="min_tiempo_esp_3" class="element text " size="2" type="text" 
						maxlength="2" value="<?php echo set_value('min_tiempo_esp_3');?>" />
					<label>SS</label> </span> 
					<span> <select class="element select" style="width: 4em" id="min_tiempo_esp_4" name="min_tiempo_esp_4">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select> <label>AM/PM</label> 
					</span>
			<p class="guidelines" id="guide_10">
					<small>Tiempo minimo de espera para entregar un pedido tipo "Yo lo
						Busco"</small>
				</p></li>

			<li class="buttons"> 
			<input id="saveForm" class="button_text art-button"
				type="submit" name="enviar" value="Enviar" /></li>
		</ul>
	<?php echo form_close();?>
</div>
<div id="popup">
<?php echo $catalogo_default;?>
</div>