<?php
class Zona extends DataMapper{ 	
	var $table = 'zonas';
	var $has_one= array('ciudad');
	var $has_many = array(
	'direccionesenvio',
	'tiendascomida',
	'direccionesentrega');
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
}