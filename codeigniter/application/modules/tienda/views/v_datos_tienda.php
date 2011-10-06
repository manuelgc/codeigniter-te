<script>
	$(function() {
		$( "#tabs_tienda" ).tabs();
		$(".a-plato").click(function(event){	
			event.preventDefault();
			var id_tienda = $(this).val();
			$.post("<?php echo base_url();?>index.php/tienda/c_datos_tienda/validarAbierto",
					{'id_tienda':id_tienda},
					function(data){
						if(!data.abierto){
							alert("Tienda cerrada")
						}
					},
					'json'
				);
				
		});
	});
</script>



<div class="tienda">
<div >
	<li class="cabecera_tienda" id="<?php echo $id;?>">
			<div class="titulo_tienda" name="" width="70%">
					 	<h2><span class="text"><?php echo $nombre ?>
					 	</span></h3>
						<span class="text"><?php echo $tipo_comida?> </span><br>
						<span class="text">Telefonos: <?php echo $telefono;?></span><br>
						<span class="text">Cant. Minima: <?php echo $min_cant;?></span><br>
						<span class="text">Gasto Minimo: <?php echo $min_cost;?></span><br>
						<span class="text"><?php echo $tipo_venta;?></span><br>
			</div>
			<div class="imagenes_tienda" name="" width="30%">
				<div>
					<img src="<?php echo $imagen;?>" class="">
				</div>
				<div>
					<img src="<?php echo $imagen_horario;?>" class="">
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
		<?php 
		if(is_array($menu)){
		foreach ($menu as $categoia => $plato):?>
		<h3><?php echo $categoia;?></h3>
		<ul>

			<?php foreach ($plato as $id => $p):?>	
				<li>
					<a class="a-plato" name="<?php echo $id;?>" value="<?php echo $id;?>" href="">
						<span class="text"><?php echo $p['nombre'];?> </span>
						<span class="text"><?php echo $p['precio'];?> Bs. </span>
					</a>
				</li>
			<?php endforeach;?>	

		</ul>
		<?php endforeach;
		}else{?>
			<span class="text"><?php echo $menu ?></span><br>
		<?php }//end else?>
		
	</div>
	<div id="tab_info">		
		<span class="text">Descripci&oacute;n: <?php echo $descripcion?> </span><br>
		<span class="text">Direcci&oacute;n: <?php echo $direccion?> </span><br>
		<span class="text">Horarios:</span><br>
		<?php if(is_array($horario)){
		 foreach ($horario as $key => $value):?>
			<span class="text"><?php echo $key ?></span>
			<span class="text"><?php echo $value ?></span><br>
		<?php endforeach;
		}else{?>
			<span class="text"><?php echo $horario ?></span><br>
		<?php }//end else?>
	</div>
</div>

</div>

