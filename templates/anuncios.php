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
		<h3><i class="icon-picture"></i> <span></span> anuncio</h3>
	</div>
	<form>
		<input type="hidden" name="table" value="ads">
		<input type="hidden" name="action" value="">
	<div class="modal-body">
		<div class="span8">
			<div class="input-prepend">
				<span class="add-on span2"><i class="icon-large icon-tag"></i></span>
				<input class="form-control span10" type="text" name="title" placeholder="Titulo" required>
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
			<div class="btn-group input-prepend" data-toggle="buttons-radio">
				<span class="add-on">Publicar anuncio</span>
				<button class="btn publish active" data-pub="Si">Si</button>
				<button class="btn publish" data-pub="No">No</button>
				<input type="hidden" name="publish" value="Si">
			</div>
		</div>
		<div class="span4">
			<input type="file" name="image" style="display:none;">
			<div id="select_image">
				Da clic aquí para seleccionar o arrastra la imagen del anuncio
			</div>
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