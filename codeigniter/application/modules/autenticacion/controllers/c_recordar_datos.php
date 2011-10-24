<?php
class C_recordar_datos extends MX_Controller {
	private $config = array(
		array(
			'field'=>'correo',
			'label'=>'lang:regcliente_email',		
			'rules'=>'trim|required|valid_email|xss_clean'
		)
	);
	private $config_nuevo_pass = array(
		array(
			'field'=>'nuevo_password',
			'label'=>'lang:regcliente_contrasena',
			'rules'=>'trim|required|matches[passwordConfirm]|md5'
		),
		array(
			'field'=>'confirmar_password',
			'label'=>'lang:regcliente_contrasena_confirm',
			'rules'=>'trim|required|md5'
		)
	);
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('qtip2');
		$this->load->library('email');		
		$this->load->helper('date');
		$this->form_validation->CI =& $this;	
		//plantilla				
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');				
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
	}
	
	function index($param_mensaje = '') {
		if ($this->input->post('oculto')) {
			$this->form_validation->set_rules($this->config);
			if ($this->form_validation->run($this) == FALSE) {
				$this->template->build('v_recordar_datos');		
			}else {
				$data['mensaje'] = $this->procesarForm($this->input->post('correo'));
				$this->template->build('v_dato_recordado',$data);
			}
		}else {
			$this->template->build('v_recordar_datos');
		}				
	}
	
	function procesarForm($correo) {		
		$u = new Usuario();
		$resultado_busqueda = $u->buscarPorCorreo($correo);
		if ($resultado_busqueda == FALSE) {
			return 'Lo sentimos, el correo ingresado no se encuentra registrado, si desea intentar nuevamente presione '.
			anchor('autenticacion/c_recordar_datos','aqui').', para crear una nueva cuenta presione '.anchor('autenticacion/c_registro_usuario','aqui');
		}else{
			if ($this->enviarCorreo($resultado_busqueda) == TRUE) {
				return 'Te hemos enviado un correo electronico indicando los pasos que debes seguir para recuperar tu contrasena';
			}
		}
	}
	
	function enviarCorreo($usuario) {
		$rd = new Recordardato();
		
		if ($rd->setRecordarDato($usuario->correo) == FALSE) {
			return FALSE;
		}else {
			$data['vinculo'] = $rd->string;
			$data['tiempo'] = $rd->tiempo;
			$data['id'] = $rd->id;
			$resultado = $this->load->view('v_correo_recordar_datos',$data,TRUE);
			return $this->__enviar_correo($usuario->correo, $resultado);
		}
	}
	
	function nuevoPassword($id = '') {
		if ($this->input->post('oculto')) {
			$this->form_validation->set_rules($this->config_nuevo_pass);
			if ($this->form_validation->run($this) == FALSE) {
				$this->template->build('v_nuevo_password');
			}else {
				$usuario = new Usuario();
				$usuario->where('estatus',1)->get_by_id($id);
				$usuario->password = $this->input->post('nuevo_password');
				if ($usuario->save()) {
					redirect('home/c_home/nuevopassok');
				}else {
					redirect('home/c_home/index/nuevopasserror');
				}
			}
		}
	}
	
	function __enviar_correo($correo,$mensaje) {
		$this->email->from('admingmail@binaural.com.ve','Todo Express');
		$this->email->to($correo);
		$this->email->subject('Todo Express - Recordar Contrasena');
		$this->email->message($mensaje);
		$this->email->send();		
		if (!$this->email->send()) {
			return FALSE;
		}else {
			return TRUE;
		}
	}
}
?>