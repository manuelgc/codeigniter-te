<?php
class Tiendascomida_tiposventa extends DataMapper{	
	var $table = 'tiendascomida_tiposventa';
	var $has_one= array('tiendascomida','tiposventa'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}
?>