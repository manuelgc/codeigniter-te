<script type="text/javascript">
<!--

//-->
</script>

<?php form_open('pedido/c_pedido','id="form_pedido"',array('pedido' => '1'))?>		
	<div>
		<h2>Direcci&oacute;n de Entrega</h2>		
		<?php echo $ciudad;?>
		<?php echo $zona;?>
	</div>
	<div>
		<h2>Forma de Pago</h2>
		<?php echo $radio_pago;?>
	</div>
	<div>
		<?php echo form_submit('btn_finalizar_pedido', 'Finalizar Pedido', 'id="btn_finalizar_pedido" class="button_text art-button" ')?>
		<?php echo form_button('btn_cancel_pedido', 'Cancelar Pedido', 'id="btn_cancel_pedido" class="button_text art-button"'); ?>
	</div>
<?php form_close();?>		