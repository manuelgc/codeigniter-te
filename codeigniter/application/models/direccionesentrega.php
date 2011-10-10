<?php
class Direccionesentrega extends DataMapper{ 
	var $table = 'direccionesentrega';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'direccionesentrega',
			'join_other_as' => 'tiendascomida',
			'join_self_as' => 'direccionesentrega'),
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'direccionesentrega',
			'join_other_as' => 'estados',
			'join_self_as' => 'direccionesentrega'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'direccionesentrega',
			'join_other_as' => 'ciudades',
			'join_self_as' => 'direccionesentrega'),
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'direccionesentrega',
			'join_other_as' => 'zonas',
			'join_self_as' => 'direccionesentrega')); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
	
	function getDirecionesByParam($campo = array()){
		$direciones=$this->where('estatus',1)->where($campo)->get();
		if($direciones->exists()){
			return $direciones;
		}else {
			return false;
		}
		
	}
	
	function getEstado(){
		$estado =$this->estado->where('estatus',1)->get();
			if($estado->exists()){
				return $estado;							
			}else{
				return false;	
			}
	}
	
	function getCiudad(){
		$ciudad =$this->ciudad->where('estatus',1)->get();
			if($ciudad->exists()){
				return $ciudad;							
			}else{
				return false;	
			}
	}
	
	function getZona(){
		$zona =$this->zona->where('estatus',1)->get();
			if($zona->exists()){
				return $zona;							
			}else{
				return false;	
			}
	}
}