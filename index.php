<?php
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}
require_once('classes/db_config.php');
require_once('classes/Login.php');
$login = new Login();
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>SuperAdmin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>
<body>
<?php if(!$login->isUserLoggedIn()): ?>
<div class="container">
    <form class="form-signin" method="post">

        <h2 class="form-signin-heading">Iniciar Sesión</h2>

        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-envelope"></i></span>
            <input class="span3" type="text" name="username" placeholder="Usuario">
        </div>
        <div class="input-prepend">
            <span class="add-on"><i class="icon-large icon-key"></i></span>
            <input class="span3" type="password" name="password" placeholder="Contraseña">
        </div>
        <button class="btn btn-large btn-primary" type="submit" name="submit">Entrar</button>
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
                <span class="brand">SuperAdmin</span>

                <div class="nav-collapse collapse">

                    <ul class="nav">
                        <li class="active"><a href="#"><i class="icon-home icon-black"></i> Dashboard</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                               class="icon-edit icon-black"></i>
                                Dropdown <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Page One</a></li>
                                <li><a href="#">Page Two</a></li>
                                <li><a href="#">Page Three</a></li>
                            </ul>
                        </li>

                        <li><a href="#"><i class="icon-user icon-black"></i>Sample 1</a></li>
                        <li><a href="#"><i class="icon-pencil icon-black"></i>Sample 2</a></li>
                        <li><a href="#"><i class="icon-file icon-black"></i>Sample 3</a></li>

                    </ul>

                    <ul class="nav pull-right settings">
                        <li class="dropdown">
                            <ul class="dropdown-menu">
                                <li><a href="#">Account Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="#">System Settings</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="nav pull-right settings">
                        <li><a href="#" class="tip icon logout" data-original-title="Settings"
                               data-placement="bottom"><i class="icon-large icon-cog"></i></a></li>
                        <li class="divider-vertical"></li>
                        <li><a href="#" class="tip icon logout" data-original-title="Logout" data-placement="bottom"><i
                           class="icon-large icon-off"></i></a></li>
                    </ul>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <p class="navbar-text pull-right">
                        Welcome <strong>Admin</strong>
                    </p>

                    <ul class="nav pull-right settings">
                        <li class="divider-vertical"></li>
                    </ul>

                    <div class="pull-right">
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
                <li class="active"><a href="#">Link One</a></li>
                <li><a href="#">Link Two</a></li>
                <li><a href="#">Link Three</a></li>
                <li><a href="#">Link Four</a></li>
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
    <p>Copyright &copy; 2013 <strong>Company Name</strong></p>
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