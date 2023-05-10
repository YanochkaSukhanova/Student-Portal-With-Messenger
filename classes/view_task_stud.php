<?php

	class view_task_stud extends ACore_student{
	
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
			
			$text = $_POST['text'];
			$date = date("y-m-d", time());
			$status = $_POST['status'];
			$id_user = $_SESSION['user']['id'];
			$id_task = (int)$_GET['id_text'];
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$my_id = $_SESSION['user']['id'];
			$query2 = "SELECT * FROM students_works WHERE id_task='$id_task' and id_user = '$my_id'";
			$result2 = mysqli_query($link, $query2);
			if(!$result2){
				exit(mysqli_error($link));
			}
			$row1 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
			
			$count = mysqli_num_rows($result2);
			   if($count == 0){
			   	// добавить
						
				$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
				$mysqli->query("SET @p1='$text';");
				$mysqli->query("SET @p2='$date';");
				$mysqli->query("SET @p3='$file_src';");
				$mysqli->query("SET @p4='$status';");
				$mysqli->query("SET @p5='$id_user';");
				$mysqli->query("SET @p6='$id_task';");
				$result = $mysqli->query("CALL `addStudWork`(@p1, @p2, @p3, @p4, @p5, @p6)");
				if(!$result){
					exit(mysqli_error($mysqli));
				}
				else {
					$_SESSION['res'] = "Изменения сохранены";
					header("Location:?option=tasks_stud");
					exit;
				}
			   }
			   else {
			   	//исправить
			   	$id = $_POST['id_work'];
			   	
			   	$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			   	$mysqli->query("SET @p0='$id';");
				$mysqli->query("SET @p1='$text';");
				$mysqli->query("SET @p2='$date';");
				$mysqli->query("SET @p3='$file_src';");
				$mysqli->query("SET @p4='$status';");
				$mysqli->query("SET @p5='$id_user';");
				$mysqli->query("SET @p6='$id_task';");
				$result = $mysqli->query("CALL `editStudWork`(@p0, @p1, @p2, @p3, @p4, @p5, @p6)");
				if(!$result){
					exit(mysqli_error($mysqli));
				}
				else {
					$_SESSION['res'] = "Изменения сохранены";
					header("Location:?option=tasks_stud");
					exit;
				}
			   }
			
			
			
			
		
		}
		
		
		public function get_content(){
		
		echo '<div id="main_a">';
	
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
				$query = "SELECT title, discription, text, date_start, date_end, file_src, id FROM tasks WHERE id='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				printf("<h2>%s</h2>  
				
					<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='font-size: 20px'><b>%s</b></div></p>
					<p><div style='text-align:left'>%s</div></p>
					
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b>
					
					<p><b>Последнее изменение: %s | Крайняя дата сдачи: %s</b></p></div>", $row['discription'], $row['title'], $row['text'], $row['file_src'], basename($row['file_src']), $row['date_start'], $row['date_end']);
					
				echo "<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>";
				echo "<p><div style='font-size: 20px'><b>Сдача задания:</b></div></p>";	
				
				$my_id = $_SESSION['user']['id'];
				
				$query1 = "SELECT * FROM students_works WHERE id_task='$id_text' and id_user = '$my_id'";
				$result1 = mysqli_query($link, $query1);
				if(!$result1){
					exit(mysqli_error($link));
				}
				$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				
				$count = mysqli_num_rows($result1);
				   if($count == 0){
					//форма сдачи
					
					print <<<HEREDOC
					<form enctype="multipart/form-data" action="" method="POST">
						<p><b>Комментарий к работе:</b><br>
						<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '></textarea>
						</p>
						
						<p><b>Материалы (файл/архив):</b><br>
						<input type='file' name='file_src'>
						</p>
						
						<input type='hidden' name='status' value='Нa проверке'>
					HEREDOC;
					
					echo "<p><input type='submit' name='button' value='Сохранить'></p></form>";
				   }
				   else if($row1['status'] == "Исправить"){
				   	//если преподаватель отправил на переделку, то изменить
				   	$txt = $row1['text'];
				   	$id_work = $row1['id'];
				   	print <<<HEREDOC
					<form enctype="multipart/form-data" action="" method="POST">
						<p><b>Комментарий к работе:</b><br>
						<textarea id='editor3' name='text' style='width:1000px; height:100px; font-size: 16px;  font-family: Geometria; src: url(font/Geometria.ttf); '>$txt</textarea>
						</p>
						
						<p><b>Материалы (файл/архив):</b><br>
						<input type='file' name='file_src'>
						</p>
						
						<input type='hidden' name='status' value='Нa проверке'>
						<input type='hidden' name='id_work' value='$id_work'>
					HEREDOC;
					
					echo "<p><input type='submit' name='button' value='Сохранить'></p></form>";
				   }
				   else{
				   	//вывести результат
				   printf("<p><div style='text-align:left'><b>Комментарий:</b> %s</div></p>
				   	<p><div style='text-align:left'><b>Статус:</b> %s</div></p>
				   	<p><div style='text-align:left'><b>Дата сдачи:</b> %s</div></p>
					
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b>", $row1['text'], $row1['status'], $row1['date'], $row1['file_src'], basename($row1['file_src']));
				   }
					
					
					
				echo '</div><br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}
		}	
			
		echo '<br></div>';
	}
}
?>
