<script type="text/javascript">
<!--
function Cargador(){
	$('.content-restaurantes').block({
		message: 'Cargando ...'		
	});
}

function cargarListaRest(html){
	window.setTimeout( function(){
		if (typeof html.zona == "undefined"){
			$("#cmb_zona").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);	
		}else{
			$(".combo-zona").html(html.zona);
		}				
		
		$("#cmb_ciudad").attr("value",html.select_ciudad);
		$("#cmb_zona").attr("value",html.select_zona);
		$("#cmb_categoria").attr("value",html.select_categoria);
		$("#cmb_tipo_orden").attr("value",html.select_orden);
		$('ul.restaurantes').html(html.restaurantes);
		$('ul.link-pag').html(html.paginas_link);

		$('.content-restaurantes').unblock();
		
	}, 1000)
}
$(function() {
	$('ul.link-pag > li.li-pag a').live('click', function(e){
		e.preventDefault();
		var vinculo = $(this).attr('href')+"/busqueda";
		//console.log(vinculo);
		
		 $.ajax({
			url: vinculo,
			type: 'GET',
			dataType: 'json',
			beforeSend: function(data){
				Cargador();
			},				
			success: function (data) {					
				cargarListaRest(data);
				
			}				
		});			
	});
});
//-->
</script>
<?php if(isset($mensaje_error)){ echo '<p>'.$mensaje_error.'</p>';}else{?>
<div class="content-restaurantes">
<ul class="restaurantes">
	<?php if(isset($restaurantes['mensaje'])){echo '<p>'.$restaurantes['mensaje'].'</p>';}?>
	<?php echo form_open('tienda/c_datos_tienda',array('id' => 'frm_result_busqueda'));
	foreach ($restaurantes as $value):
	 if(is_array($value)){?>
			 
		<li class="bloque-restaurante" id="<?php echo $value['tienda_id'];?>">
		<input id="id_tienda" name="id_tienda" type="hidden" value="<?php echo $value['tienda_id'];?>" />		
			<div class="titulo_restaurant"  >
					<p>
				    	<h3><span class="text" ><?php echo $value['nombre_tienda']; ?></span></h3>
					</p>
			</div>
			<div>
				<div class="cont_imagen"  >
						<img src="<?php echo $value['ruta_imagen'];?>" class="">
				</div>
				<div class="cont_boton" >
				
					
					<input id="btn_ordenar" , class="button_text art-button"
					type="submit" name="btn_ordenar" value="Ordenar" />
				</div>
			</div>	
			<div class="descrip_restaurant">
				<div>
					<img src="<?php echo $value['imagen_horario'];?>" class="">
				</div>
				<div>
					<p class=""><?php echo $value['tipo_comida'];?></p>
				</div>
				<div>
					<p>Cant. Minima: <?php echo $value['min_cant'];?></p>
				</div>
				<div>
					<p>Gasto Minimo: <?php echo $value['min_pre'];?></p>
				</div>
				<div>
					<p class=""><?php echo $value['tipo_venta'];?></p>
				</div>
			</div>                           
		</li>
	
	
	<?php }//end if interno
	endforeach;
	echo form_close();?>
	</ul >
	<?php }//end else externo?>		
</div>
<ul class="link-pag">	
	<?php if(isset($paginas_link)){echo $paginas_link;}?>
</ul >	
