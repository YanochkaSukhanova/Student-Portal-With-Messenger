<?php
 
class add_user_to_group extends ACore_admin {

	public function get_content(){
			
		echo '<div id="main_a">';
						
						
		if(!$_GET['id_text']){
			echo 'Неправильные данные для вывода статьи';
		}
		else{
			$id_text = (int)$_GET['id_text'];
			if(!$id_text){
				echo 'Неправильные данные для вывода статьи';
			}
			else{
				
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT * 
					  FROM `groups`
					  WHERE id_group='$id_text' ";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				
				$group = array();
				for ($i = 0; $i < mysqli_num_rows($result); $i++){
				   	$group = mysqli_fetch_array($result, MYSQLI_ASSOC);
				}
				$a = $group['name_group'];
				echo "<h2 style='color: #cc0605'>Добавить студента в группу &#8220;$a&#8220;</h2>";
				
				$link_a = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query_a = "SELECT * 
					  FROM users
					  WHERE rights = 'student'";
				$result_a = mysqli_query($link_a, $query_a);
				if(!$result_a){
					exit(mysqli_error($link_a));
				}
				
				$link_b = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query_b = "SELECT * 
					  FROM `groups`";
				$result_b = mysqli_query($link_b, $query_b);
				if(!$result_b){
					exit(mysqli_error($link_b));
				}
				$group_b = array();
				

				
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="add_count_student.php" method="POST">
				<p><b>Выберите ID студента:</b><br>
				<select name='student_group'>
			HEREDOC;
			$student_group = array();
			for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
			   	$student_group = mysqli_fetch_array($result_a, MYSQLI_ASSOC);
			   	echo "<option value='".$student_group['id']."'>".$student_group['id']."</option>";
			}
			echo "</select>";
			
			echo "<p><input type='submit' name='button' value='Добавить в группу'></p></form></div>";
				
				
			echo '<img class="illustration" src="file/undraw_Selecting_team_re_ndkb.png">';
		
			echo '<table class="table_center" border="1" cellspacing="0" cellpadding="12">
				<tr style= "background-color:#fff3ed;">
				<td><a style="color:#585858, text-decoration: none"><b>ID</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Логин</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Фамилия</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Имя</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Отчество</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>e-mail</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Группа</b></a></td></tr>';
			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
				$row = mysqli_fetch_array($result_a, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				
					printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td></tr>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email'], '-');
					       
					       
				for ($i = 0; $i < mysqli_num_rows($result_b); $i++){
				   	$group_b = mysqli_fetch_array($result_b, MYSQLI_ASSOC);
				   	
				   	if(($row['student_group'] != 0) || ($row['student_group'] == $group_b['id_group'])){
				   	
					printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td></tr>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email'], $group_b['id_group']);
				   	}
				   	else if ($row['student_group'] == 0){
				   	printf("<tr><p style='font-size:20px;'>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td></tr>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email'], '-');
				   	}
				}
			}
			
		echo "</table></div>";
	
		}
		
		}
	}
			
	
}
?>