<?php
class delete_category extends ACore_teacher{
	// Удаление предмета из базы данных
	public function obr(){
		if ($_GET['del_text']){
			$id_category = (int)$_GET['del_text'];
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_category';");
			$result = $mysqli->query("CALL `deleteCategory`(@p0)");
			if($result){
				$_SESSION['res']="Предмет успешно удален";
				header("Location:?option=edit_category");
				exit();
			}
			else{
				exit("Ошибка удаления категории");
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
