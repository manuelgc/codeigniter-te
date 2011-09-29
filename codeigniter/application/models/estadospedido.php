<?php
class Estadospedido extends DataMapper{
	var $table = 'estadospedido';
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'estadospedido',
			'join_other_as' => 'estadopedido',
			'join_self_as' => 'estadopedido'));
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function getEstadosPedido() {
		$estados_ped = new Estadospedido();
		$arr_estados = array();
		$estados_ped->where('estatus',1);
		$estados_ped->order_by('nombre','ASC');
		$iterador = $estados_ped->get_iterated();
		if (!$iterador->exists()) {
			return FALSE;
		}else {
			foreach ($iterador as $value) {
				$arr_estados[$value->id] = $value->nombre;
			}
			return $arr_estados;
		}		
	}
}	
?>