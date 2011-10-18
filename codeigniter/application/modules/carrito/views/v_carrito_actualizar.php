<script type="text/javascript">
<!--

$("input.cantidad").spinbox({
	  min: 1,    
	  max: 10,  
	  step: 1 
	});
$("input.cantidad").change(
		function(event){	
			event.preventDefault();
			var id="#"+$(this).attr("name")+"[rowid]";
			console.log(id);
			var rowid = $(id).val(),
			cantidad=$(this).val();
			console.log("valor"+rowid);
			if(cantidad != ''){
			$.post("<?php echo base_url();?>index.php/carrito/c_carrito/actualizarPlato",
					{'cantidad':cantidad,'rowid':rowid},
					function(data){
						$("carrito").html(data.html);	
					},
					'json'
				);
			}	
		}
		);
//-->
</script>



<?php echo form_open('carrito/c_carrito'); ?>
<div class="titulo-carrito" align="center">
	<h3>Pedido</h3>
</div>
<!--<table cellpadding="6" cellspacing="1" style="width:100%" border="0">-->

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
		  <?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
		  <span> <?php echo form_input(array('id' => $i.'[qty]','name' => $i, 'value' => $items['qty'], 'maxlength' => '2', 'size' => '3','class' => 'cantidad')); ?></span>
		  <span><?php echo $items['name']; ?></span>
		  <span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['price']); ?></span>
		  <span style="text-align:right">Bs.<?php echo $this->cart->format_number($items['subtotal']); ?></span>
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
<!--</table>-->

<!--<p><?php echo form_submit('', 'Update your Cart'); ?></p> -->