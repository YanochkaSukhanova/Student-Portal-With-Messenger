<?php
class open_note_teach extends ACore_teacher{
	// Просмотр содержания выбранной заметки
	public function get_content(){
		echo '<div id="main_a">';
		if(!$_GET['id_text']){
			echo 'Неправильные данные для вывода заметки';
		}
		else{
			$id_text = (int)$_GET['id_text'];
			if(!$id_text){
				echo 'Неправильные данные для вывода заметки';
			}
			else{
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT * FROM notes WHERE id_note='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				printf("<h2>%s</h2>  
					<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left; white-space: pre-wrap'>%s</div></p></div>", $row['name'], $row['text']);		
				echo '<br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}
		}
		echo '<br></div>';
	}
}
?>
