<script>
function preCargador(selector){
	$(selector).block({ //'.content-pedidos'
		message: 'Cargando ...'		
	});
}

function cargarFormularioDireccion(html,selector){
	window.setTimeout(function(){
		$(selector).html(html.formulario);
	},1000);
}

function agregarDireccion(datos){
	if(datos.respuesta == false){		
		window.setTimeout(function(){
			$('#nueva-dir').html('Lo sentimos, no hemos podido agregar la direccion especificada, por favor verifica los datos e intenta de nuevo');
		},1000);		
	}else{		
		window.setTimeout(function(){
			alert(datos.respuesta);
			$('ul.direcciones-content').append(datos.respuesta);
			$('#form_agregar_dir').fadeOut('slow',function(){$(this).empty();});
			$('img#agregar-dir').show();
		},1000);		
	}	
}

function cargarTablaPed(html){
	window.setTimeout( function(){
		$('div.content-pedidos').html(html.lista_ped);
		$('ul.link').html(html.link_pag);
	}, 1000);
}
	$(function() {
		$( "#tabs" ).tabs({
			cookie:{				
				expires:1
			}
		});				
		
		$("#form-filtro-pedidos").submit(function(){
			if($("#estados_ped").val() == '' && $("#tipo_ped").val() == '' && $("#ped_fecha").val() == ''){
				$('p#error-filtro').empty().append('Debes seleccionar algun valor para filtrar tu busqueda').show('fast');
				return false;
			}else{
				if ($('#estados_ped').val() != '') {
					var estado_ped = $('#estados_ped').val();					
				}
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
					preCargador('.content-pedidos');
				},				
				success: function (data) {					
					cargarTablaPed(data);
				}				
			});			
		});

		$('img.mas-info-pedido').live('click',function(e){			
			e.preventDefault();
			var id_pedido = $(this).attr('alt');
			var popup = $('#popup');

			$.get('<?php echo base_url()?>index.php/usuario/c_datos_usuario/getPedidoPorId/'+id_pedido,										
					function(data){						
						var salida = '';
						salida += '<p> Fecha del pedido: '+data.fecha_pedido+' '+data.hora_pedido+'</p>';
						salida += '<p> Cantidad total del pedido: '+data.cantidad+'</p>';
						salida += '<p> Estado del pedido: '+data.estado_pedido+'</p>';
						salida += '<p> Restaurante: '+data.tienda_comida+'</p>';
						salida += '<p> Tipo de venta: '+data.tipo_venta+'</p>';
						salida += '<p> Ciudad: '+data.direccion_envio_ciudad+'</p>';
						salida += '<p> Zona: '+data.direccion_envio_zona+'</p>';
						salida += '<p> Calle/Carrera: '+data.direccion_envio_calle+'</p>';
						salida += '<p> Casa/Urb: '+data.direccion_envio_casa+'</p>';
						salida += '<p> Lugar de referencia: '+data.direccion_envio_lugarref+'</p>';
						salida += '<p> Subtotal: '+data.subtotal+'</p>';
						salida += '<p> Iva: '+data.iva+'</p>';
						salida += '<p> Total: '+data.total+'</p>';

						popup.html(salida).dialog({
							width:600,
							title:'Pedido',
							height: 500,
							modal:true,
							show:"blind",
							hide:"explode",
							buttons:{
								'Reordenar' : function(){
									$(location).attr('href','<?php echo base_url();?>index.php/carrito/c_orden/'+id_pedido);
								},
								'Cerrar' : function(){
									$(this).dialog('close');
								}
							}
						}).dialog('open');										
				},
				'json'
			);					
		});

		$('img#agregar-dir').live('click',function(e){
			$.ajax({
				url: '<?php echo base_url()?>index.php/usuario/c_editar_usuario/mostrarFormDireccion',
				type:'POST',
				dataType : 'json',
				beforeSend: function(data){
					preCargador('#nueva-dir');
				},
				success:function(data){
					cargarFormularioDireccion(data, '#nueva-dir');
					$('img#agregar-dir').hide();
				}
			});
		});		
		
		$('#guardar-dir').live('click',function(e){	
			e.preventDefault();		
			var formulario_action = $("#form_agregar_dir").attr("action");
			var datos_form = $('#form_agregar_dir').serialize();
			
			$.ajax({
				url: formulario_action,
				type:'POST',
				dataType:'json',				
				data:datos_form,
				beforeSend: function(){
					preCargador('#nueva-dir');
				},
				success:function(data){
					agregarDireccion(data);				
				}
			});						
		});
		
		$('#cancelar').live('click',function(e){
			e.preventDefault();			
			$('#form_agregar_dir').fadeOut('slow',function(){$(this).empty();});
			$('img#agregar-dir').show();
		});

		$("#ciudad").live('change',function(event){	
			event.preventDefault();
			var id_ciudad = $(this).val();
			if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/usuario/c_editar_usuario/cargarZona",
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
				$("#zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
			}				
		});
	});
	</script>

