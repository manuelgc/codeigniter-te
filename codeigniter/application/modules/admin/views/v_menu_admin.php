<script type="text/javascript">
  $(document).ready(function(){
    $("ul.subnavegador").not('.selected').hide();
    $("a.desplegable").click(function(e){
      var desplegable = $(this).parent().find("ul.subnavegador");
      $('.desplegable').parent().find("ul.subnavegador").not(desplegable).slideUp('slow');
      desplegable.slideToggle('slow');
      e.preventDefault();
    })
 });
</script>
<div class="art-vmenublock">
	<div class="art-vmenublock-body">
		<div class="art-vmenublockheader">
			<div class="l"></div>
			<div class="r"></div>
			<h3 class="t">Menu Principal</h3>
		</div>
		<div class="art-vmenublockcontent">
			<div class="art-vmenublockcontent-tl"></div>
			<div class="art-vmenublockcontent-tr"></div>
			<div class="art-vmenublockcontent-bl"></div>
			<div class="art-vmenublockcontent-br"></div>
			<div class="art-vmenublockcontent-tc"></div>
			<div class="art-vmenublockcontent-bc"></div>
			<div class="art-vmenublockcontent-cl"></div>
			<div class="art-vmenublockcontent-cr"></div>
			<div class="art-vmenublockcontent-cc"></div>
			<div class="art-vmenublockcontent-body">
				<ul class="navegador art-vmenu">
				<?php if ($admin_menu == 1): ?>
					<li><a href="#" class="desplegable" title="Restaurante">Opciones
							Nombre Restaurante</a>
						<ul class="subnavegador">
							<li><a href="#" title="Pedidos">Pedidos</a>
							</li>
							<li><a href="#" title="Platos">Platos</a>
							</li>
							<li><a href="#" title="Extras">Extras</a>
							</li>
							<li><a href="#" title="Opcionales">Opcionales</a>
							</li>
							<li><a href="#" title="Horarios Despacho">Horarios Despacho</a>
							</li>
							<li><a href="#" title="Direcciones de entrega">Direcciones de
									entrega</a>
							</li>
						</ul></li>
						<?php elseif ($admin_menu == 2): ?>
					<li><a class="desplegable" href="#" title="Maestros">Gestionar
							Maestros</a>
						<ul class="subnavegador">
							<li><?php echo anchor('admin/c_tienda_com_admin','Tienda de comida');?>
							</li>
							<li><a href="#" title="Platos">Platos</a>
							</li>
							<li><a href="#" title="Extras">Extras</a>
							</li>
							<li><a href="#" title="Opcionales">Opcionales</a>
							</li>
							<li><a href="#" title="Horarios de despacho">Horarios de despacho</a>
							</li>
							<li><a href="#" title="Direcciones de entrega">Direcciones de
									entrega</a>
							</li>
							<li><a href="#" title="Usuarios de tiendas">Usuarios de tiendas</a>
							</li>
						</ul></li>
					<li><a class="desplegable" href="#" title="Consultas">Consultas</a>
						<ul class="subnavegador">
							<li><a href="#" title="Pedidos">Pedidos</a>
							</li>
							<li><a href="#" title="Usuarios">Usuarios</a>
							</li>
						</ul></li>
						<?php endif;?>
				</ul>
				<div class="cleared"></div>
			</div>
		</div>
	</div>
</div>
