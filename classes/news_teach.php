<?php
	class news_teach extends ACore_teacher {
		public function get_content(){
			
			$my_id = $_SESSION['user']['id'];
			$query = "SELECT * FROM news WHERE id_user = $my_id";
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
		
			echo "<div id='main_a'>";
			echo "<h2>Мои новости</h2>";
			echo '<img class="illustration" src="file/undraw_Add_notes_re_ln36.png">';
			echo "<br><div style='margin-right: 500px'>
				<a style='text-align:left' href='?option=add_news_teach'><button>Добавить новость</button></a>
				</div>";
			
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			$count = mysqli_num_rows($result);
			   if($count == 0){
				echo "<div><br>Данные на этой странице отсутствуют</div><br>
					<div>Добавьте новую новость, чтобы информировать студентов</div>";
			   }
			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				$gr_id = $row['id_group'];
				$query1 = "SELECT name_group FROM stud_groups WHERE id_group = $gr_id";
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$result1 = mysqli_query($link, $query1);
				if(!$result1){
					exit(mysqli_error($link));
				}
				$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				
				printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p style='font-size:20px; color:#585858'>
					<a style='color:#585858, text-decoration: none'>%s - <b>%s</b></a><br> 
					<a style='color:#585858' href='?option=open_news_teach&id_text=%s'>Открыть</a> - 
					<a style='color:#585858' href='?option=update_news_teach&id_text=%s'>Изменить</a> - 
					<a style='color:red' href='?option=delete_news&del_text=%s'>Удалить</a></p></div>",   $row['name'], $row1['name_group'], $row['id'], $row['id'], $row['id']);
			}
			
			echo "</div>";
		}
	}
?>
