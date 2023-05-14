<?php
class edit_user extends ACore_admin {
	// Изменение информации о пользователе в базе данных
	protected function obr(){
		$id = $_POST['id'];
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$rights = $_POST['rights'];
		$last_name = $_POST['last_name'];
		$first_name = $_POST['first_name'];
		$middle_name = $_POST['middle_name'];
		$email = $_POST['email'];
		if( empty($login) || empty($pass) || empty($rights) || empty($last_name) || empty($first_name) ){
			exit("Не заполнены обязательные поля");
		}
		$pass = password_hash($pass, PASSWORD_DEFAULT);	
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @p0='$login';");
		$mysqli->query("SET @p1='$pass';");
		$mysqli->query("SET @p2='$rights';");
		$mysqli->query("SET @p3='$first_name';");
		$mysqli->query("SET @p4='$last_name';");
		$mysqli->query("SET @p5='$middle_name';");
		$mysqli->query("SET @p6='$email';");
		$mysqli->query("SET @p7='$id';");
		$result = $mysqli->query("CALL `editUsers`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7)");
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=users");
			exit;
		}
	}
	
	//Форма для изменения информации о пользователе
	public function get_content(){
		if ($_GET['id_text']){
			$id_text = (int)$_GET['id_text'];
		}
		else{
			exit("Некорректные данные для страницы");
		}
		$text = $this->get_text_users($id_text);
		echo "<div id='main'>
			<h2 style='color: #cc0605'>Изменение данных о пользователе с ID = $id_text</h2>";
		if ($text['rights'] == 'student' || $text['rights'] == 'no_rights'){
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		
			<p><b>Фамилия:</b><br>
			<textarea style='width: 600px' type='text' name='last_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[last_name]</textarea>
			</p>
			
			<p><b>Имя:</b><br>
			<textarea style='width: 600px'type='text' name='first_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[first_name]</textarea>
			</p>
			
			<p><b>Отчество:</b><br>
			<textarea style='width: 600px'type='text' name='middle_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[middle_name]</textarea>
			</p>
			
			<p><b>e-mail:</b><br>
			<textarea style='width: 600px'type='text' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>$text[email]</textarea>
			</p>
			
			<p><b>Логин:</b><br>
			<textarea style='width: 600px'type='text' name='login' pattern='[A-Za-z0-9]{3,50}'>$text[login]</textarea>
			<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
			</p>

			<p><b>Пароль:</b><br>
			<textarea style='width: 600px;' name='pass' pattern="[A-Za-z0-9]{3,50}">$text[pass]</textarea>
			<br><div>*Старый пароль отображается в зашифрованном виде в целях безопасности</div><br>
			</p>
			

			<p><b>Права:</b><br>
			<select name='rights'>
				<option value="student">Студент</option>
				<option value="teacher">Преподаватель</option>
				<option value="admin">Администратор</option>
				<option value="no_rights">Без прав</option>
			</select>
		HEREDOC;
		}
		else if ($text['rights'] == 'teacher'){
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
		
			<p><b>Фамилия:</b><br>
			<textarea type='text' style='width: 600px' name='last_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[last_name]</textarea>
			</p>
			
			<p><b>Имя:</b><br>
			<textarea type='text' style='width: 600px' name='first_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[first_name]</textarea>
			</p>
			
			<p><b>Отчество:</b><br>
			<textarea type='text' style='width: 600px' name='middle_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[middle_name]</textarea>
			</p>
			
			<p><b>e-mail:</b><br>
			<textarea type='text' style='width: 600px' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>$text[email]</textarea>
			</p>
			
			<p><b>Логин:</b><br>
			<textarea type='text' style='width: 600px' name='login' pattern='[A-Za-z0-9]{3,50}'>$text[login]</textarea>
			<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
			</p>

			<p><b>Пароль:</b><br>
			<textarea name='pass' style='width: 600px;' pattern='[A-Za-z0-9]{3,50}'>$text[pass]</textarea>
			<br><div>*Старый пароль отображается в зашифрованном виде в целях безопасности</div><br>
			</p>
		
			<p><b>Права:</b><br>
			<select name='rights'>
				<option value="teacher">Преподаватель</option>
				<option value="admin">Администратор</option>
				<option value="student">Студент</option>
				<option value="no_rights">Без прав</option>
			</select>
		HEREDOC;
		}
		else if ($text['rights'] == 'admin'){
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
			<p><b>Фамилия:</b><br></p>
			<textarea type='text' style='width: 600px' name='last_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[last_name]</textarea>
			
			<p><b>Имя:</b><br></p>
			<textarea type='text' style='width: 600px' name='first_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[first_name]</textarea>
			
			<p><b>Отчество:</b><br></p>
			<textarea type='text' style='width: 600px' name='middle_name' pattern='[А-Яа-яЁё\s]{2,50}'>$text[middle_name]</textarea>
			
			<p><b>e-mail:</b><br></p>
			<textarea type='text' style='width: 600px' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'>$text[email]</textarea>
			
			<p><b>Логин:</b><br></p>
			<textarea type='text' style='width: 600px' name='login' pattern='[A-Za-z0-9]{3,50}'>$text[login]</textarea>
			<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
			
			<p><b>Пароль:</b><br></p>
			<textarea name='pass' style='width: 600px;' pattern='[A-Za-z0-9]{3,50}'>$text[pass]</textarea>
			<br><div>*Старый пароль отображается в зашифрованном виде в целях безопасности</div><br>
			
			<b>Права:</b><br>
			<select name='rights'>
				<option value="admin">Администратор</option>
				<option value="student">Студент</option>
				<option value="teacher">Преподаватель</option>
				<option value="no_rights">Без прав</option>
			</select>
		HEREDOC;
		}
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";		
	}
}
?>
