<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header">Tuzobus App</li>
    <li><a href="<?=$TB->root;?>">Inicio</a></li>
    <li><a href="<?=$TB->root;?>invitaciones">Ver invitaciones</a></li>
    <li><a href="#CU_form" data-toggle="modal">Crear invitacion</a></li>
    <li><a href="<?=$TB->root;?>invitaciones/estaditicas">Estadísticas</a></li>
</ul>