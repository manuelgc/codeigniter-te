<?php
class Opcionesplato extends DataMapper{ 
	var $table = 'opcionesplato';

	var $has_one= array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'opcionesplato',
			'join_other_as' => 'platos',
			'join_self_as' => 'opcionesplato'));
	
	var $has_many = array(
	'opcionesdetalle'=> array(
            'class' => 'opcionesdetalle',
            'other_field' => 'opcionesplato',
			'join_self_as' => 'opcionesplato'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}

	function getOpcionesDetalle() {
		$detalles= $this->opcionesdetalle->where('estatus',1)->get();
		if ($detalles->exists()) {
			return $detalles;
		}else {
			return false;
		}
		
	}
	
	function getOpcionesDetalleById($id_opciones) {
		$opciones= new Opcionesplato();
		$opciones->where('estatus',1)->get_by_id($id_opciones);
		if ($opciones->exists()){
			$detalles= $opciones->opcionesdetalle->where('estatus',1)->get();
			if ($detalles->exists()) {
				return $detalles;
			}else {
				return false;
			}
		}else{
			return false;
		}
	}

}
?>