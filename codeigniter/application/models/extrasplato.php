<?php
class Extrasplato extends DataMapper{ 
	var $table = 'extrasplato';
	var $has_one= array('tiendascomida'); 
	var $has_many = array(
	'imagen',
	'extrasplato_pedido');
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}