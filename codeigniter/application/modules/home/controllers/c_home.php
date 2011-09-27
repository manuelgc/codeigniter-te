<?php
class C_home extends MX_Controller {
	private $view_respuesta;
	private $partial_respuesta;
	function __construct() {
		parent::__construct();		
		$this->view_respuesta == NULL;
		$this->partial_respuesta == FALSE;
		//$this->load->module('banner_principal/c_banner_principal');
		$this->load->module('busqueda/c_busqueda');	
			
		$this->session->unset_userdata('ciudad',$this->input->post('ciudad'));
		$this->session->unset_userdata('zona',$this->input->post('zona'));
		$this->session->unset_userdata('categoria',$this->input->post('categoria'));
		$this->session->unset_userdata('orden',$this->input->post('tipo_orden'));
	
	}
		
	function index() {				
		$msg = $this->encrypt->encode('home/c_home');
		$this->session->set_userdata('caller_block',$msg);			
		switch ($this->partial_respuesta) {
			//el breadcrumb no se esta usando aun porque hay que cambiar algunas cosas de sergio
			//se mantiene como estaba antes
			/*case 'breadcrumb':
				if ($this->view_respuesta == NULL) {
					$data['output_header'] = Modules::run('banner_principal/c_banner_principal/index');
				}else {
					$data['output_header'] = $this->view_respuesta;
				}
			break;*/
			case 'block':{
				if ($this->view_respuesta == NULL) {
					log_message('debug','EN EL IF DE VIEW_RESPUESTA');
					$data['output_block'] = Modules::run('autenticacion/c_login/cargarView');
				}else {
					log_message('debug','EN EL ELSE DE VIEW_RESPUESTA');
					log_message('debug',$this->view_respuesta);
					$data['output_block'] = $this->view_respuesta;
				}
			}
			break;
			case FALSE:{								
				$data['output_block'] = Modules::run('autenticacion/c_login/cargarView');
			}
			break;
		}
		$data['output_header'] = Modules::run('banner_principal/c_banner_principal/index');
						
		$data['opcion_combos'] = $this->c_busqueda->index();			
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		$this->template->set_partial('menu','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');					
		$this->template->build('home/home');				
	}
	
	function setViewRespuesta($param) {
		$this->view_respuesta = $param;
	}
	
	function setPartialRespuesta($param) {		
		$this->partial_respuesta = $param;
	}
}
?>
