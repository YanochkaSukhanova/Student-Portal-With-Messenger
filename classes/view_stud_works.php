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
				
				
				//g.name_group as name_group, g.id_group as id_group, u.first_name as first_name, u.last_name as last_name, u.middle_name as middle_name, s.date as date, s.status as status, s.id_task as id_task, s.id as id_work, u.student_group as student_group, t.id as id_task_1
				
				//ON s.id_task='$id_text' and g.id_group=u.student_group and s.id_task = t.id
				
				
				/*$query = "SELECT s.id as id_work, s.status as status, s.id_user as id_user, s.id_task as id_task, s.date as date,
						t.id as task_id,
						u.first_name as first_name, u.last_name as last_name, u.middle_name as middle_name, u.rights as rights, u.student_group as student_group,
						g.id_group as id_group, g.name_group as name_group
							
					FROM students_works AS s
					JOIN users AS u
					JOIN stud_groups AS g
					JOIN tasks AS t
					ON (s.id_task = t.id) and (u.student_group = g.id_group) and s.id_task='$id_text'
					ORDER BY g.name_group, u.last_name DESC";*/
				/*$query = "SELECT *
				FROM users
				WHERE rights = 'student'";*/
			   	
			   	
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
				$id_stud = $row_u['id'];	
				echo $id_stud;
				$query_w = "SELECT *	
					FROM students_works
					WHERE id_task='$id_text' and id_user='$'";
					$result_w = mysqli_query($link, $query_w);
					if(!$result_w){
						exit(mysqli_error($link));
					}
					$row_w = mysqli_fetch_array($result_w, MYSQLI_ASSOC);
				
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
					       <td><a style='color:#585858' href='?option=view_stud_works&id_text=%s'>Посмотреть работы</a></td></p></tr>", $row_g['name_group'], $row_u['last_name'], $row_u['first_name'], $row_u['middle_name'], $row_w['date'], $row_w['status'], $row_w['id_work']);
			   
			   	}
			   }
			   
			   }
			   
			   echo "</div>";
			   
			   
			   
			   	
			   	
			   	/*
			   	
			   	
			   	$count = mysqli_num_rows($result);
			   	
			   if($count == 0){
				echo "<div>Данные на этой странице отсутствуют</div><br>
					<div>Добавьте новое задание, чтобы студенты могли начать обучение по предмету &#8220;$a&#8220;</div>
					<br><div style='margin-right: 540px'><a style='text-align:left' href='?option= add_tasks'><button>Добавить задание</button></a></div>";
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
			   
				
			   
			   $row = array();
			   for ($i = 0; $i < mysqli_num_rows($result); $i++){
			   	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата

					printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s %s %s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858' href='?option=view_stud_works&id_text=%s'>Посмотреть работы</a></td></p></tr>", $row['name_group'], $row['last_name'], $row['first_name'], $row['middle_name'], $row['date'], $row['status'], $row['id_work']);
			   
			   	}
			   }
			   
			   echo "</div>";
			}*/
		}
	}
}
?>
