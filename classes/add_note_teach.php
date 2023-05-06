<?php

	class add_note_teach extends ACore_teacher {
	
		protected function obr(){
			
			/*if(!empty($_FILES['file_src']['tmp_name'])){
				if(!move_uploaded_file($_FILES['file_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['file_src']['name'])){
					exit("Не удалось загрузить файл");
				}
				$file_src = '/STUD_PORTAL/file/'.$_FILES['file_src']['name'];
			}
			else{
				$file_src = "";
			}*/
			
			$name = $_POST['name'];
			$text = $_POST['text'];
			$id_user = $_SESSION['user']['id'];
			
			if( empty($name) || empty($text) ){
				exit("Не заполнены обязательные поля");
			}
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @name = '$name', @text = '$text', @id_user = '$id_user'");
			$result = $mysqli->query("CALL `addNotes`(@name, @text, @id_user)");
			
			/*$mysqli->query("SET @name = '$name', @file_src = '$file_src', @text = '$text', @id_user = '$id_user'");
			$result = $mysqli->query("CALL `addNotes`(@name, @file_src, @text, @id_user)");*/
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=add_note_teach");
				exit;
			}
		
		}
		
		public function get_content(){
			echo "<div id='main_a'>";
			
			echo "<h2>Добавить новую заметку</h2>";
			echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
		
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Название заметки:</b><br>
				<textarea id='editor1' type='text' name='name' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>

				<p><b>Текст:</b><br>
				<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>
				
				
			HEREDOC;
			echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
			
			
			/*
				<p><b>Материалы (файл/архив/фото):</b><br>
				<input type='file' name='file_src'>
				</p>			
			*/
		}
	}
?>
