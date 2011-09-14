<?php
class Horariosdespacho extends DataMapper{
	var $table = 'horariosdespacho';
	var $has_one= array('tiendascomida'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}