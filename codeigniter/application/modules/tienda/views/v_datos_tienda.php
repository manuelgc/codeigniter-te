<script>
	$(function() {
		$( "#tabs_tienda" ).tabs();
	});
</script>



<div class="tienda">
<div >
	
</div>
<div id="tabs_tienda">
	<ul>
		<li><a href="#tab_menu">Menu</a></li>
		<li><a href="#tab_info">Informaci&oacute;n</a></li>
	</ul>
	<div id="tab_menu">
		<p></p>
	</div>
	<div id="tab_info">
		<span class="text">Direcci&oacute;n </span>
		<span class="text">Horarios </span>
		<!--		foreach para mostras todos los horarios-->
	</div>
</div>

</div>



<div style="display: none;" class="demo-description">
<p>Click tabs to swap between content that is broken into logical sections.</p>
</div><!-- End demo-description -->