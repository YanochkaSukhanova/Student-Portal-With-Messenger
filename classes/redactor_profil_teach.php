<?php
class redactor_profil_teach extends ACore_teacher {
	// Изменение информации о пользователе в базе данных
	protected function obr(){
		$id = $_POST['id'];
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$email = $_POST['email'];
		$pole = $_POST['pole'];
		if ($pole == 'login'){
			if( empty($login) ){
				exit("Не заполнены обязательные поля");
			}	
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$login';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editUserLogin`(@p0, @p1)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=redactor_profil_teacher");
				exit;
			}
		}
		else if ($pole == 'pass'){
			if( empty($pass) ){
				exit("Не заполнены обязательные поля");
			}
			$pass = password_hash($pass, PASSWORD_DEFAULT);
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$pass';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editUserPass`(@p0, @p1)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=redactor_profil_stud");
				exit;
			}
		}
		else if ($pole == 'email'){
			if( empty($email) ){
				exit("Не заполнены обязательные поля");
			}
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$email';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editUserEmail`(@p0, @p1)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=redactor_profil_stud");
				exit;
			}
		}
		else if ($pole == 'photo'){
			if(!empty($_FILES['img_avatar']['tmp_name'])){
				if(!move_uploaded_file($_FILES['img_avatar']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['img_avatar']['name'])){
					exit("Не удалось загрузить файл");
				}
				$img_avatar = $_FILES['img_avatar']['name'];
			}
			else{
				exit("Необходимо загрузить файл");
			}				
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$img_avatar';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editUserPhoto`(@p0, @p1)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=redactor_profil_stud");
				exit;
			}
		}
	}
	
	// Формы для изменения информации в личном профиле
	public function get_content(){
		echo "<div id='main_a'>
			<h2 style='color: #cc0605'>Изменение личных данных</h2>";
		$my_id = $_SESSION['user']['id'];
		$query = "SELECT *
	 	  FROM users
	 	  WHERE id='$my_id'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){				
			exit(mysqli_error($link));
		}
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo '<img class="illustration" src="file/undraw_Site_content_re_4ctl.png">';
		echo "<p><div style='font-size: 20px;text-align:centre'><b>$row[last_name] $row[first_name] $row[middle_name]</b></div></p>";
		//LOGIN
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		<div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<p><b>Логин:</b><br>
			<textarea style='width: 600px'type='text' name='login' pattern='[A-Za-z0-9]{3,50}'>$row[login]</textarea>
			<input type='hidden' name='id' style='width:420px;' value='$my_id'>
			</p>

			<input type='hidden' name='pole' style='width:420px;' value='login'>
			</p>
		HEREDOC;
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div><br>";
		//PASS
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		<div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<input type='hidden' name='id' style='width:420px;' value='$my_id'>
			</p>
			<input type='hidden' name='pole' style='width:420px;' value='pass'>
			</p>

			<p><b>Пароль:</b><br>
			<textarea style='width: 600px;' name='pass' pattern="[A-Za-z0-9]{3,50}">$row[pass]</textarea>
			<br><div>*Старый пароль отображается в зашифрованном виде в целях безопасности</div><br>
			</p>
		HEREDOC;	
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div><br>";
		//E-MAIL
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		<div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>			
			<p><b>e-mail:</b><br>
			<textarea style='width: 600px'type='text' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>$row[email]</textarea>
			</p>

			<input type='hidden' name='id' style='width:420px;' value='$my_id'>
			</p>
			<input type='hidden' name='pole' style='width:420px;' value='email'>
			</p>

		HEREDOC;	
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div><br>";
		echo "<br><h2 style='color: #cc0605'>Загрузить новое фото</h2>";
		echo "<br><img class='illustration' src='file/undraw_Live_photo_re_4khn.png'>";
		//PHOTO
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		<div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<input type='hidden' name='id' style='width:420px;' value='$my_id'>
			</p>
			<input type='hidden' name='pole' style='width:420px;' value='photo'>
			</p>
			
			<p><b>Новое фото:</b><br>
			<input type='file' name=' img_avatar'>

		HEREDOC;
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";		
		echo "</div>";
	}
}
?> 
