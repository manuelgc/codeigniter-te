<?php
class Direccionesentrega extends DataMapper{ 
	var $table = 'direccionesentrega';
	var $has_one= array(
	'tiendascomida',
	'zona',
	'ciudad',
	'estado'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}	
}