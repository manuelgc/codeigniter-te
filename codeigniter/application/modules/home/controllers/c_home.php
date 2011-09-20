<?php
class C_home extends MX_Controller {
	function __construct() {
		parent::__construct();		
		$this->load->module('banner_principal/c_banner_principal');
		$this->load->module('busqueda/c_busqueda');
		//$this->load->module('autenticacion/c_login');
	}
	
	function index() {		
		$data['imagenes'] = $this->c_banner_principal->index();
		//$data['imagenes'] = Modules::run('banner_principal/C_banner_principal');		
		$data['opcion_combos'] = $this->c_busqueda->index();			
		cargarTemplateDefault($data);		
		$this->template->build('home');		
	}
}
?>
