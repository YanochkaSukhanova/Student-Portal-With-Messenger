<?php
	class edit_category extends ACore_teacher {
		public function get_content(){
			
			$my_id = $_SESSION['user']['id'];
			$query = "SELECT id_category, name_category FROM category WHERE autor_id='$my_id'";
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			echo "<div id='main'>";
			
					
			echo "<h2>Мои предметы</h2>";
			echo '<img class="illustration" src="file/undraw_Personal_file_re_5joy.png">';
			echo "<br><div style='margin-right: 500px'><a style='text-align:left' href='?option=add_category'><button>Добавить новый предмет</button></a></div>";

			
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			$count = mysqli_num_rows($result);
			   if($count == 0){
				echo "<div>Данные на этой странице отсутствуют</div><br>
					<div>Добавьте новый предмет, чтобы студенты могли начать обучение</div>";
			   }
			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			
				printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p style='font-size:20px; color:#585858'>
					<a style='color:#585858, text-decoration: none'>%s</a><br> 
					<a style='color:#585858' href='?option=update_category&id_text=%s'>Изменить</a> - 
					<a style='color:red' href='?option=delete_category&del_text=%s'>Удалить</a></p></div>",   $row['name_category'], $row['id_category'], $row['id_category']);
			}
			
			echo "</div>";
		}
	}
?>
