<?php
if(!defined('TuzobusApp')) die('Acceso negado');

if($TB->login->isUserLoggedIn()): ?>
<hr>

<footer align="center">
    <p>Copyright &copy; 2015 <strong>TuzobusApp</strong></p>
</footer>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>window.jQuery || document.write('<script src="<?=$TB->root;?>js/vendor/jquery-1.8.3.min.js"><\/script>')</script>
<script src="<?=$TB->root;?>js/vendor/bootstrap.min.js"></script>
<script src="<?=$TB->root;?>js/tuzobusapp.js"></script>
<script>
    // enable tooltips
    $(".tip").tooltip();
</script>
<?php endif; ?>
</body>
</html>