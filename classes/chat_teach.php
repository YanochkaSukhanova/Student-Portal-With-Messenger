<?php

class chat_teach extends ACore_teacher{
	// Отправка сообщения от преподавателя студенту (добавление в базу данных)
	protected function obr(){	
		if(!empty($_FILES['msg_file']['tmp_name'])){
			if(!move_uploaded_file($_FILES['msg_file']['tmp_name'], '/var/www/yana.local/STUD_PORTAL/file/'.$_FILES['msg_file']['name'])){
				exit("Не удалось загрузить файл");
			}
			$msg_file = '/STUD_PORTAL/file/'.$_FILES['msg_file']['name'];
		}
		$id_chat = $_POST['id_chat'];
		$send_to = $_POST['send_to'];
		$text = $_POST['text'];
		$date = date("y-m-d h:i:s", time());
		if( empty($id_chat) || empty($send_to) || empty($text) ){
			exit("Не заполнены обязательные поля");
		}
		$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
		$mysqli->query("SET @p0='$id_chat';");
		$mysqli->query("SET @p1='$send_to';");
		$mysqli->query("SET @p2='$text';");
		$mysqli->query("SET @p3='$msg_file';");
		$mysqli->query("SET @p4='$date';");
		$result = $mysqli->query("CALL `addMess`(@p0, @p1, @p2, @p3, @p4)");
		if(!$result){
			exit(mysqli_error($mysqli));
		}
		else {	
			$link = mysqli_connect(HOST, USER, PASSWORD, DB);
			$query = "SELECT id_msg
				FROM messenges
				WHERE id_chat = $id_chat";
			$result = mysqli_query($link, $query);
			$last = 0;			
			$row = array();
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				if ($last <= $row['id_msg']){
					$last = $row['id_msg'];
				}
			}
			$mysqli->query("SET @last_msg='$last';");
			$mysqli->query("SET @id_chat='$id_chat';");
			$result = $mysqli->query("CALL `editLastMsg`(@last_msg, @id_chat)");
			$unread = 1;
			$mysqli->query("SET @unread='$unread';");
			$mysqli->query("SET @id_chat='$id_chat';");
			$result = $mysqli->query("CALL `editUnreaded`(@unread, @id_chat)");
			if(!$result){
				exit(mysqli_error($mysqli));
			}
			$_SESSION['res'] = "Изменения сохранены";
			header("Location:?option=chat_stud&id_chat=$id_chat");
			exit;
		}
	}
	
	// Отображение формы для отправки сообщения и содержание чата преподавателя с выбранным студентом
	public function get_content(){
		echo '<div id="main_a">';
		if(!$_GET['id_chat']){
			echo 'Неправильные данные для вывода чата';
		}
		else{
			$id_chat = (int)$_GET['id_chat'];
			if(!$id_chat){
				echo 'Неправильные данные для вывода чата';
			}
			else{	
				$my_id = $_SESSION['user']['id'];
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query_1 = "SELECT id_chat, id_user_teacher, id_user_student
					FROM chats
					WHERE id_chat=$id_chat";
				$result_1 = mysqli_query($link, $query_1);
				if(!$result_1){
					exit(mysqli_error($link));
				}
				$row_1 = array();
				for ($i = 0; $i < mysqli_num_rows($result_1); $i++){
					$row_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
					$id_teacher = $row_1['id_user_teacher'];
					$id_student = $row_1['id_user_student'];
				}
				//Данные о преподавателе
				$query_t = "SELECT c.id_chat, c.id_user_teacher, c.id_user_student,
						 m.id_msg, m.id_chat, m.send_to, m.text, m.msg_file, m.status_of_read, m.date, 
						 u.id, u.rights, u.last_name, u.first_name, u.middle_name 
					FROM messenges AS m 
					JOIN users AS u
					JOIN chats AS c 
					ON c.id_chat = $id_chat AND c.id_chat = m.id_chat AND id_user_teacher = u.id AND id_user_teacher = $id_teacher
					ORDER BY m.date DESC";
				$result_t = mysqli_query($link, $query_t);
				if(!$result_t){
					exit(mysqli_error($link));
				}
				//Данные о студенте
				$query_s = "SELECT id, rights, last_name, first_name, middle_name 
					FROM users 
					WHERE id=$id_student";
				$result_s = mysqli_query($link, $query_s);
				if(!$result_s){
					exit(mysqli_error($link));
				}
				$row_s = array();
				for ($i = 0; $i < mysqli_num_rows($result_s); $i++){
					$row_s = mysqli_fetch_array($result_s, MYSQLI_ASSOC);
					$last_name = $row_s['last_name'];
					$first_name = $row_s['first_name'];
					$middle_name = $row_s['middle_name'];
				}
				printf( "<h2>История сообщений с пользователем %s %s %s</h2>", $last_name, $first_name,$middle_name);
				$send_to = "student";
				echo "<div style='background-color:#C37BB; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>";
				print <<<HEREDOC
						<form enctype="multipart/form-data" action="" method="POST">
							<p><b>Новое сообщение:</b><br>
							<textarea id='editor10' name='text' style='width:1000px; height:100px;'></textarea>
							</p>
							
							<p><input type='hidden' name='id_chat' value='$id_chat'></p>
							<p><input type='hidden' name='send_to' value='$send_to'></p>
							
							<p><b>Прикрепить файл:</b><br>
							<input type='file' name='msg_file'>
							</p>
				HEREDOC;
				echo "<p><input type='submit' name='button' value='Отправить'></p></form></div>";
				//Данные о состоянии непрочитанности сообщения
				$query_unread = "SELECT c.id_chat, c.last_msg_id, c.unread,
							m.id_chat, m.send_to, m.id_msg
						FROM chats AS c 
						JOIN messenges AS m
						ON c.id_chat=m.id_chat AND c.last_msg_id=m.id_msg AND c.id_chat='$id_chat'";
					
				$result_unread = mysqli_query($link, $query_unread);
				$row2 = array();
				for ($i = 0; $i < mysqli_num_rows($result_unread); $i++){
					$row2 = mysqli_fetch_array($result_unread, MYSQLI_ASSOC);
					if(($row2['unread']==1) && ($row2['send_to']=='student')){
						$unread = 0;
						$mysqli = new mysqli(HOST, USER, PASSWORD, DB);
						$mysqli->query("SET @unread='$unread';");
						$mysqli->query("SET @id_chat='$id_chat';");
						$result = $mysqli->query("CALL `editUnreaded`(@unread, @id_chat)");
						if(!$result){
							exit(mysqli_error($mysqli));
						}
					}
				}
				$row = array();
				$k = mysqli_num_rows($result_t);
				if($k == 0){
					echo "<br>Чат пустой. Отправьте сообщение, чтобы начать переписку.";
				}
				else{
					for ($i = 0; $i < mysqli_num_rows($result_t); $i++){
						$row = mysqli_fetch_array($result_t, MYSQLI_ASSOC);
						$k = $k+1;
						if($row['msg_file']==null){
							if( $row['send_to'] == 'student' && $row['id_chat'] == $id_chat){
							printf("<br><div style='background-color:#fff; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
							<p><div style='text-align:left'><b>%s %s %s</b>  | <i>%s</i> </div></p>
							<p><div style='text-align:left'>%s</div></p></div>", $row['last_name'], $row['first_name'], $row['middle_name'], $row['date'], $row['text']);
							}
							
							else if( $row['send_to'] == 'teacher' && $row['id_chat'] == $id_chat){
							printf("<br><div style='background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
							<p><div style='text-align:left'><b>%s %s %s</b>  | <i>%s</i> </div></p>
							<p><div style='text-align:left'>%s</div></p></div>", $row_s['last_name'], $row_s['first_name'], $row_s['middle_name'], $row['date'], $row['text']);
							}
						}
						else{
							if( $row['send_to'] == 'student' && $row['id_chat'] == $id_chat){
							printf("<br><div style='background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
							<p><div style='text-align:left'><b>%s %s %s</b>  | <i>%s</i> </div></p>
							<p><div style='text-align:left'>%s</div></p>
							
							<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b></div>", $row['last_name'], $row['first_name'], $row['middle_name'], $row['date'], $row['text'], $row['msg_file'], basename($row['msg_file']));
							}
							else if( $row['send_to'] == 'teacher' && $row['id_chat'] == $id_chat){
							printf("<br><div style='background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
							<p><div style='text-align:left'><b>%s %s %s</b>  | <i>%s</i> </div></p>
							<p><div style='text-align:left'>%s</div></p>
							
							<b><a style='color:#cc0605; text-align:left' href='%s'><p><img src='file/icons8-досье-20.png'> %s</p></a></b></div>", $row_s['last_name'], $row_s['first_name'], $row_s['middle_name'], $row['date'], $row['text'], $row['msg_file'], basename($row['msg_file']));
							}
						}
					}
				}
			}
		}
		echo '<br></div>';
	}
}			
?>
