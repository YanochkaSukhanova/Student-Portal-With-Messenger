<?php

	class add_chat_stud extends ACore_student {
	
		// Проверка на существование чата, добавление нового чата в базу данных
		protected function obr(){
			$id_user_student = $_POST['id_user_student'];
			$id_user_teacher = $_POST['id_user_teacher'];
			if(empty($id_user_teacher) || empty($id_user_student)){
				exit("Не заполнены обязательные поля");
			}
			
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT id_chat, COUNT(*)
				  FROM chats
				  WHERE id_user_student='$id_user_student' AND id_user_teacher='$id_user_teacher'
				  GROUP BY id_chat";
			$result = mysqli_fetch_assoc(mysqli_query($link, $query)); 
				
			if(empty($result)){
				$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
				$mysqli->query("SET @p0='$id_user_student';");
				$mysqli->query("SET @p1='$id_user_teacher';");
				$result1 = $mysqli->query("CALL `addChat`(@p0, @p1)");
				if(!$result1){
					exit(mysqli_error($mysqli));
				}
			}
			
			$query2 = "SELECT id_chat
			  FROM chats
			  WHERE id_user_student=$id_user_student AND id_user_teacher=$id_user_teacher";
			$result2= mysqli_query($link, $query2); 
			
			$r2 = array();
			for ($i = 0; $i < mysqli_num_rows($result2); $i++){
				$r2 = mysqli_fetch_array($result2, MYSQLI_ASSOC); 
				$id_chat = $r2['id_chat'];
			
			}
		
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=chat_stud&id_chat=$id_chat");
			exit;
		}
		
		// Вывод таблицы с преподавателями и кнопок для создания чата с ними (создается новый или открывается существующий)
		public function get_content(){
			echo "<div id='main_a'>";
			echo "<h2>Написать преподавателю</h2>";
			echo '<img class="illustration" src="file/undraw_Messages_re_qy9x.png">';
			$rights_of_users='teacher';
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT * 
				  FROM users
				  WHERE rights='$rights_of_users' 
				  ORDER BY last_name ASC";
			$result = mysqli_query($link, $query);
			if(!$result){
				exit(mysqli_error($link));
			}
			
			$row = array();
			$my_id = $_SESSION['user']['id'];
		
			echo '<table class="table_center" border="1" cellspacing="0" cellpadding="12">
				
				<tr style= "background-color:#fff3ed;">
				<td><a style="color:#585858, text-decoration: none"><b>Фамилия</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Имя</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>Отчество</b></a></td>
				<td><a style="color:#585858, text-decoration: none"><b>e-mail</b></a></td>
				<td><a style="color:#585858, text-decoration:"><b>Выбор пользователя</b></a></td></tr>';
				
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
				$last_name=$row['last_name'];
				$first_name=$row['first_name'];
				$middle_name=$row['middle_name'];
				$email=$row['email'];
				$id_user_teacher=$row['id'];

				echo "<form enctype='multipart/form-data' action='' method='POST'>
				
				<tr><p style='font-size:20px;'>
			       <td><a style='color:#585858, text-decoration: none''>$last_name</a></td>
			       <p><input type='hidden' name='last_name' value='$last_name'></p>
			       
			       <td><a style='color:#585858, text-decoration: none''>$first_name</a></td>
			      	<p><input type='hidden' name='first_name' value='$first_name'></p>
			      
			       <td><a style='color:#585858, text-decoration: none''>$middle_name</a></td>
			       <p><input type='hidden' name='middle_name' value='$middle_name'></p>
			       
			       <td><a style='color:#585858, text-decoration: none''>$email</a></td>
			       <p><input type='hidden' name='email' value='$email'></p>
			       
			       <p><input type='hidden' name='id_user_student' value='$my_id'></p>
			       <p><input type='hidden' name='id_user_teacher' value='$id_user_teacher'></p>
			       
			       <td><p><input type='submit' name='button' value='Написать'></td></p></tr></form>";  
			}
			echo "</table></div>";
		}
	}
?>
