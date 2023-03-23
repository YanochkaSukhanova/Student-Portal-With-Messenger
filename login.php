<?php

	session_start();
	setcookie('user', $user['login'], time() - 3600*24*365, "/");
	session_unset();
	session_destroy();
	
 	echo '
 	
<!DOCTYPE html>

<HTML lang="ru"> 

<HEAD>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Студенческий портал</title>
	<link rel="stylesheet" href="/STUD_PORTAL/styles/style.css">
</HEAD>

<BODY>

	<img class="illustration_big" src="file/undraw_Teacher_re_sico.png">
	
 	<div id="main_a">
   	 <h1>Студенческий портал</h1>
	<div style=" background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px; width: 350px; margin: auto;">
	
		<h2>Вход на платформу</h2>
		<div>Если Вы уже прошли регистрацию,<br>
		то введите свои логин и пароль</div><br>
	
		<form action="auth.php" method="post" style="margin-left: 50px;">
		<table>
			
			<tr>
				
				<td>
						
						<input class="input_style"  type="text" class="form-control" name="login" 
						id="login" placeholder="Введите логин"><br>
						
						<input class="input_style"  type="password" class="form-control" name="pass" 
						id="pass" placeholder="Введите пароль"><br>
						
						<button class="button" style="margin-right: 150px;" type="submit">Войти</button>
					
				
				</td>
				
			</tr>
			
		</table>

		</form>
		<br>
	</div>
	
	<br><div><b>У Вас нет учетной записи?<br><br>
	<a style="color: #cc0605; text-decoration: none;" href="/STUD_PORTAL/reg.php">Зарегистрироваться
	<img src="/STUD_PORTAL/file/icons8-редактировать-мужчину-пользователя-18.png">
	</a></b></div><br>
 
	</div>
		<br>
		
		<div id="footer">
				&copy; Суханова Яна - А-08-19
		</div>
		
</BODY>

</HTML>
 	
 	';
?>
