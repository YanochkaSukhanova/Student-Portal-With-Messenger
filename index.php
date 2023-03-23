<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

	header("Content-Type:text/html;charset=UTF-8");
	
	require_once("config.php");
	require_once("classes/ACore_student.php");
	require_once("classes/ACore_teacher.php");
	require_once("classes/ACore_admin.php");
	//require_once("script/script.js");
	//require_once("http://code.jquery.com/jquery-1.9.1.js");
	
	session_start();
	
	if($_SESSION['user'] == ''){  //БЫЛИ КУКИ
		header("Location:/STUD_PORTAL/login.php");
	}
	
	if(isset($_GET['option'])){
		$class = trim(strip_tags($_GET['option']));
	}
	else {
		$class = 'predmets';
	}
	
	//---если файл существует
	if(file_exists("classes/".$class.".php")){
		include("classes/".$class.".php");
		if(class_exists($class)){
			$obj = new $class;
			$obj->get_body();
		}
		else{
			exit("<p>Неправильные данные для входа</p>");
		}
	}
	else{
		exit("<p>Неправильный адрес сайта</p>");
	}

?>
