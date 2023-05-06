<?php
	class edit_task_file extends ACore_teacher {
	
		protected function obr(){
			
			if(!empty($_FILES['file_src']['tmp_name'])){
				if(!move_uploaded_file($_FILES['file_src']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['file_src']['name'])){
					exit("Не удалось загрузить файл");
				}
				$file_src = '/STUD_PORTAL/file/'.$_FILES['file_src']['name'];
			}
			else{
				exit("Необходимо загрузить файл");
			}
			
			$id = $_POST['id'];
						
			$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
			$mysqli->query("SET @p0='$file_src';");
			$mysqli->query("SET @p1='$id';");
			$result = $mysqli->query("CALL `editTasksFile`(@p0, @p1)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			else {
				$_SESSION['res'] = "Изменения сохранены";
				header("Location:?option=tasks_teach");
				exit;
			}
		
		}
		
		public function get_content(){
		
			if ($_GET['id_text']){
				$id_text = (int)$_GET['id_text'];
			}
			else{
				exit("Некорректные данные для страницы");
			}
			
			$text = $this->get_text_task($id_text);
			
			echo "<div id='main'>";
			
			echo "<h2>Изменение материалов задания</h2>";
			echo "<div>Прикрепите файл или архив. После загрузки нажмите &#8220;Сохранить&#8220;</div>";
			
			if($_SESSION['res']){
				echo $_SESSION['res'];
				unset($_SESSION['res']);
			}
		
			$cat = $this->get_categories();
			
			print <<<HEREDOC
			<form enctype="multipart/form-data" action="" method="POST">
				<p><b>Новый файл/архив:</b><br>
				<input type='file' name=' file_src'>
				<input type='hidden' name='id' style='width:420px;' value='$text[id]'>
				</p>

			HEREDOC;
			echo "<p><input type='submit' name='button' value='Сохранить'></p></form></div>";
			
		}
	}
?>
