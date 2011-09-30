<?php
class Tiposventa extends DataMapper{
	var $table = 'tiposventa';
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'tiposventa'),
	'tiendascomida'=> array(
						'class'=>'tiendascomida',
						'other_field' => 'tiposventa',		
			            'join_self_as' => 'tiposventa',		
			            'join_other_as' => 'tiendascomida',	
			            'join_table' => 'tiendascomida_tiposventa')
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function getTipoVenta() {
		$tipo_venta = new Tiposventa();
		$options = array();
		$tipo_venta->where('estatus',1);
		$tipo_venta->order_by('nombre','ASC');
		$iterador = $tipo_venta->get_iterated();
		if (!$iterador->exists()) {
			return FALSE;
		}else {
			foreach ($iterador as $value) {
				$options[$value->id] = $value->nombre;
			}
			return $options;
		}	
	}
	
	function getTiendasById($id_tipoVenta){
		$tipoVenta = new Tiposventa();
		$tipoVenta->where('estatus',1)->get_by_id($id_tipoVenta);
		if($tipoVenta->exists()){
			$tienda =$tipoVenta->tiendascomida->where('estatus',1)->get();
			if($tienda->exists()){
				return $tienda;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	function getTiendas(){
		$tienda =$this->tiendascomida->where('estatus',1)->get();
		if($tienda->exists()){
			return $tienda;
		}else{
			return false;
		}

	}
}	
?>