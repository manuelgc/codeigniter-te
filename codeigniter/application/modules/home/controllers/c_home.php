<?php
class C_home extends MX_Controller {
	private $view_respuesta;
	private $partial_respuesta;
	function __construct() {
		parent::__construct();		
		$this->load->library('encrypt');	
		$this->view_respuesta == NULL;
		$this->partial_respuesta == FALSE;
		//$this->load->module('banner_principal/c_banner_principal');
		$this->load->helper('cookie');
		$this->load->module('busqueda/c_busqueda');		
		//Eliminar cookie creadas al hacer busquedas
		delete_cookie('ciudad');
		delete_cookie('zona');
		delete_cookie('categoria');
		delete_cookie('tipo_orden');				
	}
		
	function index($param_mensaje = '') {								
		$msg = $this->encrypt->encode('home/c_home');
		$this->input->set_cookie('caller_block',$msg,0);
		//$this->session->set_userdata('caller_block',$msg);			
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
					$data['output_block'] = Modules::run('autenticacion/c_login/getHtmlSesion');
				}else {										
					$data['output_block'] = $this->view_respuesta;
				}
			}
			break;
			case FALSE:{								
				$data['output_block'] = Modules::run('autenticacion/c_login/getHtmlSesion');
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
		//$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		//$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		//$this->template->set_partial('menu','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

		$data['mensaje'] = $this->setMensaje($param_mensaje);
		
		$this->template->build('home/home',$data);				
	}
	
	function setViewRespuesta($param) {
		$this->view_respuesta = $param;
	}
	
	function setPartialRespuesta($param) {		
		$this->partial_respuesta = $param;
	}
	
	function setMensaje($mensaje = '') {
		if (empty($mensaje)) {
			return ;
		}elseif ($mensaje == $this->encrypt->sha1('cerrada')){
			return 'Haz salido de tu cuenta';
		}elseif ($mensaje == $this->encrypt->sha1('nosesion')){
			return 'Debes iniciar sesion para poder consultar tu informacion';
		}elseif ($mensaje == $this->encrypt->sha1('nuevopassok')){
			return 'Hemos guardado tu nueva contrasena';
		}elseif ($mensaje == $this->encrypt->sha1('nuevopasserror')){
			return 'Disculpa pero hemos tenido un problema para guardar contrasena, por favor intenta de nuevo mas tarde';
		}
	}
}
?>
