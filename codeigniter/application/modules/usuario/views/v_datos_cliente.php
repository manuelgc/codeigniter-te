<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
	
	<?php if ($datos_usuario === NULL ) {
		?>
	<p>Usted no deberia estar aqui... por favor ingrese en su cuenta a traves del siguiente vinculo <?php echo anchor('home/c_home','Inicio');?></p>		
<?php 
	}else {?>
<div class="demo">

<div id="tabs">
	<ul>
		<li><a href="#datos">Tus Datos</a></li>
		<li><a href="#direcciones">Tus Direcciones</a></li>
		<li><a href="#pedidos">Tus Pedidos</a></li>
	</ul>
	<div id="datos">
		<span class="text">Usuario: <?php echo $datos_usuario->nombreusuario;?></span>
		<span class="text">Nombre: <?php echo $datos_usuario->nombre;?></span>
		<span class="text">Apellidos: <?php echo $datos_usuario->apellidos;?></span>
		<span class="text">Telefono Fijo: <?php echo $datos_usuario->telfijo;?></span>
		<span class="text">Telefono Celular: <?php echo $datos_usuario->telefonoCel;?></span>
		<span class="text">Correo Electronico: <?php echo $datos_usuario->correo;?></span>
		<?php echo anchor('usuario/c_editar_usuario','Editar','class="button_text art-button" id="button-edit"');?>
	</div>
	<div id="direcciones">
		<?php //foreach ($dir_usuario as $direcciones):?>
		<span class="inline">Estado: <?php echo $dir_usuario;?></span>
		<?php //endforeach;?>
	</div>
	<div id="pedidos">
		
	</div>
</div>

</div><!-- End demo -->
<?php }?>