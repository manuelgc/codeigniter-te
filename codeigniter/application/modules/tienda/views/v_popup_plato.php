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
	
	function validarCantidad(inputCant,Error){
		if(inputCant.val()==''){
			mostrarError(Error, 'Debe seleccionar una cantidad mayor a cero');
			return false;
		}else {
			return true;
		}		
	}
				
	function validarCheck(objeto) {
		var nombre = objeto.attr("name"),
		cadena_id= nombre.split("-"),
		maximo=$("#"+cadena_id[0]+"-max_"+cadena_id[1]).val(),
		minimo=$("#"+cadena_id[0]+"-min_"+cadena_id[1]).val(),
		mensaje=$("#"+cadena_id[0]+"-msj_"+cadena_id[1]), 
		n=$('input[name="'+nombre+'"]:checkbox:checked').length;
		
		$("#mensaje_plato").text(n + (n <= 1 ? " is" : " are") + " checked!");

		if( n < minimo ){
			mostrarError(mensaje, "Debe seleccionar al menos "+minimo+" opciones");
			return false;
		}else if(maximo!=0){
			if( n> maximo){
				objeto.attr('checked',false);
				mostrarError(mensaje, "No debe seleccionar mas "+maximo+" opciones");
				return false;	
			}else if((maximo==minimo) && (n !=maximo)){
				mostrarError(objeto, "Debe seleccionar "+maximo+" opciones");
				return false;
			}else{
				if(mensaje.text()!=""){
					ocultarError(mensaje);
				}
				return true;
			}
		}else {
			if(mensaje.text()!=""){
				ocultarError(mensaje);
			}
			return true;
		}
	}

	function validarTodo() {
		var respuesta= true;
		
		$("#form_popup_plato ul").each(function (i) {

			var cadena= $(this).attr("id").split("-"),			
			num_checked=$('input[name="'+cadena[0]+'-'+cadena[1]+'"]:checked').length,
			maximo=$("#"+cadena[0]+'-max_'+cadena[1]).val(),
			minimo=$("#"+cadena[0]+'-min_'+cadena[1]).val(),
			msj_obj=$("#"+cadena[0]+'-msj_'+cadena[1]);
			
			
			if(num_checked < minimo){
				mostrarError(msj_obj, "Debe seleccionar al menos "+minimo+" opciones");
				respuesta=false;
			}else if(maximo!=0){
				if(num_checked > maximo){
					mostrarError(msj_obj, "No debe seleccionar mas de "+maximo+" opciones");
					respuesta=false;
				}else if((maximo==minimo) && (num_checked !=maximo)){
					mostrarError(msj_obj, "Debe seleccionar "+minimo+" opciones");
					respuesta=false;
				}
			}	

			
					
					
	      });
		return respuesta;

	}

	function agregarPlato(id_plato) {
		var cantidad = $("#cantidad").val(),
		observacion= $("#observacion").val(),
		seleccion= new Array();
		
		$("#form_popup_plato ul").each(function (i) {

			var cadena= $(this).attr("id").split("-");

			seleccion.push($('input[name="'+cadena[0]+'-'+cadena[1]+'"]:checked').serializeArray());

	   	});
		
		 $.post("<?php echo base_url();?>index.php/carrito/c_carrito",
				  { 'id_plato': id_plato,'cantidad': cantidad, 'observacion': observacion,'seleccion':seleccion},
  			function(data){
			  	if (data.carrito) {
			  		$("#carrito").html(data.html);	
				} else {
					dialogError($("#popup-tienda"),"Error", "El plato no se puede agregar al pedido");
				}		
  					
 		 },
			'json'); 
	}
	
//	$("form#form_popup_plato input").filter(":checkbox,:radio").checkbox();

	$("input#cantidad").spinbox({
			  min: 1,    
			  max: 10,  
			  step: 1 
			});

	$("input:checkbox").click(
			function(event) {	
				validarCheck($(this));					
			}
				
	);

	$("#form_popup_plato").submit(function(event){
		var id_plato=$("#form_popup_plato > input#id_plato").val();			
		if( validarTodo() && validarCantidad($("#cantidad"), $("#msj_cant"))){	
			agregarPlato(id_plato);
			$("#popup-tienda").dialog('close');
			return false;
		}else{
			return false;
		}
		});
	
	
});
//-->
</script>	
<?php echo form_open('','id="form_popup_plato"');?>

	<?php echo form_hidden('id_plato', $id_plato);?>	
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
		<div><p class="error" id="msj_cant"></p></div>
		<?php echo form_label('Cantidad', 'cantidad');?>
		<?php echo form_input(array('name' => 'cantidad','id' => 'cantidad','size' => '3'),1);?>
	</div>
	<div>
		<?php echo form_label('Observaci&oacute;n', 'observacion');?>
		<?php echo form_textarea(array('name' => 'observacion','id' => 'observacion','rows'	=> '2','cols'=> '40'));?>
	</div>
<?php echo form_close();?>
