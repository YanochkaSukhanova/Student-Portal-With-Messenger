<?php

	class add_posts extends ACore_teacher {
	
		protected function obr(){
			
			if(!empty($_FILES['img_src']['tmp_name'])){
				if(!move_uploaded_file($_FILES['img_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['img_src']['name'])){
					exit("Не удалось загрузить изображение");
				}
				$img_src = '/STUD_PORTAL/file/'.$_FILES['img_src']['name'];
			}
			else{
				exit("Необходимо загрузить файл или архив");
			}
			
			$title = $_POST['title'];
			$date = date("y-m-d", time());
			$discription = $_POST['discription']; 
			$text = $_POST['text'];
			$cat = $_POST['cat'];
			
			if( empty($title) || empty($text) || empty($discription) ){
				exit("Не заполнены обязательные поля");
			}
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @title = '$title', @img_src = '$img_src', @date = '$date', @text = '$text', @discription = '$discription', @cat = '$cat'");
			$result = $mysqli->query("CALL `addPosts`(@title, @img_src, @date, @text, @discription, @cat)");
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=add_posts");
				exit;
			}
		
		}
		
		public function get_content(){
			echo "<div id='main'>";
			
			echo "<h2>Добавить новую лекцию</h2>";
			echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
		
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			$cat = $this->get_categories();
			
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Название лекции:</b><br>
				<textarea id='editor1' type='text' name='title' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>
				
				<p><b>Краткое описание (например, "Лекция №12" или "Дополнительные материалы по курсу"):</b><br>
				<textarea id='editor2' name='discription' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
				</p>

				<p><b>Текст лекции:</b><br>
				<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
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
