<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header">Tuzobus App</li>
    <li><a href="<?=$TB->root;?>">Inicio</a></li>
    <li><a href="<?=$TB->root;?>anuncios">Lista de anuncios</a></li>
    <li><a href="#CU_form" data-toggle="modal" class="create">Crear anuncio</a></li>
    <li><a href="<?=$TB->root;?>anuncios/estadisticas">Estadísticas</a></li>
</ul>