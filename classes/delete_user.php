<?php

class delete_user extends ACore_admin{

	public function obr(){
		if ($_GET['del_text']){
			$id_text = (int)$_GET['del_text'];
			
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$id_text';");
			$result = $mysqli->query("CALL `deleteUsers`(@p0)");
			if($result){
				$_SESSION['res']="Пользователь успешно удален";
				header("Location:?option=users");
				exit();
			}
			else{
				exit("Ошибка удаления пользователя");
			}	  
			
		}
		else {
			exit("Неверные данные для отображения страницы");
		}
	}	
	
	public function get_content(){}
}

?>
