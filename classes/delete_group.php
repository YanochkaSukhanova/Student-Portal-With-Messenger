<?php

class delete_group extends ACore_admin{

	public function obr(){
		if ($_GET['del_text']){
			$id_group = (int)$_GET['del_text'];
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT * 
				  FROM `stud_groups`
				  WHERE id_group='$id_group' ";
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			$query_a = "SELECT id
				  FROM `users`
				  WHERE student_group='$id_group'";
			$result_a = mysqli_query($link, $query_a);
			if(!$result_a){
				exit(mysqli_error($link));
			}
			
			$id_group_null = (int)0;
			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
				$row = mysqli_fetch_array($result_a, MYSQLI_ASSOC);
				
				$user_id = $row['id'];
				
				$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
				$mysqli->query("SET @user_id = '$user_id', @id_group = '$id_group_null'");
				$result = $mysqli->query("CALL `addUserToGroup`(@user_id, @id_group)");
				if(!$result){
					$_SESSION['res']="Не удалось переназначить пользователю группу";
					header("Location:?option=groups");
					exit(); 
				}
			}
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_group';");
			$result = $mysqli->query("CALL `deleteGroup`(@p0)");
			if($result){
				$_SESSION['res']="Группа успешно удалена";
				header("Location:?option=groups");
				exit();
			}
			else{
				exit("Ошибка удаления группы");
			}	  
			
		}
		else {
			exit("Неверные данные для отображения страницы");
		}
	}	
	
	public function get_content(){}
}

?>
