<script type="text/javascript">
<!--
	$(function() {
		
		$('#btn_registrar').click(function(event){
			$.post("<?php echo base_url();?>index.php/pedido/c_pedido_login/cargarRegistro",
					null,
					function(data){
						$("#registro").html(data.html_registro);
						$("#registro > div#form_container > form").append('<input id="pedido" type="hidden" value="1" name="pedido">');	
					},
					'json'
				);	
		});

		$('form  > div.hidden').append('<input id="pedido" type="hidden" value="1" name="pedido">');
		
	});
//-->
</script>

<div>
		<?php if(isset($login_usuario)):?>
			<fieldset id="login">		
				<?php echo $login_usuario;?>
			</fieldset>
		<?php endif;?>	
	
		<fieldset id="registro">
			<?php if (isset($registro_usuario)):?>
				<?php echo $registro_usuario;?>
			<?php else:?>
				<div>
					<h2>Registro de clientes todoexpress</h2>
					<p>Crea tu cuenta para poder disfrutar de nuestros servicios.</p>
				</div>
				<?php echo form_button('btn_registrar','Registrar','id="btn_registrar" class="button_text art-button"'); ?>
			<?php endif;?>	
		</fieldset>
				
</div>