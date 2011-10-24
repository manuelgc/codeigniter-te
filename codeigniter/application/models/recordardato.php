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
		if (!$rd->exists()) {
			$rd->correo = $correo;
			$rd->string = sha1($correo);				
			$rd->tiempo = date('Y:m:d:H:i:s',now()+(60*60*2));
			if ($rd->save()) {
				return $rd;
			}else {
				return FALSE;
			}
		}else {
			$rd->query('select 1 AS diferencia_tiempo
						FROM (`recordardatos`) 
						where 
						correo = "'.$correo.'" and 
						timediff(`recordardatos`.`tiempo`, now()) > "00:00:00"');
					
			if ($rd->diferencia_tiempo == '1') {
				$rd->where('correo',$correo)->get();				
				return $rd;
			}else {
				$rd->where('correo',$correo)->get();				
				$rd->delete();
				$rd->correo = $correo;
				$rd->string = sha1($correo);				
				$rd->tiempo = date('Y:m:d:H:i:s',now()+(60*60*2));
				if ($rd->save()) {
					return $rd;
				}else {
					return FALSE;
				}
			}	
		}
	}
}
?>