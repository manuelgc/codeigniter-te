<?php
class Tipotiendascomida extends DataMapper{ 	
var $table = 'tipotiendascomida';
	var $has_many = array(
	'tiendascomida'=> array(
						'class'=>'tiendascomida',
						'other_field' => 'tipotiendascomida',	
			            'join_self_as' => 'tipotiendascomida',	
			            'join_other_as' => 'tiendascomida',		
			            'join_table' => 'tiendascomida_tipotiendascomida')
	);
	
	function getTiendasById($id_tipoComida){
		$tipoComida = new Tipotiendascomida();
		$tipoComida->where('estatus',1)->get_by_id($id_tipoComida);
		if($tipoComida->exists()){
			$tienda =$tipoComida->tiendascomida->where('estatus',1)->get();
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
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}