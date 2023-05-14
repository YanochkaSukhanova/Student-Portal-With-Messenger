<?php

	class add_category extends ACore_teacher {
	
		// Добавление нового предмета в базу данных
		protected function obr(){
			$title = $_POST['title'];
			$avtor = $_SESSION['user']['id'];
			if(empty($title)){
				exit("Не заполнены обязательные поля");
			}
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @title = '$title'");
			$mysqli->query("SET @avtor = '$avtor'");
			$result = $mysqli->query("CALL `addCategory`(@title, @avtor)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=edit_category");
				exit;
			}
		}
		
		// Вывод формы для добавления нового предмета
		public function get_content(){
			echo "<div id='main'>
				<h2>Добавить новый предмет</h2>";
			print <<<HEREDOC
			<form action="" method="POST">
				<p>Название нового предмета:<br>
				<input type='text' name='title' style='width:420px;'>
				</p><p><input type='submit' name='button' value='Добавить'></p></form></div>
			HEREDOC;
			
		}
	}
?>
