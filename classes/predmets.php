<?php
class predmets extends ACore_student {
	// Доступные предметы, по которым студент может посмотреть лекции
	public function get_content(){
		$query = "SELECT id_category, name_category FROM category";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		echo "<div id='main_a'>";
		echo "<h2>Мои предметы</h2>";
		echo '<img class="illustration" src="file/undraw_Educator_re_s3jk.png">';
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
				<a style='color:#585858; text-decoration: none;' href='?option=category&id_cat=%s'>%s</a></p></div>",   $row['id_category'], $row['name_category']);
		}
		echo '</div>';
	}
}
?>
