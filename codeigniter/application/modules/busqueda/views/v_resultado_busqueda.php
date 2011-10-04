<style>
<!--

-->
</style>
<?php if(isset($mensaje_error)){ echo '<p>'.$mensaje_error.'</p>';}else{?>
<ul class="restaurantes">
	<?php 
	if(isset($restaurantes['mensaje'])){echo '<p>'.$restaurantes['mensaje'].'</p>';}
	echo form_open('tienda/c_datos_tienda',array('id' => 'frm_result_busqueda'));
	foreach ($restaurantes as $value):
	 if(is_array($value)){?>
			 
		<li class="bloque-restaurante" id="<?php echo $value['tienda_id'];?>">
		<input id="id_tienda" name="id_tienda" type="hidden" value="<?php echo $value['tienda_id'];?>" />
			<div class="titulo_restaurant" name="" width="100%">
					<p>
<!--						<a name="<?php echo $value['tienda_id'];?>" onclick="" href=""></a>-->
<!--				    	<a>-->
				    		<h3><span class="text" ><?php echo $value['nombre_tienda']; ?></span></h3>
<!--				    	</a>-->
					</p>
			</div>
			<div width="80%">
				<div class="cont_imagen" name="" height="80%">
<!--					<a rel="" href="">-->
						<img src="<?php echo $value['ruta_imagen'];?>" class="">
<!--					</a>-->
				</div>
				<div class="cont_boton" name="" height="20%">
				
					
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
	echo form_close();	
	if(isset($paginas_link)){echo $paginas_link;}
	}//end else externo
	?>	
</ul>