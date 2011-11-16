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
	
	function cargarPopupEditar(id_plato,rowid){
		$.post("<?php echo base_url();?>index.php/carrito/c_carrito/cargarPopupEditarAjax",
				{'id_plato':id_plato,'rowid':rowid},
				function(data){
					if(data.plato){			
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
//								editarPlato(id_plato,rowid);
								$("#form_popup_plato").submit();
//								$(this).dialog('close');
							},
							'Cancelar': function() {
								$(this).dialog('close');
							}
							}
			
											
						});

						$("#popup-tienda").dialog('open');
					}
				else{
					mostrarError($("#popup-tienda"),"Error", "El plato no se puede agregar al pedido");
				}
				},
				'json'
			);
	};
	
	function actulizarTipoOrden(valor){
		
		$.cookie('tipo_orden', valor,{path: '/'});
	}
	
	function validarCarrito() {
		var valor=<?php echo $cont_pricipal;?>;
		if(valor==0){
			$("#mensaje_carrito").text("advertencia").fadeIn(1000);
		}
		console.log("algo");
		console.log("valor:"+valor);
	}
	
	$(function() {
			
		$("#form_carrito input.cantidad").spinbox({
			  min: 1,    
			  max: 10,  
			  step: 1 
			});
		
		$("#form_carrito input.cantidad").click(
				function(event){	
					event.preventDefault();
					var rowid = $(this).attr("name"),
					cantidad=$(this).val(),
					id_tienda = $("#id_tienda").val();
					if(cantidad != '' && cantidad!=this.defaultValue){
					preCargador($('#carrito'));
					$.post("<?php echo base_url();?>index.php/carrito/c_carrito/actualizarPlato",
							{'cantidad':cantidad,'rowid':rowid,'id_tienda':id_tienda},
							function(data){
								postCargador($('#carrito'));
								$("#carrito").html(data.html);	
							},
							'json'
						);
					
					}	
					
					});

		
		$("#form_carrito input.cantidad").focus(
				function(event){
					event.preventDefault();
					$(this).blur();
		});
		
		$("#form_carrito a.a-eliminar").click(
				function(event){	
					event.preventDefault();
					var rowid = $(this).attr("name"),
					id_tienda = $("#id_tienda").val();

					preCargador($('#carrito'));
					$.post("<?php echo base_url();?>index.php/carrito/c_carrito/actualizarPlato",
							{'cantidad':0,'rowid':rowid,'id_tienda':id_tienda},
							function(data){
								postCargador($('#carrito'));
								$("#carrito").html(data.html);	
							},
							'json'
						);
			
				}
		);
		
		$('#form_carrito input[name="radio_tipo_orden"]:radio').click(function(event){	
	//		event.preventDefault();
			actulizarTipoOrden($(this).val());
			preCargador($('#carrito'));
			var id_tienda = $("#id_tienda").val();
			$.post("<?php echo base_url();?>index.php/carrito/c_carrito",
					  { 'id_tienda':id_tienda},
	 			function(data){
				  postCargador($('#carrito'));
				  $("#carrito").html(data.html);	
			
	 					
			 },
				'json'); 		
		});
		
		$("#form_carrito a.a-editar").click(function(event){	
			event.preventDefault();
			var id_plato = $(this).attr('name'),
			rowid= $("#"+$(this).attr('id')+"rowid").val();
			cargarPopupEditar(id_plato,rowid);
			
		});

		$("#form_carrito button#btn_cancel_pedido").click(
				function(event){	
					event.preventDefault();
					preCargador($('#carrito'));
					$.post("<?php echo base_url();?>index.php/carrito/c_carrito/eliminarCarrito",'',
							function(data){
								postCargador($('#carrito'));
								$("#carrito").html(data.html);	
							},
							'json'
						);
			
				}
		);

//		$("div #carrito").change( 
//			function(event){
				validarCarrito();
//			});
		
		
		});
	//-->
