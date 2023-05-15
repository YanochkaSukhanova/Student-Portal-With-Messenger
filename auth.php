<?php
// Аутентификация пользователя в системе
session_start(); //старт сессии
require_once("config.php");

$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
$rights = $_POST['rights'];
$mysql = new mysqli(HOST, USER, PASSWORD, DB);
$result = $mysql->query("SELECT * FROM `users` WHERE `login`='$login'");

//---конвертация в массив
$user = $result->fetch_assoc();
$hash = $user['pass'];

if (count($user) == 0){
	echo "Такой пользователь не найден";
	exit();
}

//---Куки живут 1 год
setcookie('user', $user['login'], time() + 3600*24*365, "/");

if (password_verify($pass, $hash)){
	$_SESSION['user'] = [
	"id" =>$user['id'],
	"student_group" =>$user['student_group'],
	"login" =>$user['login'],
	"rights" =>$user['rights']
	];
	// Перенаправление на страницы веб-приложения в зависимости от прав доступа пользователя
	if ($user['rights'] == 'teacher'){
		$mysql->close();
		header ('Location:/STUD_PORTAL/index.php?option=teachers_predmets');
	}
	else if($user['rights'] == 'student'){
		$mysql->close();
		header ('Location:/STUD_PORTAL/index.php?option=predmets');
	}
	else if($user['rights'] == 'admin'){
		$mysql->close();
		header ('Location:/STUD_PORTAL/index.php?option=users');
	}
	else if($user['rights'] == 'no_rights'){
		$mysql->close();
		header ('Location:/STUD_PORTAL/null.php');
	}
	else{
		exit("Нет такой страницы сайта");
	}
}
else{
		echo "Неверные данные для входа";
		$mysql->close();
	exit();
} 
?>
