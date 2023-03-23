<?php

	class view_lections extends ACore_teacher{
		
		public function get_content(){
		
		echo '<div id="main">';
	
		if(!$_GET['id_text']){
			echo 'Неправильные данные для вывода статьи';
		}
		else{
			$id_text = (int)$_GET['id_text'];
			if(!$id_text){
				echo 'Неправильные данные для вывода статьи';
			}
			else{
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT title, discription, text, date, file_src, id FROM posts WHERE id='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				printf("<h2>%s</h2>  
				
					<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='font-size: 20px'><b>%s</b></div></p>
					<p><div style='text-align:left'>%s</div></p>
					
					<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b>
					
					<p><b>%s</b></p></div>", $row['discription'], $row['title'], $row['text'], $row['file_src'], basename($row['file_src']), $row['date']);
					
				echo '<br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}
		}	
			
		echo '<br></div>';
	}
}
?>
