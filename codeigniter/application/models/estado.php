<?php
class Estado extends DataMapper {
	var $table = 'estados';
	var $has_many = array(
	'ciudad',
	'direccionesenvio',
	'tiendascomida',
	'direccionesentrega');
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
	
	function getEstados($id = '') {
		$estado = new Estado();	
		$arrEstados = array();	
		if (empty($id)) {								
			$estado->get_iterated();
			foreach ($estado as $value) {
				$arrEstados[$value->id] = $value->nombreEstado;				
			}						
			return $arrEstados;
		}else {
			return $estado->get_by_id($id);
		}
	}
}
?>