<?php

	class add_category extends ACore_teacher {
	
		protected function obr(){
			
			$title = $_POST['title'];
			
			if(empty($title)){
				exit("Не заполнены обязательные поля");
			}

			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @title = '$title'");
			$result = $mysqli->query("CALL `addCategory`(@title)");
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=edit_category");
				exit;
			}
		
		}
		
		public function get_content(){
			echo "<div id='main'>
				<h2>Добавить новый предмет</h2>";
		
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			print <<<HEREDOC
			<form action="" method="POST">
				<p>Название нового предмета:<br>
				<input type='text' name='title' style='width:420px;'>
				</p>
				
				<p><input type='submit' name='button' value='Добавить'></p></form></div>
			HEREDOC;
			
		}
	}
?>
