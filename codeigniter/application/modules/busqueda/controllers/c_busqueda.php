<?php
class c_busqueda extends MX_Controller{
	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('language');

	}
	function index() {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));
		$arrCombo= array('ciudad'  => $this->cargarCiudad(),
                  		'categoria'    => $this->cargarTipoComida(),
                  		'orden'   => $this->cargarTipoOrden());
		return $arrCombo;
	}

	function cargarCiudad(){
		$ciudad = new Ciudad();
		$ciudad->where('estatus','1');
		$ciudad->where('estados_id','7');
		$ciudad->get_iterated();
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
		$tipoComida->get_iterated();
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
//		$tipoOrden->where('estatus','1');
		$tipoOrden->get_iterated();
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
	
}
?>