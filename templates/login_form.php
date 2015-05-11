<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<div class="container">
    <form class="form-signin" method="post" action="<?=$TB->root;?>">

        <h2 class="form-signin-heading"><img src="<?=$TB->root;?>favicon.png"> Iniciar Sesión</h2>
    <?php if(count($TB->errors)>0): ?>
        <div class="alert alert-block">
            <ul>
                <?php foreach($TB->errors as $e): ?><li><?=$e;?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(count($TB->messages)>0): ?>
        <div class="alert alert-success alert-block">
            <ul>
                <?php foreach($TB->messages as $m): ?> <li><?=$m;?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(count($TB->login->errors)>0): ?>
        <div class="alert alert-block">
            <ul>
                <?php foreach($TB->login->errors as $e): ?><li><?=$e;?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(count($TB->login->messages)>0): ?>
        <div class="alert alert-success alert-block">
            <ul>
                <?php foreach($TB->login->messages as $m): ?> <li><?=$m;?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-envelope"></i></span>
            <input class="span3" type="text" name="user_name" placeholder="Usuario">
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-key"></i></span>
            <input class="span3" type="password" name="user_password" placeholder="Contraseña">
        </div>
        <button class="btn btn-large btn-primary" type="submit" name="login">Entrar</button>
    </form>
</div>
<!-- /container -->