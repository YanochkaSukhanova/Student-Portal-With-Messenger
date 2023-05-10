<?php
	class edit_task extends ACore_teacher {
	
		protected function obr(){
			
			$id = $_POST['id'];
			$title = $_POST['title'];
			$date_start = date("y-m-d", time());
			$date_end = $_POST['date_end'];
			$discription = $_POST['discription'];
			$text = $_POST['text'];
			$cat = $_POST['cat'];
			
			if( empty($title) || empty($text) || empty($discription) ){
				exit("Не заполнены обязательные поля");
			}
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$title';");
			$mysqli->query("SET @p1='$date_start';");
			$mysqli->query("SET @p2='$date_end';");
			$mysqli->query("SET @p3='$text';");
			$mysqli->query("SET @p4='$discription';");
			$mysqli->query("SET @p5='$cat';");
			$mysqli->query("SET @p6='$id';");
			$result = $mysqli->query("CALL `editTask`(@p0, @p1, @p2, @p3, @p4, @p5, @p6)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=tasks_teach");
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
			
				$text = $this->get_text_task($id_text);
				
				echo "<div id='main_a'>";
				
				echo "<h2>Редактор заданий</h2>";
				echo '<img class="illustration" src="file/undraw_Book_lover_re_rwjy.png">';
				echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
				
				if($_SESSION['res']){
					echo $_SESSION['res'];
					unset($_SESSION['res']);
				}
			
				$cat = $this->get_categories();
				
				print <<<HEREDOC
				<form enctype="multipart/form-data" action="" method="POST">
					<p><b>Название задания:</b><br>
					<textarea id='editor1' type='text' name='title' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[title]</textarea>
					<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
					</p>
					
					<p><b>Тип работы (например, "Лабораторная работа №1" или "Контрольная работа №4"):</b><br>
					<textarea id='editor2' type='text' name='discription' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[discription]</textarea>
					</p>

					<p><b>Описание задания:</b><br>
					<textarea id='editor3' name='text' type='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[text]</textarea>
					</p>
					
					<p><b>Крайний срок сдачи:</b><br>
					<input type='date' name='date_end' value= '$text[date_end]'>
					</p>
					
					<p><b>Предмет:</b><br>
					<select name='cat'>
				HEREDOC;
				foreach($cat as $item){
					if($text['cat'] == $item['id_category']){
						echo "<option selected value='".$item['id_category']."'>".$item['name_category']."</option>";
					}	
					else {
						echo "<option value='".$item['id_category']."'>".$item['name_category']."</option>";
					}
					
				}
				echo "</select><p><input type='submit' name='button' value='Сохранить'></p></form>
				
				
				
				</div>";
			//}
			
		}
	}
?>
