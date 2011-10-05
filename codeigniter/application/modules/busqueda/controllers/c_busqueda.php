<?php
class c_busqueda extends MX_Controller{
	private $config;
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->library('qtip2');
		$this->load->helper('url');
		$this->load->library('pagination');		
		$this->load->helper('cookie');	
		$this->form_validation->CI =& $this;
		$this->config['base_url'] = site_url().'/busqueda/c_busqueda/index/';
		$this->config['per_page'] = 2;
		$this->config['num_links'] = 5;
		$this->config['uri_segment'] = 4;
		$this->config['first_link'] = '<<';
		$this->config['last_link'] = '>>';
		$this->config['next_tag_open'] = '<li>';
		$this->config['next_tag_close'] = '</li>';
		$this->config['prev_tag_open'] = '<li>';
		$this->config['prev_tag_close'] = '</li>';
		$this->config['num_tag_open'] = '<li>';
		$this->config['num_tag_close'] = '</li>';
		$this->config['cur_tag_open'] = '<li>';
		$this->config['cur_tag_close'] = '</li>';
		$this->config['first_tag_open'] = '<li>';
		$this->config['first_tag_close'] = '</li>';
		$this->config['last_tag_open'] = '<li>';
		$this->config['last_tag_close'] = '</li>';
		
	}
	function index($offset = '') {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery.blockUI.js'));
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip('li','select');
				
		$arrCombo = array('ciudad'  => $this->cargarCiudad(),
                  		'categoria'    => $this->cargarTipoComida(),
                  		'orden'   => $this->cargarTipoOrden(),
						'zona'  => array(),
						'select_ciudad' => null,
						'select_categoria' => null,
						'select_zona' => null,
						'select_orden' => null
						);
		

		if ($this->input->post('campo_busqueda')) {
			
			$cookie_ciudad = array(
					'name' => 'ciudad',
					'value' => $this->input->post('ciudad'),
					'expire' => 0);
			$cookie_zona = array(
					'name' => 'zona',
					'value' => $this->input->post('zona'),
					'expire' => 0);
			$cookie_categoria = array(
					'name' => 'categoria',
					'value' => $this->input->post('categoria'),
					'expire' => 0); 
			$cookie_tipo_orden = array(
					'name' => 'tipo_orden',
					'value' => $this->input->post('tipo_orden'),
					'expire' => 0);
			$this->input->set_cookie($cookie_ciudad);
			$this->input->set_cookie($cookie_zona);
			$this->input->set_cookie($cookie_categoria);
			$this->input->set_cookie($cookie_tipo_orden);
			
			if($this->buscarTiendaSql()!=null){
				
				$data['restaurantes']=$this->buscarTiendaSql();
				
				if($this->input->post('ciudad')!=''){
					$arrCombo['zona']=$this->cargarZona($this->input->post('ciudad'));
				}
				$arrCombo['select_ciudad']= $this->input->post('ciudad');
				$arrCombo['select_zona']  = $this->input->post('zona');
				$arrCombo['select_categoria']= $this->input->post('categoria');
				$arrCombo['select_orden']= $this->input->post('tipo_orden');
			
				$data['opcion_combos']=$arrCombo;
						
				$this->pagination->initialize($this->config);
				$data['paginas_link']= $this->pagination->create_links();
				
				$this->cargarVistaResulados($data);

			}else{
				delete_cookie('ciudad');
				delete_cookie('zona');
				delete_cookie('categoria');
				delete_cookie('tipo_orden');
				
				$data['mensaje_error']='Lo sentimos la busqueda no obtuvo ningun resultado.';

				if($this->input->post('ciudad')!=''){
					$arrCombo['zona']=$this->cargarZona($this->input->post('ciudad'));
				}
				$arrCombo['select_ciudad']= $this->input->post('ciudad');
				$arrCombo['select_zona']  = $this->input->post('zona');
				$arrCombo['select_categoria']= $this->input->post('categoria');
				$arrCombo['select_orden']= $this->input->post('tipo_orden');
				
				$data['opcion_combos']=$arrCombo;
				
				$this->cargarVistaResulados($data);
			}

		}elseif ($this->input->is_ajax_request()){ 	
			$data['restaurantes']=$this->construirHtml($this->
			buscarTiendaPagina($this->input->cookie('ciudad'),$this->input->cookie('zona'),$this->input->cookie('categoria'),$this->input->cookie('tipo_orden'),$offset));				
			$this->pagination->initialize($this->config);
			$data['paginas_link']= $this->pagination->create_links();
			echo json_encode($data);
		}

		return $arrCombo;
	}
	
	function  cargarVistaResulados($data){
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		//$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		//$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		//$this->template->set_partial('block','web/layouts/two_columns/partials/block');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

		$this->template->build('v_resultado_busqueda',$data);
	}
	function  buscarTiendaSql(){

		$sql="SELECT tienda.* FROM tiendascomida AS tienda";
		$where=" WHERE tienda.estatus=1 ";
		$tiendas = new Tiendascomida();
		$tipoComida = new Tipotiendascomida();
		$tipoVenta = new Tiposventa();
		$arrtienda = array();
		$respuesta = array();
		$sw=false;
		$bool_ciudad=false;
		$bool_zona=false;
		$bool_categoria=false;
		$bool_venta=false;
		
		//Busqueda por ciudad
		if($this->input->post('ciudad')!=''){
			$tiendas->clear();		
			$tiendas->where('ciudades_id',$this->input->post('ciudad'));
			$tiendas->where('estatus','1')->get();
			if($tiendas->exists()){
				$sql .=", direccionesentrega AS dir";
				$where .="AND tienda.id = dir.tiendascomida_id AND dir.ciudades_id =".$this->input->post('ciudad')." ";
				$where .="AND dir.estatus=1 ";
				$bool_ciudad=true;
			}else{
				$arrtienda['mesaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			

			//Busqueda por zona
			if($this->input->post('zona')!=''){
				$tiendas->clear();		
				$tiendas->where('zonas_id',$this->input->post('zona'));
				$tiendas->where('estatus','1')->get();
				if($tiendas->exists()){
					$where .="AND dir.zonas_id =".$this->input->post('zona')." ";
					$bool_zona=true;
				}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
				}	
			}
			$sw=true;
			
		}

		//Busqueda por Tipo de Comida
		if($this->input->post('categoria')!=''){
			$tiendas->clear();		
			$tiendas=$tipoComida->getTiendasById($this->input->post('categoria'));
			if($tiendas!=false){
				echo 'paso IF tcomida ';
				$sql .=", tiendascomida_tipotiendascomida AS tipoC";
				$where .="AND tienda.id = tipoC.tiendascomida_id	AND tipoC.tipotiendascomida_id =".$this->input->post('categoria')." ";
				$where .="AND tipoC.estatus=1 ";
				$bool_categoria=true;
			}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			$sw=true;
		}

		//Busqueda por Tipo de Venta
		if($this->input->post('tipo_orden')!=''){
			$tiendas->clear();		
			$tiendas=$tipoVenta->getTiendasById($this->input->post('tipo_orden'));;	
			if($tiendas!=false){
				$sql .=", tiendascomida_tiposventa AS tipoV";
				$where .="AND tienda.id = tipoV.tiendascomida_id AND tipoV.tiposventa_id =".$this->input->post('tipo_orden')." ";
				$where .="AND tipoV.estatus=1 ";
				$bool_venta=true;
			}else{
				$arrtienda['mensaje']='Lo sentimos la busqueda no obtuvo ningun resultado, le sugerimos algunos restaurantes:';
			}
			$sw=true;
				
		}

		if (($bool_ciudad || $bool_zona || $bool_venta || $bool_categoria) && $sw){
			$tiendas->clear();
			$sql.=$where.'GROUP BY tienda.id ORDER BY tienda.nombre';
			$tiendas->query($sql);
			$this->config['total_rows']=$tiendas->result_count();
			$tiendas->clear();
			$sql.=' LIMIT '.$this->config['per_page'];
			$tiendas->query($sql);
			if($tiendas->exists()){
				$img= new Imagen() ;
				
				$horario= new Horariosdespacho();
				
				foreach ($tiendas as $ti) {
					$respuesta['tienda_id']=$ti->id;
					$respuesta['nombre_tienda']=$ti->nombre;
					$respuesta['ruta_imagen']=$this->getImagenTienda($ti);
					$respuesta['tipo_comida']=$this->getTiposComidaTienda($ti);
					
					if($ti->minimoordencant!=null){
						$respuesta['min_cant']=$ti->minimoordencant;
					}
					if($ti->minimoordenprecio!=null){
						$respuesta['min_pre']=$ti->minimoordenprecio.'Bs';
					}

					$respuesta['imagen_horario']=$this->getImagenHorario($ti);
					$respuesta['tipo_venta']=$this->getTiposVentaTienda($ti);
					
					$arrtienda[]=$respuesta;
				}
				

				return $arrtienda;
			}else {
				return null;
			}

		}else{
			return null;
		}
	}
    
	function  buscarTiendaPagina($ciudad,$zona,$categoria,$orden,$offset){

		$sql="SELECT tienda.* FROM tiendascomida AS tienda";
		$where=" WHERE tienda.estatus=1 ";
		$tiendas = new Tiendascomida();
		$tipoComida = new Tipotiendascomida();
		$tipoVenta = new Tiposventa();
		$arrtienda = array();
		$respuesta = array();
		$sw=false;
		$bool_ciudad=false;
		$bool_zona=false;
		$bool_categoria=false;
		$bool_venta=false;
		
		//Busqueda por ciudad
		if($ciudad!=''){
			$tiendas->clear();
			$tiendas->where('ciudades_id',$ciudad);
			$tiendas->where('estatus','1')->get();
			if($tiendas->exists()){
				$sql .=", direccionesentrega AS dir";
				$where .="AND tienda.id = dir.tiendascomida_id AND dir.ciudades_id =".$ciudad." ";
				$where .="AND dir.estatus=1 ";
				$bool_ciudad=true;
			}
				
			//Busqueda por zona
			if($zona!=''){
				$tiendas->clear();
				$tiendas->where('zonas_id',$zona);
				$tiendas->where('estatus','1')->get();
				if($tiendas->exists()){
					$where .="AND dir.zonas_id =".$zona." ";
					$bool_zona=true;
				}
			}
			$sw=true;
				
		}

		//Busqueda por Tipo de Comida
		if($categoria!=''){
			$tiendas->clear();
			$tiendas=$tipoComida->getTiendasById($categoria);
			if($tiendas!=false){
				$sql .=", tiendascomida_tipotiendascomida AS tipoC";
				$where .="AND tienda.id = tipoC.tiendascomida_id	AND tipoC.tipotiendascomida_id =".$categoria." ";
				$where .="AND tipoC.estatus=1 ";
				$bool_categoria=true;
			}
			$sw=true;
		}
		
		//Busqueda por Tipo de Venta
		if($orden!=''){
			$tiendas->clear();
			$tiendas=$tipoVenta->getTiendasById($orden);;
			if($tiendas!=false){
				$sql .=", tiendascomida_tiposventa AS tipoV";
				$where .="AND tienda.id = tipoV.tiendascomida_id AND tipoV.tiposventa_id =".$orden." ";
				$where .="AND tipoV.estatus=1 ";
				$bool_venta=true;
			}
			$sw=true;

		}

		if (($bool_ciudad || $bool_zona || $bool_venta || $bool_categoria) && $sw){
			if($offset==''){$offset=0;}
			$tiendas->clear();
			$sql.=$where.'GROUP BY tienda.id ORDER BY tienda.nombre';
			$tiendas->query($sql);
			$this->config['total_rows']=$tiendas->result_count();
			$tiendas->clear();
			$sql.=' LIMIT '.$offset.' ,'.$this->config['per_page'];
			$tiendas->query($sql);
			if($tiendas->exists()){
			$img= new Imagen() ;
			$horario= new Horariosdespacho();

				foreach ($tiendas as $ti) {
					$respuesta['tienda_id']=$ti->id;
					$respuesta['nombre_tienda']=$ti->nombre;
					$respuesta['ruta_imagen']=$this->getImagenTienda($ti);
					$respuesta['tipo_comida']=$this->getTiposComidaTienda($ti);
					if($ti->minimoordencant!=null){
						$respuesta['min_cant']=$ti->minimoordencant;
					}
					if($ti->minimoordenprecio!=null){
						$respuesta['min_pre']=$ti->minimoordenprecio.'Bs';
					}
					$respuesta['imagen_horario']=$this->getImagenHorario($ti);
					$respuesta['tipo_venta']=$this->getTiposVentaTienda($ti);
					
					$arrtienda[]=$respuesta;
				}


				return $arrtienda;
			}else {
				return null;
			}

		}else{
			return null;
		}
	}
	
	function construirHtml($datos){
		$respuesta='';
		if(isset($datos['mensaje'])){
			$respuesta.='<p>'.$datos['mensaje'].'</p>';
		}
		$respuesta.= form_open('tienda/c_datos_tienda',array('id' => 'frm_result_busqueda'));
		foreach ($datos as $value){
	 		if(is_array($value)){
	 			$respuesta.='<li class="bloque-restaurante" id="'.$value['tienda_id'].'">';
				$respuesta.='<input id="id_tienda" name="id_tienda" type="hidden" value="'.$value['tienda_id'].'" />';
				$respuesta.='<div class="titulo_restaurant" name="" width="100%">';
				$respuesta.='<p><h3><span class="text" > '.$value['nombre_tienda'].'</span></h3></p></div>';
		    	$respuesta.='<div width="80%">';
		    	$respuesta.='<div class="cont_imagen" name="" height="80%">';
				$respuesta.='<img src="'.$value['ruta_imagen'].'" class=""></div>';
				$respuesta.='<div class="cont_boton" name="" height="20%">';
				$respuesta.='<input id="btn_ordenar" , class="button_text art-button" type="submit" name="btn_ordenar" value="Ordenar" /></div></div>';
				$respuesta.='<div class="descrip_restaurant">';
				$respuesta.='<div><img src="'.$value['imagen_horario'].'" class=""></div>';
				$respuesta.='<div><p class="">'.$value['tipo_comida'].'</p></div>';
				$respuesta.='<div><p>Cant. Minima: '.$value['min_cant'].'</p></div>';
				$respuesta.='<div><p>Gasto Minimo: '.$value['min_pre'].'</p></div>';
				$respuesta.='<div><p class="">'.$value['tipo_venta'].'</p></div></div></li>';
	 			
	 		}	
		}
		$respuesta.=form_close();
		return $respuesta;	
	}
	
	function getImagenTienda($tienda) {
		$img=$tienda->getImagen();
		if($img !=false){
			$respuesta=base_url().$img->rutaImagen;
		}else{
			$respuesta='';
		}
		return $respuesta;
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
	
	function cargarCiudad(){
		$ciudad = new Ciudad();
		$ciudad->where('estatus','1');
		$ciudad->where('estados_id','7');
		$ciudad->order_by('nombreCiudad','ASD')->get_iterated();
		$options= array();
		if (!$ciudad->exists()) {
			return FALSE;
		}else{

			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
			}
			return $options;
		}

	}

	function cargarTipoComida(){
		$tipoComida = new Tipotiendascomida();
		$tipoComida->where('estatus','1');
		$tipoComida->order_by('nombre','ASD')->get_iterated();
		$options= array();
		if (!$tipoComida->exists()) {
			return FALSE;
		}else{

			foreach ($tipoComida as $tipo) {
				$options[$tipo->id] = $tipo->nombre;
			}
			return $options;
		}

	}

	function cargarTipoOrden(){
		$tipoOrden= new Tiposventa();
		$tipoOrden->where('estatus','1');
		$tipoOrden->order_by('nombre','ASD')->get_iterated();
		$options= array();
		if (!$tipoOrden->exists()) {
			return FALSE;
		}else{

			foreach ($tipoOrden as $tipo) {
				$options[$tipo->id] = $tipo->nombre;
			}
			return $options;
		}

	}

	function cargarZonaAjax(){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$this->input->post('id_ciudad'));
		$zona->order_by('nombreZona','ASD')->get_iterated();
		$salida='<option value="" >Seleccione</option>;';
		if (!$zona->exists()) {
			$salida='0';
		}else{
			foreach ($zona as $zon) {
				$salida .= '<option value="'.$zon->id.'">'.$zon->nombreZona.'</option>';
			}
			$data['zona']= $salida;
			echo json_encode($data);
				
		}

	}
	
	function cargarZona($id_zona){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$id_zona);
		$zona->order_by('nombreZona','ASD')->get_iterated();
		$option=array();
		if (!$zona->exists()) {
			return array();
		}else{
			foreach ($zona as $zon) {
				$option[$zon->id] = $zon->nombreZona;
			}

		return $option;
				
		}

	}
	
}
?>