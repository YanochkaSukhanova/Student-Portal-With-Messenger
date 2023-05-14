<?php
class delete_news extends ACore_teacher{
	// Удаление новости из базы данных
	public function obr(){
		if ($_GET['del_text']){
			$id_text = (int)$_GET['del_text'];
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_text';");
			$result = $mysqli->query("CALL `deleteNews`(@p0)");
			if($result){
				$_SESSION['res']="Новость успешно удалена";
				header("Location:?option=news_teach");
				exit();
			}
			else{
				exit(mysqli_error($mysqli));
			}	  			
		}
		else {
			exit("Неверные данные для отображения страницы");
		}
	}	
	// Нет отображения контента	
	public function get_content(){}
}
?>
