<div id="form_container">

	<h1>
		<a>Tienda de Comida</a>
	</h1>	
	<?php echo form_open('admin/c_tienda_com_admin',array('oculto'=>'1'));?>
		<div class="form_description">
			<h2>Tienda de Comida</h2>
			<p>Ingresa la informancion a continuacion para registrar un
				restaurante dentro de TodoExpress</p>
		</div>
		<ul>

			<li id="li_1"><label class="description" for="nombre_tienda">Nombre
					Tienda </label>
				<div>
					<input id="nombre_tienda" name="nombre_tienda" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('nombre_tienda');?>" />
						<?php echo form_error('nombre_tienda','<p>','</p>');?>
				</div>
				<p class="guidelines" id="guide_1">
					<small>Ingresa el nombre de la tienda tal como es conocida por el
						publico en general</small>
				</p></li>
			<li id="li_2"><label class="description" for="descrip_tienda">Descripcion
					de la tienda </label>
				<div>
					<input id="descrip_tienda" name="descrip_tienda" class="element text medium"
						type="text" maxlength="255" value="<?php echo set_value('descrip_tienda');?>" />
						<?php echo form_error('descrip_tienda','<p>','</p>');?>
				</div>
				<p class="guidelines" id="guide_2">
					<small>Ingresa una breve descripcion de lo que hace el restaurante</small>
				</p></li>
			<li id="li_3"><label class="description" for="tlf_1">Telefono 1 </label>
				<span> 
					<input id="tlf_1_1" name="tlf_1_1" 
						class="element text" size="3" maxlength="3" value="<?php echo set_value('tlf_1');?>" type="text"> -
						<label for="tlf_1_1">(###)</label> 
						<?php echo form_error('tlf_1_1','<p>','</p>');?>
				</span> 
				<span> 
					<input id="tlf_1_2" name="tlf_1_2" class="element text" size="3"
						maxlength="3" value="<?php echo set_value('tlf_1_2');?>" type="text"> - <label for="tlf_1_2">###</label>						
				</span> 
				<span> 
					<input id="tlf_1_3" name="tlf_1_3"
					class="element text" size="4" maxlength="4" value="<?php echo set_value('tlf_1_3');?>" type="text"> <label for="tlf_1_3">####</label> 
				</span>
				<p class="guidelines" id="guide_3">
					<small>Ingresa un numero de telefono valido</small>
				</p></li>
			<li id="li_4"><label class="description" for="element_4">Telefono 2 </label>
				<span> <input id="element_4_1" name="element_4_1"
					class="element text" size="3" maxlength="3" value="" type="text"> -
					<label for="element_4_1">(###)</label> </span> <span> <input
					id="element_4_2" name="element_4_2" class="element text" size="3"
					maxlength="3" value="" type="text"> - <label for="element_4_2">###</label>
			</span> <span> <input id="element_4_3" name="element_4_3"
					class="element text" size="4" maxlength="4" value="" type="text"> <label
					for="element_4_3">####</label> </span>
				<p class="guidelines" id="guide_4">
					<small>Ingresa un numero de telefono valido, puedes ingresar numero
						local o celular</small>
				</p></li>
			<li id="li_5"><label class="description" for="element_5">Razon Social
			</label>
				<div>
					<input id="element_5" name="element_5" class="element text medium"
						type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_5">
					<small>Ingresa el nombre juridico del restaurante</small>
				</p></li>
			<li id="li_6"><label class="description" for="element_6">Cedula/RIF </label>
				<div>
					<input id="element_6" name="element_6" class="element text medium"
						type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_6">
					<small>Ingresa el RIF de la empresa o el numero de cedula del
						representante legal</small>
				</p></li>
			<li id="li_7"><label class="description" for="element_7">Minimo orden
					(cantidad) </label>
				<div>
					<input id="element_7" name="element_7" class="element text medium"
						type="text" maxlength="255" value="" />
				</div>
				<p class="guidelines" id="guide_7">
					<small>Ingresa la cantidad minima de platos que el restaurante
						podra despachar a traves de todoexpress.com</small>
				</p></li>
			<li id="li_8"><label class="description" for="element_8">Minimo orden
					(precio) </label> <span class="symbol">$</span> <span> <input
					id="element_8_1" name="element_8_1" class="element text currency"
					size="10" value="" type="text" /> . <label for="element_8_1">Dollars</label>
			</span> <span> <input id="element_8_2" name="element_8_2"
					class="element text" size="2" maxlength="2" value="" type="text" />
					<label for="element_8_2">Cents</label> </span>
				<p class="guidelines" id="guide_8">
					<small>Ingresa el minino en bolivares que el restaurante podra
						despachar a traves de todoexpress.com.ve</small>
				</p></li>
			<li id="li_11"><label class="description" for="element_11">Posee
					estacionamiento </label> <span> <input id="element_11_1"
					name="element_11_1" class="element checkbox" type="checkbox"
					value="1" /> <label class="choice" for="element_11_1">Si</label> </span>
			<p class="guidelines" id="guide_11">
					<small>Selecciona si el restaurante posee estacionamiento</small>
				</p></li>
			<li id="li_12"><label class="description" for="element_12">Estado </label>
				<div>
					<select class="element select medium" id="element_12"
						name="element_12">
						<option value="" selected="selected"></option>
						<option value="1">Seleccione</option>

					</select>
				</div></li>
			<li id="li_13"><label class="description" for="element_13">Ciudad </label>
				<div>
					<select class="element select medium" id="element_13"
						name="element_13">
						<option value="" selected="selected"></option>
						<option value="1">Seleccione</option>

					</select>
				</div></li>
			<li id="li_14"><label class="description" for="element_14">Zona </label>
				<div>
					<select class="element select medium" id="element_14"
						name="element_14">
						<option value="" selected="selected"></option>
						<option value="1">Seleccione</option>

					</select>
				</div></li>
			<li id="li_9"><label class="description" for="element_9">Minimo
					tiempo entrega </label> <span> <input id="element_9_1"
					name="element_9_1" class="element text " size="2" type="text"
					maxlength="2" value="" /> : <label>HH</label> </span> <span> <input
					id="element_9_2" name="element_9_2" class="element text " size="2"
					type="text" maxlength="2" value="" /> : <label>MM</label> </span> <span>
					<input id="element_9_3" name="element_9_3" class="element text "
					size="2" type="text" maxlength="2" value="" /> <label>SS</label> </span>
				<span> <select class="element select" style="width: 4em"
					id="element_9_4" name="element_9_4">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
				</select> <label>AM/PM</label> </span>
			<p class="guidelines" id="guide_9">
					<small>Ingrese el tiempo minimo para la entrega de un producto</small>
				</p></li>
			<li id="li_10"><label class="description" for="element_10">Minimo
					tiempo espera </label> <span> <input id="element_10_1"
					name="element_10_1" class="element text " size="2" type="text"
					maxlength="2" value="" /> : <label>HH</label> </span> <span> <input
					id="element_10_2" name="element_10_2" class="element text "
					size="2" type="text" maxlength="2" value="" /> : <label>MM</label>
			</span> <span> <input id="element_10_3" name="element_10_3"
					class="element text " size="2" type="text" maxlength="2" value="" />
					<label>SS</label> </span> <span> <select class="element select"
					style="width: 4em" id="element_10_4" name="element_10_4">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
				</select> <label>AM/PM</label> </span>
			<p class="guidelines" id="guide_10">
					<small>Tiempo minimo de espera para entregar un pedido tipo "Yo lo
						Busco"</small>
				</p></li>

			<li class="buttons"><input type="hidden" name="form_id"
				value="278867" /> <input id="saveForm" class="button_text"
				type="submit" name="submit" value="Submit" /></li>
		</ul>
	<?php echo form_close();?>
</div>
