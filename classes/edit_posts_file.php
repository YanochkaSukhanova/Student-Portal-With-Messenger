<?php
class edit_posts_file extends ACore_teacher {
	// Изменение файла, прикрепленного к лекции
	protected function obr(){
		if(!empty($_FILES['file_src']['tmp_name'])){
			if(!move_uploaded_file($_FILES['file_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['file_src']['name'])){
				exit("Не удалось загрузить файл");
			}
			$file_src = '/STUD_PORTAL/file/'.$_FILES['file_src']['name'];
		}
		else{
			exit("Необходимо загрузить файл");
		}
		$id = $_POST['id'];			
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @p0='$file_src';");
		$mysqli->query("SET @p1='$id';");
		$result = $mysqli->query("CALL `editPostFile`(@p0, @p1)");
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=teachers_predmets");
			exit;
		}
	}
	
	// Форма для изменения файла, прикрепленного к лекции
	public function get_content(){
		if ($_GET['id_text']){
			$id_text = (int)$_GET['id_text'];
		}
		else{
			exit("Некорректные данные для страницы");
		}
		$text = $this->get_text_posts($id_text);
		echo "<div id='main'>";
		echo "<h2>Изменение материалов лекций</h2>";
		echo "<div>Прикрепите файл или архив. После загрузки нажмите &#8220;Сохранить&#8220;</div>";
		$cat = $this->get_categories();
		print <<<HEREDOC
		<form enctype="multipart/form-data" action="" method="POST">
			<p><b>Новый файл/архив:</b><br>
			<input type='file' name=' file_src'>
			<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
			</p>
		HEREDOC;
		echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
	}
}
?>
