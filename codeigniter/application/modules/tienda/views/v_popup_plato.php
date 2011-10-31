<script type="text/javascript">
<!--
$(function(){


	function mostrarError(objeto,texto){
		objeto.text( texto ).addClass( "ui-state-highlight" );
		setTimeout(function() {
			objeto.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}
	
	function ocultarError(objeto){
		setTimeout(function() {
			objeto.removeClass( "ui-state-highlight", 1500 ).text("");
		}, 500 );
	}
	function contarCheckbox(nombre) {
		  var n = $('input[name="'+nombre+'"]:checkbox:checked').length;
		  $("#mensaje_plato").text(n + (n <= 1 ? " is" : " are") + " checked!");
		  return n;
		}
		
		
			

	function validarCheck(nombre,maximo,minimo,mensaje) {
		var n=contarCheckbox(nombre);

		if(maximo!=0){
			if( n >= minimo && n<= maximo){
				return true;	
			}else {
				return false;
			}
		}else {
			return true;
		}
	}
	
	function validarRadio(objeto,maximo,minimo) {
		
		
	}

	$("input:checkbox").click(
			function(event) {
//				event.preventDefault();
				var nombre = $(this).attr("name"),
				cadena_id=nombre.split("-");

				if(cadena_id[1]=="opcion"){
					var maximo=$("#"+cadena_id[0]+"-max_ops").val(),
					minimo=$("#"+cadena_id[0]+"-min_ops").val(),
					mensaje=$("#"+cadena_id[0]+"-msj_ops");
				}else{
					var maximo=$("#"+cadena_id[0]+"-max_ext").val(),
					minimo=$("#"+cadena_id[0]+"-min_ext").val(),
					mensaje=$("#"+cadena_id[0]+"-msj_ext");
				}	
				console.log("cadena split: "+cadena_id[0]+cadena_id[1]);
				console.log("mensaje: "+mensaje.attr("id"));
				console.log("maximo: "+maximo);
				console.log("minimo: "+minimo);
				console.log("checked: "+$(this).attr("checked"));
					if(!validarCheck(nombre,maximo, minimo,mensaje)){
//						mensaje.text("fallo");
						mostrarError(mensaje, "fallo");
//						$(this).checkbox('uncheck');
//						$(this).removeClass( "ui-icon ui-icon-check");
//						$(this).addClass( "ui-icon ui-icon-empty" );
						$(this).attr('checked',false);
						console.log("checked2: "+$(this).attr("checked"));
//						return false;
					}else{
//						ocultarError(mensaje);
						mensaje.text("");
//						return true;
					}
//				validarCheck($(this),maximo, minimo,mensaje);
					
			}
				
	);
	
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
		<div><p class="error" id=<?php echo $key."-msj_ops";?>></p></div>			
			<div class="titulo-opciones">
				<?php echo form_hidden($key.'-max_ops', $opcion['maximo']);?>
				<?php echo form_hidden($key.'-min_ops', $opcion['minimo']);?>
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
		<div><p class="error" id=<?php echo $key."-msj_ext";?>></p></div>	
		<div class="titulo-extras">
			<?php echo form_hidden($key.'-max_ext', $extra['maximo']);?>
			<?php echo form_hidden($key.'-min_ext', $extra['minimo']);?>
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
