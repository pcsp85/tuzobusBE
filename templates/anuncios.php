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
		<h3> anuncio</h3>
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
	</form>
</div>