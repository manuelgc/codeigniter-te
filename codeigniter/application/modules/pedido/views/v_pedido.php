<script type="text/javascript">
<!--

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
		});

		$("#cmbx_zona").change(function(event){
			event.preventDefault();
			var id_zona = $(this).val(),
			id_ciudad = $('#cmbx.ciudad').val(),
			msj=$('#direcciones > div.message').attr('class');
			actulizarZona(id_zona);
			console.log(msj);
			if(id_ciudad != '' && id_zona != ''){
			$.post("<?php echo base_url();?>index.php/pedido/c_pedido/actualizarDirecciones",
					{'id_zona':id_zona},
					function(data){
						if(data.direccion){
							$('#det_direcciones').html(data.html_dir);
							$('#direcciones > div.message').empty();
						}else{
							$('#det_direcciones').empty();
							
							if(typeof msj == 'undefined'){
								$('#direcciones').append('<div class="message">'+data.error+'</div>');
							}else{
								$('#direcciones > div.message').text(data.error);
							}	
						}
					},
					'json'
				);
			}else{
				$('#det_direcciones').empty();
				if(typeof msj == 'undefined'){
					$('#direcciones').append('<div class="message">Debe selecionar la ciudad y zona donde se encuentra</div>');
				}else{
					$('#direcciones > div.message').text('Debe selecionar la ciudad y zona donde se encuentra');
				}
			}

		});
	});
//-->
</script>

<?php form_open('pedido/c_pedido','id="form_pedido"',array('pedido' => '1'))?>		
	<div>
		<h2>Direcci&oacute;n de Entrega</h2>		
		<p><?php echo form_label('<b>Ciudad</b>', 'cmbx_ciudad');?></p>
		<?php echo $ciudad;?>
		<p><?php echo form_label('<b>Zona</b>', 'cmbx_zona');?></p>
		<?php echo $zona;?>
	</div>
	
	<div id="direcciones">
		
		<p><strong>Direcci&oacute;n</strong></p>
		<?php echo img(array(
							'src' =>base_url().'application/img/icon/Add-icon.png',
							'id'=>'agregar-dir',
							'alt'=>'Agregar Direccion'));?>
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
												<?php echo form_radio('radio_direc', $direcciones['id'], false,'id="'.$direcciones['id'].'-direccion"');?>
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
							</fieldset>
<!--						</li>-->
					<?php endforeach;?>
<!--				</ul>	-->
		<?php endif;?>
		</div>
		<?php if(isset($error_dir)):?>
			<div class="message"><?php echo $error_dir;?></div>
		<?php endif;?>
		<div id="nueva-dir"></div>
	</div>
	
	<div>
		<h2>Forma de Pago</h2>
		<?php echo $radio_pago;?>
	</div>
	<div>
		<h2>Observaciones: </h2>
		<?php echo form_textarea(array('name' =>'observacion','id' => 'observacion','rows'	=> '4','cols'=> '40'));?>
	</div>
	<div>
		<?php echo form_submit('btn_finalizar_pedido', 'Finalizar Pedido', 'id="btn_finalizar_pedido" class="button_text art-button" ')?>
		<?php echo form_button('btn_cancel_pedido', 'Cancelar Pedido', 'id="btn_cancel_pedido" class="button_text art-button"'); ?>
	</div>
	
<?php form_close();?>		