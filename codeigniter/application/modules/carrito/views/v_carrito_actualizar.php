<script type="text/javascript">
<!--

function cargarPopupEditar(id_plato,cantidad,instrucciones){
	$.post("<?php echo base_url();?>index.php/carrito/c_carrito/cargarPopupEditarAjax",
			{'id_plato':id_plato,'cantidad':cantidad,'instrucciones':instrucciones},
			function(data){
				if(data.plato){			
					$("#popup-tienda").html(data.html)
					.dialog({
						title:"Editar "+data.nombrePlato,
						autoOpen: false,
						modal:true,
						resizable: false,
						width:400,
						show:"blind",
						hide:"explode",
						buttons: {
						'Aceptar' : function(){
//							if (validarCantidad()){
//							agregarPlato(id_plato, data.nombrePlato);
							$(this).dialog('close');
//							}
						},
						'Cancelar': function() {
							$(this).dialog('close');
						}
						}
		
										
					});
					$("input#cantidad").spinbox({
						  min: 1,    
						  max: 10,  
						  step: 1 
						});
					$("#popup-tienda").dialog('open');
				}
//				else{
//					mostrarError($("#popup-tienda"),"Error", "El plato no se puede agregar al pedido");
//				}
			},
			'json'
		);
}

$("input.cantidad").spinbox({
	  min: 1,    
	  max: 10,  
	  step: 1 
	});

$("input.cantidad").focusout(
		function(event){	
			event.preventDefault();
			var rowid = $(this).attr("name"),
			cantidad=$(this).val();
			objeto=$(this);
			if(cantidad != ''){
			$.post("<?php echo base_url();?>index.php/carrito/c_carrito/actualizarPlato",
					{'cantidad':cantidad,'rowid':rowid},
					function(data){
						$("#carrito").html(data.html);	
					},
					'json'
				);

			}	
		});

$("a.a-eliminar").click(
		function(event){	
			event.preventDefault();
			var rowid = $(this).attr("name");

			$.post("<?php echo base_url();?>index.php/carrito/c_carrito/actualizarPlato",
					{'cantidad':0,'rowid':rowid},
					function(data){
						$("#carrito").html(data.html);	
					},
					'json'
				);
	
		}
);

$("a.a-editar").click(function(event){	
	event.preventDefault();
	var id_plato = $(this).attr('name'),
	instrucciones= $("#"+$(this).attr('id')+"instrucciones").val(),
	cantidad= $("#"+$(this).attr('id')+"cantidad").val();

	cargarPopupEditar(id_plato,cantidad,instrucciones);
	
});


//-->
</script>



<?php echo form_open('carrito/c_carrito'); ?>
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
<ul class="contenido-carrito">
	<?php foreach ($this->cart->contents() as $items): ?>
		
		<li class="plato-carrito">
		  <div>
		  		<div>
					<?php echo form_hidden($i.'rowid', $items['rowid']); ?>
					<?php echo form_hidden($i.'instrucciones', $items['instrucciones']); ?>
					<span> <?php echo form_input(array('id' => $i.'cantidad','name' => $items['rowid'], 'value' => $items['qty'], 'maxlength' => '2', 'size' => '3','class' => 'cantidad')); ?></span>
					<span><?php echo $items['name']; ?></span>
					<span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['price']); ?></span>
					<span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['subtotal']); ?></span>
					<?php echo anchor('','Editar',array('title' => 'Editar Plato','class' => 'a-editar', 'id' =>$i ,'name' => $items['id']));?>	
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
	  	<span><strong>Total</strong></span>
	  	<span> Bs.<?php echo $this->cart->format_number($this->cart->total()); ?></span>
	  </div>
	</li>
</ul>

<!--<p><?php echo form_submit('', 'Update your Cart'); ?></p> -->