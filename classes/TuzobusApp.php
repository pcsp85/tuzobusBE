<?php
/**
 * Class TuzobusApp.
 * Funciones para Backend de Tuzobús APP
 *
 * @author Pablo César Sánchez Porta <pcsp85@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2015 The Authors
 */
class TuzobusApp
{
	public $path = null;

	public $root = null;

	public $params = null;

	private $db = null;

	public $login = null;

	public $errors =  array();

	public $messages = array();

	public function __construct($home=false){
		$this->path = dirname(__FILE__). '/../';
		$this->root = dirname($_SERVER['PHP_SELF']) . '/';
		require_once($this->path . 'db_config.php');
		if (version_compare(PHP_VERSION, '5.3.7', '<')) {
			$this->errors[] = 'Se requiee PHP 5.3.7 o superior para que esta webApp funcione, verifíca esta información con tu Proveedor.';
		}elseif(version_compare(PHP_VERSION, '5.5.0', '<')){
			require_once($this->path.'classes/password_compatibility_library.php');
		}

		$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->db->connect_errno){
			$this->errors[] = 'Error al Conectar con la Base de Datos, verifica la información';
		}

		require_once($this->path . 'classes/Login.php');
		$this->login = new Login();

		if($home==true){
	        if(!$this->login->isUserLoggedin()){
	            //print_r($this);
	            $this->renderPartial('header', true, $this);
	            $this->renderPartial('login_form', true, $this);
	            $this->renderPartial('footer', true, $this);
	        }else{
	            $this->params = isset($_GET['params']) ? explode('/', $_GET['params']) : array(0=>'index');
	            $this->render($this->params[0], $this);
	        }
	    }

	}

	public function init(){
		/* Creando tablas y elementos para instalacion de la Aplicación */
	}

	public function renderPartial($template, $echo=true, $TB=null){
		$template_path = $this->path . 'templates/' . $template .'.php';
		$response = '';
		if(is_file($template_path)){
			ob_start();
			include($template_path);
			$response = ob_get_contents();
			ob_end_clean();
			if($echo == true){
				echo $response;
			}else{
				return $response;
			}
		}else{
			return false;
		}
	}

	public function render($template, $TB=null){
		$template_path = $this->path . 'templates/' . $template . '.php';
		$aside_path = $this->path . 'templates/aside/' . $template . '.php';

		$response = $this->renderPartial('header', false, $TB);
		$response .= '<div class="row-fluid">';
		if(is_file($aside_path)){
			$response .= '<div class="span2 pull-left">';
			$response .= $this->renderPartial('aside/'.$template, false, $TB);
			$response .= '</div><div class="span10 pull-left">';
		}else{
			$response.= '<div class="span12 pull-left">';
		}
		$response .= '<div class="well">';

		if(count($this->errors)>0){
			$response .= '<div class="alert alert-box><ul>';
			foreach ($this->errors as $e) {
				$response .= '<li>'+$e+'</li>';
			}
			$response .= '</ul></div>';
		}

		if(count($this->messages)>0){
			$response .= '<div class="alert alert-success alert-box><ul>';
			foreach ($this->messages as $m) {
				$response .= '<li>'+$m+'</li>';
			}
			$response .= '</ul></div>';
		}

		if(is_file($template_path)){
			$response .= $this->renderPartial($template, false, $TB); 
		}else{
			$response .= $this->renderPartial('error', false, $TB);
		}

		$response .= '</div></div></div>';
		$response .= $this->renderPartial('footer', false, $TB);

		echo $response;
	}

	public function change_password($password, $password_new, $password_repeat){
		$response = array();
		$response['result'] = 'error';
		if(!isset($password) || $password == '') $response['message'] = 'El campo de contraseña es obligatorio';
		elseif(!isset($password_new) || $password_new == '') $response['message'] = 'El campo de nueva contraseña es obligatorio';
		elseif(!isset($password_repeat) || $password_repeat == '') $response['message'] = 'El campo para confirmar contraseña es bligatorio';
		elseif($password_new != $password_repeat) $response['message'] = 'Las contraseñas debe ser iguales';
		elseif($password == $password_new) $response['message'] = 'La nueva contraseña es igual a la actual';
		else{
			$sql = "SELECT `user_password_hash` FROM users WHERE `id` = " . $_SESSION['user_id'];
			$cp = $this->db->query($sql);
			if($cp->num_rows == 1){
				$chk = $cp->fetch_object();
				if(password_verify($password,$chk->user_password_hash)){
					$password_hash = password_hash($password_new, PASSWORD_DEFAULT);
					$sql = "UPDATE users SET `user_password_hash` = '".$password_hash."' WHERE `id` = " . $_SESSION['user_id'];
					if($this->db->query($sql) === TRUE){
						$response['result'] = 'success';
						$response['message'] = 'La contraseña se actualizó con éxito';
					}else{
						$response['message'] = 'Error al guardar la nueva contraseña, intentalo de nuevo';
					}
				}else{
					$response['message'] = 'La contraseña actual esta equivocada, verifíca la información';
				}

			}else $response['message'] = 'Error al sincroonizar los datos de usuario';
		}
		return $response;
	}
}