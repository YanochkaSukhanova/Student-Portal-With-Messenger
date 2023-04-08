<?php
 
class add_user_to_group extends ACore_admin {


	protected function obr(){
			
		$id_group = $_POST['id_group'];
		$user_id = $_POST['user_id'];
		
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @user_id = '$user_id', @id_group = '$id_group'");
		$result = $mysqli->query("CALL `addUserToGroup`(@user_id, @id_group)");
		
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$query = "SELECT * 
			  FROM `stud_groups` 
			  WHERE id_group = '$id_group'";
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$query = "SELECT * 
			  FROM `stud_groups` 
			  WHERE id_group = '$id_group'";
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$r = mysqli_fetch_array($result, MYSQLI_ASSOC); 	
		$count_students = (int)$r + 1;
		
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @id_group = '$id_group', @count_students = '$count_students'");
		$result = $mysqli->query("CALL `editCountStudents`(@id_group, @count_students)");		
		
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=add_user_to_group");
			exit;
		}
			
	}
	
	public function get_content(){	
				
		echo '<div id="main_a">';	
		echo "<h2 style='color: #cc0605'>Добавить студента в группу</h2>";
				
		$link_a = mysqli_connect(HOST, USER, PASSWORD, DB);
		$query_a = "SELECT * 
			  FROM users
			  WHERE rights = 'student' and student_group=0";
		$result_a = mysqli_query($link_a, $query_a);
		if(!$result_a){
			exit(mysqli_error($link_a));
		}
		$K = mysqli_num_rows($result_a);
		
		if ($K != 0){ 
		
			$link_b = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query_b = "SELECT * 
				  FROM `stud_groups`";
			$result_b = mysqli_query($link_b, $query_b);
			if(!$result_b){
				exit(mysqli_error($link_b));
			}
			$group_b = array();		
				
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
					       <td><a style='color:#585858, text-decoration: none''>%s</a></td>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email']);
					       
			       echo "<td><a style='color:#585858, text-decoration: none''>";
				$id_stud = $row['id'];
				print <<<HEREDOC
				<form enctype="multipart/form-data" action="" method="POST">
					<select name='id_group'>
				HEREDOC;
				$student_group = array();
				for ($i = 0; $i < mysqli_num_rows($result_b); $i++){
				   	$student_group = mysqli_fetch_array($result_b, MYSQLI_ASSOC);
				   	echo "<option value='".$student_group['id_group']."'>".$student_group['name_group']."</option>";
				}
				echo "</select>";
				echo "<p><input type='hidden' name='user_id' value='$id_stud'></p>";
				echo "<p><input type='submit' name='button' value='Добавить в группу'></p></form></div>";
			       
			       echo "</a></td></tr>";
			}
			
			echo "</table></div>";	
			
		}
		else{
			echo '<img class="illustration" src="file/undraw_Selecting_team_re_ndkb.png">';
			echo '<br>
				<p>В данный момент нет студентов, которым не назначена группа</p></div>';	
		}
	}
}
?>
