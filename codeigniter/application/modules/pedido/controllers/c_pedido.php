<?php class c_pedido extends MX_Controller {
		
	function __construct(){
		parent::__construct();
		$this->load->library('cart'); 
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->library('qtip2');
		$this->load->module('busqueda/c_busqueda');
		$this->load->module('carrito/c_carrito');
	}

	function index() {
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
//		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.cookie.js'));
		
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
		
		$data['ciudad']=form_label('Ciudad', 'cmbx_ciudad').$this->cargarCiudad(1);
		$data['zona']= form_label('Zona', 'cmbx_zona').$this->cargarZona(1, '');
		$data['radio_pago']=$this->cargarRadioPago();
		$this->template->build('pedido/v_pedido',$data);
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
		$zona= $tienda->getZonasEntregaById($this->input->post('id_ciudad'),$this->input->post('id_tienda'));
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
		
}
?>		
