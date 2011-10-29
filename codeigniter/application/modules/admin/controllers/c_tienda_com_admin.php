<?php
class C_tienda_com_admin extends MX_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->library('qtip2');
		
		$this->qtip2->addCssJs();
		$this->qtip2->putCustomTip();
		$data['output_menu'] = Modules::run('admin/c_menu_admin/index');
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/view.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/demo-page.css'));
		$this->template->append_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/demo-table.css'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/view.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.blockUI.js'));		
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));
		$this->template->append_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.dataTables.min.js'));
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu',$data);		
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
	}
	
	function index() {
		$data['ciudades'] = $this->cargarCiudad();
		$this->template->build('v_tienda_com_admin',$data);
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