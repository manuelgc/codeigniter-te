<script type="text/javascript">
<!--
$(function(){


	function mostrarError(objeto,texto){
		objeto.fadeIn(500);
		objeto.text( texto ).addClass( "ui-state-highlight" );
		setTimeout(function() {
			objeto.removeClass( "ui-state-highlight", 1000 );
		}, 500 );
	}
	
	function ocultarError(objeto){		
		objeto.fadeOut(1500).text("");	
	}
						
	function validarCheck(nombre,maximo,minimo) {
		var n=$('input[name="'+nombre+'"]:checkbox:checked').length;
		
		$("#mensaje_plato").text(n + (n <= 1 ? " is" : " are") + " checked!");

		if(maximo!=0){
			if( n >= minimo && n<= maximo){
				return true;	
			}else if((maximo==minimo) && (n !=maximo)){
				mostrarError(msj_obj, "Debe seleccionar "+minimo+" opciones");

				return true;
			}else{
				return false;
			}
				
			
		}else {
			return true;
		}
	}

	function validarTodo() {
		var respuesta= true;
		
		$("#form_popup_plato ul").each(function (i) {
			console.log($(this));
	        console.log("id: "+$(this).attr("id"));
	        console.log("nombre: "+$(this).attr("name"));
	        var n= $(this).attr("id").split("-");
	        console.log("#"+n[0]+'-min_'+n[1]);
	        console.log("min:"+$("#"+n[0]+'-min_'+n[1]).val());
	        console.log("max:"+$("#"+n[0]+'-max_'+n[1]).val());
	        console.log("cheked: "+ $('input[name="'+n[0]+'-'+n[1]+'"]:checked').length);

			var cadena= $(this).attr("id").split("-"),
			maximo=$("#"+n[0]+'-max_'+n[1]).val(),
			minimo=$("#"+n[0]+'-min_'+n[1]).val(),
			msj_obj=$("#"+n[0]+'-msj_'+n[1]),
			num_checked=$('input[name="'+n[0]+'-'+n[1]+'"]:checked').length;
			
			
			if(num_checked < minimo){
				mostrarError(msj_obj, "Debe seleccionar al menos "+minimo+" opciones");
				respuesta=false;
			}else if(maximo!=0){
				if(num_checked > maximo){
					mostrarError(msj_obj, "No puede seleccionar mas de "+maximo+" opciones");
					respuesta=false;
				}else if((maximo==minimo) && (num_checked !=maximo)){
					mostrarError(msj_obj, "Debe seleccionar "+minimo+" opciones");
					respuesta=false;
				}
			}	
			return respuesta;		
				
			
	      });

	}
	
//	$("form#form_popup_plato input").filter(":checkbox,:radio").checkbox();

	$("input#cantidad").spinbox({
			  min: 1,    
			  max: 10,  
			  step: 1 
			});

	$("input:checkbox").click(
			function(event) {
				var nombre = $(this).attr("name"),
				cadena_id=nombre.split("-");

				if(cadena_id[1]=="opcion"){
					var maximo=$("#"+cadena_id[0]+"-max_opcion").val(),
					minimo=$("#"+cadena_id[0]+"-min_opcion").val(),
					mensaje=$("#"+cadena_id[0]+"-msj_opcion");
				}else{
					var maximo=$("#"+cadena_id[0]+"-max_extra").val(),
					minimo=$("#"+cadena_id[0]+"-min_extra").val(),
					mensaje=$("#"+cadena_id[0]+"-msj_extra");
				}	
				if(!validarCheck(nombre,maximo, minimo)){
					$(this).attr('checked',false);	
					mostrarError(mensaje, "Debe seleccionar entre "+minimo+" a "+maximo+" opciones");					
//						return false;
				}else{
					if(mensaje.text()!=""){
						ocultarError(mensaje);
					}
//						return true;
					}

					
			}
				
	);

	$("#form_popup_plato").submit(function(event){
		event.preventDefault();
		validarTodo();
		
		});
	
	
});
//-->
</script>	
<?php echo form_open('carrito/c_carrito','id="form_popup_plato"');?>

		
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
				<?php echo form_hidden($key.'-max_opcion', $opcion['maximo']);?>
				<?php echo form_hidden($key.'-min_opcion', $opcion['minimo']);?>
				<strong>
					<p><?php echo $opcion['nombre'];?>
					<span class="requerido"><?php echo $opcion['requerido']?></span>
					</p>
				</strong>
			</div>
			<div><p class="error" id=<?php echo $key."-msj_opcion";?>></p></div>
			<div class="contenido-opciones">
<!--				<fieldset class="ui-widget ui-widget-content ui-corner-all">-->
				<ul id="<?php echo $key.'-opcion';?>" name="<?php echo $opcion['nombre'];?>" class="ui-widget ui-widget-content ui-corner-all">
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
			<?php echo form_hidden($key.'-max_extra', $extra['maximo']);?>
			<?php echo form_hidden($key.'-min_extra', $extra['minimo']);?>
			<strong>
				<p><?php echo $extra['nombre'];?>
				<span class="requerido"><?php echo $extra['requerido']?></span>
				</p>
			</strong>
		</div>
		<div><p class="error" id=<?php echo $key."-msj_extra";?>></p></div>
		<div class="contenido-extras">
			<ul id="<?php echo $key.'-extra';?>" name="<?php echo $extra['nombre'];?>" class="ui-widget ui-widget-content ui-corner-all">
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
