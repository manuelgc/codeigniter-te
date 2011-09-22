<ul class="restaurantes">	
	<?php foreach ($restaurantes as $value):?>
		<li class="bloque-restaurante" id="<?php echo $value['tienda_id']?>">
			<div class="" name="titulo_restaurant" width="100%">
					<p>
						<a name="<?php echo $value['tienda_id'];?>" onclick="" href=""></a>
				    	<a><span class=""><?php echo $value['nombre_tienda']; ?></span></a>
					</p>
			</div>
			<div width="80%">
				<div class="" name="cont_imagen" height="80%">
					<a rel="" href="">
						<img src="<?php echo $value['ruta_imagen']?>" alt="" class="">
					</a>
				</div>
				<div class="" name="cont_boton" height="20%">
					<input id="btn_buscar" , class="button_text art-button"
					type="button" name="btn_ordenar" value="Ordenar" />
				</div>
			</div>	
			<div class="descrip_restaurant">
				<div>
<!--					<img src="<?php echo $value['imagen_abierto']?>" alt="" class="">-->
						<p class="">abierto o cerrado</p>
				</div>
				<div>
					<p class=""><?php echo $value['tipo_comida']?></p>
				</div>
				<div>
					<p>Cant. Minima:<?php echo $value['min_cant']?></p>
				</div>
				<div>
					<p>Gasto Minimo:<?php echo $value['min_pre']?></p>
				</div>
				<div>
					<p class=""><?php echo $value['tipo_venta']?></p>
				</div>
			</div>                           
		</li>
	<?php endforeach;?>	
</ul>