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
            'other_field' => 'ciudad'),
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'ciudad'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'ciudad'));
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
	
}
?>