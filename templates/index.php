<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<h1>Bienvenido <?=$_SESSION['name'];?></h1>
<p>Este es el Backend para gestionar la fuente de datos que alimenta a Tuzobús App</p>
<div class="row-fluid">
	<div class="span4 well">
		<h2><i class="icon-envelope"></i> Invitaciones</h2>
		<p>El módulo para validación de invitaciones esta configurado para verificar los códigos en el siguiente rango de fechas:</p>
		<button class="btn btn-primary pull-right">Ajustar fechas</button>
		<ul>
			<li> Inicio: </li>
			<li> Fin: </li>
		</ul>
		<p>Debes tener en cuenta las siguientes observaciones:</p>
		<ul>
			<li>Antes del rango no se podrá accesar a la app.</li>
			<li>Durante el periódo se validará que el código ingresado se encuentre disponible.</li>
			<li>Después del rango de fecha se validará el acceso sin ingresar códigos</li>
		</ul>
	</div>
	<div class="span4 well">
		<h2><i class="icon-picture"></i> Anuncios</h2>
		<p>Administrar los anuncios que se cargan en la App, cargará un máximo de 5 anuncios, en orden aleatorio, siempre y cuando se encuentre en el rango de fechas configurado y el estado sea "Publicado"</p>
		<p><strong>Resumen:</strong></p>
	</div>
	<div class="span4 well">
		<h2><i class="icon-user"></i> Usuarios</h2>
		<p>Este módulo gestiona los usuarios con acceso a este administrador.</p>
		<p><strong>Resumen:</strong></p>
		<ul>
			<li>Usuarios: </li>
		</ul> 
	</div>
</div>
<div class="row-fluid">
	<div class="well">
		<h2><i class="icon-road"></i> Configuración General</h2>
	</div>
</div>
