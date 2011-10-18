<?php
class C_procesar_respuesta extends MX_Controller {
	function __construct() {
		parent::__construct();		
		$this->load->helper('cookie');
	}
	
	/**
	 * 
	 * redirectRespuesta, permite procesar una solicitud de un modulo y enviar la respuesta
	 * a la vista que contiene el modulo.
	 * @param string $string_respuesta, respuesta enviada desde el modulo
	 * @return void
	 */
	function redirectRespuesta($string_respuesta,$respuesta_partial = '') {			
		$partial_respuesta = '';
		log_message('debug','header: '.$respuesta_header.' block: '.$respuesta_block);
		
		if (!empty($respuesta_partial)) {
			switch ($respuesta_partial) {
				case 'header':{
					$view_caller = $this->session->userdata('caller_header');
					$this->session->unset_userdata('caller_header');
					$partial_respuesta = 'header';
					$modulo = $this->encrypt->decode($view_caller);
				}				
				break;
				case 'breadcrumb':{
					$view_caller = $this->session->userdata('caller_breadcrumb');
					$this->session->unset_userdata('caller_breadcrumb');
					$partial_respuesta = 'breadcrumb';
					$modulo = $this->encrypt->decode($view_caller);
				}
				break;
				case 'post':{
					$view_caller = $this->session->userdata('caller_post');
					$this->session->unset_userdata('caller_post');
					$partial_respuesta = 'post';
					$modulo = $this->encrypt->decode($view_caller);
				}
				break;
				case 'menu':{
					$view_caller = $this->session->userdata('caller_menu');
					$this->session->unset_userdata('caller_menu');
					$partial_respuesta = 'menu';
					$modulo = $this->encrypt->decode($view_caller);
				}
				break;
				case 'block':{
					$view_caller = $this->input->cookie('caller_block');
					delete_cookie('caller_block');
					$partial_respuesta = 'block';
					$modulo = $this->encrypt->decode($view_caller);
				}
				break;
				case 'footer':{
					$view_caller = $this->session->userdata('caller_footer');
					$this->session->unset_userdata('caller_footer');
					$partial_respuesta = 'footer';
					$modulo = $this->encrypt->decode($view_caller);
				}
				break;				
			}
		}				
		
		$arreglo = explode('/', $modulo);
		$controlador = $arreglo[1];
		$this->load->module($modulo);
		$this->$controlador->setViewRespuesta($string_respuesta);
		$this->$controlador->setPartialRespuesta($partial_respuesta);
		$this->$controlador->index();				
	}
}
?>