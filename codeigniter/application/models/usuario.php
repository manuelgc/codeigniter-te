<?php
class Usuario extends DataMapper {
	var $table = 'usuarios';
	var $has_one = array(
	'tipousuario'=> array(
            'class' => 'tipousuario',
            'other_field' => 'usuario',
			'join_other_as' => 'tipousuarios')
	);
	var $has_many = array(
	'pedido'=> array(
            'class' => 'pedido',
            'other_field' => 'usuario'),
	'favoritosusuario'=> array(
            'class' => 'favoritosusuario',
            'other_field' => 'usuario'),
	'calificacionesproducto'=> array(
            'class' => 'calificacionesproducto',
            'other_field' => 'usuario'),
	'calificacionestienda'=> array(
            'class' => 'calificacionestienda',
            'other_field' => 'usuario'),
	'direccionesenvio'=> array(
						'class'=>'direccionesenvio',
						'other_field' => 'usuario',				
			            'join_other_as' => 'direccionesenvio',
						'join_self_as' => 'usuarios')
	
	);
	
	function __construct($id = NULL) {
		parent::__construct($id);
	}
	
	function getUsuarioLogueoAdmin($usuario_email = '',$contrasena = '',$campo_busqueda = 'nombreusuario') {
		$u = new Usuario();
		
		$u->where($campo_busqueda,$usuario_email);
		$u->where('password',md5($contrasena));
		$u->where('estatus',1)->get();
		
		if ($u->exists()) {
			return $u;
		}else {
			return FALSE;
		}
	}
	
	function getUsuarioLogueo($usuario_email = '',$contrasena = '',$tipo_usuario,$campo_busqueda = 'nombreusuario') {
		$u = new Usuario();
		$tipusuario = new Tipousuario();
		
		$u->where($campo_busqueda,$usuario_email);
		$u->where('password',md5($contrasena));
		$u->where('estatus',1);			

		$tipusuario->where('estatus',1);
		$tipusuario->where('id',$tipo_usuario);
		
		$u->get();
		$tipusuario->get();
				
		if ($u->exists()) {			
			if ($u->tipousuarios_id == $tipusuario->id) {
				return $u;
			}else {
				return 1;
			}			
		}else{
			return FALSE;
		}
	}
	
	function buscarPorNombreUsuario($nombre_usuario) {
		$usuario = new Usuario();
		$usuario->where('nombreusuario',$nombre_usuario)->get();			
		return $usuario->exists();
	}
	
	function buscarPorCorreo($correo) {
		$u = new Usuario();
		$u->where('estatus',1);
		$u->where('correo',$correo)->get();
		if (!$u->exists()) {
			return FALSE;
		}else {
			return $u;
		}
	}
	
	function getUsuarioById($id_usuario) {
		$usuario = new Usuario();
		$usuario->where('id',$id_usuario);
		$usuario->where('estatus',1);
		$usuario->get();
		if (!$usuario->exists()) {
			return FALSE;
		}else {
			return $usuario;
		}
	}
	
	function getTipoUsuarioById($id_usuario) {
		$u = new Usuario();
		$u->where('estatus',1);
		$u->where('id',$id_usuario);
		$u->get();
		$tipo_usuario = $u->tipousuario->where('estatus',1)->get();		
		return $tipo_usuario->nombre;
	}
	
	function getDireccionesEnvio($id_usuario) {
		$u = new Usuario();
		$resultadoDireccion = array();
		$contador = 0;
		$u->where('id',$id_usuario);
		$u->where('estatus',1);
		$u->get();		
		$u->direccionesenvio->where('estatus',1)->get();		
		foreach ($u->direccionesenvio as $valor) {
			$resultadoDireccion[$contador]['calle_carrera'] = $valor->calle_carrera;
			$resultadoDireccion[$contador]['casa_urb'] = $valor->casa_urb;
			$resultadoDireccion[$contador]['numeroCasaApto'] = $valor->numeroCasaApto;
			$resultadoDireccion[$contador]['lugarreferencia'] = $valor->lugarreferencia;
			$resultadoDireccion[$contador]['estado'] = $valor->estado->where('estatus',1)->get()->nombreEstado;
			$resultadoDireccion[$contador]['ciudad'] = $valor->ciudad->where('estatus',1)->get()->nombreCiudad;
			$resultadoDireccion[$contador]['zona'] = $valor->zona->where('estatus',1)->get()->nombreZona;
			$resultadoDireccion[$contador]['id'] = $valor->id;
			$contador++;									
		}									
		return $resultadoDireccion;
	}
	
	function getDireccionesEnvioId($id_usuario) {
		$u = new Usuario();
		$resultadoDireccion = array();
		$contador = 0;
		$u->where('id',$id_usuario);
		$u->where('estatus',1);
		$u->get();		
		$u->direccionesenvio->where('estatus',1)->get();		
		foreach ($u->direccionesenvio as $valor) {
			$resultadoDireccion[$contador]['calle_carrera'] = $valor->calle_carrera;
			$resultadoDireccion[$contador]['casa_urb'] = $valor->casa_urb;
			$resultadoDireccion[$contador]['numeroCasaApto'] = $valor->numeroCasaApto;
			$resultadoDireccion[$contador]['lugarreferencia'] = $valor->lugarreferencia;
			$resultadoDireccion[$contador]['estado'] = $valor->estado->where('estatus',1)->get()->id;
			$resultadoDireccion[$contador]['ciudad'] = $valor->ciudad->where('estatus',1)->get()->id;
			$resultadoDireccion[$contador]['zona'] = $valor->zona->where('estatus',1)->get()->id;
			$resultadoDireccion[$contador]['id'] = $valor->id;
			$contador++;									
		}									
		return $resultadoDireccion;
	}
	
	function getDireccionesEnvioByZona($id_usuario,$id_ciudad,$id_zona) {
		$u = new Usuario();
		$resultadoDireccion = array();
		$contador = 0;
		$u->where('id',$id_usuario);
		$u->where('estatus',1);
		$u->get();
		$direciones= $u->direccionesenvio
		->where('estatus',1)
		->where('ciudades_id',$id_ciudad)
		->where('zona_id',$id_zona)->get();
		foreach ($direciones as $valor) {
			$resultadoDireccion[$contador]['calle_carrera'] = $valor->calle_carrera;
			$resultadoDireccion[$contador]['casa_urb'] = $valor->casa_urb;
			$resultadoDireccion[$contador]['numeroCasaApto'] = $valor->numeroCasaApto;
			$resultadoDireccion[$contador]['lugarreferencia'] = $valor->lugarreferencia;
			$resultadoDireccion[$contador]['estado'] = $valor->estado->where('estatus',1)->get()->nombreEstado;
			$resultadoDireccion[$contador]['ciudad'] = $valor->ciudad->where('estatus',1)->get()->nombreCiudad;
			$resultadoDireccion[$contador]['zona'] = $valor->zona->where('estatus',1)->get()->nombreZona;
			$resultadoDireccion[$contador]['id'] = $valor->id;
			$contador++;
		}
		return $resultadoDireccion;
	}
}
?>