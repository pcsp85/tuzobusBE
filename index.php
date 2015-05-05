<?php
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("classes/password_compatibility_library.php");
}
require_once('classes/db_config.php');
require_once('classes/Login.php');
$login = new Login();
//if($_POST) $login->dologinWithPostData();
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>TuzobusAdmin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="favicon.ico" />

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
<?php if(!$login->isUserLoggedIn()): ?>
<div class="container">
    <form class="form-signin" method="post" action="./">

        <h2 class="form-signin-heading"><img src="favicon.png"> Iniciar Sesión</h2>
    <?php if(count($login->errors)>0): ?>
        <div class="alert alert-block">
            <ul>
                <?php foreach($login->errors as $e): ?><li><?=$e;?></li><?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if(count($login->messages)>0): ?>
        <div class="alert alert-success alert-block">
            <ul>
                <?php foreach($login->messages as $m): ?> <li><?=$m;?></li><?php endforeach; ?>
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
<?php else: ?>
<div class="navbar navbar-fixed-top">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container-fluid">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <span class="brand"><img src="favicon.png"> TuzbusAdmin</span>

                <div class="nav-collapse collapse">

                    <ul class="nav">
                        <li class="active"><a href="./"><i class="icon-home icon-black"></i> Inicio</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                               class="icon-envelope icon-black"></i>
                                Invitaciones <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="./invitaciones?create">Crear código</a></li>
                                <li><a href="./invitaciones/">Ver códigos</a></li>
                                <li><a href="#">Codigos utilizados</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                               class="icon-picture icon-black"></i>
                                Anuncios <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Crear anuncio</a></li>
                                <li><a href="#">Ver anuncios</a></li>
                                <li><a href="#">Estadísticas</a></li>
                            </ul>
                        </li>

                        <li><a href="#"><i class="icon-user icon-black"></i>Usuarios</a></li>
                        <!--li><a href="#"><i class="icon-pencil icon-black"></i>Sample 2</a></li>
                        <li><a href="#"><i class="icon-file icon-black"></i>Sample 3</a></li-->

                    </ul>

                    <ul class="nav pull-right settings">
                        <li><a href="#" class="tip icon logout" data-original-title="Camiar contraseña"
                               data-placement="bottom"><i class="icon-large icon-cog"></i></a></li>
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

<div class="row-fluid">
    <div class="span2 pull-left">
        <div class="well sidebar-nav">
            <ul class="nav nav-tabs nav-stacked">
                <li class="nav-header">Navigation</li>
                <li class="active"><a href="./">Inicio</a></li>
                <li><a href="./Invitaciones">Invitaciones</a></li>
                <li><a href="./Anuncios">Anuncios</a></li>
                <li><a href="./Usuarios">Usuarios</a></li>
            </ul>
        </div>
    </div>
    <!--/.well -->
    <!--/span3-->

    <div class="span10 pull-left">

        <div class="well">
            <h1>Hello, World!</h1>

            <p>
                A super admin interface for your projects !
                For more information about usage, visit <a href="http://twitter.github.com/bootstrap/"
                                                           target="_blank">Bootstrap</a><br><br>
                <a class="btn btn-primary btn-large" href="layout-options.html">Layout Options &raquo;</a>
            </p>
        </div>

    </div>
    <!--/span9-->

</div>
<!--/row-fluid-->

<hr>

<footer align="center">
    <p>Copyright &copy; 2015 <strong>TuzobusApp</strong></p>
</footer>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
<script src="js/vendor/bootstrap.min.js"></script>
<script>
    // enable tooltips
    $(".tip").tooltip();
</script>
<?php endif; ?>
</body>
</html>
