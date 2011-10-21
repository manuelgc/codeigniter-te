<?php
class Recordardato extends DataMapper {
	var $table = 'recordardatos';
	
	function __construct() {
		parent::__construct();		
	}
	
	function getRdPorParam($correo,$tiempo) {
		$rd = new Recordardato();
		$rd->where('correo',$correo);
		$rd->where('tiempo >=',date('H:i:s',$tiempo));
		$rd->get();
		if (!$rd->exists()) {
			$rd->delete_all();
			return FALSE;
		}else {
			return $rd;
		}
	}
	
	function setRecordarDato($correo) {
		$rd = new Recordardato();
		$rd->where('correo',$correo)->get();
		$rd->check_last_query();		
		if ($rd->exists()) {
			$rd->where('tiempo <= DATE_SUB(CURDATE(),INTERVAL 2 HOUR_SECOND)')->order_by('tiempo','desc')->get();
			$rd->check_last_query();			
			if ($rd->exists()) {
				return $rd;
			}else {
				$rd->delete_all();
				$rd->correo = $correo;
				$rd->string = sha1($correo);				
				$rd->tiempo = date('Y:m:d:H:i:s',now()+(60*60*2));
				if ($rd->save()) {
					return $rd->string;
				}else {
					return FALSE;
				}
			}
		}else {
			$rd->correo = $correo;
			$rd->string = sha1($correo);			
			$rd->tiempo = date('Y:m:d:H:i:s',now()+(60*60*2));
			if ($rd->save()) {
				return $rd->string;
			}else {
				return FALSE;
			}
		}				
	}
}
?>