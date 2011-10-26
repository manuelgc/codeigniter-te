<?php 
class C_login_admin extends MX_Controller {
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
		$this->load->library('encrypt');	
		$this->load->library('qtip2');
		$this->load->module('autenticacion/c_login');
		$this->form_validation->CI =& $this;
		
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');		
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}
	
	function index() {
		if ($this->input->post('oculto')) {
			$this->form_validation->set_rules($this->config);
			if ($this->form_validation->run($this) == FALSE) {
				$this->template->build('v_login_admin');
			}else {
				$resultado = $this->verificarDatosUsuario($this->input->post('nombre_usuario'), $this->input->post('contrasena'));
				if ($resultado == FALSE) {
					$data['error'] = 'Los datos que ha ingresado no son correctos o usted no es '.
					'usuario administrador, por favor verifique los datos e intente nuevamente';
					$this->template->build('v_login_admin',$data);
				}else {
					$this->c_login->crearSesion($resultado);
					redirect('admin/c_admin_home');
				}
			}
		}else {
			$this->template->build('v_login_admin');
		}		
	}
	
	function verificarDatosUsuario($usuario_correo,$contrasena) {
		$campo_busqueda = '';
		if ($this->form_validation->valid_email($usuario_correo)) {
			$campo_busqueda = 'correo';
		}else {
			$campo_busqueda = 'nombreusuario'; 
		}
		
		$u = new Usuario();
		$usuario = $u->getUsuarioLogueoAdmin($usuario_correo,$contrasena,$campo_busqueda);
		if ($usuario == FALSE) {
			return FALSE;
		}elseif ($usuario->tipousuarios_id == 3) {
			return FALSE;
		}else {
			return $usuario;
		}
	}
		
}
?>
