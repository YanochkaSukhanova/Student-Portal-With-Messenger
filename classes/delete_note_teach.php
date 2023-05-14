<?php
class delete_note_teach extends ACore_teacher{
	// Удаление заметки, созданной преподавателем
	public function obr(){
		if ($_GET['del_text']){
			$id_text = (int)$_GET['del_text'];
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_text';");
			$result = $mysqli->query("CALL `deleteNotes`(@p0)");
			if($result){
				$_SESSION['res']="Заметка успешно удалена";
				header("Location:?option=notes_teach");
				exit();
			}
			else{
				exit("Ошибка удаления");
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
