/**
 * Codigo para controlar los eventos en el formulario de platos
 */

function cargarFormulario(html,selector){
	window.setTimeout(function(){
		$(selector).html(html.formulario);
	},1000);
}

$(document).ready(function(){
	var id_tienda = '';
	var id_opcion_boton = 1;
	var id_opcion_detalle_boton = 1;
	var id_extra_boton = 1;
	var id_extra_detalle_boton = 1;
	var opciones = new Array();
	
	$('fieldset').collapse();
	
	$('img').live('click',function(e){		
		var li = $(this).parents('li:first');
		li.remove();		
	});
	
	$(':button').live('click', function(){
		var id_boton = $(this).attr('id');
		var opcion_extra = id_boton.substr(0,1);
		var general_detalle = id_boton.substr(2,1);
		var digit_boton = id_boton.substr(4);		
		
		if(opcion_extra == 'o' && general_detalle == 'g'){
			id_opcion_boton++;			
			$.ajax({
				url: 'c_plato_admin/mostrarFormOpcion',
				type:'POST',
				dataType : 'json',
				data : {id_opcion : id_opcion_boton,es_opcion : '1'},			
				success:function(data){				
					$('div#content_opciones').append(data.item_opcion);
					$('.guidelines').hide();
					$('li').each(
							function(index){
								$($(this).find('input')).qtip({
									content:{
										text: $(this).find('small')},
										position:{my: 'bottom left',at:'right top'},
										style:{classes: 'ui-tooltip-blue ui-tooltip-shadow'}
									});
								});	
					artButtonSetup("art-button");
					console.log(id_opcion_boton);
					$('fieldset#content_'+id_opcion_boton).collapse();
				}
			});					
		}else if(opcion_extra == 'o' && general_detalle == 'd'){
			
			$.ajax({
				url: 'c_plato_admin/mostrarFormOpcion',
				type:'POST',
				dataType : 'json',
				data : {id_opcion_detalle : id_opcion_detalle_boton,es_opcion : '0', id_opcion : digit_boton},			
				success:function(data){				
					$('fieldset#content_'+digit_boton+' ul').append(data.item_opcion_detalle);
					$('.guidelines').hide();
					$('li.li_op_detalle').each(
							function(index){
								$($(this).find('input')).qtip({
									content:{
										text: $(this).find('small')},
										position:{my: 'bottom left',at:'right top'},
										style:{classes: 'ui-tooltip-blue ui-tooltip-shadow'}
									});
								});	
				}
			});		
			id_opcion_detalle_boton++;
		}else if(opcion_extra == 'e' && general_detalle == 'g'){
			id_extra_boton++;			
			$.ajax({
				url: 'c_plato_admin/mostrarFormExtra',
				type:'POST',
				dataType : 'json',
				data : {id_extra : id_extra_boton,es_extra : '1'},			
				success:function(data){				
					$('div#content_extras').append(data.item_extra);
					$('.guidelines').hide();
					$('li').each(
							function(index){
								$($(this).find('input')).qtip({
									content:{
										text: $(this).find('small')},
										position:{my: 'bottom left',at:'right top'},
										style:{classes: 'ui-tooltip-blue ui-tooltip-shadow'}
									});
								});	
					artButtonSetup("art-button");
					console.log(id_extra_boton);
					$('fieldset#content_extra_'+id_extra_boton).collapse();
				}
			});	
		}else if(opcion_extra == 'e' && general_detalle == 'd'){
			$.ajax({
				url: 'c_plato_admin/mostrarFormExtra',
				type:'POST',
				dataType : 'json',
				data : {id_extra_detalle : id_extra_detalle_boton,es_extra : '0', id_extra : digit_boton},			
				success:function(data){				
					$('fieldset#content_extra_'+digit_boton+' ul').append(data.item_extra_detalle);
					$('.guidelines').hide();
					$('li.li_ext_detalle').each(
							function(index){
								$($(this).find('input')).qtip({
									content:{
										text: $(this).find('small')},
										position:{my: 'bottom left',at:'right top'},
										style:{classes: 'ui-tooltip-blue ui-tooltip-shadow'}
									});
								});	
				}
			});		
			id_extra_detalle_boton++;
		}		
	});		
	
	$('#popup').dialog({
		'autoOpen':false,
		width:800,
		title:'Tiendas',
		height: 600,
		modal:true,
		show:"blind",
		hide:"explode",
		buttons:{			
			'Cerrar' : function(){
				$(this).dialog('close');
			}
		},
		close: function(){
			$('#form-filtro-tiendas').each (function(){
				this.reset();
			});
		}	
	});

	$('#boton-catalogo').live('click',function(e){
		e.preventDefault();		
		$('#popup').dialog('open');
	});

	$('#ciudad_popup').live('change',function(e){						
		var id_ciudad = $(this).val();	
		
		if(id_ciudad != ''){
			$.post("c_tienda_com_admin/cargarZona",
					{'id_ciudad':id_ciudad},
					function(data){
						if(data.zona!='0'){
							$("#zona_popup").empty().append(data.zona).attr("disabled",false);
						}else{
							$("#zona_popup").empty().append('<option value="" >Seleccione</option>;').attr("disabled",true);
								alert("La ciudad seleccionada no tiene zonas registradas");
							}
					},
					'json'
				);
		}else{
				$("#zona").empty().append('<option value="">Seleccione</option>;').attr("disabled",true);
		}
	});	

	$('ul.link > li a').live('click', function(e){
		e.preventDefault();
		var vinculo = $(this).attr('href');
		 $.ajax({
			url: vinculo,
			type: 'GET',
			dataType: 'json',
			beforeSend: function(data){
				preCargador('.content-tiendas');
			},				
			success: function (data) {					
				cargarTablaTienda(data);
			}				
		});			
	});

	function preCargador(selector){
		$(selector).block({ //'.content-pedidos'
			message: 'Cargando ...'		
		});
	}

	function cargarTablaTienda(html){
		window.setTimeout( function(){
			$('div.content-tiendas').html(html.lista_ped);
			$('ul.link').html(html.link_pag);
		}, 1000);
	}

	$('input:checked').live('click',function(){
		var id_tienda_selec = $(this).val();
		$.ajax({
			url:'c_plato_admin/getTiendaById/',
			dataType:'json',
			type:'POST',
			data: {id_tienda : id_tienda_selec},
			success:function(data){	
				$('#id_tienda').val(data.id);
				$('#nombre_tienda').html(data.nombre);				
				$('#razon_social').html(data.razonsocial);
				$('#ci_rif').html(data.ci_rif);		
				$('label[for="id_tienda"]').hide();
			}
		});
		$('#popup').dialog('close');
	});
	
	$('#boton-catalogo-reset').live('click',function(){
		$('#form-filtro-tiendas').each (function(){
			this.reset();
		});
		$.ajax({
			url:'c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});
	
	$('#ciudad_popup').live('change',function(){
		if($('#ciudad_popup').val() != ''){
			var id_ciudad = $('#ciudad_popup').val(); 
		}
		if($('#zona_popup').val() != ''){
			var id_zona = $('#zona_popup').val(); 
		}
		$.ajax({
			url:'c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			data:{
				id_tienda : id_tienda ,
				id_ciudad : id_ciudad,
				id_zona : id_zona
			},
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});

	$('#zona_popup').live('change',function(){
		if($('#ciudad_popup').val() != ''){
			var id_ciudad = $('#ciudad_popup').val(); 
		}
		if($('#zona_popup').val() != ''){
			var id_zona = $('#zona_popup').val(); 
		}
		$.ajax({
			url:'c_tienda_com_admin/catalogoTienda/',
			dataType:'json',
			type:'POST',
			data:{
				id_tienda : id_tienda ,
				id_ciudad : id_ciudad,
				id_zona : id_zona
			},
			beforeSend:function(data){
				preCargador('.content-tiendas');
			},
			success:function(data){
				cargarTablaTienda(data);
			}
		});
	});
	
	$('#nombre_tienda_catalogo').live('keyup', function(){		
		$(this).autocomplete({
			source:function(req,resp){
				$.ajax({
					url:'c_tienda_com_admin/getNombreTiendas',
					dataType:'json',
					type:'POST',
					data:{term : req.term},
					success:function(data){
						resp($.map(data,function(item){	
							id_tienda = item.id;						
							return {
								value: item.label,
								label: item.label							
							}
						}));
					}					
				});
			},
			minLength: 2,
			select:function(event,ui){		
				if($('#ciudad_popup').val() != ''){
					var id_ciudad = $('#ciudad_popup').val(); 
				}
				if($('#zona_popup').val() != ''){
					var id_zona = $('#zona_popup').val(); 
				}
						
				$.ajax({
					url:'c_tienda_com_admin/catalogoTienda/',
					dataType:'json',
					type:'POST',
					data: { id_tienda : id_tienda ,
							id_ciudad : id_ciudad,
							id_zona : id_zona
						},
					beforeSend:function(data){
						preCargador('.content-tiendas');
					},
					success:function(data){
						cargarTablaTienda(data);
					}
				});
			}
		});
	});
	
	$("#form_plato_tienda_comida").formwizard({ 
		textNext : 'Siguiente',
		textBack : 'Atras',	 	
	 	validationEnabled: true,
	 	focusFirstInput : true,	 	
	 	validationOptions : {
	 		rules: {
	 			id_tienda : "required",
	 			nombre_plato : "required",
	 			precio : {
	 				required : true,
	 				number : true
	 			},
	 			descuento : {	 					 				
	 				maxlength : '2',
	 				digits : true
	 			},
	 			categoria_plato : "required",
	 			tipo_plato : "required",
	 			impuesto : "required"	 			
	 		},
	 		messages : {	 			
	 			id_tienda : "Debe seleccionar una tienda.",
	 			nombre_plato : "Indique un nombre para el plato",
	 			precio : {
	 				required : "Ingrese un precio para el plato",
	 				number : "El valor ingresado debe ser de tipo numerico"
	 			},
	 			descuento : {
	 				maxlength : "La longitud maxima para el descuento es de 2 digitos",
	 				digits : "Debe ingresar solo numeros para el campo descuento"
	 			},
	 			categoria_plato : "Seleccione una categoria para el plato",
	 			tipo_plato : "Seleccione un tipo de plato",
	 			impuesto : "Seleccione un tipo de impuesto"
	 		}
	 	}
	 }
	);		
			
});