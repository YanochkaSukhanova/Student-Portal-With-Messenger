<?php
 
class edit_group extends ACore_admin {

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
				
				$query_a = "SELECT * 
					  FROM users
					  WHERE rights='student'";
				$result_a = mysqli_query($link, $query_a);
				if(!$result_a){
					exit(mysqli_error($link_a));
				}
				
				$name_group = array();
				for ($i = 0; $i < mysqli_num_rows($result); $i++){
				   	$name_group = mysqli_fetch_array($result, MYSQLI_ASSOC);
				}
				$a = $name_group['name_group'];
				$id = $name_group['id_group'];
				echo "<h2 style='color: #cc0605'>Состав группы &#8220;$a&#8220;</h2>";
				
				$count = $name_group['count_students'];
				if($count == 0){
					echo "<div>В группе нет студентов</div><br>";
					printf( '<a style="margin-right: 1000px" href="?option=add_user_to_group&id_text=%s "><button>Добавить нового пользователя в группу</button></a><br>', $id);		
					echo '<img class="illustration_big" src="file/undraw_People_search_re_5rre.png">';
				}
				else{
		
			echo '<img class="illustration" src="file/undraw_Selecting_team_re_ndkb.png">';
			echo '<a style="margin-right: 1000px" href="?option=add_user_to_group"><button>Добавить нового пользователя в группу</button></a><br>';
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
		for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
			$row = mysqli_fetch_array($result_a, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			printf("<tr><p style='font-size:20px;'>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td>
		       <td><a style='color:#585858, text-decoration: none''>%s</a></td></tr>",   $row['id'], $row['login'], $row['last_name'], $row['first_name'],  $row['middle_name'], $row['email']);
		}
		
		echo "</table></div>";
	
		}
		
		}
	}
}
}
?>
