<?php
class Tiendascomida_tipotiendascomida extends DataMapper{
	var $table = 'tiendascomida_tipotiendascomida';
	var $has_one= array('tiendascomida','tipotiendascomida'); 
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}