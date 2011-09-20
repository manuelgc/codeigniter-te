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
	
	function __construct() {
		parent::__construct();
		$this->load->helper('language');	
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;	
	}
	
	function index() {
		//log(1,'entro al index del c_login');
		if ($this->input->post('oculto')) {
			log_message('debug','EN EL IF DEL POST');			
			$this->ejecutarLogin();
		}else {							
			log_message('debug','EN EL ELSE DEL POST');
			$data['error'] = 'primera vez';
			$this->load->view('v_login',$data);
		}		
	}
	
	function ejecutarLogin() {
		$this->form_validation->set_rules($this->config);
		
		if ($this->form_validation->run($this) == FALSE) {
			$data['error'] = 'un error';
			$this->load->view('v_login',$data);
			redirect('autenticacion/c_registro_usuario');
		}else {
			$this->template->build('v_registro_exitoso');
		}
	}
}
?>