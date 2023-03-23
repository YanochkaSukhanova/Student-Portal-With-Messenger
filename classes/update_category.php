<?php
	class update_category extends ACore_teacher {
	
		protected function obr(){
			
			$id = $_POST['id'];
			$title = $_POST['title'];
			
			if( empty($title) ){
				exit("Не заполнены обязательные поля");
			}
									
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$title';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editCategory`(@p0, @p1)");
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
		
			if ($_GET['id_text']){
				$id_text = (int)$_GET['id_text'];
			}
			else{
				exit("Некорректные данные для страницы");
			}
			
			$my_id = $_SESSION['user']['id'];
			$query = "SELECT id_category, name_category, autor_id FROM category WHERE id_category='$id_text'";
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			$result = mysqli_fetch_assoc($result);
			if($result['autor_id'] != $my_id){
				echo "<div id='main'>
					<h2>Данная страница Вам не доступна</h2>
					<img class='illustration_big' src='file/undraw_Cancel_re_pkdm.png'>
					<p>Перейдите в раздел с предметами, чтобы иметь возможноссть их редактирования</p>
					<br><div style='margin-right: 540px'><a style='text-align:left' href='?option= edit_category'><button>Мои предметы</button></a></div>
				</div>";
			}
			else{
			
				$text = $this->get_name_category($id_text);

				
				echo "<div id='main'>
				<h2>Добавить новый предмет</h2>";
				
				if($_SESSION['res']){
					echo $_SESSION['res'];
					unset($_SESSION['res']);
				}
				
				print <<<HEREDOC
				<form action="" method="POST">
					<p>Новое название предмета:<br>
					<input type='text' name='title' style='width:420px;' value='$text[name_category]'>
					<input type='hidden' name='id' style='width:420px;' value='$text[id_category]'></p>
					<p><input type='submit' name='button' value='Сохранить'></p></form></div>
				HEREDOC;	
			}
		}
	}
?>
