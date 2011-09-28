<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>

<?php if ($datos_usuario === NULL ) {
	?>
<p>
	Usted no deberia estar aqui... por favor ingrese en su cuenta a traves
	del siguiente vinculo
	<?php echo anchor('home/c_home','Inicio');?>
</p>
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
			<span class="text">Usuario: <?php echo $datos_usuario->nombreusuario;?>
			</span> <span class="text">Nombre: <?php echo $datos_usuario->nombre;?>
			</span> <span class="text">Apellidos: <?php echo $datos_usuario->apellidos;?>
			</span> <span class="text">Telefono Fijo: <?php echo $datos_usuario->telfijo;?>
			</span> <span class="text">Telefono Celular: <?php echo $datos_usuario->telefonoCel;?>
			</span> <span class="text">Correo Electronico: <?php echo $datos_usuario->correo;?>
			</span>
			<?php echo anchor('usuario/c_editar_usuario','Editar','class="button_text art-button" id="button-edit"');?>
		</div>
		<div id="direcciones">
			<ul class="direcciones-content">
			<?php foreach ($dir_usuario as $direcciones):?>
				<li><span class="inline">Estado: <?php echo $direcciones['estado'];?>
				</span> <span class="inline">Ciudad: <?php echo $direcciones['ciudad'];?>
				</span> <span class="inline">Zona: <?php echo $direcciones['zona'];?>
				</span> <span class="inline">Calle/Carrera: <?php echo $direcciones['calle_carrera'];?>
				</span> <span class="inline">Casa/Urb: <?php echo $direcciones['casa_urb'];?>
				</span> <span class="inline">Numero Casa/Apto: <?php echo $direcciones['numeroCasaApto'];?>
				</span> <span class="inline">Lugar de Referencia: <?php echo $direcciones['lugarreferencia'];?>
				</span>
				</li>
				<?php echo anchor('usuario/c_editar_direccion/'.$direcciones['id'],'Editar Direccion','class="button_text art-button"');?>
				<?php endforeach;?>
			</ul>
			<?php echo anchor('usuario/c_editar_direccion','Agregar Direccion','class="button_text art-button"');?>
		</div>
		<div id="pedidos">
		<?php echo form_open('usuario/filtrarBusqueda','id="form-filtro-pedidos"',array('reordenar' => '0'));?>
			<ul class="">

				<li id="li_1" class="pedido-usuario"><label class="description" for="element_1">Estado del
						Pedido </label>
					<div>
					<?php echo form_dropdown('estados_ped',$estados_pedido,'','class="element select medium"');?>
					</div>
				</li>
				<li id="li_2" class="pedido-usuario"><label class="description" for="element_2">Tipo de
						Pedido </label>
					<div>
					<?php echo form_dropdown('tipo_ped',$tipo_ped,'','class="element select medium"');?>
					</div>
				</li>
				<li id="li_3" class="pedido-usuario"><label class="description" for="element_3">Fecha de
						Pedido </label>
					<div>
					<?php echo form_dropdown('ped_fecha',$ped_fecha,'','class="element select medium"');?>
					</div>
				</li>

				<li class="buttons"><input type="hidden" name="form_id"
					value="259891" /> <input id="saveForm" class="button_text"
					type="submit" name="submit" value="Submit" />
				</li>
			</ul>
			<?php echo form_close();?>
		</div>
	</div>

</div>
<!-- End demo -->
<?php }?>