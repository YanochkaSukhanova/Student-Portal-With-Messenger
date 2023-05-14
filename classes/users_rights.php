<?php
class users_rights extends ACore_admin {
	// Список пользователей с определенными правами 
	public function get_content(){	
		echo '<div id="main_a">';	
		if(!$_GET['rights_of_users']){
			echo 'Неправильные данные для вывода статьи';
		}
		else{
			$rights_of_users = $_GET['rights_of_users'];
			if(!$rights_of_users){
				echo 'Неправильные данные для вывода статьи';
			}
			else{
				if($rights_of_users == 'student'){
					$a = 'Студенты';
				}
				else if($rights_of_users == 'teacher'){
					$a = 'Преподаватели';
				}
				else if($rights_of_users == 'admin'){
					$a = 'Администраторы';
				}
				else if($rights_of_users == 'no_rights'){
					$a = 'Пользователи без прав';
				}
				else{
					$a = 'Ошибка: неизвестный тип пользователей';
				}
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT * 
					  FROM users
					  WHERE rights='$rights_of_users' ";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				echo "<h2 style='color: #cc0605'> $a</h2>";				
				$row = array();
				$count = mysqli_num_rows($result);
		if($count == 0){
			echo "<div>Данные на этой странице отсутствуют</div><br>";
			echo '<a style="margin-right: 1000px" href="?option=add_user"><button>Добавить нового пользователя</button></a><br>';		
			echo '<img class="illustration_big" src="file/undraw_Engineering_team_re_fvat.png">';
		}
			echo '<img class="illustration" src="file/undraw_Engineering_team_re_fvat.png">';
			echo '<a style="margin-right: 1000px" href="?option=add_user"><button>Добавить нового пользователя</button></a><br>';		
			echo '<table class="table_center" border="1" cellspacing="0" cellpadding="12">
				<tr style= "background-color:#fff3ed;">
				<td><a style="color:#585858, text-decoration: none"><b>ID</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Логин</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Фамилия</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Имя</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Отчество</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>e-mail</b></a></td>
				<td colspan=2><a style="color:#585858, text-decoration:"><b>Редактировать</b></a></td></tr>';
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<tr><p style='font-size:20px;'>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858' href='?option=edit_user&id_text=%s'>Изменить</a></td>
		       <td><a style='color:red' href='?option=delete_user&del_text=%s'>Удалить</a></td></p></tr>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email'], $row['id'], $row['id']);
		}		
		echo "</table></div>";
			}
		}
	}
}
?>
