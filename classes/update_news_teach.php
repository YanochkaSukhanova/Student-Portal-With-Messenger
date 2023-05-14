Ы<?php
class update_news_teach extends ACore_teacher {
	// Изменение информации о новости в базе данных
	protected function obr(){
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
		$id_group = $_POST['id_group'];
		$id_user = $_SESSION['user']['id'];
		$id_news = (int)$_GET['id_text'];
		if( empty($name) || empty($text) ){
			exit("Не заполнены обязательные поля");
		}
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @name = '$name', @text = '$text', @file_src = '$file_src', @id_user = '$id_user', @id_group = '$id_group', @id_news = $id_news");
		$result = $mysqli->query("CALL `editNews`(@name, @text, @file_src, @id_user, @id_group, @id_news)");
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		$_SESSION['res'] = "Изменения сохранены";
		header("Location:?option=news_teach");
		exit;
	}
	
	// Форма для изменения
	public function get_content(){
		if ($_GET['id_text']){
			$id_text = (int)$_GET['id_text'];
		}
		else{
			exit("Некорректные данные для страницы");
		}		
		echo "<div id='main_a'>";
		$my_id = $_SESSION['user']['id'];
		$link_b = mysqli_connect(HOST, USER, PASSWORD, DB);
		$query_b = "SELECT * 
			  FROM `stud_groups`";
		$result_b = mysqli_query($link_b, $query_b);
		$result_b1 = mysqli_query($link_b, $query_b);
		if(!$result_b){
			exit(mysqli_error($link_b));
		}
		$group_b = array();
		$query = "SELECT * 
			  FROM `news` WHERE id = '$id_text'";
		$result = mysqli_query($link_b, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$text = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$st_gr = array();
		$k = 0;
		$name_gr = "";
		for ($k = 0; $k < mysqli_num_rows($result_b); $k++){
		   	$st_gr = mysqli_fetch_array($result_b, MYSQLI_ASSOC);
			if($st_gr['id_group'] == $text['id_group']){
				$name_gr = $st_gr['name_group'];
			}	   	
		}
		echo "<h2>Редактировать новость &#8220; $text[name] - $name_gr &#8220; </h2>";
		echo '<img class="illustration" src="file/undraw_Certificate_re_yadi.png"><br>';
		echo "<div>После заполнения всех полей нажмите &#8220;Сохранить&#8220;</div>";
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
			<p><b>Название новости:</b><br>
			<textarea id='editor1' type='text' name='name' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[name]</textarea>
			</p>

			<p><b>Текст:</b><br>
			<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$text[text]</textarea>
			</p>
			
			<p><b>Материалы (файл/архив):</b><br>
			<input type='file' name='file_src'>
			</p>
			
			<p><b>Группа:</b><br>
			<select name='id_group'>
		HEREDOC;
		$student_group = array();
		$j = 0;
		for ($j = 0; $j < mysqli_num_rows($result_b1); $j++){
		   	$student_group = mysqli_fetch_array($result_b1, MYSQLI_ASSOC);
		   	echo "<option value='".$student_group['id_group']."'>".$student_group['name_group']."</option>";
		}
		echo "</select></p>";
		echo "<p><input type='hidden' name='user_id' value='$my_id'></p>";	
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
	}
}
?>
