<script>
	$(function() {
		$( "#tabs_tienda" ).tabs();
	});
</script>



<div class="tienda">
<div >
	<li class="cabecera_tienda" id="<?php echo $tienda['id'];?>">
			<div class="titulo_tienda" name="" width="70%">
					 	<h2><span class="text"><?php echo $tienda['nombre'] ?>
					 	</span></h3>
						<span class="text"><?php echo $tienda['tipo_comida']?> </span><br>
						<span class="text">Telefonos: <?php echo $tienda['telefono'];?></span><br>
						<span class="text">Cant. Minima: <?php echo $tienda['min_cant'];?></span><br>
						<span class="text">Gasto Minimo: <?php echo $tienda['min_cost'];?></span><br>
						<span class="text"><?php echo $tienda['tipo_venta'];?></span><br>
			</div>
			<div class="imagenes_tienda" name="" width="30%">
				<div>
					<img src="<?php echo $tienda['imagen'];?>" class="">
				</div>
				<div>
					<img src="<?php echo base_url().'imagenes/cerrado.png';?>" class="">
				</div>
					
			</div>			
</div>
<div id="tabs_tienda">
	<ul>
		<li><a href="#tab_menu">Menu</a></li>
		<li><a href="#tab_info">Informaci&oacute;n</a></li>
	</ul>
	<div id="tab_menu">
		<!--Foreach para categoria-->
		<h3>Categoria plato</h2>
		<ul>
		<!--Foreach para platos-->
			
			<li>
				<a name="<?php echo 'id plato';?>" onclick="" href="">
					<span class="text"><?php echo ' nombre_plato1'?> </span>
					<span class="text"><?php echo ' precio_plato1'?> </span>
				</a>
			</li>
			<li>
				<a name="<?php echo 'id plato';?>" onclick="" href="">
					<span class="text"><?php echo ' nombre_plato2'?> </span>
					<span class="text"><?php echo ' precio_plato2'?> </span>
				</a>
			</li>
		</ul>
	</div>
	<div id="tab_info">		
		<span class="text">Descripci&oacute;n: <?php echo $tienda['descripcion']?> </span><br>
		<span class="text">Direcci&oacute;n: <?php echo $tienda['direccion']?> </span><br>
		<!--foreach motrar horarioa	-->
		<span class="text">Horarios:</span><br>
		<?php foreach ($tienda['horario'] as $value):?>
			<span class="text"><?php echo $value ?></span><br>
		<?php endforeach;?>
	</div>
</div>

</div>

