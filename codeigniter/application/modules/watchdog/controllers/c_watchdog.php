<?php
class C_watchdog extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('watchdog');
	}
	
	function setWatchdog($descripcion, $tipoAviso) {
		if (!empty($descripcion) && !empty($tipoAviso)) {
			$w = new Watchdog();
			$w->descripcion = $descripcion;			
		};
	}
}
?>