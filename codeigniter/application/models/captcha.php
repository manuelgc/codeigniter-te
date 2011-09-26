<?php
class Captcha extends DataMapper {
	var $table = 'captcha';
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
}
?>