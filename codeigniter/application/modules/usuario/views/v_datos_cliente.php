<script>
	$(function() {
		$( "#tabs" ).tabs();

		$("#form-filtro-pedidos").submit(function(){
			if($("#estados_ped").val() == '' && $("#tipo_ped").val() == '' && $("#ped_fecha").val() == ''){
				$('p#error-filtro').empty().append('Debes seleccionar algun valor para filtrar tu busqueda').show('fast');
				return false;
			}else{
				if ($('#estados_ped').val() != '') {
					var estado_ped = $('#estados_ped').val();					
				}
			}
		});
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
			<ul class="content-form-pedido">

				<li id="li-estados_ped" class="item-pedido-usuario"><label class="description"
					for="estados_ped">Estado del Pedido </label>
					<div>
					<?php echo form_dropdown('estados_ped',$estados_pedido,'','class="element select medium" id="estados_ped"');?>
					</div>
				</li>
				<li id="li-tipo_ped" class="item-pedido-usuario"><label class="description"
					for="tipo_ped">Tipo de Pedido </label>
					<div>
					<?php echo form_dropdown('tipo_ped',$tipo_ped,'','class="element select medium" id="tipo_ped"');?>
					</div>
				</li>
				<li id="li-ped_fecha" class="item-pedido-usuario"><label class="description"
					for="ped_fecha">Fecha de Pedido </label>
					<div>
					<?php echo form_dropdown('ped_fecha',$ped_fecha,'','class="element select medium" id="ped_fecha"');?>
					</div>
				</li>

				<li class="item-pedido-usuario">
					<div>
						<input class="button_text art-button" type="submit" name="submit-pedidos"
							value="Buscar" />
					</div>
				</li>
			</ul>
			<p class="error" id="error-filtro"></p>
			<?php echo form_close();?>
			<?php echo $lista_ped;?>
			<?php echo $link_pag;?>
		</div>
	</div>

</div>
<!-- End demo -->
<?php }?>