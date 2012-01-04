<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('getNombreImg')) {
	function getNombreImg($pathImg,$posicion_nombre = 4) {
		$arr_img = array();
		$arr_img = explode(DIRECTORY_SEPARATOR, $pathImg);
		return $arr_img[$posicion_nombre];
	};
}

if (! function_exists('getMimeTypeImg')) {
	function getMimeTypeImg($pathImg,$posicion_nombre = 4) {
		$arr_ext = array();
		$nombre_img = getNombreImg($pathImg);
		$arr_ext = explode('.',$nombre_img);
		
		switch (strtolower($arr_ext[1])) {
			case 'jpg':
				return 'image/jpeg';
			break;
			case 'png':
				return 'image/png';
			break;
			case 'gif':
				return 'image/gif';
			break;
		}
	};
}

if( ! function_exists('icon'))
{
	function icon($name, $alt = 'icon', $size = 16)
	{
		$alt = htmlspecialchars($alt);
		return '<img src="' . site_url("img/icon/$size/$name.png") . "\" width=\"$size\" height=\"$size\" alt=\"$alt\" />";
	} 
}