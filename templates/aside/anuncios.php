<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header">Tuzobus App</li>
    <li><a href="<?=$TB->root;?>">Inicio</a></li>
    <li><a href="<?=$TB->root;?>anuncios">Ver anuncios</a></li>
    <li><a href="<?=$TB->root;?>anuncios/create">Crer anuncio</a></li>
    <li><a href="<?=$TB->root;?>anuncios/stats">Estadísticas</a></li>
</ul>