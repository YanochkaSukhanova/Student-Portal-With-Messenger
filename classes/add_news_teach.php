<?php

	class add_news_teach extends ACore_teacher {
	
		// Добавление новости в базу данных
		protected function obr(){
			// Пооверка загрузки файла
			if(!empty($_FILES['file_src']['tmp_name'])){
				if(!move_uploaded_file($_FILES['file_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['file_src']['name'])){
					exit("Не удалось загрузить файл");
				}
				$file_src = '/STUD_PORTAL/file/'.$_FILES['file_src']['name'];
			}
			else{
				$file_src = "";
			}
			
			$name = $_POST['name'];
			$text = $_POST['text'];
			$id_user = $_SESSION['user']['id'];
			
			if( empty($name) || empty($text) ){
				exit("Не заполнены обязательные поля");
			}
			
			foreach ($_POST['id_group'] as $id_group){
			
				$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
				$mysqli->query("SET @name = '$name', @text = '$text', @file_src = '$file_src', @id_user = '$id_user', @id_group = '$id_group'");
				$result = $mysqli->query("CALL `addNews`(@name, @text, @file_src, @id_user, @id_group)");
				
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				if(!$result){
					exit(mysqli_error($mysqli));
				}
			}
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=add_note_teach");
			exit;
		}
		
		// Вывод формы для создания новости
		public function get_content(){
			echo "<div id='main_a'>";
			
			echo "<h2>Добавить новую новость</h2>";
			echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
			$my_id = $_SESSION['user']['id'];
			
			$link_b = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query_b = "SELECT * 
				  FROM `stud_groups`";
			$result_b = mysqli_query($link_b, $query_b);
			if(!$result_b){
				exit(mysqli_error($link_b));
			}
			$group_b = array();
			
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Название новости:</b><br>
				<textarea id='editor1' type='text' name='name' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>

				<p><b>Текст:</b><br>
				<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>
				
				<p><b>Материалы (файл/архив):</b><br>
				<input type='file' name='file_src'>
				</p>
				
				<p><b>Группа:</b><br>
				<select multiple name='id_group[]'>
			HEREDOC;

			$student_group = array();
			$j = 0;
			for ($j = 0; $j < mysqli_num_rows($result_b); $j++){
			   	$student_group = mysqli_fetch_array($result_b, MYSQLI_ASSOC);
			   	echo "<option value='".$student_group['id_group']."'>".$student_group['name_group']."</option>";
			}
			echo "</select><br> * Для выбора нескольких групп необходимо одновременно нажать CTRL+SHIFT</p>";
			
			echo "<p><input type='hidden' name='user_id' value='$my_id'></p>";	
			
			echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
		}
	}
?>
