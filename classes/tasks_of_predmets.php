<?php
 
class tasks_of_predmets extends ACore_teacher{
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
					  ORDER BY date_start DESC";
			   	$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			   	$result = mysqli_query($link, $query);
			   	if(!$result){
			    		exit(mysqli_error($link));
			   	}
			
			  
			   echo "<br><div id='main_a'>";
			   
			   if($_SESSION['res']){
			    	echo $_SESSION['res'];
			    	unset($_SESSION['res']);
			   }
			   
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
			   echo "<h2 style='color: #cc0605'>Редактировать задания по предмету &#8220;$a&#8220;</h2>";
			   
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
				<td><a style="color:#585858, text-decoration: none; "><b>Название</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Тип работы</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Дата создания</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Крайняя дата сдачи</b></a></td>
				<td><a style="color:#585858, text-decoration: none; "><b>Работы студентов</b></a></td>
				<td colspan=4><a style="color:#585858, text-decoration: none;"><b>Просмотр и изменение</b></a></td><tr>';
			   
				
			   
			   $row = array();
			   for ($i = 0; $i < mysqli_num_rows($result); $i++){
			   	$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата

					printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858' href='?option=view_stud_works&id_text=%s'>Проверить</a></td>
					       <td><a style='color:#585858' href='?option=view_task&id_text=%s'>Посмотреть</a></td>
					       <td><a style='color:#585858' href='?option=edit_task&id_text=%s'>Изменить описание</a></td>
					       <td><a style='color:#585858' href='?option=edit_task_file&id_text=%s'>Изменить файл</a></td>
					       <td><a style='color:red' href='?option=delete_task&del_text=%s'>Удалить</a></td></p></tr>",    $row['title'], $row['discription'],  $row['date_start'], $row['date_end'], $row['id'], $row['id'], $row['id'], $row['id'], $row['id']);
			   
			   }
			   }
			   
			   echo "</div>";
			  }
 		}
 }
 }
?>
