<?php
	class update_note_teach extends ACore_teacher {
	
		protected function obr(){
			
			$id_user = $_SESSION['user']['id'];
			$id_note = $_POST['id_note'];
			$name = $_POST['name'];
			$text = $_POST['text'];
			
			if( empty($name) || empty($text) || empty($id_user) ){
				exit("Не заполнены обязательные поля");
			}
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$name';");
			$mysqli->query("SET @p1='$text';");
			$mysqli->query("SET @p2='$id_user';");
			$mysqli->query("SET @p3='$id_note';");
			$result = $mysqli->query("CALL `editNotes`(@p0, @p1, @p2, @p3)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=notes_teach");
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
			
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT * FROM notes WHERE id_note='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$text = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				echo "<div id='main_a'>";
				
				echo "<h2>Редактор заметок</h2>";
				echo '<img class="illustration" src="file/undraw_Book_lover_re_rwjy.png">';
				echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
				
				if($_SESSION['res']){
					echo $_SESSION['res'];
					unset($_SESSION['res']);
				}
				
				print <<<HEREDOC
				<form enctype="multipart/form-data" action="" method="POST">
					<p><b>Название заметки:</b><br>
					<textarea id='editor1' type='text' name='name' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[name]</textarea>
					<input type='hidden' name='id_note' style='width:420px;' value='$text[id_note]'>
					</p>

					<p><b>Текст:</b><br>
					<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[text]</textarea>
					</p>

				HEREDOC;

				echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
			
		}
	}
?>
