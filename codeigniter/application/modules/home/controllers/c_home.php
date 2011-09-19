<?php
class C_home extends MX_Controller {
	function __construct() {
		parent::__construct();		
		$this->load->module('banner_principal/c_banner_principal');
		$this->load->module('busqueda/c_busqueda');
	}
	
	function index() {		
		$data['imagenes'] = $this->c_banner_principal->index();		
		$data['opcion_combos'] = $this->c_busqueda->index();		
		cargarTemplateDefault($data);		
		$this->template->build('home');		
	}
}
?>
