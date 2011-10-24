<p>Hemos recibido una solicitud para recuperar tu contrasena.</p>
<p>A traves del siguiente enlace podras ingresar una nueva contrasena, este enlace 
es temporal y caducara a las <?php echo date('H:i:s',$tiempo);?></p>
<p><?php echo anchor('autenticacion/c_nueva_contrasena/'.$vinculo.'/'.$id,'Recordar Contrasena');?></p>
