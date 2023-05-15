<?php
class view_work extends ACore_teacher{
	// Изменения статуса (оценки) задания
	protected function obr(){			
		$status = $_POST['status'];
		$id = $_POST['id_work'];
	   	$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
	   	$mysqli->query("SET @p0='$id';");
		$mysqli->query("SET @p1='$status';");
		$result = $mysqli->query("CALL `editWorkGrade`(@p0, @p1)");
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=tasks_teach");
			exit;
		}
	}
	
	// Отображение готовой работы студента и формы для проставления оценки или изменения статуса
	public function get_content(){
		echo '<div id="main">';
		if(!$_GET['id_text']){
			echo 'Неправильные данные для вывода страницы';
		}
		else{
			$id_text = (int)$_GET['id_text'];
			if(!$id_text){
				echo 'Неправильные данные для вывода страницы';
			}
			else{
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query_s = "SELECT * FROM students_works WHERE id='$id_text'";
				$result_s  = mysqli_query($link, $query_s);
				if(!$result_s){
					exit(mysqli_error($link));
				}
				$row_s = mysqli_fetch_array($result_s, MYSQLI_ASSOC);
				$id_task = $row_s['id_task'];
				$stud_id = $row_s['id_user'];
				
				$query_t = "SELECT title, discription, text, date_start, date_end, file_src, id FROM tasks WHERE id='$id_task'";
				$result_t = mysqli_query($link, $query_t);
				if(!$result_t){
					exit(mysqli_error($link));
				}
				$row_t = mysqli_fetch_array($result_t, MYSQLI_ASSOC);
				printf("<h2>%s</h2>  
					<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='font-size: 20px'><b>%s</b></div></p>
					<p><div style='text-align:left'>%s</div></p>
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b>
					<p><b>Последнее изменение: %s | Крайняя дата сдачи: %s</b></p></div>", $row_t['discription'], $row_t['title'], $row_t['text'], $row_t['file_src'], basename($row_t['file_src']), $row_t['date_start'], $row_t['date_end']);					
				echo "<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>";
				echo "<p><div style='font-size: 20px'><b>Сдача задания:</b></div></p>";		
				$query1 = "SELECT * FROM students_works WHERE id_task='$id_task' and id_user = '$stud_id'";
				$result1 = mysqli_query($link, $query1);
				if(!$result1){
					exit(mysqli_error($link));
				}
				$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				printf("<p><div style='text-align:left'><b>Комментарий:</b> %s</div></p>
				   	<p><div style='text-align:left'><b>Статус:</b> %s</div></p>
				   	<p><div style='text-align:left'><b>Дата сдачи:</b> %s</div></p>
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b>", $row1['text'], $row1['status'], $row1['date'], $row1['file_src'], basename($row1['file_src']));
				echo '</div><br><div>При наличии дополнительных комментариев по работе, Вы можете написать сообщение студенту</div>';					
				print <<<HEREDOC
				<form enctype="multipart/form-data" action="" method="POST">					
					<input type="hidden" name="id_work" value="$id_text" >
					<p><b>Оценка:</b><br>
					<select name='status'>
					<option selected value='Принято, оценка 5'>Принято, оценка 5</option>
					<option selected value='Принято, оценка 4'>Принято, оценка 4</option>
					<option selected value='Принято, оценка 3'>Принято, оценка 3</option>
					<option selected value='Исправить'>Исправить</option>
					</select>
				HEREDOC;
				echo "<p><input type='submit' name='button' value='Сохранить'></p></form>";					
				echo '</div><br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}	
		}			
		echo '<br></div>';
	}
}
?>
