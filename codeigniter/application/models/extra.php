<?php
class Extra extends DataMapper{ 
	var $table = 'extras';
	
	var $has_one= array(
	'plato'=> array(
            'class' => 'plato',
            'other_field' => 'extra',
			'join_other_as' => 'platos',
			'join_self_as' => 'extra')); 
	
	var $has_many = array(
	'extrasdetalle'=> array(
            'class' => 'extrasdetalle',
            'other_field' => 'extra',
			'join_self_as' => 'extras'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function getExtrasDetalle() {
		$detalles= $this->extrasdetalle->where('estatus',1)->get();
		if ($detalles->exists()) {
			return $detalles;
		}else {
			return false;
		}
		
	}
	
	function getExtrasDetalleById($id_extra) {
		$extra= new Extra();
		$extra->where('estatus',1)->get_by_id($id_extra);
		if ($extra->exists()){
			$detalles= $extra->extrasdetalle->where('estatus',1)->get();
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