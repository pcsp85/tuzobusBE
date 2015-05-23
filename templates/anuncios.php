<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-picture"></i> Anuncios</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="anuncios">
		<?php $TB->renderPartial('parts/table', true, $TB->ads());?> 
	</div>
<?php elseif($TB->params[1]=='create' || $TB->params[1]=='update'): ?>
	<form name="ads_form">

	</form>
<?php elseif($TB->params[1]=='estadisticas'): ?>

<?php endif; ?>