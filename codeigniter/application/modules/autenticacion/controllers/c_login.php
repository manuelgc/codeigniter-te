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
			echo 'en el post oculto';	
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
			$resultado_logueo = $this->verificarDatosUsuario($this->input->post('nombre_usuario'), $this->input->post('contrasena'));
			if ($resultado_logueo) {
				$data['nombre'] = $this->session->userdata('nombreusuario');
				$resultado = $this->load->view('v_datos_logueado',$data,true);
				$this->respuestaLogin($resultado);
			}else{
				$data['error'] = 'El usuario o la contrasena introducidos no son correctos';
				$resultado = $this->load->view('v_login',$data,true);
				$this->respuestaLogin($resultado);
			}			
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
			return TRUE;
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
		
	function getHtmlSesion(){
		log_message('error','HIZO EL GETHTMLSESION');
		if ($this->session->userdata('nombreusuario') === FALSE) {
			echo 'en el if de la sesion';
			return $this->load->view('v_login',$data,true);
		}else {
			echo 'en el else de la sesion';
			$data['nombre'] = $this->session->userdata('nombreusuario');
			return $this->load->view('v_datos_logueado',$data,true);
		}		
	}
	
}
?>