<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>

<?php if(!isset($TB->search) || $TB->search==true):?>
	<form name="search" class="form-search">
		<div class="input-prepend">
			<span class="add-on"><i class="icon-large icon-search"></i></span>
			<input type="search" placeholder="Buscar">
		</div>
		<button class="btn">ir</button> <img src="<?=$TB->root;?>img/ajax-loader.gif" class="loading">
	</form>
<?php endif;?>
<div class="response">
<?php if($TB->treg>0): ?>
<p>Existen <strong><?=$TB->treg;?></strong> <?=$TB->name;?>, mostrando <strong><?=$TB->rpp;?></strong>, página <strong><?=$TB->npag;?></strong> de <strong><?=$TB->tpag;?></strong></p>
<table>
	<thead>
		<tr>
			<?php foreach ($TB->columns as $column): ?>
				<th><?=$column;?></th>
			<? endforeach;?>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php $nf=0; foreach ($TB->data as $field): ?>
		<tr data-row="<?=$nf;?>">
			<?php foreach ($field as $key => $value): ?>
				<td data-col="<?=$key;?>"><?=$value?></td>
			<?php endforeach;?>
			<td>
				<a href="<?=$TB->name;?>/<?=$field['id']?>" class="tip" data-original-title="Ver"><i class="icon-large icon-eye-open"></i></a>
				<a href="javaScript:TB.row_edit($(this).parent().siblings())" class="tip" data-original-title="Editar"><i class="icon-large icon-edit"></i></a>
				<a href="javaScript:TB.row_delete($(this).parent().siblings('td[data-col=id]'))" class="tip" data-original-title="Eliminar"><i class="icon-large icon-trash"></i></a>
			</td>
		</tr>
		<? $nf++; endforeach;?>
	</tbody>
</table>
<?php else: ?>
<div class="text-center">
 <h3 class="error">No se encontaron resultados para la búsqueda</h3>
</div>
<?php endif; ?>
</div>

<div class="pagination <?=$TB->name;?>">
	<ul>
		<?php if($TB->npag>1):?><li><a href="1">&lt;&lt;</a></li><?php endif; ?>
		<?php for($i=1;$i<=$TB->tpag;$i++):?><li <?php if($i==$TB->npag) echo 'class="active"';?>><a href="<?=$i;?>"><?=$i;?></a></li><?php endfor;?>
		<?php if($TB->npag<$TB->tpag):?><li><a href="<?=$TB->tpag;?>">&gt;&gt;</a></li><?php endif; ?>
	</ul>
</div>
