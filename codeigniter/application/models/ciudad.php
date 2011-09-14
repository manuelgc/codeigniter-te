<?php
class Ciudad extends DataMapper{
	var $table = 'ciudades';
	var $has_one= array('estado');
	var $has_many = array(
	'zona',
	'direccionesenvio',
	'tiendascomida',
	'direccionesentrega');
	
	function __construct($id = NULL){
		parent::__construct($id);
	}
	
}
?>