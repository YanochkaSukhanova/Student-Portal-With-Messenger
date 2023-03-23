<?php

	class profil_stud extends ACore_student{
		
		public function get_content(){
		
		echo '<div id="main_a">';
		echo '<h2>Личный профиль</h2>';
	
		$my_id = $_SESSION['user']['id'];
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$query = "SELECT * FROM users WHERE id='$my_id'";
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		echo "<br><div style='margin-right: 500px'>
			<a style='text-align:left;' href='?option=redactor_profil_stud'><button>Редактировать данные</button></a>
				</div>";
		
		
		if ($row['img_avatar'] == null){
		
			printf("<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<table>
			<tr>
			<td>
				<img class='illustration' src='file/undraw_Female_avatar_re_l6cx.png'>
			</td>
			<td>
				<p><div style='font-size: 20px;text-align:left; margin-left: 70px'><b>%s %s %s</b></div></p>
				<p><div style='text-align:left; margin-left: 70px'><b>Группа:</b> %s</div></p>
				<p><div style='text-align:left; margin-left: 70px'><b>e-mail:</b> %s</div></p>
				<p><div style='text-align:left; margin-left: 70px'><b>Логин:</b> %s</div></p>
			</td>
			</tr>
			</table>
				</div>", $row['last_name'], $row['first_name'], $row['middle_name'],$row['student_group'], $row['email'], $row['login']);
		}
		else {
			printf("<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
			<table>
			<tr>
			<td>
				<img class='illustration' src='file/%s'>
			</td>
			<td>
				<p><div style='font-size: 20px;text-align:left; margin-right: 500px'><b>%s %s %s</b></div></p>
				<p><div style='text-align:left; margin-right: 500px'><b>Группа:</b> %s</div></p>
				<p><div style='text-align:left; margin-right: 500px'><b>e-mail:</b> %s</div></p>
				<p><div style='text-align:left; margin-right: 500px'><b>Логин:</b> %s</div></p>
			</td>
			</tr>
			</table>
				</div>", $row['img_avatar'], $row['last_name'], $row['first_name'], $row['middle_name'],$row['student_group'], $row['email'], $row['login']);
		}
			
		//echo '<br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
	
		echo '<br></div>';
		
		}
	}
	
	//<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b> <p><b>%s</b></p> </div>
?>


