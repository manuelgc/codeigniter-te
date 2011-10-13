<?php
class Ciudad extends DataMapper{
	var $table = 'ciudades';
	var $has_one= array(
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'ciudad')
	);
	var $has_many = array(
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'ciudad'),
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'ciudad',
			'join_self_as' => 'ciudades'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'ciudad',
			'join_self_as' => 'ciudades'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'ciudad',
			'join_self_as' => 'ciudades'));
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
	
	function getTiendasById($id_ciudad){
		$ciudad = new Ciudad();
		$ciudad->where('estatus',1)->get_by_id($id_ciudad);
		if($ciudad->exists()){
			$tienda =$ciudad->tiendascomida->where('estatus',1)->get();
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