<?php

class delete_posts extends ACore_teacher{

	public function obr(){
		if ($_GET['del_text']){
			$id_text = (int)$_GET['del_text'];
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_text';");
			$result = $mysqli->query("CALL `deletePosts`(@p0)");
			if($result){
				$_SESSION['res']="Статья успешно удалена";
				header("Location:?option=teachers_predmets");
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
	
	public function get_content(){}
}

?>
