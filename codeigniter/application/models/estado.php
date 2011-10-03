<?php
class Estado extends DataMapper {
	var $table = 'estados';
	var $has_many = array(
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'estado'),
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'estado'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'estado',
			'join_self_as' => 'estados'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'estado'));
	
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