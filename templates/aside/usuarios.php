<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header">Tuzobus App</li>
    <li><a href="<?=$TB->root;?>">Inicio</a></li>
    <li><a href="<?=$TB->root;?>usuarios">Lista de usuarios</a></li>
    <li><a href="#CU_form" data-toggle="modal">Crear usuario</a></li>
</ul>