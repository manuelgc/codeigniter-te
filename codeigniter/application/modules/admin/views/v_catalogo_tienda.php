<?php echo form_open('admin/c_tienda_com_admin/filtrarTienda','id="form-filtro-tiendas"',array('reordenar' => '1'));?>
			<ul class="content-form-tienda">
				<li id="li-nombre-tienda" class="item-catalogo"><label
					class="description" for="nombre_tienda_catalogo">Nombre Tienda </label>
					<div>
					<input type="text" id="nombre_tienda_catalogo" class="element large" maxlength="255" name="nombre_tienda" />
					</div>
				</li>				
				<li id="li-ciudad" class="item-catalogo"><label
					class="description" for="ciudad_tienda">Ciudad</label>
					<div>
					<?php echo form_dropdown('ciudad_tienda',
					$ciudades,
					($this->input->post('ciudad_tienda')) ? $this->input->post('ciudad_tienda') : '',
											'class="element select medium" id="ciudad_popup"');?>
					</div>
				</li>
				<li id="li-zona" class="item-catalogo"><label
					class="description" for="zona_tienda">Zona </label>
					<div>
					<?php echo form_dropdown('zona_tienda',array(),null,'class="element select medium" id="zona_popup"');?>
					</div>
				</li>	
				<li id="li-buttons" class="item-catalogo">
					<input id="boton-catalogo-reset" class="button_text art-button"
				type="button" name="boton-catalogo-reset" value="Limpiar" />
				</li>			
			</ul>
			<p class="error" id="error-filtro"></p>
			<?php echo form_close();?>
			<div class="content-tiendas">
			<?php echo $lista_ped;?>
			</div>
			<ul class="link" id="ul-link-tienda">
			<?php echo (!empty($link_pag)) ? $link_pag : '';?>
			</ul>
