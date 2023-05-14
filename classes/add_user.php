<?php

	class add_user extends ACore_admin {
	
		// Добавление пользователя в базу данных
		protected function obr(){
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
			$result = $mysqli->query("CALL `addUsers`(@p0, @p1, @p2, @p3, @p4, @p5, @p6)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=add_user");
				exit;
			}
		}
		
		// Вывод формы для создания пользователя
		public function get_content(){
			echo "<div id='main'>";
			echo "<h2 style='color:#cc0605'>Добавление нового пользователя</h2>";
			print <<<HEREDOC
			
			<form enctype="multipart/form-data" action="" method="POST">
			
				<p><b>Фамилия:</b><br>
				<textarea style='width: 600px' type='text' name='last_name' pattern='[А-Яа-яЁё\s]{2,50}'></textarea>
				</p>
				
				<p><b>Имя:</b><br>
				<textarea style='width: 600px'type='text' name='first_name' pattern='[А-Яа-яЁё\s]{2,50}'></textarea>
				</p>
				
				<p><b>Отчество:</b><br>
				<textarea style='width: 600px'type='text' name='middle_name' pattern='[А-Яа-яЁё\s]{2,50}'></textarea>
				</p>
				
				<p><b>e-mail:</b><br>
				<textarea style='width: 600px'type='text' name='email' pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'></textarea>
				</p>
				
				<p><b>Логин:</b><br>
				<textarea style='width: 600px'type='text' name='login' pattern='[A-Za-z0-9]{3,50}'></textarea>
				</p>

				<p><b>Пароль:</b><br>
				<textarea style='width: 600px;' name='pass' pattern="[A-Za-z0-9]{3,50}"></textarea>
				</p>

				<p><b>Права:</b><br>
				<select name='rights'>
					<option value="no_rights">Без прав</option>
					<option value="student">Студент</option>
					<option value="teacher">Преподаватель</option>
					<option value="admin">Администратор</option>
				</select>
			HEREDOC;
			
			echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
		}
	}
?>
