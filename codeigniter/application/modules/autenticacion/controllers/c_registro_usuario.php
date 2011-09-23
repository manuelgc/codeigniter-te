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
				'rules'=>'trim|max_length[3]|required'
			),
			array(
				'field'=>'celular_1',
				'label'=>'lang:regcliente_celular',
				'rules'=>'trim|required|max_length[3]'
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
			)
		);
	private $view_respuesta;
	private $partial_respuesta;		
	
	function validar_celular($campo1_celular) {
		echo 'llamo a validar_celular';
		$campo2_celular = $this->input->post('celular_2');
		$campo3_celular = $this->input->post('celular_3');
		$this->form_validation->set_message('validar_celular','Algo aqui...');
		return false;
		if ((empty($campo1_celular)) || (empty($campo2_celular)) || (empty($campo3_celular))) {
			echo 'entro en validar_celular if';
			$this->form_validation->set_message('validar_celular','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if ((!$this->form_validator->numeric($campo2_celular)) || (!$this->form_validator->numeric($campo3_celular))) {
				$this->form_validation->set_message('validar_celular','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}			
		}
	}
	
	function validar_fijo($campo1_fijo) {
		$campo2_tlf = $this->input->post('tlf_fijo_2');
		$campo3_tlf = $this->input->post('tlf_fijo_3');
		if (empty($campo2_tlf) && empty($campo3_tlf)) {
			$this->form_validation->set_message('validar_fijo','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if (!$this->form_validator->numeric($campo2_tlf) && !$this->form_validator->numeric($campo3_tlf)) {
				$this->form_validation->set_message('validar_fijo','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}			
		}
	}
	
	function __construct() {
		parent::__construct();
		$this->view_respuesta = NULL;	
		$this->partial_respuesta == FALSE;		
		$this->load->helper('form');
		$this->load->helper('captcha');
		$this->load->library('qtip2');		
		$this->load->library('form_validation');
		$this->load->helper('language');		
		$this->form_validation->CI =& $this;
	}
	
	function index() {		
		//caller_"sufijo" es la variable que guardara el metodo 'respuesta' del view 'solicitud'
		//se pasa encriptado para mayor seguridad
		$msg = $this->encrypt->encode('autenticacion/c_registro_usuario');
		$this->session->set_userdata('caller_block',$msg);
		
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/view.js'));

		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		//$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb');
		$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		
		//en este switch van los partial que tengan respuesta en el mismo modulo llamador
		switch ($this->partial_respuesta) {
			//el breadcrumb no se esta usando aun porque hay que cambiar algunas cosas de sergio
			//se mantiene como estaba antes
			/*case 'breadcrumb':
				if ($this->view_respuesta == NULL) {
					$data['output_header'] = Modules::run('banner_principal/c_banner_principal/index');
				}else {
					$data['output_header'] = $this->view_respuesta;
				}
			break;*/			
			case FALSE:{								
				$data['output_block'] = Modules::run('autenticacion/c_login/cargarView');
			}
			break;
		}
		
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
		
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();	
		
		$this->procesarRegistro();
	}
	
	function setViewRespuesta($param) {
		$this->view_respuesta = $param;
	}
	
	function setPartialRespuesta($param) {
		$this->partial_respuesta = $param;
	}
			
	function crearCaptcha() {
		$valores = array(
			'img_path' => './'
		);
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
				$data['ciudad'] = $this->cargarCiudad();											
				$this->template->build('v_registro_cliente',$data);
			}else {
				$this->template->build('v_registro_exitoso');
			}
		}else {
			$data['ciudad'] = $this->cargarCiudad();
			$this->template->build('v_registro_cliente',$data);
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
