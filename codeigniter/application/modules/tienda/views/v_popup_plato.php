<script type="text/javascript">
<!--
$(function(){
//	$("form#form_popup_plato input").filter(":checkbox,:radio").checkbox();
	
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
				<strong>
					<p><?php echo $opcion['nombre'];?>
					<span class="requerido"><?php echo $opcion['requerido']?></span>
					</p>
				</strong>
			</div>
			<div class="contenido-extras">
				<ul>
					<?php foreach ($opcion['opcion_item'] as $item):?>
						<li>
							<?php echo $item['input']?>
							<?php echo $item['label']?>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
		<?php endforeach;?>
	<?php endif;?>	
					
	<?php if (isset($extras)&& is_array($extras)):?>
	
	<?php foreach ($extras as $key => $extra):?>	
		<div class="titulo-extras">
			<strong>
				<p><?php echo $extra['nombre'];?>
				<span class="requerido"><?php echo $extra['requerido']?></span>
				</p>
			</strong>
		</div>
		<div class="contenido-extras">
			<ul>
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
