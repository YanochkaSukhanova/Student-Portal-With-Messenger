<?php
class tasks_of_predmets_stud extends ACore_student{
	// Список заданий, относящихся к выбранному предмету
	public function get_content(){					
		if(!$_GET['id_cat']){
			echo 'Неправильные данные для вывода страницы';
		}
		else{
			$id_cat = (int)$_GET['id_cat'];
			if(!$id_cat){
				echo 'Неправильные данные для вывода страницы';
			}
			else{
				$query = "SELECT id, title, cat, discription, date_start, date_end
					  FROM tasks
					  WHERE cat='$id_cat' 
					  ORDER BY date_end ASC";
			   	$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			   	$result = mysqli_query($link, $query);
			   	if(!$result){
			    		exit(mysqli_error($link));
			   	}
			   echo "<br><div id='main_a'>";
			   $query_a = "SELECT id_category, name_category 
					  FROM category
					  WHERE id_category='$id_cat' ";
			   $link_a = mysqli_connect(HOST, USER, PASSWORD, DB);
			   $result_a = mysqli_query($link_a, $query_a);
			   if(!$result_a){
			    	exit(mysqli_error($link_a));
			   }
			   $name_cat = array();
			   for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
			   	$name_cat = mysqli_fetch_array($result_a, MYSQLI_ASSOC);
			   }
			   $a = $name_cat['name_category'];
			   echo "<h2 style='color: #cc0605'>Задания по предмету &#8220;$a&#8220;</h2>"; 
			   $count = mysqli_num_rows($result);
			   if($count == 0){
				echo "<div>Данные на этой странице отсутствуют</div><br>
					<div>Скоро преподаватель добавит задания, и вы сможете начать выполнение</div>";
				echo '<img class="illustration_big" src="file/undraw_learning_sketching_nd4f.png">';
			   }
			   else{
			   	echo '<img class="illustration" src="file/undraw_File_bundle_re_6q1e.png">';
			   	echo '<table class="table_center" border="1" cellspacing="0" cellpadding="12">
			   	<tr style="background:#fff3ed">
				<td><a style="color:#585858, text-decoration: none; "><b>Название</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Тип работы</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Крайняя дата сдачи</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Статус</b></a></td>
				<td colspan=4><a style="color:#585858, text-decoration: none;"><b>Просмотр и сдача</b></a></td><tr>';
			   }
			   $my_id = $_SESSION['user']['id']; 
			   $row = array();
			   for ($i = 0; $i < mysqli_num_rows($result); $i++){
			   	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			   		$id_task = $row['id'];
			   		$query1 = "SELECT * FROM students_works WHERE id_task='$id_task' and id_user ='$my_id'";	
					$result1 = mysqli_query($link, $query1);
					if(!$result1){
						exit(mysqli_error($link));
					}
					$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);		
					$count = mysqli_num_rows($result1);
					if($count == 0){
						$status = "Не отправлено";
					}
					else{
						$status = $row1['status'];
					}
					if ($status == "Не отправлено"){
						printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><b><a style='color:#585858, text-decoration: none''>&#10060; %s</a></b></td>
					       <td><a style='color:#585858' href='?option=view_task_stud&id_text=%s'>Открыть задание</a></td>
</p></tr>",    $row['title'], $row['discription'],  $row['date_end'], $status, $row['id'], $row['id']);
					}
					else if ($status == "Исправить"){
						printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><b><a style='color:#585858, text-decoration: none''>&#128257; %s</a></b></td>
					       <td><a style='color:#585858' href='?option=view_task_stud&id_text=%s'>Открыть задание</a></td>
</p></tr>",    $row['title'], $row['discription'],  $row['date_end'], $status, $row['id'], $row['id']);
					}
					else if ($status == "Нa проверке"){
						printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><b><a style='color:#585858, text-decoration: none''>&#8987; %s</a></b></td>
					       <td><a style='color:#585858' href='?option=view_task_stud&id_text=%s'>Открыть задание</a></td>
</p></tr>",    $row['title'], $row['discription'],  $row['date_end'], $status, $row['id'], $row['id']);
					}
					else{
						printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><b><a style='color:#585858, text-decoration: none''>&#9989; %s</a></b></td>
					       <td><a style='color:#585858' href='?option=view_task_stud&id_text=%s'>Открыть задание</a></td>
</p></tr>",    $row['title'], $row['discription'],  $row['date_end'], $status, $row['id'], $row['id']);
					}
			   }		   
			   echo "</div>"; 
			  }
 		}
 	}
 }
?>
