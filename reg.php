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

	<img class="illustration" src="file/undraw_Dev_focus_re_6iwt.png">
	
	<div id="main_a">
   	 <h1>Студенческий портал</h1>
	<div style=" background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px; width: 600px; margin: auto;">
	
		<h2>Регистрация на платформе</h2>
		<div>Введите информацию о себе, а также придумайте<br>
		 логин и пароль для входа на платформу</div><br>
	
		<div><b>ФИО:</b>  2-50 символов кириллицей<br>
		 <b>Логин и пароль:</b> 3-50 символов латиницей и/или цифры</div><br><br> 


					<form action="check.php" method="post">
						<table>
						
						<tr>
						<td>
						
						<b><div>Фамилия:</div></b>
						<input class="input_style"  type="text" class="form-control" name="last_name" 
						id="last_name" placeholder="Введите фамилию" pattern="[А-Яа-яЁё\s]{2,50}"><br>
						
						<b><div>Имя:</div></b>
						<input class="input_style"  type="text" class="form-control" name="first_name" 
						id="first_name" placeholder="Введите имя" pattern="[А-Яа-яЁё\s]{2,50}"><br>
						
						<b><div>Отчество:</div></b>
						<input class="input_style"  type="text" class="form-control" name="middle_name" 
						id="middle_name" placeholder="Введите отчество" pattern="[А-Яа-яЁё\s]{2,50}"><br>
						
						<b><div>E-mail:</div></b>
						<input class="input_style"  type="text" class="form-control" name="email"  style="text-transform: lowercase" id="email" placeholder="example@mail.ru" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
				
						</td>
						
						
						<td>
						
						<b><div>Логин:</div></b>
						<input class="input_style"  type="text" class="form-control" name="login" 
						id="login" placeholder="Придумайте логин" pattern="[A-Za-z0-9]{3,50}"><br>
						
						<b><div>Пароль:</div></b>
						<input class="input_style" type="password" class="form-control" name="pass" 
						id="pass" placeholder="Придумайте пароль" pattern="[A-Za-z0-9]{3,50}"><br>
						
						<b><div>Повтор пароля:</div></b>
						<input class="input_style" type="password" class="form-control" name="pass2" 
						id="pass2" placeholder="Повторите пароль" pattern="[A-Za-z0-9]{3,50}"><br>
						
						<div><b>Ваша фотография:</b><br>
						<input type="file" name="img_avatar">
						</div>
						
						</td>
						</tr>
						
						<tr><td><br>
						<button class="button" style="margin-left: 120px;" type="submit">Зарегистрироваться</button>
						</td></tr>
						
						</table>
					</form>

	</div>
	
	<br><div><b>У Вас уже есть учетная запись?<br><br>
	<a style="color: #cc0605; text-decoration: none;" href="/STUD_PORTAL/login.php">Войти
	<img src="/STUD_PORTAL/file/icons8-войти-18.png">
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
