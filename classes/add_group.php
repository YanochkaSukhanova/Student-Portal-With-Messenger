<?php

	class add_group extends ACore_admin {
	
		protected function obr(){
			
			$title = $_POST['title'];
			$count = 0;
			
			if(empty($title)){
				exit("Не заполнены обязательные поля");
			}
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @name = '$title', @count = '$count'");
			$result = $mysqli->query("CALL `addGroup`(@name, @count)");
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=groups");
				exit;
			}
		
		}
		
		public function get_content(){
			echo "<div id='main'>";
		
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			print <<<HEREDOC
			<form action="" method="POST">
				<p>Название новой группы:<br>
				<input type='text' name='title' style='width:420px;'>
				</p>
				
				<p><input type='submit' name='button' value='Добавить'></p></form></div>
			HEREDOC;
			
		}
	}
?>
