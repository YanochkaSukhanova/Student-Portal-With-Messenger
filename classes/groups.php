<?php
class groups extends ACore_admin {
	// Вывод списка всех групп
	public function get_content(){
		$query = "SELECT * FROM `stud_groups`";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		echo "<div id='main_a'>";		
		echo "<h2>Редактировать группы</h2>";
		echo '<img class="illustration" src="file/undraw_Lives_matter_38lv.png">';
		echo "<br><div style='margin-right: 500px'><a style='text-align:left' href='?option=add_group'><button>Добавить новую группу</button></a></div>";
		$query_a = "SELECT * FROM `users` WHERE rights='student' and student_group=0";
		$link_a = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result_a = mysqli_query($link_a, $query_a);
		if(!$result_a){
			exit(mysqli_error($link_a));
		}
		$kol = mysqli_num_rows($result_a);
		$r = mysqli_fetch_array($result_a, MYSQLI_ASSOC);
		echo "<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<p style='font-size:20px; color:#585858'>
			<b><a style='color:#585858, text-decoration: none'>Студенты, не зачисленные в группу</a><br></b>
			<a>Количество студентов: $kol</a><br>
			<a style='color:#585858' href='?option=add_user_to_group'>Посмотреть или изменить</a></div>";		
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px; color:#585858'>
				<b><a style='color:#585858, text-decoration: none'>%s</a><br></b>
				<a>Количество студентов: %s</a><br>
				<a style='color:#585858' href='?option=edit_group&id_text=%s'>Посмотреть или изменить</a> - 
				<a style='color:red' href='?option=delete_group&del_text=%s'>Удалить</a></p></div>",   $row['name_group'], $row['count_students'], $row['id_group'], $row['id_group']);
		}
		echo "</div>";
	}
}
?>
