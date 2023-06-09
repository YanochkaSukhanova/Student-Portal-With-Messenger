<?php
abstract class ACore_teacher{
	
	// Вывод шапки 
	protected function get_header(){
		echo '<!DOCTYPE html>

			<HTML lang="ru"> 

			<HEAD>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Студенческий портал</title>
				<link rel="stylesheet" href="/STUD_PORTAL/styles/style.css">
				<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
			</HEAD>

			<BODY>
			    	<h1>Студенческий портал для преподавателей</h1>';
	}
	
	// Вывод меню
	protected function get_category(){

		echo '<div id="menu"><ul>';
		
		echo '<li><a href="?option=news_teach">Новости</a></li>';  
		echo '<li><a href="?option=notes_teach">Заметки</a></li>';  
		echo '<li><a href="?option=edit_category">Предметы</a></li>';        
		echo '<li><a href="?option=teachers_predmets">Лекции</a></li>';
		echo '<li><a href="?option=tasks_teach">Задания</a></li>';
		echo '<li><a href="?option=messenger_teach">Мессенджер</a></li>';
		echo '<li><a href="?option=profil_teach">Профиль</a></li>';
		echo '	<li><a href="/STUD_PORTAL/login.php">Выйти</a></li>
			</ul></div>';
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
			<img class="illustration_big" src="file/undraw_Page_not_found_re_e9o6.png">
			  
			</BODY>

			</HTML>';
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
	
		if($_SESSION['user']['rights'] === 'teacher'){
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
	
	// Возврат информации о предметах
	protected function get_categories(){
		$query = "SELECT id_category, name_category FROM category";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){				
			exit(mysqli_error($link));
		}
		
		$row = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row[] = mysqli_fetch_array($result, MYSQLI_ASSOC);
		}
		
		return $row;
	}
	
	// Возврат информации о лекции с конкретным id
	protected function get_text_posts($id){
		$query = "SELECT id, title, discription, text, cat, file_src
		 	  FROM posts
		 	  WHERE id='$id'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){				
			exit(mysqli_error($link));
		}
		
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		return $row;
	}
	
	// Возврат информации о задании с конкретным id
	protected function get_text_task($id){
		$query = "SELECT id, title, discription, text, cat, file_src, date_start, date_end
		 	  FROM tasks
		 	  WHERE id='$id'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){				
			exit(mysqli_error($link));
		}
		
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		return $row;
	}
	
	// Возврат информации о предмете с конкретным id
	protected function get_name_category($id){
		$query = "SELECT id_category, name_category
		 	  FROM category
		 	  WHERE id_category='$id'";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){				
			exit(mysqli_error($link));
		}
		
		$row = array();
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		return $row;
	}
}
?>
