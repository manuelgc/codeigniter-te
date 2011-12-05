<?php class c_pedido extends MX_Controller {
	private $config = array(
    		'direccion' => array(
				array('field'=>'calle_carrera',
				'label'=>'lang:regcliente_calle_carr',
				'rules'=>'trim|required|max_length[255]|xss_clean'
				),
				array('field'=>'urb_edif',
				'label'=>'lang:regcliente_urb_edif',
				'rules'=>'trim|required|max_length[255]|xss_clean'
				),
				array('field'=>'nroCasa_apt',
				'label'=>'lang:regcliente_numcasa_apto',
				'rules'=>'trim|required|max_length[255]|xss_clean'
				),
				array('field'=>'lugar_referencia',
				'label'=>'lang:regcliente_lugar_referencia',
				'rules'=>'trim|required|max_length[255]|xss_clean'
				)
            ),
    		'pedDom' => array(
            	array('field'=>'ciudad',
            	'label'=>'Ciudad',
            	'rules'=>'required'
            	),
				array('field'=>'zona',
				'label'=>'Zona',
				'rules'=>'required'
				),
				array('field'=>'radio_direc',
            	'label'=>'Direcci&oacute;n',
            	'rules'=>'required'
				),
				array('field'=>'radio_tipo_pago',
				'label'=>'Forma de Pago',
				'rules'=>'required')
            	),
            'pedRet' => array(
				array('field'=>'radio_tipo_pago',
				'label'=>'Forma de Pago',
				'rules'=>'required')
            )	
            );	
            
	function __construct(){
		parent::__construct();
		$this->load->library('cart'); 
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->library('qtip2');
		$this->load->module('busqueda/c_busqueda');
		$this->load->module('carrito/c_carrito');
		$this->load->library('form_validation');	
		$this->form_validation->CI =& $this;	
		$this->id_usuario = $this->verificarExisteSesion();
	}

	function index() {
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.blockUI.js'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery.spinbox.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.spinbox.js'));	
		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');
		
		if($this->input->cookie('tienda')){
			$data['output_block'] = $this->c_carrito->index($this->input->cookie('tienda'),true);
		}
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');

