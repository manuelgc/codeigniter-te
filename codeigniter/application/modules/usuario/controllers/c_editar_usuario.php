<?php
class C_editar_usuario extends MX_Controller {
	
	private $id_usuario;
	private $config = array(
				array(
				'field'=>'password',
				'label'=>'lang:regcliente_contrasena',
				'rules'=>'trim|required|matches[passwordConfirm]|md5'
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
				)				
	);
	
	
	function __construct() {
		parent::__construct();
		$this->id_usuario = Modules::run('autenticacion/c_login/verificarExisteSesion');
		$this->load->module('busqueda/c_busqueda');
		
		//$data['output_header'] = $this->getDataPartial('header');
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');

		//plantilla
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.collapsible.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		//$this->template->set_partial('header','web/layouts/two_columns/partials/header',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}
	
	function index() {
		if ($this->input->post('oculto_edicion_usuario')) {
			
		}
		
		$data = $this->getDatosDireccionUsuario();
		$this->template->build('v_editar_usuario',$data);
	}
	
	function editarUsuario($datos) {
		$cant_direcciones = count($datos['direcciones']);
		for ($i = 0; $i < $cant_direcciones; $i++) {
			$this->config[] = array('field'=>'ciudad_'.$i,'label'=>'lang:regcliente_ciudad','rules'=>'required');
			$this->config[] = array('field'=>'zona_'.$i,'label'=>'lang:regcliente_zona','rules'=>'required');
			$this->config[] = array('field'=>'calle_carrera_'.$i,'label'=>'lang:regcliente_calle_carr','rules'=>'trim|required|max_length[255]|xss_clean');
			$this->config[]	= array('field'=>'urb_edif_'.$i,'label'=>'lang:regcliente_urb_edif','rules'=>'trim|required|max_length[255]|xss_clean');
			$this->config[]	= array('field'=>'nroCasa_apt_'.$i,'label'=>'lang:regcliente_numcasa_apto','rules'=>'trim|required|max_length[255]|xss_clean');
			$this->config[]	= array('field'=>'lugar_referencia_'.$i,'label'=>'lang:regcliente_lugar_referencia','rules'=>'trim|required|max_length[255]|xss_clean');
		}
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
		
		if ($usuario = $u->getUsuarioById($id_usuario)) {
			$arr_zonas_ciudad = array();
						
			$datos['nombre_usuario'] = $usuario->nombreusuario;
			$datos['nombre'] = $usuario->nombre;
			$datos['apellidos'] = $usuario->apellidos;
			$datos['correo'] = $usuario->correo;
			
			$datos['tlf_fijo_1'] = substr($usuario->telfijo, -8, 3);
			$datos['tlf_fijo_2'] = substr($usuario->telfijo, -5, 3);
			$datos['tlf_fijo_3'] = substr($usuario->telfijo, -4);				 
			 
			$datos['celular_1'] = substr($usuario->telefonoCel, -8, 3);
			$datos['celular_2'] = substr($usuario->telefonoCel, -5, 3);
			$datos['celular_3'] = substr($usuario->telefonoCel, -4);
			
			$datos['ciudades'] = $this->cargarCiudad();

			$datos['direcciones'] = $usuario->getDireccionesEnvioId($id_usuario);
			
			$copia_direcciones = $datos['direcciones'];			
			for ($i = 0; $i < count($copia_direcciones); $i++) {
				$arr_zonas_ciudad[$i] = $this->cargarZonaPorCiudad($copia_direcciones[$i]['ciudad']);
			}						
			$datos['zonas_ciudad'] = $arr_zonas_ciudad;
		}			
		return $datos;	
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

	function cargarZonaPorCiudad($ciudad){
		$zona = new Zona();
		$zona->where('estatus','1');
		$zona->where('ciudades_id',$ciudad);
		$zona->order_by('nombreZona','ASD')->get_iterated();
		if (!$zona->exists()) {
			return '';
		}else {
			foreach ($zona as $z) {
				$options[$z->id] = $z->nombreZona;
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
	
	function validar_fijo($campo1_fijo) {
		$campo2_tlf = $this->input->post('tlf_fijo_2');
		$campo3_tlf = $this->input->post('tlf_fijo_3');
		if (empty($campo1_fijo) || empty($campo2_tlf) || empty($campo3_tlf)) {
			$this->form_validation->set_message('validar_fijo','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if (!$this->form_validation->numeric($campo2_tlf) && !$this->form_validation->numeric($campo3_tlf)) {
				$this->form_validation->set_message('validar_fijo','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}
		}
	}
	
	function validar_celular($campo1_celular) {
		$campo2_celular = $this->input->post('celular_2');
		$campo3_celular = $this->input->post('celular_3');
		if ((empty($campo1_celular)) || (empty($campo2_celular)) || (empty($campo3_celular))) {
			$this->form_validation->set_message('validar_celular','Debe ingresar un numero de telefono valido');
			return FALSE;
		}else {
			if ((!$this->form_validation->numeric($campo2_celular)) || (!$this->form_validation->numeric($campo3_celular))) {
				$this->form_validation->set_message('validar_celular','Solo se permiten numeros para este campo');
				return FALSE;
			}else {
				return TRUE;
			}
		}
	}
	
}
?>