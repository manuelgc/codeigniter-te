<script type="text/javascript">
<!--
	function preCargador(objeto){
		objeto.block({
			message: 'Cargando ...'		
		});
		
	}
	
	function postCargador(objeto) {
		objeto.unblock();
	}

	function cargarFormularioDireccion(html,selector){
		window.setTimeout(function(){
			$(selector).html(html.formulario);
		},1000);
	}
	
	function actulizarCiudad(valor){
		$.cookie('ciudad', valor,{path: '/'});
	}
	
	function actulizarZona(valor){
		$.cookie('zona', valor,{path: '/'});
	}
	
	$(function() {
	
		$("#cmbx_ciudad").change(function(event){	
			event.preventDefault();
			var id_ciudad = $(this).val() ;

			actulizarCiudad(id_ciudad);
			if(id_ciudad != ''){
			$.post("<?php echo base_url();?>index.php/pedido/c_pedido/cargarZonaAjax",
					{'id_ciudad':id_ciudad},
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
			$("#cmbx_zona").change();	
		});

		$("#cmbx_zona").change(function(event){
			event.preventDefault();
			var id_zona = $(this).val(),
			id_ciudad = $('#cmbx.ciudad').val(),
			msj=$('#direcciones > div.message').attr('class');

			preCargador($('div#det_direcciones'));
			actulizarZona(id_zona);
			if(id_ciudad != '' && id_zona != ''){
			$.post("<?php echo base_url();?>index.php/pedido/c_pedido/actualizarDirecciones",
					{'id_zona':id_zona},
					function(data){
						if(data.direccion){
							$('#det_direcciones').html(data.html_dir);
							$('#direcciones > div.message').empty().hide();
						}else{
							$('#det_direcciones').empty();
							
							if(typeof msj == 'undefined'){
								$('#direcciones').append('<div class="message">'+data.error+'</div>');
							}else{
								$('#direcciones > div.message').text(data.error).show();
							}	
						}
						if(data.agr_visible){
							$('img#agregar-dir').show();
						}else{
							$('img#agregar-dir').hide();
						}	
						postCargador($('div#det_direcciones'));
					},
					'json'
				);
				
			}else{
				$('#det_direcciones').empty();
				$('img#agregar-dir').hide();
				if(typeof msj == 'undefined'){
					$('#direcciones').append('<div class="message">Debe selecionar la ciudad y zona donde se encuentra</div>');
				}else{
					$('#direcciones > div.message').text('Debe selecionar la ciudad y zona donde se encuentra').show();
				}
				postCargador($('div#det_direcciones'));
			}

		});

		$('img#agregar-dir').live('click',function(e){
			$('#cmbx_ciudad').attr('disabled',true);
			$('#cmbx_zona').attr('disabled',true);
			$.ajax({
				url: '<?php echo base_url()?>index.php/pedido/c_pedido/mostrarFormDireccion',
				type:'POST',
				dataType : 'json',
				beforeSend: function(data){
					preCargador($('#nueva-dir'));
				},
				success:function(data){
					cargarFormularioDireccion(data, '#nueva-dir');
					$('img#agregar-dir').hide();
					$('#direcciones > div.message').hide();
				}
			});
		});		
		
		$('#guardar-dir').live('click',function(e){	
			e.preventDefault();		
			var formulario_action = $("#form_agregar_dir").attr("action");
			var datos_form = $('#form_agregar_dir').serialize();
			var id_ciudad = $('#cmbx_ciudad').val();
			var id_zona = $('#cmbx_zona').val();
			console.log(datos_form);
			$.ajax({
				url: formulario_action,
				type:'POST',
				dataType:'json',				
				data: datos_form+'&id_ciudad='+id_ciudad+'&id_zona='+id_zona,
				beforeSend: function(){
					preCargador($('#nueva-dir'));
				},
				success:function(data){
					if(data.validacion){
						console.log("entro if validacion");
					if(data.resultado == false){
						console.log("entro if resultado");		
						window.setTimeout(function(){
							$('#nueva-dir').html('Lo sentimos, no hemos podido agregar la direccion especificada, por favor verifica los datos e intenta de nuevo');
							$('#cmbx_ciudad').attr('disabled',false);
							$('#cmbx_zona').attr('disabled',false);
						},1000);		
					}else{		
						console.log("entro else resultado");
						window.setTimeout(function(){
							$('#det_direcciones').append(data.resultado);
							$('#form_agregar_dir').fadeOut('slow',function(){$(this).empty();});
							$('img#agregar-dir').show();
							$('#nueva-dir').unblock();
							$('#cmbx_ciudad').attr('disabled',false);
							$('#cmbx_zona').attr('disabled',false);
						},1000);								
					}
					}else{
						console.log("entro else validacion");
						$('#nueva-dir').html(data.formulario);;
					}						
				}
			});						
		});
		
		$('#cancelar').live('click',function(e){
			e.preventDefault();			
			$('#form_agregar_dir').fadeOut('slow',function(){$(this).empty();});
			$('img#agregar-dir').show();
			$('#cmbx_ciudad').attr('disabled',false);
			$('#cmbx_zona').attr('disabled',false);
			if($('#direcciones > div.message').text()!=''){
				$('#direcciones > div.message').show();
			}
		});

		$("#carrito :radio").live('change',function(event){
			var tipo= $(this).val();
			if(tipo==2){
				$('div#direccion').fadeOut();	
			}else{
				if(typeof $('div#direccion').attr('id') == 'undefined'){
					$.post("<?php echo base_url();?>index.php/pedido/c_pedido/cargarDireccionesAjax",
							null,
							function(data){
							 $("#form_pedido").append(data.html);	
							},
							'json'
						);	
				}else{
					$('div#direccion').fadeIn();
				}
			}	
		});


		
	});
//-->
</script>

<?php echo form_open('pedido/c_pedido','id="form_pedido"',array('pedido' => '1'));?>		
	
	<?php if($envio):?>
	<div id="direccion">
		<div>
			<h2>Direcci&oacute;n de Entrega</h2>
			<div name="dir">		
			<p><?php echo form_label('<b>Ciudad</b>', 'cmbx_ciudad');?></p>
			<?php echo $ciudad;?>
			<small class="guidelines" id="guide_1">Seleccione la ciudad donde se encuentra</small>
			<?php echo form_error('ciudad','<p class="error">','</p>');?>
			</div>
			<div name="dir">
			<p><?php echo form_label('<b>Zona</b>', 'cmbx_zona');?></p>
			<?php echo $zona;?>
			<small class="guidelines" id="guide_2">Seleccione la zona donde se encuentra</small>
			<?php echo form_error('zona','<p class="error">','</p>');?>
			</div>
		</div>
		
		<div id="direcciones">
			
			<p><strong>Direcci&oacute;n</strong></p>					
			<div id="det_direcciones" class="direcciones">
				<?php if(isset($dir_usuario)):?>
	<!--				<ul class="direcciones-content">-->
						<?php foreach ($dir_usuario as $direcciones):?>
	<!--						<li>-->
								<fieldset class="ui-widget ui-widget-content ui-corner-all">
									<table class="direcciones-content">
										<tbody>
											<tr>					
												<td style="border: 0px">
													<?php echo form_radio('radio_direc', $direcciones['id'], false,'id="'.$direcciones['id'].'-direccion" '.set_radio('radio_direc', $direcciones['id']));?>
												</td>
												<td style="border: 0px">
													Ciudad: <?php echo $direcciones['ciudad'];?>,
													Zona: <?php echo $direcciones['zona'];?> , Calle/Carrera: <?php echo $direcciones['calle_carrera'];?>, 
													Casa/Urb: <?php echo $direcciones['casa_urb'];?> , Numero
													Casa/Apto: <?php echo $direcciones['numeroCasaApto'];?> , Lugar de
													Referencia: <?php echo $direcciones['lugarreferencia'];?>
												</td>
											</tr>
										</tbody>
									</table>
								<small class="guidelines" >Seleccione una direcci&oacute;n de entrega</small>						
								</fieldset>
								
	<!--						</li>-->
						<?php endforeach;?>
	<!--				</ul>	-->
		</div>
		<?php endif;?>
		<?php echo form_error('radio_direc','<p class="error">','</p>');?>		
		</div>
		<?php $visible=($agr_visible)?'display:inline':'display:none';?>
		<div>
			<?php echo img(array(
						'src' =>base_url().'application/img/icon/Add-icon.png',
						'id'=>'agregar-dir',
						'alt'=>'Agregar Direccion',
						'style'=>$visible));?>
			<small class="guidelines" id="guide_3">Agregar direcci&oacute;n</small>
		</div>			
		<?php if(isset($error_dir)):?>
			<div class="message"><?php echo $error_dir;?></div>
		<?php endif;?>			
		<div id="nueva-dir"></div>
	</div>
	<?php endif;?>
	<div name="forma_pago">
		<h2>Forma de Pago</h2>
		<div name="radio_pago">
			<?php echo $radio_pago;?>
		</div>
		<small class="guidelines" id="guide_4">Selecione una forma de pago</small>
		<?php echo form_error('radio_tipo_pago','<p class="error">','</p>');?>		
	</div>
	<div>
		<h2>Observaciones(Opcional): </h2>
		<?php echo form_textarea(array('name' =>'observacion','id' => 'observacion','rows'	=> '4','cols'=> '40'));?>
		<small class="guidelines" id="guide_5">Puede agregar algunas indicaciones adicionales para la entrega del pedido</small>	
	</div>
	<div>
		<?php echo form_submit('btn_finalizar_pedido', 'Finalizar Pedido', 'id="btn_finalizar_pedido" class="button_text art-button" ')?>
		<?php echo form_button('btn_cancel_pedido', 'Cancelar Pedido', 'id="btn_cancel_pedido" class="button_text art-button"'); ?>
	</div>
	
<?php echo form_close();?>		