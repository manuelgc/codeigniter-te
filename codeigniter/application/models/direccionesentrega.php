<?php
class Direccionesentrega extends DataMapper{ 
	var $table = 'direccionesentrega';
	var $has_one= array(
	'tiendascomida'=> array(
            'class' => 'tiendascomida',
            'other_field' => 'direccionesentrega'),
	'zona'=> array(
            'class' => 'zona',
            'other_field' => 'direccionesentrega'),
	'ciudad'=> array(
            'class' => 'ciudad',
            'other_field' => 'direccionesentrega'),
	'estado'=> array(
            'class' => 'estado',
            'other_field' => 'direccionesentrega')); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}