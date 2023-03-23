<?php
abstract class ACore_student{
	
	protected $db;
	
	public function _construct (){
	
		if($_COOKIE['user'] == ''){
			header("Location:/STUD_PORTAL/login.php");
		}
	
		$this->$db = mysqli_connect(HOST, USER, PASSWORD);
		if(!$this->db){
			exit("Ошибка соединения с базой данных".mysqli_error());
		}
		if(!mysqli_select_db(DB, $tris->db)){
			exit("Нет такой базы данных".mysqli_error());
		}
		
		mysqli_query("SET NAMES UTF8");
	}
	
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
			   
		           <li><a href="?option=predmets">Предметы</a></li>
		           <li><a href="?option=messenger_stud">Мессенджер</a></li>
		           <li><a href="?option=profil_stud">Профиль</a></li>';
			

		echo '	<li><a href="/STUD_PORTAL/login.php">Выйти</a></li>
			</ul></div>
			<br>';
	}	
	
	
	protected function get_footer(){
		echo '<div id="footer">    
			  &copy; Суханова Яна - А-08-19
			 </div>
			  
			</BODY>

			</HTML>';
	}	
	
	protected function get_error(){
		echo '<div> Нет доступа к данной странице</div><br>
			<a style="text-align: center" href="/STUD_PORTAL/login.php"><button>Выйти</button></a>
			<img class="illustration_big" src="file/undraw_Page_not_found_re_e9o6.png">';
	}
	
	protected function get_null(){
		echo '<div> Администратор еще не назначил Вам права студента или преподавателя для доступа к сайту</div><br>
			<div> Попробуйте зайти на портал через какое-то время</div><br>
			<a style="text-align: center" href="/STUD_PORTAL/login.php"><button>Выйти</button></a><br>
			<img class="illustration_big" src="file/undraw_Time_management_re_tk5w.png">';
	}		
	
	public function get_body() {

		if($_SESSION['user']['rights'] === 'student'){
			if($_POST || $_GET['del_text']){
				$this->obr();
			}
			$this->get_header();
			$this->get_category();
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
	
	abstract function get_content();
}
?>
