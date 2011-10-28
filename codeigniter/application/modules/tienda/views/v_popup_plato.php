<script type="text/javascript">
<!--
$(function(){

	function countChecked() {
		  var n = $('input[name="1extra"]:checkbox:checked').length;
		  $("#mensaje_plato").text(n + (n <= 1 ? " is" : " are") + " checked!");
		}
		
		$(":checkbox").click(countChecked);
			

	function validarCheck(objeto,maximo,minimo) {
//		var $();
		
	}
	
	function validarRadio(objeto,maximo,minimo) {
		
		
	}
	
	$("form#form_popup_plato input").filter(":checkbox,:radio").checkbox();
	
	$("input#cantidad").spinbox({
		  min: 1,    
		  max: 10,  
		  step: 1 
		});

	
	
});
//-->
</script>	
<?php echo form_open('carrito/c_carrito_actualizar','id="form_popup_plato"');?>

		
	<div align="center" class="imagene_plato">	
		<img height="auto" width="350px" src="<?php echo $imagen;?>">
	</div>
	<div><p class="error" id="mensaje_plato"></p></div>
	<div>
		<p>Precio: Bs. <?php  echo $precio;?></p>
	</div>
	<div>
		<p> <?php echo $descripcion; ?></p>
	</div>
	
	<?php if (isset($opciones) && is_array($opciones)):?>		
		<?php foreach ($opciones as $key => $opcion):?>			
			<div class="titulo-opciones">
				<?php echo form_hidden($key.'max_ops', $opcion['maximo']);?>
				<?php echo form_hidden($key.'min_ops', $opcion['minimo']);?>
				<strong>
					<p><?php echo $opcion['nombre'];?>
					<span class="requerido"><?php echo $opcion['requerido']?></span>
					</p>
				</strong>
			</div>
			<div class="contenido-extras">
<!--				<fieldset class="ui-widget ui-widget-content ui-corner-all">-->
				<ul class="ui-widget ui-widget-content ui-corner-all">
					<?php foreach ($opcion['opcion_item'] as $item):?>
						<li>
							<?php echo $item['input']?>
							<?php echo $item['label']?>
						</li>
					<?php endforeach;?>
				</ul>
<!--				</fieldset>-->
			</div>
		<?php endforeach;?>
	<?php endif;?>	
					
	<?php if (isset($extras)&& is_array($extras)):?>
	
	<?php foreach ($extras as $key => $extra):?>	
		<div class="titulo-extras">
			<?php echo form_hidden($key.'max_ext', $extra['maximo']);?>
			<?php echo form_hidden($key.'min_ext', $extra['minimo']);?>
			<strong>
				<p><?php echo $extra['nombre'];?>
				<span class="requerido"><?php echo $extra['requerido']?></span>
				</p>
			</strong>
		</div>
		<div class="contenido-extras">
			<ul class="ui-widget ui-widget-content ui-corner-all">
<!--			<fieldset class="ui-widget ui-widget-content ui-corner-all">-->
				<?php foreach ($extra['extra_item'] as $item):?>
					<li>
						<div class="detalle-extra">
							<?php echo $item['input']?>
							<?php echo $item['label']?>
						</div>
						
					</li>
				<?php endforeach;?>
<!--			</fieldset>-->
			</ul>		
		</div>
		<?php endforeach;?>
	<?php endif;?>
			
	<div>
		<?php echo form_label('Cantidad', 'cantidad');?>
		<?php echo form_input(array('name' => 'cantidad','id' => 'cantidad','size' => '3'),1);?>
	</div>
	<div>
		<?php echo form_label('Observaci&oacute;n', 'observacion');?>
		<?php echo form_textarea(array('name' => 'observacion','id' => 'observacion','rows'	=> '2','cols'=> '40'));?>
	</div>
<?php echo form_close();?>
