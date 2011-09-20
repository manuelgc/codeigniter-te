<?php
class C_login extends MX_Controller {
	private $config = array(
		array(
			'field'=>'usuario',
			'label'=>'lang:logincliente_usuario',
			'rules'=>'trim|required|xss_clean'
		),
		array(
			'field'=>'contrasena',
			'label'=>'lang:logincliente_pass',
			'rules'=>'trim|required|xss_clean'
		)
	);
	
	function __construct() {
		parent::__construct();
		$this->load->helper('language');	
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;	
	}
	
	function index() {
		if ($this->input->post('usuario')) {
			$this->ejecutarLogin();
		}else {						
			$this->template->build('v_login');
		}		
	}
	
	function ejecutarLogin() {
		$this->form_validation->set_rules($this->config);
		
		if ($this->form_validation->run($this) == FALSE) {
			$this->template->build('v_login');
		}else {
			$this->template->build('v_registro_exitoso');
		}
	}
}
?>