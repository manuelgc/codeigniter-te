<?php
class C_datos_tienda extends MX_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper('date');
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->helper('language');
		$this->load->helper('cookie');
		$this->load->library('qtip2');
		$this->load->module('busqueda/c_busqueda');
	}

	function index(){
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery.spinbox.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.spinbox.js'));		
		
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');
		$data['output_block'] = $this->load->view('carrito/v_carrito','',true);	
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

		if($this->input->post('id_tienda')){
			$data=$this->getDatosTienda($this->input->post('id_tienda'));
			$data+=$this->getCiudadZona();
			
			$this->template->build('v_datos_tienda',$data);
		}
		
	}

	function getDatosTienda($id) {
		$tienda = new Tiendascomida();
		$tienda->where('estatus',1);
		$tienda->get_by_id($id);
		$arrTienda= array();
		if($tienda->exists()){
			$arrTienda['id'] = $tienda->id;
			$arrTienda['nombre'] = $tienda->nombre;
			$arrTienda['telefono'] = $tienda->telefono1.(($tienda->telefono2!=null)?'/'.$tienda->telefono2:'');
			$arrTienda['min_cant'] = ($tienda->minimoordencant!=null)?$tienda->minimoordencant:'Sin limite';
			$arrTienda['min_cost'] = ($tienda->minimoordenprecio!=null)?$tienda->minimoordenprecio:'Sin limite';
			$arrTienda['descripcion'] = $tienda->descripcion;
			$arrTienda['direccion'] = $tienda->direccion.'. '.$tienda->getCiudad()->nombreCiudad.', Estado '.$tienda->getEstado()->nombreEstado;
			$arrTienda['imagen'] = base_url().$tienda->imagen->where('estatus',1)->get()->rutaImagen;
			$arrTienda['tipo_comida'] = $this->getTiposComidaTienda($tienda);
			$arrTienda['tipo_venta']=$this->getTiposVentaTienda($tienda);
			$arrTienda['horario']=$this->getHorarioTienda($tienda);
			$arrTienda['imagen_horario']=$this->getImagenHorario($tienda);
			$arrTienda['menu']=$this->getPlatosPorCategoria($tienda);

			return $arrTienda;
		}else{
			return false;
		}
	}
	
	
	function getPlatosPorCategoria($tienda){
		$categoria=$tienda->getCategoriaPlato();
		$plato=$tienda->getPlatosArreglo();
		if($categoria!=false && $plato!=false){
				
			foreach ($categoria as $cat) {
				$arrPlato= array();
				$iterador= current($plato);
				while (($iterador!=false) && ($iterador['categoriaplatos_id']==$cat->id)) {
					$arrPlato[$iterador['id']]['nombre']=$iterador['nombre'];
					$arrPlato[$iterador['id']]['precio']=$iterador['precio'];
					$arrPlato[$iterador['id']]['descripcion']=$iterador['descripcion'];
					$arrPlato[$iterador['id']]['tamano']=$iterador['tamano'];
					$arrPlato[$iterador['id']]['descuento']=$iterador['descuento'];
					$arrPlato[$iterador['id']]['estatus']=$iterador['estatus'];
					$arrPlato[$iterador['id']]['categoriaplatos_id']=$iterador['categoriaplatos_id'];
					$arrPlato[$iterador['id']]['tiendacomida_id']=$iterador['tiendacomida_id'];
					next($plato);
					$iterador= current($plato);

				}
				$respuesta[$cat->nombre]=$arrPlato;
			}
		}else {
			$respuesta='No hay platos registrados para esta tienda';
		}
		return $respuesta;

	}
	
	function getCiudadZona() {
		
		if ($this->input->cookie('ciudad')!=false){
			$ciudad= new Ciudad();
			$ciudad->where('estatus',1)->get_by_id($this->input->cookie('ciudad'));
			$arreglo['nombreCiudad']=$ciudad->nombreCiudad;
		}else{
			$arreglo['nombreCiudad']='No Seleccionada';
		}
		
		if ($this->input->cookie('zona')!=false){
			$zona= new Zona();
			$zona->where('estatus',1)->get_by_id($this->input->cookie('zona'));
			$arreglo['nombreZona']=$zona->nombreZona;
		}else{
			$arreglo['nombreZona']='No Seleccionada';
		}
		return $arreglo;
	}
	
	function validarAbierto(){
		$tienda = new Tiendascomida();
		$hoy = mdate('%w',now());
		$hora= strtotime(mdate('%H:%i:%s',now()));
		$horario=$tienda->getHorarioDiabyId($hoy,$this->input->post('id_tienda'));
		if($horario!=false){
			if($horario->tipohorario==0){
				if( ( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) )  ){
					$respuesta=true;
				}else{
					$respuesta=false;
				}
			}elseif($horario->tipohorario==1){
				if( (( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) ))
				|| (( $hora >= strtotime($horario->horainicio2) )&&($hora <=strtotime($horario->horacierre2) ))){
					$respuesta=true;
				}else{
					$respuesta=false;
				}
			}else{
				$respuesta=false;
			}
		}else{
			$respuesta=false;
		}
		
		return  $respuesta;
	}
	
	function validarDatos(){
			
		$data['abierto']=$this->validarAbierto();
		if($data['abierto']==false){
			
			$data['html']='<p>El Restaurante esta cerrado, En este momento no puede realizar pedidos</p>';
		
		}
		
		if (!$this->input->cookie('zona') || !$this->input->cookie('ciudad') ){
			$data['zona']=false;
			
			$data['html_zona']='<form>';
			$data['html_zona'].='<p>Aun no ha seleccionado la zona donde se encuentra</p>';
			$data['html_zona'].='<p class="error" id="mensaje_error"></p>';
			$data['html_zona'].=lang('busqueda_ciudad','cmb_ciudad','description');
			$data['html_zona'].=$this->cargarCiudad($this->input->post('id_tienda'));
			$data['html_zona'].=lang('busqueda_zona','cmb_zona','description');
			$data['html_zona'].=$this->cargarZona((($this->input->cookie('ciudad')!=false)?$this->input->cookie('ciudad'):''),$this->input->post('id_tienda'));
			$data['html_zona'].='</form>';	
		}else{
			$data['zona']=true;
		}
		
		
		echo json_encode($data);
	}

	function cargarPopupActualizarAjax() {

		$data['html_zona']='<form>';
		$data['html_zona'].='<p class="error" id="mensaje_error"></p>';
		$data['html_zona'].=lang('busqueda_ciudad','cmb_ciudad','description');
		$data['html_zona'].=$this->cargarCiudad($this->input->post('id_tienda'));
		$data['html_zona'].=lang('busqueda_zona','cmb_zona','description');
		$data['html_zona'].=$this->cargarZona((($this->input->cookie('ciudad')!=false)?$this->input->cookie('ciudad'):''),$this->input->post('id_tienda'));
		$data['html_zona'].='</form>';

		echo json_encode($data);
	}
	
	function cargarPopupPlatoAjax(){
		$plato = new Plato();
		$plato->where('estatus',1)->get_by_id($this->input->post('id_plato'));
		
		if($plato->exists()){
			$data['plato']=true;
			$data['html']='<form>';
			$img=$plato->getImagen();
			if($img!=false){
				$data['html'].='<div align="center" class="imagene_plato">	<img height="auto" width="350px" src="'.base_url().$img->rutaImagen.'"></div>';
			}else {
				$data['html'].='<div class="imagene_plato">	<img src=""></div>';
			}
			$data['html'].='<div><p class="error" id="mensaje_plato"></p></div>';
			$data['html'].='<div><p>Precio: '.$plato->precio.' Bs.</p></div>';
			$data['html'].='<div><p>'.$plato->descripcion.'</p></div>';
			$data['html'].='<div>'.form_label('Cantidad', 'cantidad');
			$attr = array(
              'name'        => 'cantidad',
              'id'          => 'cantidad',
              'size'        => '3',

			);
			$data['html'].=form_input($attr,1).'</div>';
			$data['html'].='<div>'.form_label('Instrucciones Extra', 'instrucciones');
			$attr2 = array(
              'name'        => 'instrucciones',
              'id'          => 'instrucciones',
              'rows'   		=> '2',
              'cols'        => '40',
              
            );
			$data['html'].=form_textarea($attr2).'</div>';
			$data['html'].='</form>';
			$data['nombrePlato']=$plato->nombre;
		}else{
			$data['plato']=false;
			$data['html']='<p>error</p>';
			$data['nombrePlato']=$plato->nombre;
			
		}
		echo json_encode($data);
	}
	
	function cargarCiudad($id_tienda){
		$tienda = new Tiendascomida();
		$ciudad= $tienda->getCiudadesEntregaById($id_tienda);
		$options= array();
		if ($ciudad!=false) {
			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
			}
			return form_dropdown('ciudad',$options,(($this->input->cookie('ciudad')!=false)?$this->input->cookie('ciudad'):''),'id=cmbx_ciudad class="element text medium"');
		}else{
			return array();		
		}

	}

	function cargarZona($id_ciudad,$id_tienda){
		$tienda = new Tiendascomida();
		$zona= $tienda->getZonasEntregaById($id_ciudad,$id_tienda);
		$options=array();
		if ($zona!=false) {
			foreach ($zona as $zon) {
				$options[$zon->id] = $zon->nombreZona;
			}
			$disable='';
		}else{
			$options=array();
			$disable='disabled="disabled"';
		}
		
		return form_dropdown('zona',$options,(($this->input->cookie('zona')!=false)?$this->input->cookie('zona'):''),'id=cmbx_zona class="element text medium" '.$disable);		
	}

	function cargarZonaAjax(){
		$tienda = new Tiendascomida();
		$zona= $tienda->getZonasEntregaById($this->input->post('id_ciudad'),$this->input->post('id_tienda'));
		$data['html_zona']='<option value="" selected="selected">Seleccione</option>;';
		if ($zona!=false) {
			foreach ($zona as $zon) {		
				$data['html_zona'] .= '<option value="'.$zon->id.'">'.$zon->nombreZona.'</option>';
			}
			$data['disable']=false;
			$data['zona']=true;
		}else{		
			$data['disable']=true;
			$data['zona']=false;
		}

		
		echo json_encode($data);
				
		}

	
	function getDataPartial($partial = '') {
		$output = '';
		switch ($partial) {
			case 'breadcrumb':
				$output = $this->c_busqueda->index();
				break;
			case 'header':
				$output = Modules::run('banner_principal/c_banner_principal/index');
				break;
			case 'block':
				$output = Modules::run('autenticacion/c_login/cargarView');
		}

		return $output;
	}
	
	function getTiposVentaTienda($tienda){
		$tipoVenta= $tienda->getTiposVenta();
		if($tipoVenta!=false){
			$i=1;
			foreach ($tipoVenta as $ven){
				if($i==1){
					$respuesta=$ven->nombre;
					$i++;
				}else{
					$respuesta .=','.$ven->nombre;
				}

			}
			return $respuesta;
		}else{
			return null;
		}

	}

	function getTiposComidaTienda($tienda) {
		$tipoComida=$tienda->getTiposComida();
		if($tipoComida!=false){
			$i=1;
			foreach ($tipoComida as $tip){
				if($i==1){
					$respuesta=$tip->nombre;
					$i++;
				}else{
					$respuesta.=', '.$tip->nombre;
				}
			}
			return $respuesta;
		}else {
			return null;
		}
	}
		
	function getImagenHorario($tienda){
		$hoy = mdate('%w',now());
		$hora= strtotime(mdate('%H:%i:%s',now()));
		$horario=$tienda->getHorarioDia($hoy);
		 
		if($horario!=false){
			if($horario->tipohorario==0){
				if( ( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) )  ){
					$respuesta=base_url().'imagenes/abierto.png';
				}else{
					$respuesta=base_url().'imagenes/cerrado.png';
				}
			}elseif($horario->tipohorario==1){
				if( (( $hora >= strtotime($horario->horainicio1) )&&($hora <=strtotime($horario->horacierre1) ))
				|| (( $hora >= strtotime($horario->horainicio2) )&&($hora <=strtotime($horario->horacierre2) ))){
					$respuesta=base_url().'imagenes/abierto.png';
				}else{
					$respuesta=base_url().'imagenes/cerrado.png';
				}
			}else{
				$respuesta=base_url().'imagenes/cerrado.png';
			}
		}else{
			$respuesta='';
		}
		return $respuesta;
	}
	
	function getHorarioTienda($tienda){
		$horario=$tienda->getHorarioCompleto();
		
		if($horario!=false){
			foreach ($horario as $h) {

				switch ($h->dia) {
					case 0:
						if($h->tipohorario==0){
							$respuesta['DOMINGO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1){
							$respuesta['DOMINGO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else{
							$respuesta['DOMINGO']='CERRADO';
						}
						break;
					case 1:
						if($h->tipohorario==0){
							$respuesta['LUNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['LUNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['LUNES']='CERRADO';
						}
						break;
					case 2:
						if($h->tipohorario==0){
							$respuesta['MARTES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['MARTES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['MARTES']='CERRADO';
						}
						break;
					case 3:
						if($h->tipohorario==0){
							$respuesta['MIERCOLES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1){
							$respuesta['MIERCOLES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['MIERCOLES']='CERRADO';
						}
						break;
					case 4:
						if($h->tipohorario==0){
							$respuesta['JUEVES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['JUEVES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['JUEVES']='CERRADO';
						}
						break;
					case 5:
						if($h->tipohorario==0){
							$respuesta['VIERNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif($h->tipohorario==1) {
							$respuesta['VIERNES']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['VIERNES']='CERRADO';
						}
						break;
					case 6:
						if($h->tipohorario==0){
							$respuesta['SABADO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1));
						}elseif ($h->tipohorario==1) {
							$respuesta['SABADO']=mdate('%h:%i%a',strtotime($h->horainicio1)).'-'.mdate('%h:%i%a',strtotime($h->horacierre1))
							.'|'.mdate('%h:%i%a',strtotime($h->horainicio2)).'-'.mdate('%h:%i%a',strtotime($h->horacierre2));
						}else {
							$respuesta['SABADO']='CERRADO';
						}
						break;
							
				}
					
			}
		}else{
			$respuesta='No hay horarios registrados para esta tienda';
		}
		return $respuesta;
	}

}

?>