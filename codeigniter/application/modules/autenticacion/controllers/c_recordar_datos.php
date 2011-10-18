<?php
class C_recordar_datos extends MX_Controller {
	private $config = array(
		array(
			'field'=>''
		)
	);
	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('qtip2');
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
		$this->template->build('v_recordar_datos');
	}
}
?>