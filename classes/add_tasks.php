<?php

	class add_tasks extends ACore_teacher {
	
		// Добавление задания в базу данных
		protected function obr(){
			if(!empty($_FILES['img_src']['tmp_name'])){
				if(!move_uploaded_file($_FILES['img_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['img_src']['name'])){
					exit("Не удалось загрузить файл");
				}
				$img_src = '/STUD_PORTAL/file/'.$_FILES['img_src']['name'];
			}
			else{
				exit("Необходимо загрузить файл или архив");
			}
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
			$mysqli->query("SET @title = '$title', @img_src = '$img_src', @date_start = '$date_start', @date_end = '$date_end', @text = '$text', @discription = '$discription', @cat = '$cat'");
			$result = $mysqli->query("CALL `addTasks`(@title, @img_src, @date_start, @date_end, @text, @discription, @cat)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=add_tasks");
				exit;
			}	
		}
		
		// Вывод формы для создания задания
		public function get_content(){
			echo "<div id='main'>";
			echo "<h2>Добавить новое задание</h2>";
			echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
			$cat = $this->get_categories();
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Название задания:</b><br>
				<textarea id='editor1' type='text' name='title' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>
				
				<p><b>Тип работы (например, "Лабораторная работа №1" или "Контрольная работа №4"):</b><br>
				<textarea id='editor2' name='discription' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>

				<p><b>Описание задания:</b><br>
				<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>
				
				<p><b>Крайняя дата сдачи:</b><br>
				<input type='date' name='date_end'>
				</p>
				
				<p><b>Материалы (файл/архив):</b><br>
				<input type='file' name='img_src'>
				</p>
				
				<p><b>Предмет:</b><br>
				<select name='cat'>
			HEREDOC;
			foreach($cat as $item){
				echo "<option value='".$item['id_category']."'>".$item['name_category']."</option>";
			}
			echo "</select><p><input type='submit' name='button' value='Сохранить'></p></form>
			
			</div>";
		}
	}
?>
