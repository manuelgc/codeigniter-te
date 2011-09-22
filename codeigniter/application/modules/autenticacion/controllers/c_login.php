<?php
class C_login extends MX_Controller {
	private $config = array(
		array(
			'field'=>'nombre_usuario',
			'label'=>'lang:logincliente_usuario',
			'rules'=>'trim|required|xss_clean'
		),
		array(
			'field'=>'contrasena',
			'label'=>'lang:logincliente_pass',
			'rules'=>'trim|required|xss_clean'
		)
	);	
	private $uri_request;
	
	function __construct() {
		parent::__construct();
		$this->load->helper('language');	
		$this->load->library('form_validation');		
		$this->form_validation->CI =& $this;	
	}
	
	function index() {
		if ($this->input->post('oculto')) {				
			$this->ejecutarLogin();
		}else {													
			return $this->load->view('v_login',$data,true);
		}		
	}
	
	function cargarView() {				
		return $this->load->view('v_login');
	}		
	
	function respuestaLogin($resultado) {
		$this->session->set_userdata('respuesta_block','1');			
		Modules::run('respuesta_modulos/c_procesar_respuesta/redirectRespuesta',$resultado);
	}
	
	function ejecutarLogin() {
		$this->form_validation->set_rules($this->config);		
		
		if ($this->form_validation->run($this) == FALSE) {									
			$resultado = $this->load->view('v_login',null,true);
			$this->respuestaLogin($resultado);				
		}else {
			$this->template->build('v_registro_exitoso');
		}
	}
}
?>