<?php
class C_procesar_respuesta extends MX_Controller {
	function __construct() {
		parent::__construct();		
	}
	
	/**
	 * 
	 * redirectRespuesta, permite procesar una solicitud de un modulo y enviar la respuesta
	 * a la vista que contiene el modulo.
	 * @param string $string_respuesta, respuesta enviada desde el modulo
	 * @return void
	 */
	function redirectRespuesta($string_respuesta) {		
		$respuesta_header = $this->session->userdata('respuesta_header');
		$respuesta_breadcrumb = $this->session->userdata('respuesta_breadcrumb');		
		$respuesta_post = $this->session->userdata('respuesta_post');
		$respuesta_menu = $this->session->userdata('respuesta_menu');
		$respuesta_block = $this->session->userdata('respuesta_block');
		$respuesta_footer = $this->session->userdata('respuesta_footer');
		$partial_respuesta = '';
		log_message('debub','header: '.$respuesta_header.' block: '.$respuesta_block);
		
		if ($respuesta_header == '1') {
			$view_caller = $this->session->userdata('caller_header');
			$this->session->unset_userdata('caller_header');
			$partial_respuesta = 'header';
			$modulo = $this->encrypt->decode($view_caller);									
		}
		
		if ($respuesta_breadcrumb == '1') {
			$view_caller = $this->session->userdata('caller_breadcrumb');
			$this->session->unset_userdata('caller_breadcrumb');
			$partial_respuesta = 'breadcrumb';
			$modulo = $this->encrypt->decode($view_caller);							
		}
		
		if ($respuesta_post == '1') {
			$view_caller = $this->session->userdata('caller_post');
			$this->session->unset_userdata('caller_post');
			$partial_respuesta = 'post';
			$modulo = $this->encrypt->decode($view_caller);							
		}
		
		if ($respuesta_menu == '1') {
			$view_caller = $this->session->userdata('caller_menu');
			$this->session->unset_userdata('caller_menu');
			$partial_respuesta = 'menu';
			$modulo = $this->encrypt->decode($view_caller);							
		}
		
		if ($respuesta_block == '1') {
			$view_caller = $this->session->userdata('caller_block');
			$this->session->unset_userdata('caller_block');
			$partial_respuesta = 'block';
			$modulo = $this->encrypt->decode($view_caller);							
		}
		
		if ($respuesta_footer == '1') {
			$view_caller = $this->session->userdata('caller_footer');
			$this->session->unset_userdata('caller_footer');
			$partial_respuesta = 'footer';
			$modulo = $this->encrypt->decode($view_caller);							
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