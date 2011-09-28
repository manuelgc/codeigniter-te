<?php
class C_datos_usuario extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('language');
	}
	
	function index() {
		$this->template->append_metadata(link_tag(base_url().'/application/views/web/layouts/two_columns/css/jquery-ui-1.8.16.custom.css'));
		$this->template->append_metadata(script_tag(base_url().'/application/views/web/layouts/two_columns/js/jquery-ui-1.8.16.custom.min.js'));

		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');
		//$this->template->set_partial('breadcrumb','web/layouts/two_columns/partials/breadcrumb');
		$this->template->set_partial('post','web/layouts/two_columns/partials/post');
		$this->template->set_partial('menu','web/layouts/two_columns/partials/menu');
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');
		$this->template->build('v_datos_cliente');
	}
	
	function getDataPartial($partial = '') {
		switch ($partial) {
			case 'breadcrumb':
			//algo;
			break;						
		}
		
		return $data;
	}
}
?>