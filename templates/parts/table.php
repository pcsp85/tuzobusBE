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
<?php if($TB->treg>0): ?>
<p>Existen <strong><?=$TB->treg;?></strong> <?=$TB->name;?>, mostrando <strong><?=$TB->rpp;?></strong>, página <strong><?=$TB->npag;?></strong> de <strong><?=$TB->tpag;?></strong></p>
<table>
	<thead>
		<tr>
			<?php foreach ($TB->columns as $column): ?>
				<th><?=$column;?></th>
			<? endforeach;?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($TB->data as $field): ?>
		<tr>
			<?php foreach ($field as $key => $value): ?>
				<td><?=$value?></td>
			<?php endforeach;?>
		</tr>
		<? endforeach;?>
	</tbody>
</table>
<div class="pagination <?=$TB->name;?>">
	<ul>
		<?php if($TB->npag>1):?><li><a href="1">&lt;&lt;</a></li><?php endif; ?>
		<?php for($i=$TB->npag;$i<=$TB->tpag;$i++):?><li><a href="<?=$i;?>"><?=$i;?></a></li><?php endfor;?>
		<?php if($TB->npag<$TB->tpag):?><li><a href="<?=$TB->tpag;?>">&gt;&gt;</a></li><?php endif; ?>
	</ul>
</div>
<?php else: ?>
<div class="text-center">
 <h3>No se encontaron resultados para la búsqueda</h3>
</div>
<?php endif; ?>