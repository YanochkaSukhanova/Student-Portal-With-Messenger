<?php
	class news_stud extends ACore_student {
		public function get_content(){
			
			$gr_id = $_SESSION['user']['student_group'];
			$query = "SELECT * FROM news WHERE id_group = $gr_id ORDER BY id DESC";
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			echo "<div id='main_a'>";
			echo "<h2>Мои новости</h2>";
			
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
			
			$count = mysqli_num_rows($result);
			   if($count == 0){
				echo "<div><br>Данные на этой странице отсутствуют</div><br>
					<div>Преподаватели еще не опубликовали новости для вашей группы</div>";
			   }
			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				$avtor_id = $row['id_user'];
				$query1 = "SELECT * FROM users WHERE id = $avtor_id";
				$result1 = mysqli_query($link, $query1);
				if(!$result1){
					exit(mysqli_error($link));
				}
				$row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				if ($row['file_src'] == ""){
					printf("<br><div style='background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left; font-size: 20px;'><b>%s</b></div></p>
					
					<p><div style='text-align:left'>%s</div></p>
					<p><div style='text-align:left'><b>Автор:</b> %s %s %s</div></p>
					
					</div>", $row['name'], $row['text'], $row1['last_name'], $row1['first_name'], $row1['middle_name']);
				}
				else{
					
					printf("<br><div style='background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left; font-size: 20px;'><b>%s</b></div></p>
					
					<p><div style='text-align:left'>%s</div></p>
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'>%s</p></a></b>
					<p><div style='text-align:left'><b>Автор:</b> %s %s %s</div></p>
					
					</div>", $row['name'], $row['text'], $row['file_src'], basename($row['file_src']), $row1['last_name'], $row1['first_name'], $row1['middle_name']);
				}
			}
			
			echo "</div>";
		}
	}
?>
