<?php
class tasks_teach extends ACore_teacher {
	//Список предметов, созданных преподавателем, по которым преподаватель может публиковать задания для студентов
	public function get_content(){
		$my_id = $_SESSION['user']['id'];
		$query = "SELECT id_category, name_category FROM category WHERE autor_id='$my_id'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		echo "<div id='main'>";
		echo "<h2>Мои задания</h2><br>";
		echo '<img class="illustration" src="file/undraw_Book_lover_re_rwjy.png">';
		echo "<br><div style='margin-right: 500px'><a style='text-align:left' href='?option=add_tasks'><button>Добавить новое задание</button></a></div>";
		echo "<br><div>Чтобы открыть список заданий, выберите нужный предмет</div><br>";
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<p style='font-size:20px;'>
				<a style='color:#585858;  text-decoration: none;' href='?option=tasks_of_predmets&id_cat=%s'>%s</a></p></div>",   $row['id_category'], $row['name_category']);
		}
		echo "</div>";
	}
}
?>
