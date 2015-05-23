<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1>Bienvenido <?=$_SESSION['name'];?></h1>
<p>Este es el Backend para gestionar la fuente de datos que alimenta a Tuzobús App</p>
<div class="row-fluid">
	<div class="span4 well">
		<h2><i class="icon-envelope"></i> Invitaciones</h2>
		<p>El módulo para validación de invitaciones esta configurado para verificar los códigos en el siguiente rango de fechas:</p>
		<a href="#save_dates" class="btn btn-primary pull-right" data-toggle="modal">Ajustar fechas</a>
		<ul>
			<li> Inicio: <strong id="begin_date"><?=$TB->get_option('begin_date');?></strong></li>
			<li> Fin: <strong id="end_date"><?=$TB->get_option('end_date');?></strong></li>
		</ul>
		<p>Debes tener en cuenta las siguientes observaciones:</p>
		<ul>
			<li>Antes del rango no se podrá accesar a la app.</li>
			<li>Durante el periódo se validará que el código ingresado se encuentre disponible.</li>
			<li>Después del rango de fecha se validará el acceso sin ingresar códigos</li>
		</ul>
		<div id="save_dates" class="modal hide fade">
		  <form>
			<div class="modal-header">
				<button class="close" data-dismiss="modal" aria-hideden="true">&times;</button>
				<h3>Periódo de pruebas para Tuzobús App</h3>
			</div>
			<div class="modal-body">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-calendar"></i></span>
					<input type="date" name="begin_date" value="<?=$TB->get_option('begin_date');?>">
				</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-calendar"></i></span>
					<input type="date" name="end_date" value="<?=$TB->get_option('end_date');?>">
				</div>
			</div>
			<div class="modal-footer">
				<img src="img/ajax-loader.gif" class="loading"> 
				<button class="btn btn-primary">Guardar</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
			</div>
		  </form>
		</div>
	</div>
	<div class="span4 well">
		<h2><i class="icon-picture"></i> Anuncios</h2>
		<p>Administrar los anuncios que se cargan en la App, cargará un máximo de 5 anuncios, en orden aleatorio, siempre y cuando se encuentre en el rango de fechas configurado y el estado sea "Publicado"</p>
		<p><strong>Resumen:</strong></p>
		<ul>
			<li>Anuncios publicados: <strong><?=$TB->num_ads('publish');?></strong></li>
			<li>Anuncios suspendidos: <strong><?=$TB->num_ads('no_publish');?></strong></li>
			<li>Total de anuncios: <strong><?=$TB->num_ads();?></strong></li>
		</ul>
		<a href="<?=$TB->root;?>anuncios" class="btn btn-primary pull-right">Administrar anuncios</a>
	</div>
	<div class="span4 well">
		<h2><i class="icon-user"></i> Usuarios</h2>
		<p>Este módulo gestiona los usuarios con acceso a Tuzobús Admin.</p>
		<p><strong>Resumen:</strong></p>
		<ul>
			<li>Usuarios: <strong><?=$TB->num_users();?></strong></li>
		</ul>
		<a href="<?=$TB->root;?>usuarios" class="btn btn-primary pull-right">Administrar usuarios</a>
	</div>
</div>
<div class="row-fluid stores">
	<div class="span6 well">
		<form>
			<fieldset>
				<legend><img src="img/google_play_icon.png"> Android</legend>
				<input type="hidden" name="so" value="Android">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-shopping-cart"></i></span>
					<input type="text" class="span11" name="store" value="<?=$TB->get_option('Android_store');?>" placeholder="Google Play" required>
				</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-star"></i></span>
					<input type="text" class="span11" name="rank" value="<?=$TB->get_option('Android_rank');?>" placeholder="Calificar App" required>
				</div>
				<button class="btn btn-primary pull-right">Guardar</button>
				<img src="img/ajax-loader.gif" class="loading pull-right"> 
			</fieldset>
		</form>
	</div>
	<div class="span6 well">
		<form>
			<fieldset>
				<legend><img src="img/apple.png"> IOS</legend>
				<input type="hidden" name="so" value="iOS">
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-shopping-cart"></i></span>
					<input type="text" class="span11" name="store" value="<?=$TB->get_option('iOS_store');?>" placeholder="iOS Store" required>
				</div>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-large icon-star"></i></span>
					<input type="text" class="span11" name="rank" value="<?=$TB->get_option('iOS_rank');?>" placeholder="Calificar App" required>
				</div>
				<button class="btn btn-primary pull-right">Guardar</button>
				<img src="img/ajax-loader.gif" class="loading pull-right"> 
			</fieldset>
		</form>
	</div>
</div>
