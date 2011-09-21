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
		$this->load->library('encrypt');		
		$this->form_validation->CI =& $this;	
	}
	
	function index() {
		//log(1,'entro al index del c_login');
		if ($this->input->post('oculto')) {				
			$this->ejecutarLogin();
		}else {										
			$data['error'] = 'primera vez';
			return $this->load->view('v_login',$data,true);
		}		
	}
	
	function cargarView() {				
		return $this->load->view('v_login');
	}		
	
	function respuestaLogin($resultado) {
		$view_caller = $this->session->userdata('caller_login');
		$this->session->unset_userdata('caller_login');
		$msn = $this->encrypt->decode($view_caller);		
		Modules::run($msn,$resultado);			
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