<script type="text/javascript">
<!--
	$(function() {
		
		$('#btn_registrar').click(function(event){
			$.post("<?php echo base_url();?>index.php/pedido/c_pedido_login/cargarRegistro",
					null,
					function(data){
						$("#registro").html(data.html_registro);	
					},
					'json'
				);	
		});

	});
//-->
</script>

<div>
		<?php if(isset($login_usuario)):?>
			<fieldset id="login">		
				<?php echo $login_usuario;?>
				<?php echo form_button('btn_registrar','Nuevo Usuario','id="btn_registrar" class="button_text art-button"'); ?>
			</fieldset>
			<fieldset id="registro">
			</fieldset>
		<?php endif;?>			
			
		
</div>