<?php if ($datos_usuario === NULL ) {
	?>
<p>
	Usted no deberia estar aqui... por favor ingrese en su cuenta a traves
	del siguiente vinculo
	<?php echo anchor('home/c_home','Inicio');?>
</p>
	<?php
}else {
	if (isset($mensaje)) {
		if ($mensaje == '0') {
			?>
<div class="error">No hemos podido registrar los cambios, por favor
	intenta nuevamente.</div>
			<?php
		}else {
			?>
<div class="message">Hemos registrado tus cambios.</div>
			<?php
		}
	}
	?>
<div class="demo">
	<div id="tabs">
		<ul>
			<li><a href="#datos">Tus Datos</a></li>
			<li><a href="#direcciones">Tus Direcciones</a></li>
			<li><a href="#pedidos">Tus Pedidos</a></li>
		</ul>
		<div id="datos">
			<span class="text">Usuario: <?php echo $datos_usuario->nombreusuario;?>
			</span> <span class="text">Nombre: <?php echo $datos_usuario->nombre;?>
			</span> <span class="text">Apellidos: <?php echo $datos_usuario->apellidos;?>
			</span> <span class="text">Telefono Fijo: <?php echo $datos_usuario->telfijo;?>
			</span> <span class="text">Telefono Celular: <?php echo $datos_usuario->telefonoCel;?>
			</span> <span class="text">Correo Electronico: <?php echo $datos_usuario->correo;?>
			</span>
			<?php echo anchor('usuario/c_editar_usuario','Editar','class="button_text art-button" id="button-edit"');?>
		</div>
		<div id="direcciones">
			<ul class="direcciones-content">
			<?php foreach ($dir_usuario as $direcciones):?>
				<li><span class="inline">
				Ciudad: <?php echo $direcciones['ciudad'];?>
				, Zona: <?php echo $direcciones['zona'];?>
				, Calle/Carrera: <?php echo $direcciones['calle_carrera'];?>
				, Casa/Urb: <?php echo $direcciones['casa_urb'];?>
				, Numero Casa/Apto: <?php echo $direcciones['numeroCasaApto'];?>
				, Lugar de Referencia: <?php echo $direcciones['lugarreferencia'];?>
				</span>
				<div class="opciones-dir">
							<img
								src="<?php echo base_url();?>application/img/icon/edit-icon.png" />
							<img
								src="<?php echo base_url();?>application/img/icon/delete-icon.png" />
				</div>
				</li>
				<?php //echo anchor('usuario/c_editar_direccion/'.$direcciones['id'],'Editar Direccion','class="button_text art-button"');?>
				<?php endforeach;?>
			</ul>
			<div id="nueva-dir"></div>
			<?php echo img(array(
							'src' =>base_url().'application/img/icon/Add-icon.png',
							'id'=>'agregar-dir',
							'alt'=>'Agregar Direccion'));?>
		</div>
		<div id="pedidos">
		<?php echo form_open('usuario/c_datos_usuario/processFiltro','id="form-filtro-pedidos"',array('reordenar' => '1'));?>
			<ul class="content-form-pedido">
				<li id="li-estados_ped" class="item-pedido-usuario"><label
					class="description" for="estados_ped">Estado del Pedido </label>
					<div>
					<?php
					echo form_dropdown('estados_ped',
					$estados_pedido,
					($this->input->post('estados_ped')) ? $this->input->post('estados_ped') : '',
										'class="element select medium" id="estados_ped"');
					?>
					</div>
				</li>
				<li id="li-tipo_ped" class="item-pedido-usuario"><label
					class="description" for="tipo_ped">Tipo de Pedido </label>
					<div>
					<?php echo form_dropdown('tipo_ped',
					$tipo_ped,
					($this->input->post('tipo_ped')) ? $this->input->post('tipo_ped') : '',
											'class="element select medium" id="tipo_ped"');?>
					</div>
				</li>
				<li id="li-ped_fecha" class="item-pedido-usuario"><label
					class="description" for="ped_fecha">Fecha de Pedido </label>
					<div>
					<?php echo form_dropdown('ped_fecha',
					$ped_fecha,
					($this->input->post('ped_fecha')) ? $this->input->post('ped_fecha') : '',
											'class="element select medium" id="ped_fecha"');?>
					</div>
				</li>

				<li class="item-pedido-usuario">
					<div>
						<input class="button_text art-button" type="submit"
							name="submit-pedidos" value="Buscar" />
					</div>
				</li>
			</ul>
			<p class="error" id="error-filtro"></p>
			<?php echo form_close();?>
			<div class="content-pedidos">
			<?php echo $lista_ped;?>
			</div>
			<ul class="link">
			<?php echo (!empty($link_pag)) ? $link_pag : '';?>
			</ul>
		</div>
	</div>

</div>
<div id="popup"></div>
<!-- End demo -->
			<?php }?>