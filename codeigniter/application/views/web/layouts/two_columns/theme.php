<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es-ES" xml:lang="es">
<head>
<?php
echo (isset($template['partials']['metadata'])) ? $template['partials']['metadata'] : '' ; 	
echo (isset($template['partials']['inc_css'])) ? $template['partials']['inc_css'] : '' ;
echo (isset($template['partials']['inc_js'])) ? $template['partials']['inc_js'] : '' ;
echo $template['metadata'];
?>
</head>
<body>
	<div class="art-main">
		<div class="art-sheet">
			<div class="art-sheet-tl"></div>
            <div class="art-sheet-tr"></div>
            <div class="art-sheet-bl"></div>
            <div class="art-sheet-br"></div>
            <div class="art-sheet-tc"></div>
            <div class="art-sheet-bc"></div>
            <div class="art-sheet-cl"></div>
            <div class="art-sheet-cr"></div>
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
            	<?php echo (isset($template['partials']['header'])) ? $template['partials']['header'] : '';?>
            	<div class="breadcrumb">
            		<?php echo (isset($template['partials']['breadcrumb'])) ? $template['partials']['breadcrumb'] : '';?>
            	</div>
            	<div class="art-content-layout">
            		<div class="art-content-layout-row">
            			<div class="art-layout-cell art-content">
            				<div class="art-post">
								<div class="art-post-tl"></div>
							    <div class="art-post-tr"></div>
							    <div class="art-post-bl"></div>
							    <div class="art-post-br"></div>
							    <div class="art-post-tc"></div>
							    <div class="art-post-bc"></div>
							    <div class="art-post-cl"></div>
							    <div class="art-post-cr"></div>
							    <div class="art-post-cc"></div>
							    <div class="art-post-body">
							    	<div class="art-post-inner art-article">
							    		<h2 class="art-postheader">Titulo</h2>
							    		<div class="art-postcontent">							    		
							    		<?php echo $template['body'];?>
							    		</div>
							    	</div>
							    	<div class="cleared"></div>
							    </div>
							</div>
            				<?php echo (isset($template['partials']['post'])) ? $template['partials']['post'] : '';?>
            			</div>
            			<div class="art-layout-cell art-sidebar1">
            				<?php echo (isset($template['partials']['menu'])) ? $template['partials']['menu'] : '';?>
            				<?php echo (isset($template['partials']['block'])) ? $template['partials']['block'] : '';?>
            			</div>
            		</div>
            	</div>
            	<div class="cleared"></div>
            	<?php echo (isset($template['partials']['footer'])) ? $template['partials']['footer'] : '';?>
            </div>
		</div>
		<div class="cleared"></div>
		<p class="art-page-footer">
					<?php echo isset($script_foot) ? $script_foot : ''; ?>
		</p>
	</div>
</body>
</html>