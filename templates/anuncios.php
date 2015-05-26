<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-picture"></i> Anuncios</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="anuncios">
		<?php $TB->renderPartial('parts/table', true, $TB->ads());?> 
	</div>
<?php elseif($TB->params[1]=='create' || $TB->params[1]=='update'): ?>
	<form name="ads_form" class="">
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-tag"></i></span>
			<input class="form-control" type="text" name="title" placeholder="Titulo" required>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-picture"></i></span>
			<input class="form-control" type="text" name="select-image" placeholder="Selecciona o arrastra la imagen" readonly required>
			<div class="hide"><input type="file" name="image"></div>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-check"></i></span>
			<input class="form-contol" type="text" name="href" placeholder="Link" required>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-calendar"></i></span>
			<input class="form-contol" type="date" name="begin_date" placeholder="Vigencia inicia" required>
		</div>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-calendar"></i></span>
			<input class="form-contol" type="date" name="end_date" placeholder="Vigencia termina" required>
		</div>
	</form>
<?php elseif($TB->params[1]=='estadisticas'): ?>

<?php endif; ?>