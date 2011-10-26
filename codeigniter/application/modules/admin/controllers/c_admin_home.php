<?php
class C_admin_home extends MX_Controller {
	function __construct() {
		parent::__construct();
		
		$this->template->set_partial('metadata','web/layouts/two_columns/partials/metadata');
		$this->template->set_partial('inc_css','web/layouts/two_columns/partials/inc_css');
		$this->template->set_partial('inc_js','web/layouts/two_columns/partials/inc_js');		
		$this->template->set_partial('footer','web/layouts/two_columns/partials/footer');
		$this->template->set_layout('two_columns/theme');		
	}
	
	function index() {
		$this->template->build('v_admin_home');
	}
}
?>