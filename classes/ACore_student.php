<?php
abstract class ACore_student{
	
	// Вывод шапки 
	protected function get_header(){
		echo '<!DOCTYPE html>

			<HTML lang="ru"> 

			<HEAD>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Студенческий портал</title>
				<link rel="stylesheet" href="/STUD_PORTAL/styles/style.css">
			</HEAD>

			<BODY>
			    	<h1>Студенческий портал</h1>';
	}

	// Вывод меню
	protected function get_category(){
		$query = "SELECT id_category, name_category FROM category";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		
		if(!$result){
			exit(mysqli_error($link));
		}
		
		$row = array();
		echo '<div id="menu"><ul>   
			   <li><a href="?option=news_stud">Новости</a></li>
			   <li><a href="?option=notes_stud">Заметки</a></li>
			   
		           <li><a href="?option=predmets">Лекции</a></li>
		           <li><a href="?option=tasks_stud">Задания</a></li>
		           <li><a href="?option=messenger_stud">Мессенджер</a></li>
		           <li><a href="?option=profil_stud">Профиль</a></li>';
			

		echo '	<li><a href="/STUD_PORTAL/login.php">Выйти</a></li>
			</ul></div>
			<br>';
	}	
	
	// Вывод подвала
	protected function get_footer(){
		echo '<div id="footer">    
			  &copy; Суханова Яна - А-08-19
			 </div>
			  
			</BODY>

			</HTML>';
	}	
	
	// Вывод ошибки (нет доступа к странице)
	protected function get_error(){
		echo '<div> Нет доступа к данной странице</div><br>
			<a style="text-align: center" href="/STUD_PORTAL/login.php"><button>Выйти</button></a>
			<img class="illustration_big" src="file/undraw_Page_not_found_re_e9o6.png">';
	}
	
	// Вывод ошибки (не назначены права)
	protected function get_null(){
		echo '<div> Администратор еще не назначил Вам права студента или преподавателя для доступа к сайту</div><br>
			<div> Попробуйте зайти на портал через какое-то время</div><br>
			<a style="text-align: center" href="/STUD_PORTAL/login.php"><button>Выйти</button></a><br>
			<img class="illustration_big" src="file/undraw_Time_management_re_tk5w.png">';
	}		
	
	// Проверка прав, вызов функций для отображения контента шапки, меню, подвала, основной(изменяемой) части или ошибок
	public function get_body() {

		if($_SESSION['user']['rights'] === 'student'){
			if($_POST || $_GET['del_text']){
				$this->obr();
			}
			$this->get_header();
			$this->get_category();
			
			if ($_SESSION['res']){
				echo "<br><div style=' width: 1200px; margin-left: 300px; background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'><b>$_SESSION[res]</b></div>";
				unset($_SESSION['res']);
			}
			
			$this->get_content();
			$this->get_footer();
		}
		else if($_SESSION['user']['rights'] === NULL){
			$this->get_header();
			$this->get_null();
			$this->get_footer();
		}
		else{
			$this->get_header();
			$this->get_error();
			$this->get_footer();
		}

	}
	
	// Функция, описанная в классах-наследниках, чтобы выводить основную часть контента (разная для каждой функции)
	abstract function get_content();
}
?>
