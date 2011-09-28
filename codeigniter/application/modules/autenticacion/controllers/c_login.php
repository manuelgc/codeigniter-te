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
	
	function verificarDatosUsuario($usuario_email,$contrasena) {
		$campo_busqueda = '';
		if ($this->form_validation->valid_email($usuario_email)) {
			$campo_busqueda = 'correo';
		}else {
			$campo_busqueda = 'nombreusuario'; 
		}
		
		$u = new Usuario();
		$u->where($campo_busqueda,$usuario_email);
		$u->where('password',md5($contrasena));
		$u->where('estatus',1);
		$u->get();
		
		if ($u->exists()) {
			$this->crearSesion($u);
		}else{
			return FALSE;
		}
	}
	
	function crearSesion($usuario) {
		$usuario_logueado = array(
			'nombreusuario' => $usuario->nombreusuario,
			'id' => $usuario->id
		);
		
		$this->session->set_userdata($usuario_logueado);
	}
	
	function verificarExisteSesion() {
		if ($this->session->userdata('nombreusuario') === FALSE) {
			return FALSE;
		}else {
			return $this->session->userdata('id');
		}		
	}
		
}
?>