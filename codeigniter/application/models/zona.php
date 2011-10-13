<?php
class Zona extends DataMapper{ 	
	var $table = 'zonas';
	var $has_one= array(
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'zona')
	);
	var $has_many = array(
	'direccionesenvio'=> array(
            'class' => 'direccionesenvio',
            'other_field' => 'zona'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'zona',
			'join_self_as' => 'zonas'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'zona',
			'join_self_as' => 'zonas'));
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
	
	function getTiendasById($id_zona){
		$zona = new Zona();
		$zona->where('estatus',1)->get_by_id($id_zona);
		if($zona->exists()){
			$tienda =$zona->tiendascomida->where('estatus',1)->get();
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