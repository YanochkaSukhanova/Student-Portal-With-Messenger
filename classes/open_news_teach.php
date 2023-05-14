<?php
class open_news_teach extends ACore_teacher{
	// Просмотр содержания выбранной заметки
	public function get_content(){
		echo '<div id="main_a">';
		if(!$_GET['id_text']){
			echo 'Неправильные данные для вывода заметки';
		}
		else{
			$id_text = (int)$_GET['id_text'];
			if(!$id_text){
				echo 'Неправильные данные для вывода заметки';
			}
			else{
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT * FROM news WHERE id='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);	
				$query_b = "SELECT * 
					  FROM `stud_groups`";
				$result_b = mysqli_query($link, $query_b);
				if(!$result_b){
					exit(mysqli_error($link));
				}
				$text = mysqli_fetch_array($result_b, MYSQLI_ASSOC);
				$k = 0;
				$name_gr = "";
				if($row['id_group'] == $text['id_group']){
					$name_gr = $text['name_group'];
				}	   	
			if ($row['file_src'] == ""){
				printf("<h2>%s - $name_gr</h2>  

					<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left'>%s</div></p></div>", $row['name'], $row['text']);
			}
			else{	
				printf("<h2>%s</h2>  
					<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left'>%s</div></p>			
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b></div></div>", $row['name'], $row['text'], $row['file_src'], basename($row['file_src']));
			}			
				echo '<br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}
		}
		echo '<br></div>';
	}
}
?>
