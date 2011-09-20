<?php
class C_registro_usuario extends MX_Controller {
	private $config = array(
			array(
				'field'=>'usuario',
				'label'=>'lang:regcliente_usuario',
				'rules'=>'trim|required|callback_validar_usuario|min_length[5]|max_length[12]|xss_clean'
			),
			array(
				'field'=>'password',
				'label'=>'lang:regcliente_contrasena',
				'rules'=>'trim|required|matches[passwordConfirm]|md5'
			),
			array(
				'field'=>'passwordConfirm',
				'label'=>'lang:regcliente_contrasena_confirm',
				'rules'=>'trim|required|md5'
			),
			array(
				'field'=>'nombre',
				'label'=>'lang:regcliente_nombre',
				'rules'=>'trim|required|alpha|max_length[20]|xss_clean'
			),
			array(
				'field'=>'apellidos',
				'label'=>'lang:regcliente_apellidos',
				'rules'=>'trim|required|alpha_whitespace|max_length[40]|xss_clean'
			),
			array(
				'field'=>'correo',
				'label'=>'lang:regcliente_email',
				'rules'=>'trim|required|valid_email|xss_clean'
			),
			array(
				'field'=>'celular_1',
				'label'=>'lang:regcliente_celular',
				'rules'=>'trim|required|numeric|max_length[3]|callback_validar_celular|xss_clean'
			),
			array(
				'field'=>'estado',
				'label'=>'lang:regcliente_estado',
				'rules'=>'required'
			),
			array(
				'field'=>'calle_carrera',
				'label'=>'lang:regcliente_calle_carr',
				'rules'=>'trim|required|max_length[255]|xss_clean'
			),
			array(
				'field'=>'urb_edif',
				'label'=>'lang:regcliente_urb_edif',
				'rules'=>'trim|required|max_length[255]|xss_clean'
			),
			array(
				'field'=>'nroCasa_apt',
				'label'=>'lang:regcliente_numcasa_apto',
				'rules'=>'trim|required|max_length[255]|xss_clean'
			)
		);
	
	function __construct() {
		parent::__construct();		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		//$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb');
		$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		$this->template->set_partial('block','web/layouts/two_columns/partials/block');
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');				
		$this->load->helper('form');
		$this->load->library('qtip2');		
		$this->load->library('form_validation');
		$this->load->helper('language');
		$this->form_validation->CI =& $this;
	}
	
	function index() {		
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));		
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();	
		
		$this->procesarRegistro();
	}
	
	function procesarRegistro() {
		$this->form_validation->set_rules($this->config);
		
		if ($this->input->post('oculto_registro')) {
			$usuario = new Usuario();
			$usuario->nombreusuario = $this->input->post('usuario');
			$usuario->password = $this->input->post('password');
			$usuario->nombre = $this->input->post('nombre');
			$usuario->apellidos = $this->input->post('apellidos');
			$usuario->telefonoCel = $this->input->post('celular_1').$this->input->post('celular_2').$this->input->post('celular_3');
			$usuario->correo = $this->input->post('correo');
		
		
			if ($this->form_validation->run($this) == FALSE) {												
				$this->template->build('v_registro_cliente');
			}else {
				$this->template->build('v_registro_exitoso');
			}
		}else {
			$this->template->build('v_registro_cliente');
		}
	}			

	function comprobarNombreUsuario() {	
		$nombre = $this->input->post('usuario');
		$u = new Usuario();
		if ($u->buscarPorNombreUsuario($nombre)) {
			$data['nombre_usuario'] = $nombre;
		}else {
			$data['nombre_usuario'] = '0';
		}
		echo json_encode($data);
	}
	
	function validar_usuario($usuario) {
		if ($usuario == 'prueba') {
			$this->form_validation->set_message('validar_usuario','el campo %s no puede ser "prueba"');
			return FALSE;
		}else {
			return TRUE;
		}
	}
		
}
?>
