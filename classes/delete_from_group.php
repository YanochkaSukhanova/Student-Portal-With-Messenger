<?php

class delete_from_group extends ACore_admin{

	public function obr(){
		if ($_GET['del_text']){
			$user_id = (int)$_GET['del_text'];
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT student_group
				  FROM `users`
				  WHERE id='$user_id'";
			$id_group = mysqli_query($link, $query);
			if(!$id_group){
				exit(mysqli_error($link));
			}
			$r1 = array();
			$r1 = mysqli_fetch_array($id_group, MYSQLI_ASSOC);
			$id_gr = $r1['student_group']; 
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT * 
				  FROM `stud_groups`
				  WHERE id_group='$id_gr'";
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			$query_a = "SELECT id
				  FROM `users`
				  WHERE student_group='$id_gr'";
			$result_a = mysqli_query($link, $query_a);
			if(!$result_a){
				exit(mysqli_error($link));
			}
			
			$id_group_null = (int)0;
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @user_id = '$user_id', @id_group = '$id_group_null'");
			$result = $mysqli->query("CALL `addUserToGroup`(@user_id, @id_group)");
			if(!$result){
				$_SESSION['res']="Не удалось добавить студента в группу";
				header("Location:?option=groups");
				exit(); 
			}

			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT count(*) 
				  FROM `users` 
				  WHERE student_group = '$id_gr'";
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			$r = mysqli_fetch_array($result, MYSQLI_ASSOC); 	
			$count_students = (int)$r - 1;
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @id_group = '$id_gr', @count_students = '$count_students'");
			$result = $mysqli->query("CALL `editCountStudents`(@id_group, @count_students)");		
			
	  		if(!$result){
			exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=groups");
				exit;
			}
			
		}
		else {
			exit("Неверные данные для отображения страницы");
		}
	}	
	
	public function get_content(){}
}

?>
