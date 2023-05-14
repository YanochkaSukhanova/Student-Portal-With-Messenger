<?php
class new_messenger_stud extends ACore_student {
	// Отображение всех доступных пользователю чатов, в которых есть непрочитанные им сообщения
	public function get_content(){
		$my_id = $_SESSION['user']['id'];
		$query = "SELECT c.id_chat, c.id_user_teacher, c.last_msg_id, c.unread,
				 u.id, u.rights, u.last_name, u.first_name, u.middle_name 
			FROM chats AS c 
			JOIN users AS u 
			ON c.id_user_teacher=u.id AND c.id_user_student=$my_id
			ORDER BY c.last_msg_id DESC";
		$link = mysqli_connect(HOST, USER, PASSWORD, DB);
		$result = mysqli_query($link, $query);
		if(!$result){
			exit(mysqli_error($link));
		}
		echo "<div id='main_a'>";
		echo "<h2>Чаты с преподавателями</h2>";
		echo '<img class="illustration" src="file/undraw_Newsletter_re_wrob.png">';
		echo "<br><div style='margin-right: 500px'>
			<a style='text-align:left' href='?option=add_chat_stud'><button>Добавить новый чат</button></a>
			<a style='text-align:left; margin-left: 50px;' href='?option=messenger_stud'><button>Все сообщения</button></a>
			</div>";
		$query1 = "SELECT c.id_chat, c.last_msg_id,
				m.id_chat, m.send_to, m.id_msg
			FROM chats AS c 
			JOIN messenges AS m
			ON c.id_chat=m.id_chat AND c.last_msg_id=m.id_msg
			ORDER BY c.last_msg_id DESC";
		$result1 = mysqli_query($link, $query1);
		if(!$result1){
			exit(mysqli_error($link));
		}
		$count = 0;
		$row = array();
		$row2 = array();
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
			$row2 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
			if(($row['unread']==1) && ($row2['send_to']=='student')){
				printf("<br><div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
				<p style='font-size:20px;'>
				<a style='color:#585858; text-decoration: none;' href='?option=chat_stud&id_chat=%s'>%s %s %s  <img src='file/icons8-новинка-24.png'></a></p></div>",   $row['id_chat'], $row['last_name'], $row['first_name'], $row['middle_name']);
				$count=$count+1;
			}
		}
		if($count == 0){
			echo "<br><div style=' background-color:#fff; border: 2px solid #fff; border-radius: 15px;box-sizing: border-box; padding: 10px;'>У Вас нет непрочитанных сообщений</div>";
		}
		echo '</div>';
	}
}
?>
