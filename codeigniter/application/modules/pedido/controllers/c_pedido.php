<?php class c_pedido extends MX_Controller {
		
	function __construct(){
		parent::__construct();
		$this->load->library('cart'); 
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->library('qtip2');
		$this->load->module('busqueda/c_busqueda');
		$this->load->module('carrito/c_carrito');
		$this->id_usuario = $this->verificarExisteSesion();
	}

	function index() {
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.blockUI.js'));
		
//		$data['opcion_combos'] = $this->getDataPartial('breadcrumb');
		
//		if($this->input->post('id_tienda')){
//			$data['output_block'] = $this->c_carrito->index($this->input->post('id_tienda'));
//		}
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
//		$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb',$data);
//		$this->template->set_partial('block','web/layouts/two_columns/partials/block',$data);
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
//		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
		
		if($this->input->cookie('tienda')!==false){
			$data['ciudad']=$this->cargarCiudad($this->input->cookie('tienda'));
			if($this->input->cookie('ciudad')!==false){
				$data['zona']= $this->cargarZona($this->input->cookie('tienda'),$this->input->cookie('ciudad'));
			}else{
				$data['zona']= $this->cargarZona($this->input->cookie('tienda'), '');
			}
			$data['radio_pago']=$this->cargarRadioPago();
			
			$data += $this->cargarDireciones();
				
			$this->template->build('pedido/v_pedido',$data);
		}
	}

	function cargarDireciones() {
		if ($this->input->cookie('ciudad')===false || $this->input->cookie('zona')===false) {
			$data["error_dir"]='Debe selecionar la ciudad y zona donde se encuentra';
		}else if($this->validarZona()){
			$data['dir_usuario']= $this->getDireccionesUsuario($this->input->cookie('ciudad'),$this->input->cookie('zona'));
			if(empty($data['dir_usuario'])){
				$data['error_dir']='No posee direcciones registradas en la Zona Seleccionada, Por favor seleccione otra zona o agregue una direcci&oacute;n';
			}
		}else {
			$data['error_dir']='No se pueden realizar envios en la Ciudad o Zona Seleccionada, Por favor selccione otra';
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
		}
		echo json_encode($dataAjax);
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
					$respuesta .='<div>';				
					$respuesta .= form_radio('radio_tipo_pago', $tipo->id, false,'id="'.$tipo->id.'-tipo_pago"');
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
		
}
?>		
