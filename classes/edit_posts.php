<?php
class edit_posts extends ACore_teacher {
	// Изменение информации о лекции в базе данных
	protected function obr(){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$date = date("y-m-d", time());
		$discription = $_POST['discription'];
		$text = $_POST['text'];
		$cat = $_POST['cat'];
		if( empty($title) || empty($text) || empty($discription) ){
			exit("Не заполнены обязательные поля");
		}
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @p0='$title';");
		$mysqli->query("SET @p1='$date';");
		$mysqli->query("SET @p2='$text';");
		$mysqli->query("SET @p3='$discription';");
		$mysqli->query("SET @p4='$cat';");
		$mysqli->query("SET @p5='$id';");
		$result = $mysqli->query("CALL `editPosts`(@p0, @p1, @p2, @p3, @p4, @p5)");
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=teachers_predmets");
			exit;
		}
	}
	
	// Вывод формы для редактирования лекции
	public function get_content(){
		if ($_GET['id_text']){
			$id_text = (int)$_GET['id_text'];
		}
		else{
			exit("Некорректные данные для страницы");
		}
			$text = $this->get_text_posts($id_text);	
			echo "<div id='main_a'>";
			echo "<h2>Редактор лекций</h2>";
			echo '<img class="illustration" src="file/undraw_Book_lover_re_rwjy.png">';
			echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
			$cat = $this->get_categories();
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Название лекции:</b><br>
				<textarea id='editor1' type='text' name='title' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[title]</textarea>
				<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
				</p>
				
				<p><b>Краткое описание (например, "Лекция 12" или "Дополнительные материалы по курсу"):</b><br>
				<textarea id='editor2' type='text' name='discription' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[discription]</textarea>
				</p>

				<p><b>Текст лекции:</b><br>
				<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[text]</textarea>
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
			echo "</select><p><input type='submit' name='button' value='Сохранить'></p></form></div>";		
	}
}
?>
