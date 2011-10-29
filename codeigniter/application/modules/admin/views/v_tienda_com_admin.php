<script type="text/javascript">
$(document).ready(function(){
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

	$('#example').dataTable();
	
	$('#boton-catalogo').click(function(e){
		e.preventDefault();
		var popup = $('#popup');
		popup.html($('#example').dataTable()).dialog({
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
			}									
		}).dialog('open');
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
<div id="popup"></div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
	<thead>
		<tr>
			<th>Rendering engine</th>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>
		</tr>
	</thead>
	<tbody>
		<tr class="gradeX">
			<td>Trident</td>
			<td>
				Internet
				 Explorer 
				4.0
				</td>
			<td>Win 95+</td>
			<td class="center">4</td>
			<td class="center">X</td>
		</tr>
		<tr class="gradeC">
			<td>Trident</td>
			<td>Internet
				 Explorer 5.0</td>
			<td>Win 95+</td>
			<td class="center">5</td>
			<td class="center">C</td>
		</tr>
		<tr class="gradeA">
			<td>Trident</td>
			<td>Internet
				 Explorer 5.5</td>
			<td>Win 95+</td>
			<td class="center">5.5</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Trident</td>
			<td>Internet
				 Explorer 6</td>
			<td>Win 98+</td>
			<td class="center">6</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Trident</td>
			<td>Internet Explorer 7</td>
			<td>Win XP SP2+</td>
			<td class="center">7</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Trident</td>
			<td>AOL browser (AOL desktop)</td>
			<td>Win XP</td>
			<td class="center">6</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Firefox 1.0</td>
			<td>Win 98+ / OSX.2+</td>
			<td class="center">1.7</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Firefox 1.5</td>
			<td>Win 98+ / OSX.2+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Firefox 2.0</td>
			<td>Win 98+ / OSX.2+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Firefox 3.0</td>
			<td>Win 2k+ / OSX.3+</td>
			<td class="center">1.9</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Camino 1.0</td>
			<td>OSX.2+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Camino 1.5</td>
			<td>OSX.3+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Netscape 7.2</td>
			<td>Win 95+ / Mac OS 8.6-9.2</td>
			<td class="center">1.7</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Netscape Browser 8</td>
			<td>Win 98SE+</td>
			<td class="center">1.7</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Netscape Navigator 9</td>
			<td>Win 98+ / OSX.2+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.0</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.1</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.1</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.2</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.2</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.3</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.3</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.4</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.4</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.5</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.5</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.6</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">1.6</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.7</td>
			<td>Win 98+ / OSX.1+</td>
			<td class="center">1.7</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Mozilla 1.8</td>
			<td>Win 98+ / OSX.1+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Seamonkey 1.1</td>
			<td>Win 98+ / OSX.2+</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Gecko</td>
			<td>Epiphany 2.20</td>
			<td>Gnome</td>
			<td class="center">1.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>Safari 1.2</td>
			<td>OSX.3</td>
			<td class="center">125.5</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>Safari 1.3</td>
			<td>OSX.3</td>
			<td class="center">312.8</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>Safari 2.0</td>
			<td>OSX.4+</td>
			<td class="center">419.3</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>Safari 3.0</td>
			<td>OSX.4+</td>
			<td class="center">522.1</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>OmniWeb 5.5</td>
			<td>OSX.4+</td>
			<td class="center">420</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>iPod Touch / iPhone</td>
			<td>iPod</td>
			<td class="center">420.1</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Webkit</td>
			<td>S60</td>
			<td>S60</td>
			<td class="center">413</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 7.0</td>
			<td>Win 95+ / OSX.1+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 7.5</td>
			<td>Win 95+ / OSX.2+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 8.0</td>
			<td>Win 95+ / OSX.2+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 8.5</td>
			<td>Win 95+ / OSX.2+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 9.0</td>
			<td>Win 95+ / OSX.3+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 9.2</td>
			<td>Win 88+ / OSX.3+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera 9.5</td>
			<td>Win 88+ / OSX.3+</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Opera for Wii</td>
			<td>Wii</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Nokia N800</td>
			<td>N800</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>Presto</td>
			<td>Nintendo DS browser</td>
			<td>Nintendo DS</td>
			<td class="center">8.5</td>
			<td class="center">C/A<sup>1</sup></td>
		</tr>
		<tr class="gradeC">
			<td>KHTML</td>
			<td>Konqureror 3.1</td>
			<td>KDE 3.1</td>
			<td class="center">3.1</td>
			<td class="center">C</td>
		</tr>
		<tr class="gradeA">
			<td>KHTML</td>
			<td>Konqureror 3.3</td>
			<td>KDE 3.3</td>
			<td class="center">3.3</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeA">
			<td>KHTML</td>
			<td>Konqureror 3.5</td>
			<td>KDE 3.5</td>
			<td class="center">3.5</td>
			<td class="center">A</td>
		</tr>
		<tr class="gradeX">
			<td>Tasman</td>
			<td>Internet Explorer 4.5</td>
			<td>Mac OS 8-9</td>
			<td class="center">-</td>
			<td class="center">X</td>
		</tr>
		<tr class="gradeC">
			<td>Tasman</td>
			<td>Internet Explorer 5.1</td>
			<td>Mac OS 7.6-9</td>
			<td class="center">1</td>
			<td class="center">C</td>
		</tr>
		<tr class="gradeC">
			<td>Tasman</td>
			<td>Internet Explorer 5.2</td>
			<td>Mac OS 8-X</td>
			<td class="center">1</td>
			<td class="center">C</td>
		</tr>
		<tr class="gradeA">
			<td>Misc</td>
			<td>NetFront 3.1</td>
			<td>Embedded devices</td>
			<td class="center">-</td>
			<td class="center">C</td>
		</tr>
		<tr class="gradeA">
			<td>Misc</td>
			<td>NetFront 3.4</td>
			<td>Embedded devices</td>
			<td class="center">-</td>
			<td class="center">A</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th>Rendering engine</th>
			<th>Browser</th>
			<th>Platform(s)</th>
			<th>Engine version</th>
			<th>CSS grade</th>
		</tr>
	</tfoot>
</table>