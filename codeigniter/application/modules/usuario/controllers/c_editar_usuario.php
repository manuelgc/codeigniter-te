<?php
class C_editar_usuario extends MX_Controller {
	
	private $id_usuario;
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
				'rules'=>'trim|required|max_length[40]|xss_clean'
				),
				array(
				'field'=>'correo',
				'label'=>'lang:regcliente_email',
				'rules'=>'trim|required|valid_email|xss_clean'
				),
				array(
				'field'=>'tlf_fijo_1',
				'label'=>'lang:regcliente_tlf_fijo',
				'rules'=>'trim|max_length[3]|required|callback_validar_fijo'
				),
				array(
				'field'=>'celular_1',
				'label'=>'lang:regcliente_celular',
				'rules'=>'trim|required|max_length[3]|callback_validar_celular'
				),
				array(
				'field'=>'ciudad',
				'label'=>'lang:regcliente_ciudad',
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
				),
				array(
				'field'=>'lugar_referencia',
				'label'=>'lang:regcliente_lugar_referencia',
				'rules'=>'trim|required|max_length[255]|xss_clean'
				),
				array(
				'field'=>'cod_captcha',
				'label'=>'lang:regcliente_cod_captcha',
				'rules'=>'trim|required|max_length[255]|xss_clean|callback_procesarCaptcha'
				)
	);
	
	
	function __construct() {
		parent::__construct();
		$this->id_usuario = Modules::run('autenticacion/c_login/verificarExisteSesion');
		$this->load->module('busqueda/c_busqueda');
		
		//$data['output_header'] = $this->getDataPartial('header');
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');

		//plantilla
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}
	
	function index() {
		$this->template->build('v_editar_usuario');
	}
	
	function getDataPartial($partial = '') {
		$output = '';
		switch ($partial) {
			case 'breadcrumb':
				$output = $this->c_busqueda->index();
				break;
			case 'header':
				$output = Modules::run('banner_principal/c_banner_principal/index');
				break;
			case 'block':
				$output = Modules::run('autenticacion/c_login/cargarView');
		}

		return $output;
	}
	
	function getDatosDireccionUsuario() {
		$id_usuario = 2;//$this->id_usuario;
		$u = new Usuario();
		
		if ($u->getUsuarioById($id_usuario) != FALSE) {
			$datos_usuario[];
		}
	}
	
	function cargarCiudad(){
		$ciudad = new Ciudad();
		$ciudad->where('estatus','1');
		$ciudad->where('estados_id','7');
		$ciudad->order_by('nombreCiudad','ASD')->get_iterated();
		$options= array();
		if (!$ciudad->exists()) {
			return '';
		}else{
			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
			}
			return $options;
		}
	}

	function cargarZona(){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$this->input->post('id_ciudad'));
		$zona->order_by('nombreZona','ASD')->get_iterated();
		$salida='<option value="" >Seleccione</option>;';
		if (!$zona->exists()) {
			$salida='0';
		}else{
			foreach ($zona as $zon) {
				$salida .= '<option value="'.$zon->id.'">'.$zon->nombreZona.'</option>';
			}
			$data['zona']= $salida;
			echo json_encode($data);
				
		}

	}
	
}
?>