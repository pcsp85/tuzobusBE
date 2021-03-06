<?php 
/**
 * Class TuzobusApp.
 * Clase para Backend de Tuzobús APP
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
			$this->errors[] = 'Se requiere PHP 5.3.7 o superior para que esta webApp funcione, verifíca esta información con tu Proveedor.';
		}elseif(version_compare(PHP_VERSION, '5.5.0', '<')){
			require_once($this->path.'classes/password_compatibility_library.php');
		}

		$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if($this->db->connect_errno){
			$this->errors[] = 'Error al Conectar con la Base de Datos, verifica la información';
		}

		$this->init();

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

	private function init(){
		/* Creando tablas y elementos para instalacion de la Aplicación */
		$sql = "SHOW TABLES LIKE 'logs'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `logs` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `user_id` int(11) NOT NULL, `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `IP` varchar(20) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de logs';
		}

		$sql = "SHOW TABLES LIKE 'users'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `users` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `user_name` varchar(60) NOT NULL, `user_email` varchar(128) NOT NULL, `user_password_hash` varchar(60) NOT NULL, `name` tinytext NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de usuarios';
		}

		$sql = "SELECT id FROM users WHERE user_name LIKE 'Admin'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			require_once($this->path.'classes/Registration.php');
			$_POST = array(
				'register'=>true,
				'user_name'=> 'Admin',
				'user_password_new' => 'tuz08u5',
				'user_password_repeat' => 'tuz08u5',
				'user_email' => 'chimopo@gmail.com',
				'name' => 'Administrador'
				);
			$Admin = new Registration();
			$this->messages[] = $Admin->messages[0];
		}

		$sql = "SHOW TABLES LIKE 'invitations'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `invitations` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `code` varchar(10) NOT NULL,  `create_date` datetime NOT NULL,  `create_by` int(11) NOT NULL,  `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP,  `modify_by` int(11) NOT NULL,  `activation_date` datetime NOT NULL,  `activation_device` varchar(60) NOT NULL,  `activation_connection` varchar(30) NOT NULL,  PRIMARY KEY (`id`), FULLTEXT KEY `code` (`code`)) ENGINE=MyISAM AUTO_INCREMENT=1";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de Invitaciones';
			$sql = file_get_contents($this->path.'invitations.sql', FILE_USE_INCLUDE_PATH);
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se cargo el listado de códigos';
		}

		$sql = "SHOW TABLES LIKE 'ads'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `ads` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `title` tinytext NOT NULL, `image` tinytext NOT NULL, `href` tinytext NOT NULL, `begin_date` date NOT NULL, `end_date` date NOT NULL, `publish` tinyint(1) NOT NULL, `create_date` datetime NOT NULL, `create_by` int(11) NOT NULL, `modify_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP, `modify_by` int(11) NOT NULL, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de Anuncios';
		}

		$sql = "SHOW TABLES LIKE 'ads_log'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `ads_log` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `id_ad` int(11) NOT NULL, `device` tinytext NOT NULL, `href` tinytext NOT NULL, `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de estadísticas para Anuncios';
		}

		$sql = "SHOW TABLES LIKE 'options'";
		$chk = $this->db->query($sql);
		if($chk->num_rows == 0){
			$sql = "CREATE TABLE IF NOT EXISTS `options` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  `option` varchar(60) NOT NULL,  `value` text NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=1;";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se creó la tabla de opciones';
			$sql = "INSERT INTO `options` (`option`, `value`) VALUES ('begin_date', '2015-05-10'), ('end_date', '2015-06-15'), ('Android_store', ''), ('iOS_store', ''), ('Android_rank', ''), ('iOS_rank', '')";
			if($this->db->query($sql) === TRUE) $this->messages[] = 'Se agregaron las opciones por defecto.';
		}
	}

	public function get_option($option){
		$option = $this->db->real_escape_string($option);
		$sql = "SELECT `value` FROM `options` WHERE `option` = '$option'";
		$res = $this->db->query($sql);
		if($res->num_rows == 1){
			$r = $res->fetch_object();
			return $r->value;
		}
		return false;
	}

	public function update_option($option, $value){
		$option = $this->db->real_escape_string($option);
		$value = $this->db->real_escape_string($value);
		$sql = "UPDATE `options` SET `value` = '$value' WHERE `option` = '$option'";
		if($this->db->query($sql) === TRUE){
			return true;
		}else{
			return false;
		}
	}

	public function num_users(){
		$sql = "SELECT `id` FROM `users`";
		$result = $this->db->query($sql);
		return $result->num_rows;
	}

	public function invitations(){
		$sql = "SELECT * FROM `invitations` ";
		if(isset($_GET['search']) && $_GET['search']!=''){
			$search = $this->db->real_escape_string($_GET['search']);
			$sql .= "WHERE `code` LIKE ('%$search%') ";
		}
		$rpp = isset($_GET['rpp']) ? $_GET['rpp'] : 25;
		$treg = $this->db->query($sql)->num_rows;
		$tpag = ceil($treg/$rpp);
		$npag = isset($_GET['npag']) ? $_GET['npag'] : 1;
		$inicio = $npag == 1 ? 0 : ($npag-1)*$rpp;
		$data_q = $this->db->query($sql . "ORDER BY `id` LIMIT $inicio, $rpp");
		$data = array();
		if($data_q->num_rows>0){
			$n = 0;
			while($row = $data_q->fetch_object()){
				//$data[] = $row;
				foreach($row as $k => $v){
					if($k=='create_by' || $k=='modify_by'){
						$data[$n][$k] = $this->get_userdata($v)->name;
					}else{
						$data[$n][$k] = $v;
					}

				}$n++;
			}
		}

		$result = (object) array(
			'name'		=> 'invitaciones',
			'treg'		=> $treg,
			'rpp'		=> $rpp,
			'tpag'		=> $tpag,
			'npag'		=> $npag,
			'data'		=> $data,
			'columns'	=> array(
				'ID',
				'Código',
				'Fecha de Alta',
				'Creado por',
				'Fecha de Modificación',
				'Modificado por',
				'Fecha de Activación',
				'Dispositivo',
				'Tipo de conexion'
				),
			'root' => $this->root,
			'sql' => $sql
			);
		return $result;
	}

	public function ads(){
		$sql = "SELECT * FROM `ads` ";
		if(isset($_GET['search']) && $_GET['search']!=''){
			$search = $this->db->real_escape_string($_GET['search']);
			$sql .= "WHERE `title` LIKE ('%$search%') ";
		}
		$rpp = isset($_GET['rpp']) ? $_GET['rpp'] : 25;
		$treg = $this->db->query($sql)->num_rows;
		$tpag = ceil($treg/$rpp);
		$npag = isset($_GET['npag']) ? $_GET['npag'] : 1;
		$inicio = $npag == 1 ? 0 : ($npag-1)*$rpp;
		$data_q = $this->db->query($sql . "ORDER BY `id` LIMIT $inicio, $rpp");
		$data = array();
		if($data_q->num_rows>0){
			$n = 0;
			while($row = $data_q->fetch_object()){
				//$data[] = $row;
				foreach($row as $k => $v){
					if($k=='create_by' || $k=='modify_by'){
						$data[$n][$k] = $this->get_userdata($v)->name;
					}elseif($k=='image'){
						$data[$n][$k] = '<img src="'.$v.'"><span>'.$v.'</span>';
					}elseif($k=='publish'){
						$data[$n][$k] = $v==1 ? 'Si' : 'No';
					}else{
						$data[$n][$k] = $v;
					}

				}$n++;
			}
		}

		$result = (object) array(
			'name' => 'anuncios',
			'treg' => $treg,
			'rpp'		=> $rpp,
			'tpag'		=> $tpag,
			'npag'		=> $npag,
			'data'		=> $data,
			'columns'	=> array(
				'ID',
				'Titulo',
				'Imagen',
				'Destino',
				'Vigencia inicia',
				'Vigencia termina',
				'Publicado',
				'Creado',
				'Creado por',
				'Modificación',
				'Modificado por'
				),
			'root' => $this->root,
			'sql' => $sql
			);
		return $result;
	}

	public function users(){
		$sql = "SELECT `id`,`user_name`,`user_email`, `name` FROM `users` ";
		if(isset($_GET['search']) && $_GET['search']!=''){
			$search = $this->db->real_escape_string($_GET['search']);
			$sql .= "WHERE `code` LIKE ('%$search%') ";
		}
		$rpp = isset($_GET['rpp']) ? $_GET['rpp'] : 25;
		$treg = $this->db->query($sql)->num_rows;
		$tpag = ceil($treg/$rpp);
		$npag = isset($_GET['npag']) ? $_GET['npag'] : 1;
		$inicio = $npag == 1 ? 0 : ($npag-1)*$rpp;
		$data_q = $this->db->query($sql . "ORDER BY `id` LIMIT $inicio, $rpp");
		$data = array();
		if($data_q->num_rows>0){
			$n = 0;
			while($row = $data_q->fetch_object()){
				//$data[] = $row;
				foreach($row as $k => $v){
					if($k=='create_by' || $k=='modify_by'){
						$data[$n][$k] = $this->get_userdata($v)->name;
					}else{
						$data[$n][$k] = $v;
					}

				}$n++;
			}
		}

		$result = (object) array(
			'name'		=> 'usuarios',
			'treg'		=> $treg,
			'rpp'		=> $rpp,
			'tpag'		=> $tpag,
			'npag'		=> $npag,
			'data'		=> $data,
			'columns'	=> array(
				'ID',
				'Usuario',
				'E-mail',
				'Nombre'
				),
			'root' => $this->root,
			'sql' => $sql
			);
		return $result;
	}

	public function createItem(){		
		if($this->login->isUserLoggedin()){
			if($_POST['action']!='createItem') $this->errors[] = 'Funcion erronea';
			if(!isset($_POST['table']) || $_POST['table'] == '') $this->errors[] = 'Parametros incorrectos';
			if(!isset($_POST['title']) || $_POST['title'] == '') $this->errors[] = 'El campo de título es obligatorio';
			if(!isset($_POST['href']) || $_POST['href'] == '') $this->errors[] = 'El campo de link es obligatorio';
			if(!isset($_POST['begin_date']) || $_POST['begin_date'] == '') $this->errors[] = 'Falta la fecha de inicio de vigencia';
			if(!isset($_POST['end_date']) || $_POST['end_date'] == '') $this->errors[] = 'Falta la fecha de fin de vigencia';
			if(!isset($_POST['publish']) || $_POST['publish'] == '') $this->errors[] = 'Debes indicar si el anuncio se publicará';
			if(count($this->errors)==0){
				$columns=''; $values='';
				foreach($_POST as $k => $v) if($k!='table' && $k!='id' && $k!='action'){
					$columns .= "`$k`,";
					if($k=='publish'){
						$values .= $v == 'Si' ? "1," : "0,";
					}else{
						$values .= "'".$this->db->real_escape_string($v)."',";
					}
				}
				$columns .= " `create_date`, `create_by`, `modify_by`";
				$values .= " NOW(), $_SESSION[user_id], $_SESSION[user_id]";
				$sql = "INSERT INTO `$_POST[table]` ($columns) VALUES ($values)";
				if($this->db->query($sql) === TRUE){
					$ads_id = $this->db->insert_id;
					if(isset($_FILES['image']['tmp_name'])){
						$ext = substr($_FILES['image']['name'],strrpos($_FILES['image']['name'], '.'));
						$image = $this->path . 'img/ads/' . $ads_id . $ext;
						$image_uri = 'http://' . $_SERVER['HTTP_HOST'] . $this->root . 'img/ads/' . $ads_id . $ext;
						move_uploaded_file($_FILES['image']['tmp_name'], $image);
						$sql = "UPDATE `$_POST[table]` SET `image` = '$image_uri' WHERE `id` = $ads_id";
						$this->db->query($sql);
					}
				}else $this->errors[] = 'Error al guardar el elemento, intentalo de nuevo.'.$sql;
			}
			
		}else $this->errors[] = 'Acceso negado';

		if(count($this->errors)>0) $response = array(
												'result' => 'error',
												'message' => $this->toList($this->errors) 
												);
		else $response = array(
							'result' => 'success',
							'message' => 'El elemento fue creado con éxito'
							);

		return $response;
	}

	public function updateItem(){
		if($this->login->isUserLoggedin()){
			if($_POST['action']!='updateItem') $this->errors[] = 'Función erronea';
			if(!isset($_POST['table']) || $_POST['table'] == '') $this->errors[] = 'Parametros incorrectos';
			if(!isset($_POST['id']) || $_POST['id'] == '') $this->errors[] = 'Falta la referencia del anuncio';
			if(!isset($_POST['title']) || $_POST['title'] == '') $this->errors[] = 'El campo de título es obligatorio';
			if(!isset($_POST['href']) || $_POST['href'] == '') $this->errors[] = 'El campo de link es obligatorio';
			if(!isset($_POST['begin_date']) || $_POST['begin_date'] == '') $this->errors[] = 'Falta la fecha de inicio de vigencia';
			if(!isset($_POST['end_date']) || $_POST['end_date'] == '') $this->errors[] = 'Falta la fecha de fin de vigencia';
			if(!isset($_POST['publish']) || $_POST['publish'] == '') $this->errors[] = 'Debes indicar si el anuncio se publicará';
			if(count($this->errors)==0){
				$sql = "SELECT * FROM `$_POST[table]` WHERE `id` = $_POST[id]";
				$chk = $this->db->query($sql);
				if($chk->num_rows==1){
					$ad = $chk->fetch_assoc();
					$image = $this->path . 'img/ads/' . substr($ad['image'], strrpos($ad['image'], '/'));
					if(isset($_FILES['image']['tmp_name'])){
						if(is_file($image)) unlink($image);
						$ext = substr($_FILES['image']['name'],strrpos($_FILES['image']['name'], '.'));
						$image = $this->path . 'img/ads/' . $_POST['id'] . $ext;
						$image_uri = 'http://' . $_SERVER['HTTP_HOST'] . $this->root . 'img/ads/' . $_POST['id'] . $ext;
						move_uploaded_file($_FILES['image']['tmp_name'], $image);
						$sql = "UPDATE `$_POST[table]` SET `image` = '$image_uri' WHERE `id` = $_POST[id]";
						if($this->db->query($sql)!==TRUE) $this->errors[] ='Error al actualizar la imagen';
					}
					$update = '';
					foreach ($_POST as $k => $v) if($k!='table' && $k!='id' && $k!='action'){
						if($ad[$k]!=$v){
							$update .= "`$k` = '";
							if($k=='publish') $update .= $v == 'Si' ? "1" : "0";
							else $update .= $this->db->real_escape_string($v); 
							$update .= "', ";
						}
					}
					if($update!=''){
						$update .= " `modify_by` = $_SESSION[user_id] ";
						$sql = "UPDATE `$_POST[table]` SET $update WHERE `id` = $_POST[id]";
						if($this->db->query($sql)!==TRUE) $this->errors[] = 'Error al actualizar la información';
					}

				}else $this->errors[] = 'No se encontró el anuncio.';
			}
		}else $this->errors[] = 'Acceso negado';

		if(count($this->errors)>0) $response = array(
												'result' => 'error',
												'message' => $this->toList($this->errors) 
												);
		else $response = array(
							'result' => 'success',
							'message' => 'El elemento se actualizo con éxito.'
							);

		return $response;
	}

	private function toList($array){
		$ret = '<ul>';
		foreach($array as $k => $v){
			$ret .= '<li>' . $v . '</li>';
		}
		$ret .= '</ul>';
		return $ret;
	}

	public function deleteItem($table, $id){
		if($this->login->isUserLoggedin()){
			$sql = "DELETE FROM `$table` WHERE `id` = $id LIMIT 1";
			if($this->db->query($sql) === TRUE){
				$response = array(
					'result' => 'success',
					'message' => 'El registro fué eliminado con éxito'
					);
			}else{
				$response = array(
					'result' => 'error',
					'message' => 'Ocurrio un error al procesar la solicitud, intentalo de nuevo ' . $sql
					);
			}
		}else{
			$response = array(
				'result' => 'error',
				'message' => 'acceso negado'
				);
		}
		return $response;	
	}

	public function getItem($table, $id){
		if($this->login->isUserLoggedin()){
			$sql = "SELECT * FROM `$table` WHERE `id`= $id";
			$data = $this->db->query($sql);
			if($data->num_rows==1){
				$response = $data->fetch_object();
			}else $this->errors[] = 'Elemento no encontrado';
		}else $this->errors[] = 'Acceso negado';

		if(count($this->errors)>0){
			$response = '<p>Error(es): </p>'.$this->toList($this->errors);
		}

		return $response;
	}

	public function get_userdata($id){
		if($id==0){
			$result = (object) array('name' => 'Sistema');
		}else{
			$sql = "SELECT name FROM `users` WHERE `id` = $id";
			$res = $this->db->query($sql);
			$result = $res->fetch_object();
		}
		return $result;
	}

	public function num_ads($filter = false){
		$sql = "SELECT `id` FROM `ads`";
		if($filter!=false && $filter == 'publish') $sql .= " WHERE `publish` = 1";
		if($filter!=false && $filter == 'no_publish') $sql .= " WHERE `publish` != 1";
		$result = $this->db->query($sql);
		return $result->num_rows; 
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
			$response .= '<div class="alert alert-box"><ul>';
			foreach ($this->errors as $k => $e) {
				$response .= '<li>'+$e+'</li>';
			}
			$response .= '</ul></div>';
		}

		if(count($this->messages)>0){
			$response .= '<div class="alert alert-success alert-box"><ul>';
			foreach ($this->messages as $k => $m) {
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

	/*
	 * Funciones de respuesta utilizadas en ajax.php
	 */

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

	/*
	 * Funciones de respuesta utilizadas en Fuente de datos V
	 */
	public function activate_App ($code, $device, $conection){
		$response = array(
			'result' => 'error',
			'message' => ''
			);
		if(!isset($code) || $code == '') $response['message'] = 'Debes proporcionar el código de activación';
		elseif(!isset($device) || $device == '') $response['message'] = 'Dispositivo desconocido';
		elseif(!isset($conection) || $conection == '') $response['message'] = 'Conexion desconocida';
		else{
			$code = $this->db->real_escape_string($code);
			$sql = "SELECT * FROM `invitations` WHERE `code` = '$code'";
			$chk = $this->db->query($sql);
			if($chk->num_rows == 1){
				$c = $chk->fetch_object();
				if($c->activation_date == '0000-00-00 00:00:00'){
					$sql = "UPDATE `invitations` SET `activation_date` = NOW(), `activation_device` = '$device', `activation_connection` = '$conection' WHERE `id` = $c->id";
					if($this->db->query($sql) === TRUE){
						$response = array(
							'result'	=> 'success',
							'message'	=> '¡Tuzobús App se activó con éxito, gracias!'
							);
					}else{
						$response['message'] = 'No fue posible activar Tuzobús App, intentalo de nuevo';
					}
				}else{
					if($c->activation_device == $device){
						$response = array(
							'result'	=> 'success',
							'message'	=> '¡Tuzobús App se activó con éxito, gracias!'
							);
					}else{
						$response['message'] = 'El código proporcionado ya habia sido utilizado';
					}
				}
			}else{
				$response['message'] = 'El código proporcionado no existe';
			}
		}
		return $response;
	}

	public function get_ads(){
		$response = array();
		$hoy = date("Y-m-d");
		$sql = "SELECT id, title, image FROM ads WHERE begin_date <= '$hoy' AND end_date >= '$hoy' AND publish = 1 ORDER BY RAND() LIMIT 5";
		$data = $this->db->query($sql);
		if($data->num_rows >0){
			while($row = $data->fetch_assoc()) $response[] = $row;
		}

		return $response;
	}

	public function go_ad($id_ad, $device){
		if(!isset($id_ad) || $id_ad==''){
			$response = array(
				'result' => 'error',
				'message' => 'Falta la referencia del anuncio'
				);
		}else{
			$sql = "SELECT `href` FROM `ads` WHERE `id` = $id_ad";
			$ad = $this->db->query($sql);
			if($ad->num_rows==1){
				$href = $ad->fetch_object()->href;
				$sql = "INSERT INTO `ads_log` (`id_ad`, `device`, `href`) VALUES ($id_ad, '$device', '$href')";
				$this->db->query($sql);
				$response = array(
					'result' => 'success',
					'href' => $href
					);
			}else{
				$response = array(
					'result' => 'error',
					'message' => 'El anuncio no existe'
					);
			}
		}
		return $response;
	}

	public function coments($coments,$email){
		require_once($this->path.'classes/PHPMailer/PHPMailerAutoload.php');
		if(!isset($coments) || $coments == ''){
			$response = array(
				'result' => 'error',
				'message' => 'El campo de comentarios es obligatorio'
				);
		}else{
			$mail = new PHPMailer;

			$body = '<p>Has recibido comentarios desde Tuzobús App, a continuación encontrarás los detalles:</p><p>'.$coments.'</p>';

			$mail->From = 'admin@tuzobus.com';
			$mail->FromName = 'Tuzobus Admin';
			$mail->addaddress('chimopo@gmail.com');
			if(isset($email) && $email!=''){
				$mail->addReplyTo($email);
			$body .= '<p>Además incluyó su correo electrónico: '.$email.'</p><p><strong>Nota:</strong>Puedes enviar una respuesta dando click en responder.</p>';
			}
			$mail->addBCC('pcsp85@gmail.com');

			$mail->Subject = utf8_decode('Comentarios de Tuzobús App');
			$mail->Body = utf8_decode($body);
			$mail->AltBody = utf8_decode(strip_tags($body));

			if(!$mail->send()){
				$response = array(
					'result' => 'error',
					'message' => 'Ocurrio un error al enviar el mensaje, por favor intentalo de nuevo. <strong>'.$mail->ErrorInfo.'</strong>'
					);
			}else{
				$response = array(
					'result' => 'success',
					'message' => 'En mensaje fue enviado con éxito, muchas gracias, reralmente apreciamos tus comentarios.'
					);
			}
		}
		return $response;
	}	
}