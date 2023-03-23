<?php
	
	// --- trim - фильтр от лишних пробелов
	// --- F_S_S - фильтр строки
	session_start();
	
	require_once("config.php");
	
	$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
	$pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
	$pass2 = filter_var(trim($_POST['pass2']), FILTER_SANITIZE_STRING);
	$first_name = filter_var(trim($_POST['first_name']), FILTER_SANITIZE_STRING);
	$last_name= filter_var(trim($_POST['last_name']), FILTER_SANITIZE_STRING);
	$middle_name = filter_var(trim($_POST['middle_name']), FILTER_SANITIZE_STRING);
	$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
	$img_avatar = $_POST['img_avatar'];
	
	if($pass != $pass2){
		echo "Пароли не совпадают. Повторите еще раз";
		exit();
	}
	else if(mb_strlen($login) < 3 || mb_strlen($login) > 50){
		echo "Недопустимая длина логина. Введите логин, содержащий от 3 до 50 символов.";
		exit();
	}
	else if(mb_strlen($pass) < 3 || mb_strlen($pass) > 50){
		echo "Недопустимая длина пароля. Введите пароль, содержащий от 3 до 50 символов.";
		exit();
	}
	else if(mb_strlen($first_name) < 2 || mb_strlen($first_name) > 50){
		echo "Недопустимая длина имени. Введите имя, содержащее от 2 до 50 символов.";
		exit();
	}
	else if(mb_strlen($last_name) < 2 || mb_strlen($last_name) > 50){
		echo "Недопустимая длина фамилии. Введите фамилию, содержащую от 2 до 50 символов.";
		exit();
	}
	else if(mb_strlen($middle_name) < 2 || mb_strlen($middle_name) > 50){
		echo "Недопустимая длина отчества. Введите отчество, содержащее до 50 символов.";
		exit();
	}
	else if(empty($email)){
		echo "Введите email";
		exit();
	}
	
	//---хеширование пароля
	$pass = password_hash($pass, PASSWORD_DEFAULT);

	
	$query = "SELECT * FROM users WHERE login = '$login'";
	$link = mysqli_connect(HOST, USER, PASSWORD, DB);
	$result = mysqli_query($link, $query);
	if(!$result){
		exit(mysqli_error($link));
	}
	$col = mysqli_num_rows($result);

	if($col == 0){
		$sql = "INSERT INTO `users`(`login`, `pass`, `last_name`, `first_name`, `middle_name`, `email`, `img_avatar`) 
	VALUES ('$login', '$pass', '$last_name', '$first_name', '$middle_name', '$email', '$img_avatar') ";
		$result = mysqli_query($link, $sql);
		if(!$result){
			exit(mysqli_error($link));
		}
	}
	else{
		exit("Такой пользователь уже есть");
	}
	
	header ('Location:/STUD_PORTAL/login.php');
?>
