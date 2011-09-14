<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Qtip2 {
	private $_selectorWrapper;
	private $_options = array();
	private $_ci;
	
	function __construct($tagContent = 'p') {
		$this->_selector = 'li';
		$this->_ci =& get_instance();
		$this->_options['content'] = "text: $(this).find('".$tagContent."')";
		$this->_options['position'] = "my: 'bottom left',at:'right top'";
		$this->_options['style'] = "classes: 'ui-tooltip-blue ui-tooltip-shadow'";
	}
	
	function addCssJs() {
		$this->_ci->template->prepend_metadata(link_tag(base_url().'application/views/web/layouts/two_columns/css/jquery.qtip.min.css'));
		$this->_ci->template->prepend_metadata(script_tag(base_url().'application/views/web/layouts/two_columns/js/jquery.qtip.min.js'));
	}
	
	function putTipDefault($param) {
		;
	}
	
	function putCustomTip($selectorWrapper = 'li', $selectorTarget = 'input',$selectorContent = '.guidelines') {
		$output = '';
		$output .= "$('".$selectorContent."').hide();";
		$output .= "$('".$selectorWrapper."').each(function(index){";
		$output .= "$($(this).find('".$selectorTarget."')).qtip({";
		foreach ($this->_options as $key => $value) {
			$output .= $key.":{".$value."},";
		}
		$output .= "})";
		$output .= "})";
		$this->_ci->javascript->output($output);
		$this->_ci->javascript->compile();
	}
}
?>