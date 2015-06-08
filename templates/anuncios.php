<?php if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1><i class="icon-picture"></i> Anuncios</h1>
<?php if(!isset($TB->params[1])): ?>
	<div class="anuncios">
		<?php $TB->renderPartial('parts/table', true, $TB->ads());?> 
	</div>
<?php elseif(is_numeric($TB->params[1])): $ad = $TB->getItem('ads',$TB->params[1]);
if(is_object($ad)):?>

<div class="row-fluid">
	<div class="span6 left">
		<h3>Información</h3>
		<table>
			<tr><th>Título</th><td><?=$ad->title;?></td></tr>
			<tr><th>Imagen</th><td><?=$ad->image;?></td></tr>
			<tr><th>Destino</th><td><?=$ad->href;?></td></tr>
			<tr><th>Vigencia inicia</th><td><?=$ad->begin_date;?></td></tr>
			<tr><th>Vigencia termina</th><td><?=$ad->end_date;?></td></tr>
			<tr><th>Vigencia termina</th><td><?=$ad->end_date;?></td></tr>
			<tr><th>Publicado</th><td><?=$ad->publish==1? 'Si': 'No';?></td></tr>
		</table>
	</div>
	<div class="span6 pull-left">
		<h3>Vista previa</h3>
		<div class="ads_view">
			<div class="span12">
				<h1>Recomendacion para ti</h1>
				<div class="span 12">
					<?=$ad->title;?>
					<img src="<?=$ad->image;?>">
				</div>
			</div>
		</div>
	</div>
</div>
<?php else: echo $ad;
	 endif;
elseif($TB->params[1]=='estadisticas'): ?>

<?php endif; ?>
<div id="CU_form" class="modal hide fade">
	<div class="modal-header">
		<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><i class="icon-picture"></i> <span></span> anuncio</h3>
	</div>
	<form>
		<input type="hidden" name="table" value="ads">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="id" value="">
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