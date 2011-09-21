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
            'other_field' => 'zona'),
	'direccionesentrega'=> array(
            'class' => 'direccionesentrega',
            'other_field' => 'zona'));
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
}