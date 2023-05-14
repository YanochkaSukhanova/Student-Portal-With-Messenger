<?php
class category extends ACore_student{

	// Отображение списка лекций, относящихся к конкретному предмету
	public function get_content(){
		echo '<div id="main_a">';			
		if(!$_GET['id_cat']){
			echo 'Неправильные данные для вывода статьи';
		}
		else{
			$id_cat = (int)$_GET['id_cat'];
			if(!$id_cat){
				echo 'Неправильные данные для вывода статьи';
			}
			else{
				$link = mysqli_connect(HOST, USER, PASSWORD, DB);
				$query = "SELECT id, title, discription, date, file_src 
					  FROM posts 
					  WHERE cat='$id_cat' 
					  ORDER BY date DESC";
				$result = mysqli_query($link, $query);
				if(!$result){
					exit(mysqli_error($link));
				}
				$query_a = "SELECT id_category, name_category 
					  FROM category
					  WHERE id_category='$id_cat' ";
				$link_a = mysqli_connect(HOST, USER, PASSWORD, DB);
				$result_a = mysqli_query($link_a, $query_a);
				if(!$result_a){
				 	exit(mysqli_error($link_a));
				}
				$name_cat = array();
				for ($i = 0; $i < mysqli_num_rows($result_a); $i++){
				   	$name_cat = mysqli_fetch_array($result_a, MYSQLI_ASSOC);
				}
				$a = $name_cat['name_category'];
				echo "<h2 style='color: #cc0605'>Лекции по предмету &#8220;$a&#8220;</h2>";
				$row = array();
				$count = mysqli_num_rows($result);
				if($count == 0){
					echo "<div>Данные на этой странице отсутствуют</div>
						<div>Возможно, преподаватель удалил или еще не добавил лекции по этому предмету</div>";
					echo '<img class="illustration_big" src="file/undraw_Taken_re_yn20.png">';
				}
				else{
					echo '<img class="illustration_big" src="file/undraw_Designer_re_5v95.png">';
				}
				for ($i = 0; $i < mysqli_num_rows($result); $i++){
					$row = mysqli_fetch_array($result, MYSQLI_ASSOC); //---последовательно считываем ряды результата
					
					printf("<div style=' background-color:#fff3ed; border: 2px solid #cc0605; border-radius: 25px;box-sizing: border-box; padding: 20px;'>
					<p><b><a style='font-size: 20px; color: #585858; text-decoration: none' href='?option=view&id_text=%s'>%s</a></b></p>
					<p><a style='font-size: 20px; color: #585858; text-decoration: none' href='?option=view&id_text=%s'>%s</a></p>
					</div><br>", $row['id'], $row['title'], $row['id'], $row['discription']);
				}
			}
		}
		echo '</div>';
	}
}
?>
