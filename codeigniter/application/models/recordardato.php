<?php
class Recordardato extends DataMapper {
	var $table = 'recordardatos';
	
	function __construct() {
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	function setRecordarDato($correo) {
		$rd = new Recordardato();
		$rd->correo = $correo;
		$rd->string = $correo;
		$rd->tiempo = date('H:i:s',time()+(60*60*2));
		if ($rd->save()) {
			return $rd->string;
		}else {
			return FALSE;
		}
	}
}
?>