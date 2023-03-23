<?php

	class add_group extends ACore_admin {
	
		protected function obr(){
			
			$title = $_POST['title'];
			
			if(empty($title)){
				exit("Не заполнены обязательные поля");
			}
			
			$query = "INSERT INTO `groups` (name_group) VALUES ('$title')";
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
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
