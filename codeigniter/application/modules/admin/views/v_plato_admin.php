<?php if (isset($mensaje)):?>
<div class="message">
<?php echo $mensaje;?>
</div>
<?php endif;?>

<h1>
	<a>Platos de tienda de comida</a>
</h1>
<?php echo form_open_multipart('admin/c_plato_admin/','id="form_plato_tienda_comida"',array('oculto'=>'1','id_plato'=>''));?>
<div id="form_container">
	<div class="step" id="paso1">
		<div class="form_description">
			<h2>Platos</h2>
			<div>
				<input id="boton-catalogo" class="button_text art-button"
					type="button" name="boton-catalogo" value="Buscar" />
			</div>
			<div id="content-thumb"></div>
			<p>Ingresa la informancion a continuacion para registrar un plato de
				una tienda de comida en particular</p>
		</div>
		<ul>

			<li id="li_1"><label class="description" for="nombre_tienda">Nombre
					Tienda </label> <span id="nombre_tienda"></span><span
				id="razon_social"></span><span id="ci_rif"></span>
				<input type="hidden" value="" id="id_tienda" name="id_tienda" />
			</li>
			<li id="li_2"><label class="description" for="nombre_plato">Nombre
					del plato </label>
				<div>
					<input id="nombre_plato" name="nombre_plato"
						class="element text medium" type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_2">
					<small>Ingresa el nombre del plato</small>
				</p></li>


			<li id="li_3"><label class="description" for="precio">Precio </label>
				<div>
					<input id="precio" name="precio" class="element text medium"
						type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_5">
					<small>Ingresa el precio del plato</small>
				</p></li>
			<li id="li_4"><label class="description" for="descripcion">Descripcion
					del plato</label>
				<div>
					<textarea id="descripcion" name="descripcion"
						class="element text medium" rows="10" cols="30">						
						 </textarea>
				</div>
				<p class="guidelines" id="guide_6">
					<small>Ingresa una descripcion para el plato.</small>
				</p></li>
			<li id="li_5"><label class="description" for="descuento">Descuento
					(%) </label>
				<div>
					<input id="descuento" name="descuento" class="element text medium"
						type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_7">
					<small>Porcentaje de descuento aplicado al plato.</small>
				</p></li>


			<li id="li_6"><label class="description" for="categoria_plato">Categoria
			</label>
				<div>
				<?php
				echo form_dropdown('categoria_plato',$cat_plato,set_select('categoria_plato'),'class="element select medium" id="categoria_plato"');
				?>
				</div></li>


			<li id="li_7"><label class="description" for="tipo_plato">Tipo Plato
			</label>
				<div>
				<?php
				echo form_dropdown('tipo_plato',array('1'=>'Principal','2'=>'Secundario'),'0','class="element select medium" id="categoria_plato"');
				?>
				</div>
				<p class="guidelines" id="guide_1">
					<small>Seleccione si es plato principal o secundario.</small>
				</p>
			</li>

			<li id="li_8"><label class="description" for="impuesto">Impuesto</label>
				<div>
				<?php
				echo form_dropdown('impuesto',$imp,set_select('impuesto'),'class="element select medium" id="impuesto"');
				?>
				</div></li>

			<li id="li_9"><label class="description" for="img_tienda">Imagen:</label>
				<span> <input id="img_tienda" name="img_tienda"
					class="element text " size="20" type="file" /> </span>
				<p class="guidelines" id="guide_11">
					<small>Ingresa una imagen en formato JPG/PNG</small>
				</p></li>
		</ul>
	</div>
	<div class="step" id="paso2">
		<div class="form_description">
			<h2>Opciones de plato</h2>
			<p>Ingresa la informancion a continuacion para registrar las opciones
				del plato y los detalles.</p>
		</div>
		<div id="content_opciones">
			<fieldset id="content_1">
				<legend> Opcion 1 </legend>
				<ul>
					<li> <input type="hidden" name="oculto_opciones[]" id="oculto_opciones" value=""/></li>
					<li><label class="description" for="o_1_nombre">Nombre opcion</label>
						<div>
							<input id="o_1_nombre" name="o_1_nombre"
								class="element text medium" type="text" maxlength="255" value="" />
						</div>
						<p class="guidelines" id="guide_10">
							<small>Ingresa el nombre de la opcion</small>
						</p></li>


					<li><label class="description" for="o_1_requirido">Requerido </label>
						<div>
						<?php
						echo form_dropdown('o_1_requerido',array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="o_1_requirido"');
						?>
						</div>
						<p class="guidelines" id="guide_11">
							<small>Seleccione si es plato principal o secundario.</small>
						</p>
					</li>
					<li><label class="description" for="o_1_minimo">Descripcion
							del plato</label>
						<div>
							<input id="o_1_minimo" name="o_1_minimo"
								class="element text medium" type="text" maxlength="3" value="" />
						</div>
						<p class="guidelines" id="guide_12">
							<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si
								es requerido y 0 si no).</small>
						</p></li>
					<li><label class="description" for="o_maximo_1">Maximo opcion</label>
						<div>
							<input id="o_1_maximo" name="o_1_maximo"
								class="element text medium" type="text" maxlength="3" value="" />
						</div>
						<p class="guidelines" id="guide_13">
							<small>Ingresa la cantidad maxima de opcion (0 sin limite).</small>
						</p></li>
				</ul>
				<input id="o_d_1" type="button" class="art-button"
					value="Nueva Opcion Detalle" style="float: right;" />
			</fieldset>
		</div>
		<input id="o_g_1" type="button" class="art-button"
			value="Nueva Opcion" style="float: right;" />
	</div>
	<div class="step" id="paso3">

		<div id="content_extras">

			<fieldset id="content_extra_1">
				<legend> Extra 1 </legend>
				<ul>
					<li><label class="description" for="e_1_nombre">Nombre extra</label>
						<div>
							<input id="e_1_nombre" name="e_1_nombre"
								class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default"
								type="text" maxlength="255" value="" />
						</div>
						<p class="guidelines">
							<small>Ingresa el nombre del extra del plato</small>
						</p>
					</li>


					<li><label class="description" for="e_1_requirido">Requerido </label>
						<div>
						<?php
						echo form_dropdown('e_1_requerido',array('0'=>'Opcional','1'=>'Obligatorio'),'','class="element select medium" id="e_1_requirido"');
						?>
						</div>
						<p class="guidelines">
							<small>Seleccione si es plato principal o secundario.</small>
						</p>
					</li>
					<li><label class="description" for="e_1_minimo">Minimo extra</label>
						<div>
							<input id="e_1_minimo" name="e_1_minimo"
								class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default"
								type="text" maxlength="3" value="" />
						</div>
						<p class="guidelines">
							<small>Ingresa la cantidad minima de opcion (mayor o igual a 1 si
								es requerido y 0 si no).</small>
						</p>
					</li>
					<li><label class="description" for="e_1_maximo">Maximo extra</label>
						<div>
							<input id="e_1_maximo" name="e_1_maximo"
								class="element text medium element text medium ui-wizard-content ui-helper-reset ui-state-default"
								type="text" maxlength="3" value="" />
						</div>
						<p class="guidelines">
							<small>Ingresa la cantidad maxima de opcion (0 sin limite).</small>
						</p>
					</li>
				</ul>
				<input id="e_d_1" type="button" class="art-button"
					value="Nueva Extra Detalle" />
			</fieldset>
		</div>
		<input id="e_g_1" type="button" class="art-button" value="Nuevo Extra"
			style="float: right;" />
	</div>
	<div id="demoNavigation">
		<input class="navigation_button" id="back" value="Atras" type="reset" />
		<input class="navigation_button" id="next" value="Siguiente"
			type="submit" />
	</div>
</div>
						<?php echo form_close();?>
<div id="popup">
<?php echo $catalogo_default;?>
</div>
