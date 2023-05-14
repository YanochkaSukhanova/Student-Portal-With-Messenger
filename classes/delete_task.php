<?php
class delete_task extends ACore_teacher{
	// Удаление задания
	public function obr(){
		if ($_GET['del_text']){
			$id_text = (int)$_GET['del_text'];
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_text';");
			$result = $mysqli->query("CALL `deleteTasks`(@p0)");
			if($result){
				$_SESSION['res']="Задание успешно удалено";
				header("Location:?option=tasks_teach");
				exit();
			}
			else{
				exit("Ошибка удаления статьи");
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
