<?php
/**
 * 
 * Controlador para el registro de usuarios tipo cliente en el sitio
 * @author manuelgc
 * @todo validar que el correo sea unico
 */

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
				private $view_respuesta;
				private $partial_respuesta;

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

				function validar_usuario($nombre_usuario) {
					$u = new Usuario();
					if ($u->buscarPorNombreUsuario($nombre_usuario)) {
						$this->form_validation->set_message('validar_usuario','El nombre de usuario '.$nombre_usuario.' ya se esta usando, selecciona otro nombre de usuario');
						return FALSE;
					}else {
						return TRUE;
					}
				}

				function __construct() {
					parent::__construct();
					$this->view_respuesta = NULL;
					$this->partial_respuesta == FALSE;
					$this->load->helper('language');
					$this->load->helper('form');
					$this->load->helper('captcha');
					$this->load->library('qtip2');
					$this->load->library('form_validation');
					//$this->form_validation->CI =& $this;
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

//					$this->qtip2->addCssJs();
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
					'img_path' => realpath('application/captcha/').'/',
					'img_url' => base_url().'application/captcha/'						
					);
		
					$cap = create_captcha($valores);
					$modelo_captcha = new Captcha();
					$modelo_captcha->captcha_time = $cap['time'];
					$modelo_captcha->ip_address = $this->input->ip_address();
					$modelo_captcha->word = $cap['word'];
					$modelo_captcha->save();
					if ($this->input->is_ajax_request()) {
						echo $cap['image'];
					}else{
						return $cap['image'];
					}
				}

				function procesarCaptcha($cod_captcha) {
					$expiracion = time()-7200;
					$modelo_captcha = new Captcha();
					$modelo_captcha->where('captcha_time <',$expiracion);
					$modelo_captcha->delete();

					$modelo_captcha2 = new Captcha();
					$modelo_captcha2->where('word',$cod_captcha);
					$modelo_captcha2->where('ip_address',$this->input->ip_address());
					$modelo_captcha2->where('captcha_time >',$expiracion);
					$modelo_captcha2->get();
									
					if (!$modelo_captcha2->exists()) {
						$this->form_validation->set_message('procesarCaptcha','El codigo que haz ingresado no concuerda con el mostrado, intentalo nuevamente');
						return FALSE;
					}else {
						return TRUE;
					}
				}

				function procesarRegistro() {
					$this->form_validation->set_rules($this->config);

					if ($this->input->post('oculto_registro')) {
						if ($this->form_validation->run($this) == FALSE) {
							$data['ciudad'] = $this->cargarCiudad();
							$data['captcha'] = $this->crearCaptcha();
							if($this->input->post('pedido')===FALSE){
								$this->template->build('autenticacion/v_registro_cliente',$data);
							}else{
								Modules::run('pedido/c_pedido_login/index',$data);
							}
						}else {
							$usuario = new Usuario();
							$estado = new Estado();
							$ciudad = new Ciudad();
							$zona = new Zona();
							$direccion_envio = new Direccionesenvio();
							
							$usuario->nombreusuario = $this->input->post('usuario');
							$usuario->password = $this->input->post('password');
							$usuario->nombre = $this->input->post('nombre');
							$usuario->apellidos = $this->input->post('apellidos');
							$usuario->telfijo = $this->input->post('tlf_fijo_1').$this->input->post('tlf_fijo_2').$this->input->post('tlf_fijo_3');
							$usuario->telefonoCel = $this->input->post('celular_1').$this->input->post('celular_2').$this->input->post('celular_3');
							$usuario->correo = $this->input->post('correo');
							$usuario->estatus = (int)1;

							$tipo_usuario = new Tipousuario();
							$tipo_usuario->where('id',3)->get();
														
							$estado_id = 7; //para cuando funcione en otros estados
							$ciudad_id = $this->input->post('ciudad');
							$zona_id = $this->input->post('zona');
							
							$estado->get_by_id($estado_id);
							$ciudad->get_by_id($ciudad_id);
							$zona->get_by_id($zona_id);
							
							$usuario->trans_begin();
							$usuario->save($tipo_usuario);
							
							if ($usuario->trans_status() === FALSE) {								
								$usuario->trans_rollback();
								$data['ciudad'] = $this->cargarCiudad();
								$data['captcha'] = $this->crearCaptcha();
								$data['error_bd'] = $usuario->error->string;
								
								if($this->input->post('pedido')===FALSE){
									$this->template->build('autenticacion/v_registro_cliente',$data);
								}else{
									Modules::run('pedido/c_pedido_login/index',$data);
								}
								
							}else {
								$direccion_envio->calle_carrera = $this->input->post('calle_carrera');
								$direccion_envio->casa_urb = $this->input->post('urb_edif');
								$direccion_envio->numeroCasaApto = $this->input->post('nroCasa_apt');
								$direccion_envio->lugarreferencia = $this->input->post('lugar_referencia');
								$direccion_envio->estatus = (int)1;
								
								$direccion_envio->save(array($estado,$ciudad,$zona,$usuario));
								$direccion_envio->trans_begin();
								if ($direccion_envio->trans_status() === FALSE) {
									$direccion_envio->trans_rollback();
									$data['ciudad'] = $this->cargarCiudad();
									$data['captcha'] = $this->crearCaptcha();
									$data['error_bd'] = $usuario->error->string;								
									
								if($this->input->post('pedido')===FALSE){
									$this->template->build('autenticacion/v_registro_cliente',$data);
								}else{
									Modules::run('pedido/c_pedido_login/index',$data);
								}
								
								}else {
									$usuario->trans_commit();
									$direccion_envio->trans_commit();
									Modules::run('autenticacion/c_login/crearSesion',$usuario);
									
									
									if($this->input->post('pedido')===FALSE){
										$this->template->build('v_registro_exitoso');
									}else{
										Modules::run('pedido/c_pedido_login/index');
									}
								}
							}																					
						}
					}else {
						$data['ciudad'] = $this->cargarCiudad();
						$data['captcha'] = $this->crearCaptcha();
						$this->template->build('autenticacion/v_registro_cliente',$data);
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
