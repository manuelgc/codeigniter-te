<?php echo form_open('admin/c_tienda_com_admin/filtrarPlato','id="form-filtro-platos"',array('reordenar' => '1'));?>
			<ul class="content-form-plato">
				<li id="li-nombre-plato" class="item-catalogo"><label
					class="description" for="nombre_plato_catalogo">Nombre plato </label>
					<div>
					<input type="text" id="nombre_plato_catalogo" class="element large" maxlength="255" name="nombre_plato" />
					</div>
				</li>									
				<li id="li-buttons" class="item-catalogo">
					<input id="boton-catalogo-reset" class="button_text art-button"
				type="button" name="boton-catalogo-reset" value="Limpiar" />
				</li>			
			</ul>
			<p class="error" id="error-filtro"></p>
			<?php echo form_close();?>
			<div class="content-platos">
			<?php echo $lista_platos;?>
			</div>
			<ul class="link" id="ul-link-plato">
			<?php echo (!empty($link_pag)) ? $link_pag : '';?>
			</ul>
