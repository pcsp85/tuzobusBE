<?php
if(!defined('TuzobusApp')) die('Acceso negado'); ?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>TuzobusAdmin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="<?=$TB->root;?>favicon.ico" />

    <link rel="stylesheet" href="<?=$TB->root;?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=$TB->root;?>css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="<?=$TB->root;?>css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=$TB->root;?>css/main.css">

    <script src="<?=$TB->root;?>js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script type="text/javascript">
    var var_root = '<?=$TB->root;?>';
    </script>
</head>
<body>
<?php if($TB->login->isUserLoggedIn()): ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand"><!--img src="<?=$TB->root;?>favicon.png"--> TuzbusAdmin</span>

                <div class="nav-collapse collapse">

                    <ul class="nav">
                        <li <?php if($TB->params[0]=='index') echo 'class="active"';?>><a href="<?=$TB->root;?>"><i class="icon-home icon-black"></i> Inicio</a></li>

                        <!--li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                               class="icon-envelope icon-black"></i>
                                Invitaciones <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="./invitaciones/create">Crear código</a></li>
                                <li><a href="./invitaciones/">Ver códigos</a></li>
                                <li><a href="#">Codigos utilizados</a></li>
                            </ul>
                        </li-->

                        <li <?php if($TB->params[0]=='invitaciones') echo 'class="active"';?>><a href="<?=$TB->root;?>invitaciones"><i class="icon-envelope icon-black"></i>Invitaciones</a></li>
                        <li <?php if($TB->params[0]=='anuncios') echo 'class="active"';?>><a href="<?=$TB->root;?>anuncios"><i class="icon-picture icon-black"></i>Anuncios</a></li>
                        <li <?php if($TB->params[0]=='usuarios') echo 'class="active"';?>><a href="<?=$TB->root;?>usuarios"><i class="icon-user icon-black"></i>Usuarios</a></li>
                        <!--li><a href="#"><i class="icon-pencil icon-black"></i>Sample 2</a></li>
                        <li><a href="#"><i class="icon-file icon-black"></i>Sample 3</a></li-->

                    </ul>

                    <ul class="nav pull-right settings">
                        <li><a href="#change_password" class="tip icon logout" data-original-title="Camiar contraseña"
                               data-placement="bottom" data-toggle="modal" role="button"><i class="icon-large icon-cog"></i></a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="?logout" class="tip icon logout" data-original-title="Salir" data-placement="bottom"><i
                           class="icon-large icon-off"></i></a></li>
                    </ul>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <p class="navbar-text pull-right">
                        <strong><?=$_SESSION['name'];?></strong>
                    </p>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <div class="pull-right hide">
                        <form class="form-search form-inline" style="margin:5px 0 0 0;" method="post">
                            <div class="input-append">
                                <input type="text" name="keyword" class="span2 search-query" placeholder="Search">
                                <button type="submit" class="btn"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>

                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
</div>
<div id="change_password" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="cpLabel" aria-hidden="true">
    <form>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="cpLabel">Cambiar contraseña</h3>
    </div>
    <div class="modal-body">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-key"></i></span>
            <input class="span3" type="password" name="user_password" placeholder="Contraseña actual" required>
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-key"></i></span>
            <input class="span3" type="password" name="user_password_new" placeholder="Nueva contraseña" required>
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-key"></i></span>
            <input class="span3" type="password" name="user_password_repeat" placeholder="Confirmar contraseña" required>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Cambiar contraseña</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    </div>
    </form>
</div>
<?php endif; ?>