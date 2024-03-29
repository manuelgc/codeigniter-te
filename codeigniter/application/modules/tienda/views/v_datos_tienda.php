
<script><!--
	

		function preCargador(objeto){
			objeto.block({
				message: 'Cargando ...'		
			});
			
		}

		function postCargador(objeto) {
			objeto.unblock();
		}
		
		function mostrarError(objeto,texto){
			objeto.text( texto ).addClass( "ui-state-highlight" );
			setTimeout(function() {
				objeto.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
				
				
		}
		
		function dialogError(div,titulo,mensaje) {
			div.html('<p>'+mensaje+'</p>')
			.dialog({
				title:titulo,
				autoOpen: false,
				modal:true,
				resizable: false,
				width:400,
				show:"blind",
				hide:"explode",
				buttons: {
				'Cerrar': function() {
					$(this).dialog('close');
				}
				}

								
			}).dialog('open');
		}

		function validarSeleccion(){
			if($("#cmbx_ciudad").val()=='' || $("#cmbx_zona").val()==''){
				mostrarError($("#mensaje_error"), 'Debe seleccionar Ciudad y Zona');
				return false;
			}else {
				return true;
			}		
		}
		
		function validarTipoOrden() {
			if($("#cmbx_orden").val()==''){
				mostrarError($("#mensaje_error_orden"), 'Debe seleccionar tipo de orden');
				return false;
			}else {
				return true;
			}
		}

		function actualizarCiudadZona(id_ciudad,id_zona,nombreCiudad,nombreZona) {
		
			$.cookie('ciudad', id_ciudad,{path: '/'});
			$("#nombre_ciudad").html('<b>'+nombreCiudad+'</b>');
			$.cookie('zona', id_zona,{path: '/'});
			$("#nombre_zona").html('<b>'+nombreZona+'</b>');
			
		}

		function actulizarTipoOrden(valor){
			$.cookie('tipo_orden', valor,{path: '/'});
		}	
				
		function cargarPopupPlato(id_plato){
			$.post("<?php echo base_url();?>index.php/tienda/c_datos_tienda/cargarPopupPlatoAjax",
					{'id_plato':id_plato},
					function(data){
						if(data.plato){	
							postCargador($("#tabs_tienda"));		
							$("#popup-tienda").html(data.html)
							.dialog({
								title:data.nombrePlato,
								autoOpen: false,
								modal:true,
								resizable: false,
								width:400,
								show:"blind",
								hide:"explode",
								buttons: {
								'Aceptar' : function(){
									$("#form_popup_plato").submit();
//									$(this).dialog('close');
								},
								'Cancelar': function() {
									$(this).dialog('close');
								}
								}
				
												
							});
							$("#popup-tienda").dialog('open');
						}else{
							dialogError($("#popup-tienda"),"Error", "El plato no se puede agregar al pedido");
						}
					},
					'json'
				);
		}

		function cargarPopupZona(html,id_plato){
			postCargador($("#tabs_tienda"));
			$("#popup-tienda").html(html)
			.dialog({
				title:'Seleccionar Zona',
				autoOpen: false,
				modal:true,
				resizable: false,
				show:"blind",
				hide:"explode",
				buttons: {
				'Aceptar' : function(){
					if(validarSeleccion()){
						actualizarCiudadZona($("#cmbx_ciudad").val(),$("#cmbx_zona").val(),$("#cmbx_ciudad option:selected").text(),$("#cmbx_zona option:selected").text());
						cargarPopupPlato(id_plato);
//						$(this).dialog('close');
						
					}
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
				}

								
			})
			.dialog('open');
		}
		
		function cargarPopupTipoOrden(html,id_plato,zona,html_zona){
			postCargador($("#tabs_tienda"));
			$("#popup-tienda").html(html)
			.dialog({
				title:'Seleccionar Tipo de Orden',
				autoOpen: false,
				modal:true,
				resizable: false,
				show:"blind",
				hide:"explode",
				buttons: {
				'Aceptar' : function(){
					if(validarTipoOrden()){
						actulizarTipoOrden($("#cmbx_orden").val());
						if($.cookie("tipo_orden")!=null && $.cookie("tipo_orden")==1 && !zona){
							cargarPopupZona(html_zona,id_plato);
						}else{
							cargarPopupPlato(id_plato);
						}
					}	
				},
				'Cancelar': function() {
					$(this).dialog('close');
				}
				}

								
			})
			.dialog('open');
			
		}		
		
		$(function() {
			
		$( "#tabs_tienda" ).tabs({cookie:{expires:1}});
								
		$("#cmbx_ciudad").live('change',function(event){	
			event.preventDefault();
			var id_ciudad = $(this).val(),
			id_tienda=$('#id_tienda').val();
			if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/tienda/c_datos_tienda/cargarZonaAjax",
					{'id_ciudad':id_ciudad,'id_tienda':id_tienda},
					function(data){
						if(data.zona!=false){
							$("#cmbx_zona").html(data.html_zona).attr("disabled",data.disable);
						}else{
							$("#cmbx_zona").html(data.html_zona).attr("disabled",data.disable);
							mostrarError($("#mensaje_error"), 'La ciudad seleccionada no tiene zonas registradas');

							}
					},
					'json'
				);
			}else{
				$("#cmbx_zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
			}	
		});
		
		$("a.a-plato").click(function(event){
			preCargador($("#tabs_tienda"));
			event.preventDefault();
			var id_tienda = $("#id_tienda").val(),
				id_plato = $(this).attr('id') ;
			
			$.post("<?php echo base_url();?>index.php/tienda/c_datos_tienda/validarDatos",
					{'id_tienda':id_tienda},
					function(data){
						if(!data.abierto){
							dialogError($("#popup-tienda"),'Cerrado', data.html_cerrado);
						}else if(!data.envio) {
							cargarPopupTipoOrden(data.html_orden, id_plato, data.zona, data.html_zona);
						}else if(!data.envio_domicilio){
							cargarPopupPlato(id_plato);
						}else if(!data.zona){
							cargarPopupZona(data.html_zona,id_plato);
						}else{
							cargarPopupPlato(id_plato);
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
			<div  class="titulo_tienda">
				<h2><span class="text"><?php echo $nombre ?> </span></h2>
				<span class="text"><?php echo $tipo_comida?> </span><br>
				<span class="text"><strong>Telefonos:</strong> <?php echo $telefono;?></span><br>
				<span class="text"><strong>Cant. Minima:</strong> <?php echo $min_cant;?></span><br>
				<span class="text"><strong>Gasto Minimo:</strong> Bs.<?php echo $min_cost;?></span><br>
				<span class="text"><strong>Costo de Envio:</strong> Bs.<?php echo $costo_envio;?></span><br>
				<span class="text"><?php echo $tipo_venta;?></span><br>
			</div>
			<div class="imagenes_tienda" >
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
					<a class="a-plato" name="<?php echo $id;?>" id="<?php echo $id;?>" href="">
						<span class="text"><?php echo $p['nombre'];?> </span>
						<span class="text"><?php echo $p['precio'];?> Bs </span>
						<span class="text">(<?php echo $p['tipo_plato'];?>)</span>
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



