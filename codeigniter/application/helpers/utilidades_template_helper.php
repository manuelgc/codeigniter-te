<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('cargarTemplateDefault')) {
	function cargarTemplateDefault($data = NULL) {
		$CI =& get_instance();
		
		$posicion = array(
				'0' => 'metadata',
				'1' => 'inc_css',
				'2' => 'inc_js',
				'3' => 'header',				
				'4' => 'breadcrumb',
				'5' => 'post',
				'6' => 'menu',
				'7' => 'block',
				'8' => 'footer'
			);
		$ruta = array(
				'0' => 'web/layouts/two_columns/partials/metadata',
				'1' => 'web/layouts/two_columns/partials/inc_css',
				'2' => 'web/layouts/two_columns/partials/inc_js',
				'3' => 'web/layouts/two_columns/partials/header',				
				'4' => 'web/layouts/two_columns/partials/breadcrumb',
				'5' => 'web/layouts/two_columns/partials/post',
				'6' => 'web/layouts/two_columns/partials/menu',
				'7' => 'web/layouts/two_columns/partials/block',
				'8' => 'web/layouts/two_columns/partials/footer',
		);
		
		if (empty($data)) {
			for ($i = 0; $i < count($posicion); $i++) {
				$CI->template->set_partial($posicion[$i],$ruta[$i]);
			}
		}else {
			for ($i = 0; $i < count($posicion); $i++) {
				$CI->template->set_partial($posicion[$i],$ruta[$i],$data);
			}
		}

		$CI->template->set_layout('two_columns/theme');
	}
}

if (! function_exists('cargarPartials')) {
	function cargarPartials($arregloPartials, $layout = 'two_columns/theme', $data = NULL) {
		$CI =& get_instance();
		
		$posicion = array(
				'0' => 'metadata',
				'1' => 'inc_css',
				'2' => 'inc_js',
				'3' => 'header',				
				'4' => 'breadcrumb',
				'5' => 'post',
				'6' => 'menu',
				'7' => 'block',
				'8' => 'footer'
			);
		$ruta = array(
				'0' => 'web/layouts/two_columns/partials/metadata',
				'1' => 'web/layouts/two_columns/partials/inc_css',
				'2' => 'web/layouts/two_columns/partials/inc_js',
				'3' => 'web/layouts/two_columns/partials/header',				
				'4' => 'web/layouts/two_columns/partials/breadcrumb',
				'5' => 'web/layouts/two_columns/partials/post',
				'6' => 'web/layouts/two_columns/partials/menu',
				'7' => 'web/layouts/two_columns/partials/block',
				'8' => 'web/layouts/two_columns/partials/footer',
		);
		
		if (empty($data)) {			
			for ($i = 0; $i < count($arregloPartials); $i++) {				
				if ($arregloPartials[$i] == $i) {
					$CI->template->set_partial($posicion[$i],$ruta[$i]);
				}				
			}			
		}else {			
			for ($i = 0; $i < count($arregloPartials); $i++) {
				if ($arregloPartials[$i] == $i) {
					$CI->template->set_partial($posicion[$i],$ruta[$i],$data);
				}
			}			
		}
		
		$CI->template->set_layout($layout);
	}
}

if (! function_exists('noCargarPartials')) {
	function noCargarPartials($noArregloPartials, $layout = 'two_columns/theme', $data = NULL) {
		$CI =& get_instance();
		
		$posicion = array(
				'0' => 'metadata',
				'1' => 'inc_css',
				'2' => 'inc_js',
				'3' => 'header',				
				'4' => 'breadcrumb',
				'5' => 'post',
				'6' => 'menu',
				'7' => 'block',
				'8' => 'footer'
			);
		$ruta = array(
				'0' => 'web/layouts/two_columns/partials/metadata',
				'1' => 'web/layouts/two_columns/partials/inc_css',
				'2' => 'web/layouts/two_columns/partials/inc_js',
				'3' => 'web/layouts/two_columns/partials/header',				
				'4' => 'web/layouts/two_columns/partials/breadcrumb',
				'5' => 'web/layouts/two_columns/partials/post',
				'6' => 'web/layouts/two_columns/partials/menu',
				'7' => 'web/layouts/two_columns/partials/block',
				'8' => 'web/layouts/two_columns/partials/footer',
		);
		
		if (empty($data)) {
			for ($i = 0; $i < count($posicion); $i++) {
				if ($noArregloPartials[$i] != $i) {
					$CI->template->set_partial($posicion[$i],$ruta[$i]);
				}
			}
		}else {
			for ($i = 0; $i < count($posicion); $i++) {
				if ($noArregloPartials[$i] != $i) {
					$CI->template->set_partial($posicion[$i],$ruta[$i],$data);
				}
			}
		}
		
		$CI->template->set_layout($layout);
	}
}

if (! function_exists('script_tag')) {
	function script_tag($src = '', $type = 'text/javascript') {		
		$script = '<script ';
		$script .= 'src='.$src.' ';
		$script .= 'type='.$type;
		$script .= '></script>';
		return $script;
	}	
}
?>