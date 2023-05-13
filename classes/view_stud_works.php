<?php

	class view_stud_works extends ACore_teacher{
		
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
				
			$query_t = "SELECT *	
			FROM tasks
			WHERE id='$id_text'";
			$result_t = mysqli_query($link, $query_t);
			if(!$result_t){
				exit(mysqli_error($link));
			}
			$row_t = mysqli_fetch_array($result_t, MYSQLI_ASSOC);
			$r = $row_t['title'];
			
			echo "<h2>Работы студентов по теме &#8220;$r&#8220;</h2><br>";
			
			$query_w = "SELECT *	
			FROM students_works
			WHERE id_task='$id_text'";
			$result_w = mysqli_query($link, $query_w);
			if(!$result_w){
				exit(mysqli_error($link));
			}
			$row_w = mysqli_fetch_array($result_w, MYSQLI_ASSOC);
			
			$count = mysqli_num_rows($result_w);
			if($count == 0){	
				echo '<div>Нет еще выполненных заданий</div>';
				echo '<img class="illustration_big" src="file/undraw_learning_sketching_nd4f.png">';
			}
			else{
			
		   	echo '<img class="illustration" src="file/undraw_File_bundle_re_6q1e.png">';
		   	echo '<table class="table_center" border="1" cellspacing="0" cellpadding="12">
		   	<tr style="background:#fff3ed">
			<td><a style="color:#585858, text-decoration: none; "><b>Группа</b></a></td>
			<td><a style="color:#585858, text-decoration: none; "><b>ФИО студента</b></a></td>
			<td><a style="color:#585858, text-decoration: none; "><b>Дата сдачи</b></a></td>
			<td><a style="color:#585858, text-decoration: none; "><b>Статус</b></a></td>
			<td colspan=4><a style="color:#585858, text-decoration: none;"><b>Просмотр и оценка</b></a></td><tr>';
			   
			$query_u = "SELECT * FROM `users` WHERE (rights='student') and (student_group != 0)";
			$result_u = mysqli_query($link, $query_u);
			if(!$result_u){
				exit(mysqli_error($link));
			}
			$row_u = mysqli_fetch_array($result_u, MYSQLI_ASSOC);
			   
			   $row = array();
			   for ($i = 0; $i < mysqli_num_rows($result_u); $i++){
			   $row = mysqli_fetch_array($result_u, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				
			   	$row1 = array();
			        for ($i = 0; $i < mysqli_num_rows($result_w); $i++){
				$row1 = mysqli_fetch_array($result_w, MYSQLI_ASSOC); //---последовательно считываем ряды результата
					$gr = $row_u['student_group'];
					
					$query_g = "SELECT * FROM `stud_groups` WHERE id_group=$gr";
					$result_g = mysqli_query($link, $query_g);
					if(!$result_g){
						exit(mysqli_error($link));
					}
					$row_g = mysqli_fetch_array($result_g, MYSQLI_ASSOC);

					printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s %s %s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858' href='?option=view_work&id_text=%s'>Проверить</a></td></p></tr>", $row_g['name_group'], $row_u['last_name'], $row_u['first_name'], $row_u['middle_name'], $row_w['date'], $row_w['status'], $row_w['id']);
			   
			   	}
			   }
			   }
			   }
			   
			   echo "</div>";
		}
	}
}
?>
