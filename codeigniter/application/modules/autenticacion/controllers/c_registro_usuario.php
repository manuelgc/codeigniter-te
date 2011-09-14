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
		$partials = array(0,1,2,4,5,6,7,8);
		cargarPartials($partials);				
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
		
		$this->ejecutarValidacion();
	}
	
	function ejecutarValidacion() {
		$this->form_validation->set_rules($this->config);
		if ($this->form_validation->run($this) == FALSE) {												
			$this->template->build('v_registro_cliente');
		}else {
			$this->template->build('v_registro_exitoso');
		}
	}			

	function comprobarNombreUsuario() {
		$data['nombre_usuario'] = $this->input->post('usuario');		
		//$this->template->set('usuario',$data);		
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
