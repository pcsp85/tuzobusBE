<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-picture"></i> Anuncios</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="anuncios">
		<?php $TB->renderPartial('parts/table', true, $TB->ads());?> 
	</div>
<?php elseif(is_numeric($TB->params[1])): ?>
	vista de anuncio
<?php elseif($TB->params[1]=='estadisticas'): ?>

<?php endif; ?>
<div id="CU_form" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><span></span> anuncio</h3>
	</div>
	<form name="ads_form" class="">
	<div class="modal-body">
		<div class="input-prepend">
			<span class="add-on span2"><i class="icon-large icon-tag"></i></span>
			<input class="form-control span10" type="text" name="title" placeholder="Titulo" required>
		</div>
		<div class="input-prepend">
			<span class="add-on span2"><i class="icon-large icon-picture"></i></span>
			<input class="form-control span10" type="text" name="select-image" placeholder="Selecciona o arrastra la imagen" readonly required>
			<div class="hide"><input type="file" name="image"></div>
		</div>
		<div class="input-prepend">
			<span class="add-on span2"><i class="icon-large icon-flag"></i></span>
			<input class="form-contol span10" type="text" name="href" placeholder="Link" required>
		</div>
		<div class="input-prepend">
			<span class="add-on span2"><i class="icon-large icon-calendar"></i></span>
			<input class="form-contol span10" type="date" name="begin_date" placeholder="Vigencia inicia" required>
		</div>
		<div class="input-prepend">
			<span class="add-on span2"><i class="icon-large icon-calendar"></i></span>
			<input class="form-contol span10" type="date" name="end_date" placeholder="Vigencia termina" required>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary">Guardar</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>
	</form>
</div>
<div id="delete" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Eliminar anuncio</h3>
	</div>
	<div class="modal-body">
		<p>¿Estas seguro de que deseas eliminar el anuncio "<strong></strong>"?</p>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary deleteConfirmation" data-deleteId="" data-deleteTable="ads">Aceptar</button>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
	</div>
</div>