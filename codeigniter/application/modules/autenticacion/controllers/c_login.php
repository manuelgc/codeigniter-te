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
		//$this->session->set_userdata('respuesta_block','1');			
		Modules::run('respuesta_modulos/c_procesar_respuesta/redirectRespuesta',$resultado,'block');
	}
	
	function ejecutarLogin() {
		$this->form_validation->set_rules($this->config);		
		$this->input->set_cookie('respuesta_block','1',0);
		
		if ($this->form_validation->run($this) == FALSE) {									
			$resultado = $this->load->view('v_login',null,true);
			$this->respuestaLogin($resultado);				
		}else {
			$resultado_logueo = $this->verificarDatosUsuario($this->input->post('nombre_usuario'), $this->input->post('contrasena'));
			if ($resultado_logueo == FALSE) {
				$data['error'] = 'El usuario o la contrasena introducidos no son correctos';
				$resultado = $this->load->view('v_login',$data,true);
				$this->respuestaLogin($resultado);
			}
			if ($resultado_logueo === 1) {
				$data['error'] = 'Para entrar a tu cuenta administrativa debes seleccionar '.anchor('admin/c_login_admin','aqui');
				$resultado = $this->load->view('v_login',$data,true);
				$this->respuestaLogin($resultado);
			}else {
				$this->crearSesion($resultado_logueo);
				$data['nombre'] = $this->session->userdata('nombreusuario');
				$resultado = $this->load->view('v_datos_logueado',$data,true);
				$this->respuestaLogin($resultado);
			}							
		}
	}
	
	function verificarDatosUsuario($usuario_email,$contrasena,$tipo_usuario = 3) {
		$campo_busqueda = '';
		if ($this->form_validation->valid_email($usuario_email)) {
			$campo_busqueda = 'correo';
		}else {
			$campo_busqueda = 'nombreusuario'; 
		}
		
		$u = new Usuario();
		return $u->getUsuarioLogueo($usuario_email,$contrasena,$tipo_usuario,$campo_busqueda);				
	}
	
	function crearSesion($usuario) {
		$usuario_logueado = array(
			'nombreusuario' => $usuario->nombreusuario,
			'id' => $usuario->id,
			'tipousuario' => $usuario->tipousuarios_id
		);
		
		$this->session->set_userdata($usuario_logueado);
	}
	
	function cerrarSesion() {
		$id_usuario = $this->verificarExisteSesion();
		if (!FALSE) {
			$this->session->unset_userdata('nombreusuario');
			$this->session->unset_userdata('id');
			redirect('home/c_home/index/'.$this->encrypt->sha1('cerrada'));
		}
	}
	
	function verificarExisteSesion($mensaje = '') {
		if ($this->session->userdata('nombreusuario') === FALSE) {
			redirect('home/c_home/index/'.$this->encrypt->sha1($mensaje));
		}else {
			return $this->session->userdata('id');
		}		
	}
		
	function getHtmlSesion(){
		if ($this->session->userdata('nombreusuario') === FALSE) {			
			return $this->load->view('v_login',$data,true);
		}else {			
			$data['nombre'] = $this->session->userdata('nombreusuario');
			return $this->load->view('v_datos_logueado',$data,true);
		}		
	}
	
}
?>