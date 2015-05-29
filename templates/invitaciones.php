<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-envelope"></i> Invitaciones</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="invitaciones">
		<?php $TB->renderPartial('parts/table', true, $TB->invitations()); ?>
	</div>
<? elseif($TB->params[1]=='estaditicas'):?>

<?php endif; ?>
<div id="CU_form" class="modal hide fade">
	<form>
		<div class="modal-header">
			<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><span></span> invitación</h3>
		</div>
		<div class="modal-body">
			<div class="input-prepend">
				<span class="add-on"><i class="icon-key"></i></span>
				<input type="text" name="code" placeholder="Código de activación">
			</div>
		</div>
		<div class="modal-footer">
			<img src="img/ajax-loader.gif" class="loading">
			<button class="btn btn-primary">Guardar</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
		</div>
	</form>
</div>
<div id="delete" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Eliminar invitación</h3>
	</div>
	<div class="modal-body">
		<p>¿Estas seguro de que deseas eliminar la invitacion "<strong></strong>"?</p>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary deleteConfirmation" data-deleteId="" data-deleteTable="invitations">Aceptar</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>
</div>