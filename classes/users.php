<?php
 
class users extends ACore_admin {
	public function get_content(){
	
		echo "<div id='main'>";
		echo "<h2>Пользователи</h2>";	
		echo '<a style="margin-right: 1000px" href="?option=add_user"><button>Добавить нового пользователя</button></a><br>';		
		if($_SESSION['res']){
			echo $_SESSION['res'];
			unset($_SESSION['res']);
		}

		$rights = "student";
		$r_text = "Студенты";
		$query = "SELECT * FROM users WHERE rights='$rights'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$count = mysqli_num_rows($result);
		
			
	        printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
					<a style='color:#585858;  text-decoration: none;' href='?option=users_rights&rights_of_users=%s'>%s - %s</a></p></div>",  $rights,  $r_text, $count);

		
		$rights = "teacher";
		$r_text = "Преподаватели";
		$query = "SELECT * FROM users WHERE rights='$rights'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$count = mysqli_num_rows($result);
		
			
	        printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
					<a style='color:#585858;  text-decoration: none;' href='?option=users_rights&rights_of_users=%s'>%s - %s</a></p></div>",  $rights,  $r_text, $count);
		
		
		$rights = 'admin';
		$r_text = 'Администраторы';
		$query = "SELECT * FROM users WHERE rights='$rights'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$count = mysqli_num_rows($result);
		
			
	        printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
					<a style='color:#585858;  text-decoration: none;' href='?option=users_rights&rights_of_users=%s'>%s - %s</a></p></div>",  $rights,  $r_text, $count);
		
		
		$rights = 'no_rights';
		$r_text = 'Без прав';
		$query = "SELECT * FROM users WHERE rights='$rights'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		$count = mysqli_num_rows($result);
			
	        printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
					<a style='color:#585858;  text-decoration: none;' href='?option=users_rights&rights_of_users=%s'>%s - %s</a></p></div>",  $rights,  $r_text, $count);
			
		echo "</table></div>";
	}
}
?>
