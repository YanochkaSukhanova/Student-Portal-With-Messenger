<?php
class notes_teach extends ACore_teacher {
	// Отображение всех заметок, созданных пользователем
	public function get_content(){	
		$my_id = $_SESSION['user']['id'];
		$query = "SELECT * FROM notes WHERE id_user = $my_id";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		echo "<div id='main_a'>";
		echo "<h2>Мои заметки</h2>";
		echo '<img class="illustration" src="file/undraw_Add_notes_re_ln36.png">';
		echo "<br><div style='margin-right: 500px'>
			<a style='text-align:left' href='?option=add_note_teach'><button>Добавить заметку</button></a>
			</div>";
		$count = mysqli_num_rows($result);
		   if($count == 0){
			echo "<div><br>Данные на этой странице отсутствуют</div><br>
				<div>Добавьте новую заметку, чтобы сохранить важную информацию</div>";
		   }		
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px; color:#585858'>
				<a style='color:#585858, text-decoration: none'>%s</a><br> 
				<a style='color:#585858' href='?option=open_note_teach&id_text=%s'>Открыть</a> - 
				<a style='color:#585858' href='?option=update_note_teach&id_text=%s'>Изменить</a> - 
				<a style='color:red' href='?option=delete_note_teach&del_text=%s'>Удалить</a></p></div>",   $row['name'], $row['id_note'], $row['id_note'], $row['id_note']);
		}
		echo "</div>";
	}
}
?>
