<h1><i class="icon-envelope"></i> Invitaciones</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="invitaciones">
		<?php $TB->renderPartial('parts/table', true, $TB->invitations()); ?>
	</div>
<? elseif($TB->params[1]=='estaditicas'):?>

<?php endif; ?>
<div id="invitations_form" class="modal hide fade">
	<form>
		<div class="modal-header">
			<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Crear invitación</h3>
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