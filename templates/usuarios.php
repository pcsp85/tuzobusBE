<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-user"></i> Usuarios</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="usuarios">
		<?php $TB->renderPartial('parts/table', true, $TB->users());?> 
	</div>
<?php elseif(is_numeric($TB->params[1])): $ad = $TB->getItem('ads',$TB->params[1]);
if(is_object($ad)):?>

<?php else: echo $ad;
	 endif;
elseif($TB->params[1]=='estadisticas'): ?>

<?php endif; ?>
<div id="CU_form" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><i class="icon-picture"></i> <span></span> usuario</h3>
	</div>
	<form>
		<div class="modal-body"></div>
		<div class="modal-footer"></div>
	</form>
</div>
<div id="delete" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Eliminar usuario</h3>
	</div>
	<div class="modal-body">
		<p>¿Estas seguro de que deseas eliminar el usuario "<strong></strong>"?</p>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary deleteConfirmation" data-deleteId="" data-deleteTable="users">Aceptar</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>
</div>