</script>

<div id="carrito">
				
	<?php if(!$this->cart->contents()): ?>
		
		<h3>Pedido</h3>
	
	<?php else:?>  
<!--		<?php echo print_r($this->cart->contents());?>-->
		<?php echo form_open('carrito/c_carrito','id="form_carrito"'); ?>
		<div class="titulo-carrito" align="center">
			<h3>Pedido</h3>
		</div>
		
		
		<div class="cabecera-carrito">
		  <span>Cantidad</span>
		  <span>Plato</span>
		  <span style="text-align:right">Precio</span>
		  <span style="text-align:right">Sub-Total</span>
		</div>
		
		<?php $i = 1; ?>
		<?php $total_iva=0;?>
		<ul class="contenido-carrito">
			<?php foreach ($this->cart->contents() as $items): ?>
				
				<li class="plato-carrito">
				  <div>
				  		<div>
							<?php echo form_hidden($i.'rowid', $items['rowid']); ?>
							<span> <?php echo form_input(array('id' => $i.'cantidad','name' => $items['rowid'], 'value' => $items['qty'], 'maxlength' => '2', 'size' => '3','class' => 'cantidad')); ?></span>
							<span><?php echo $items['name']; ?></span>
							<span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['price']); ?></span>
							<span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['subtotal']); ?></span>
							<?php echo anchor('','Editar',array('title' => 'Editar Plato','class' => 'a-editar', 'id' =>$i ,'name' => $items['id']));?>
							<?php $total_iva +=($items['precio_iva']*$items['qty']);?>
						</div>
						
						<div class="eliminar-plato">
								<?php echo anchor('',
								img(array( 'src'=> base_url().'application/img/icon/delete-icon.png','width' => '15px','height' => '15px')),
								array('title' => 'Eliminar Plato','class' => 'a-eliminar','name' => $items['rowid']));?>														
						</div>
				  </div>
				</li>
			<?php $i++; ?>
			<?php endforeach; ?>
		
			<li class="total-carrito">	  
			  <div align="right">
			  	<span><strong>Sub-Total</strong></span>
			  	<span> Bs.<?php echo $this->cart->format_number($this->cart->total()); ?></span>
			  </div>
			</li>
			<li class="total-carrito">	
			  <div align="right">
			  	<span><strong>IVA</strong></span>
			  	<span> Bs.<?php echo number_format($total_iva,2,',','.'); ?></span>
			 </div>
			</li>
			<?php if(isset($costo_envio)):?>
				<li class="total-carrito">	
				  <div align="right">
				  	<span><strong>Costo de envio</strong></span>
				  	<span> Bs.<?php echo  number_format($costo_envio,2,',','.') ?></span>
				  </div>
				</li>
			<?php endif;?>
			<li class="total-carrito">	
			  <div align="right">
			  	<span><strong>Total</strong></span>
			  	<?php if(isset($costo_envio)):?>
			  		<span> Bs.<?php echo  number_format($this->cart->total()+$total_iva + $costo_envio,2,',','.'); ?></span>
			  	<?php else:?>
			  		<span> Bs.<?php echo  number_format($this->cart->total()+$total_iva,2,',','.'); ?></span>
			  	<?php endif;?>
			  </div>
			  		
			</li>  
		</ul>
		<?php if(isset($radio_tipo)):?>
			<div>
				<?php echo $radio_tipo;?>
			</div>
		<?php endif;?>
		<div>
			<?php echo form_submit('btn_comfirmar_pedido', 'Confirmar Pedido', 'id="btn_confir_pedido" class="button_text art-button"')?>
			<?php echo form_button('btn_cancel_pedido', 'Cancelar Pedido', 'id="btn_cancel_pedido" class="button_text art-button"'); ?>
		</div>
		<div><p class="error" id="mensaje_carrito"></p></div>
		<?php form_close()?>  
	<?php endif;?>
</div> <!--Cierra div carrito -->
