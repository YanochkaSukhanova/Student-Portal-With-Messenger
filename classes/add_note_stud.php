<?php

	class add_note_stud extends ACore_student {
	
		// Добавление заметки в базу данных
		protected function obr(){
			$name = $_POST['name'];
			$text = $_POST['text'];
			$id_user = $_SESSION['user']['id'];
			if( empty($name) || empty($text) ){
				exit("Не заполнены обязательные поля");
			}
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @name = '$name', @text = '$text', @id_user = '$id_user'");
			$result = $mysqli->query("CALL `addNotes`(@name, @text, @id_user)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=add_note_stud");
				exit;
			}
		}
		
		// Вывод формы для создания заметки
		public function get_content(){
			echo "<div id='main_a'>";
			echo "<h2>Добавить новую заметку</h2>";
			echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
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
		}
	}
?>
