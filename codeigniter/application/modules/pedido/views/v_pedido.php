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
					if(data.resultado == false){		
						window.setTimeout(function(){
							$('#nueva-dir').html('Lo sentimos, no hemos podido agregar la direccion especificada, por favor verifica los datos e intenta de nuevo');
							$('#cmbx_ciudad').attr('disabled',false);
							$('#cmbx_zona').attr('disabled',false);
						},1000);		
					}else{		
						window.setTimeout(function(){
							$('#det_direcciones').append(data.resultado);
							$('#form_agregar_dir').fadeOut('slow',function(){$(this).empty();});
							$('img#agregar-dir').show();
							$('#nueva-dir').unblock();
							$('#cmbx_ciudad').attr('disabled',false);
							$('#cmbx_zona').attr('disabled',false);
						},1000);								
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
		
		<?php $visible=($agr_visible)?'display:inline':'display:none';?>
		<?php echo img(array(
					'src' =>base_url().'application/img/icon/Add-icon.png',
					'id'=>'agregar-dir',
					'alt'=>'Agregar Direccion',
					'style'=>$visible));?>
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