//		$this->qtip2->addCssJs();		
//		$this->qtip2->putCustomTip('select','img','textarea','p','radio');
		$this->qtip2->putCustomTip('div','textarea');
		$this->qtip2->putCustomTip('div[name="dir"]','select');
		$this->qtip2->putCustomTip('div','img#agregar-dir');
		$this->qtip2->putCustomTip('fieldset','table');
		$this->qtip2->putCustomTip('div[name="forma_pago"]','div[name="radio_pago"]');

		
		
		if ( !$this->cart->contents() ) {
			redirect('tienda/c_datos_tienda');
		}elseif($this->input->cookie('tienda')!==false){
			if($this->input->cookie('tipo_orden')!==false && $this->input->cookie('tipo_orden')==1){
				$this->form_validation->set_rules($this->config['pedDom']);
				$data['envio']=true;
				$data['ciudad']=$this->cargarCiudad($this->input->cookie('tienda'));
				if($this->input->cookie('ciudad')!==false){
					$data['zona']= $this->cargarZona($this->input->cookie('tienda'),$this->input->cookie('ciudad'));
				}else{
					$data['zona']= $this->cargarZona($this->input->cookie('tienda'), '');
				}

				$data += $this->cargarDireciones();

			}else{
				$data['envio']=false;
				$this->form_validation->set_rules($this->config['pedRet']);
			}
			$data['radio_pago']=$this->cargarRadioPago();
				
				
			if($this->input->post('pedido')==false){

				$this->template->build('pedido/v_pedido',$data);
			}else{
				
				if ($this->form_validation->run() == FALSE){
					$this->template->build('pedido/v_pedido',$data);
				}else{
					echo 'exito';
				}
			}
		}
	}
    
	function procesarPedido() {
		;
	}
	function cargarDireciones() {
		if ($this->input->cookie('ciudad')===false || $this->input->cookie('zona')===false) {
			$data["error_dir"]='Debe selecionar la ciudad y zona donde se encuentra';
			$data['agr_visible']=false;
		}else if($this->validarZona()){
			$data['dir_usuario']= $this->getDireccionesUsuario($this->input->cookie('ciudad'),$this->input->cookie('zona'));
			$data['agr_visible']=true;
			if(empty($data['dir_usuario'])){
				$data['error_dir']='No posee direcciones registradas en la Zona Seleccionada, Por favor seleccione otra zona o agregue una direcci&oacute;n';
			}
		}else {
			$data['error_dir']='No se pueden realizar envios en la Ciudad o Zona Seleccionada, Por favor selccione otra';
			$data['agr_visible']=false;
		}
		return $data;
	}
	
	function getDireccionesUsuario($id_ciudad,$id_zona) {
		$u = new Usuario();
		$direcciones= $u->getDireccionesEnvioByZona($this->id_usuario, $id_ciudad, $id_zona);
		if ($direcciones === FALSE) {
			return NULL;
		}else {
			return $direcciones;
		}
	}
	
	function actualizarDirecciones(){
		$data = $this->cargarDireciones();
		if(array_key_exists('dir_usuario', $data) && !empty($data['dir_usuario'])){
			$dataAjax['direccion']=true;
			$dataAjax['html_dir']= '';
			$dataAjax['agr_visible']=$data['agr_visible'];
			foreach ($data['dir_usuario'] as $direcciones){
				$dataAjax['html_dir'].= '<fieldset class="ui-widget ui-widget-content ui-corner-all">';
				$dataAjax['html_dir'].= '<table><tbody><tr><td style="border: 0px">';
				$dataAjax['html_dir'].= form_radio('radio_direc', $direcciones['id'], false,'id="'.$direcciones['id'].'-direccion"') .'</td>';
				$dataAjax['html_dir'].=	'<td style="border: 0px">
												Ciudad: '.$direcciones['ciudad'].',
												Zona: '.$direcciones['zona'].', Calle/Carrera: '.$direcciones['calle_carrera'].', 
												Casa/Urb: '.$direcciones['casa_urb'].' , Numero
												Casa/Apto: '. $direcciones['numeroCasaApto'].', Lugar de
												Referencia: '.$direcciones['lugarreferencia'];
				$dataAjax['html_dir'].=	'</td></tr></tbody></table></fieldset>';
			}
		}else{
			$dataAjax['direccion']=false;
			$dataAjax['error']=$data['error_dir'];
			$dataAjax['agr_visible']=$data['agr_visible'];
		}
		echo json_encode($dataAjax);
	}
	
	function mostrarFormDireccion() {
		$data['formulario'] = $this->load->view('v_form_direccion','',true);
		echo json_encode($data);
	}

	function guardarDireccion() {
		$id_usuario = $this->id_usuario;//$this->id_usuario
		
		$this->form_validation->set_rules($this->config['direccion']);
		if ($this->form_validation->run() == FALSE){
			$data['calle_carrera']= $this->input->post('calle_carrera');
			$data['urb_edif']= $this->input->post('urb_edif');
			$data['nroCasa_apt'] = $this->input->post('nroCasa_apt');
			$data['lugar_referencia'] = $this->input->post('lugar_referencia');
			$dataAjax['formulario'] = $this->load->view('v_form_direccion',$data,true);
			$dataAjax['validacion'] = false; 
			echo json_encode($dataAjax);
			
		}else if ($this->input->is_ajax_request()) {
			
			$data = array();
			$d = new Direccionesenvio();
			$ciu = new Ciudad();
			$zona = new Zona();
			$u = new Usuario();
				
			$d->calle_carrera = $this->input->post('calle_carrera');
			$d->casa_urb = $this->input->post('urb_edif');
			$d->numeroCasaApto = $this->input->post('nroCasa_apt');
			$d->lugarreferencia = $this->input->post('lugar_referencia');
			$d->estatus = (int)1;

			$d->estado_id = (int)7; //para cuando se implemente en otros estados
			$ciu->get_by_id($this->input->post('id_ciudad'));
			$zona->get_by_id($this->input->post('id_zona'));
			$u->get_by_id($id_usuario);

			$data['validacion'] = true;
			
			if ($d->save(array($ciu,$zona,$u)) == FALSE) {
				$data['resultado'] = FALSE;
			}else {
				$data['resultado']= '<fieldset class="ui-widget ui-widget-content ui-corner-all">';
				$data['resultado'].= '<table><tbody><tr><td style="border: 0px">';
				$data['resultado'].= form_radio('radio_direc', $d->id, false,'id="'.$d->id.'-direccion"') .'</td>';
				$data['resultado'].=	'<td style="border: 0px">
												Ciudad: '.$d->ciudad->get()->nombreCiudad.',
												Zona: '.$d->zona->get()->nombreZona.', Calle/Carrera: '.$d->calle_carrera.', 
												Casa/Urb: '.$d->casa_urb.' , Numero Casa/Apto: '. $d->numeroCasaApto.', 
												Lugar de Referencia: '.$d->lugarreferencia;
				$data['resultado'].=	'</td></tr></tbody></table></fieldset>';
				
			}
				
			echo json_encode($data);
		}
	}
	
	function validarZona(){
		$tienda = new Tiendascomida();
		$encontrado = false;
		$zona = $tienda->getZonasEntregaById($this->input->cookie('ciudad'), $this->input->cookie('tienda'));
		
		if ($zona!==false) {
			foreach ($zona as $z) {
				if ($z->id == $this->input->cookie('zona')) {
					$encontrado=true;
					break;
				};
			}
			if($encontrado){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function cargarCiudad($id_tienda){
		$tienda = new Tiendascomida();
		$ciudad= $tienda->getCiudadesEntregaById($id_tienda);
		$options= array();
		if ($ciudad!=false) {
			foreach ($ciudad as $ci) {
				$options[$ci->id] = $ci->nombreCiudad;
			}
			return form_dropdown('ciudad',$options,(($this->input->cookie('ciudad')!=false)?$this->input->cookie('ciudad'):''),'id=cmbx_ciudad class="element text medium"');
		}else{
			return array();		
		}

	}
	
	function cargarZona($id_ciudad,$id_tienda){
		$tienda = new Tiendascomida();
		$zona= $tienda->getZonasEntregaById($id_ciudad,$id_tienda);
		$options=array();
		if ($zona!=false) {
			foreach ($zona as $zon) {
				$options[$zon->id] = $zon->nombreZona;
			}
			$disable='';
		}else{
			$options=array();
			$disable='disabled="disabled"';
		}
		
		return form_dropdown('zona',$options,(($this->input->cookie('zona')!=false)?$this->input->cookie('zona'):''),'id=cmbx_zona class="element text medium" '.$disable);		
	}
	
	function cargarZonaAjax(){
		$tienda = new Tiendascomida();
		$zona= $tienda->getZonasEntregaById($this->input->post('id_ciudad'),$this->input->cookie('tienda'));
		$data['html_zona']='<option value="" selected="selected">Seleccione</option>;';
		if ($zona!=false) {
			foreach ($zona as $zon) {		
				$data['html_zona'] .= '<option value="'.$zon->id.'">'.$zon->nombreZona.'</option>';
			}
			$data['disable']=false;
			$data['zona']=true;
		}else{		
			$data['disable']=true;
			$data['zona']=false;
		}

		
		echo json_encode($data);
				
		}

		function cargarRadioPago() {
			$tipoPago = new Tipospago();
			$tipoPago->where('estatus',1)->get();
			$respuesta ='';
			if($tipoPago->exists()){
				foreach ($tipoPago as $tipo){
					$check=false;
					if ($tipo->id == $this->input->post('radio_tipo_pago')) {
						$check=true;
					}
					$respuesta .='<div>';				
					$respuesta .= form_radio('radio_tipo_pago', $tipo->id, $check,'id="'.$tipo->id.'-tipo_pago"');
					$respuesta .= form_label($tipo->nombre);
					$respuesta .= '</div>';
				}
				return $respuesta;
			}
			
		}
		
	function verificarExisteSesion() {
		if ($this->session->userdata('nombreusuario') === FALSE) {
			redirect('pedido/c_pedido_login');
		}else {
			return $this->session->userdata('id');
		}		
	}

	function getDataPartial($partial = '') {
		$output = '';
		switch ($partial) {
			case 'breadcrumb':
				$output = $this->c_busqueda->index();
				break;
			case 'header':
				$output = $this->load->helper('language');
				$this->load->helper('form');
				$this->load->helper('captcha');
				$this->load->library('qtip2');
				$this->load->library('form_validation');;
				break;
			case 'block':
				$output = Modules::run('autenticacion/c_login/cargarView');
		}

		return $output;
	}
}
?>
