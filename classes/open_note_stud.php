<?php

	class open_note_stud extends ACore_student{
		
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
				$query = "SELECT * FROM notes WHERE id_note='$id_text'";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				
				if ($row['file_src'] != ""){
					printf("<h2>%s</h2>  
					
						<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
						<p><div style='text-align:left'>%s</div></p>
						
						<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'>%s</p></a></b></div>
						
						</div>", $row['name'], $row['text'], $row['file_src'], basename($row['file_src']));
				}
				else{
					printf("<h2>%s</h2>  
				
					<br><div style=' background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><div style='text-align:left'>%s</div></p>
					
					</div>", $row['name'], $row['text']);
				}
					
				echo '<br><img class="illustration" src="file/undraw_Notebook_re_id0r.png">';
			}
		}
	
		echo '<br></div>';
	}
}
?>
