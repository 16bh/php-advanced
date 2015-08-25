<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php #script 1-2 add_task.php
	$dbc = mysqli_connect('localhost', 'root', '', 'test');
	var_dump($dbc);
	if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST['task'])) {
		if(isset($_POST['parent_id']) && filter_var($_POST['parent_id'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$parent_id = $_POST['parent_id'];
		}else{
			$parent_id = 0;
		}

		$task = mysqli_real_escape_string($dbc, strip_tags($_POST['task']));

		$q = "INSERT INTO tasks (parent_id, task) VALUES ($parent_id, '$task')";
		$r = mysqli_query($dbc, $q);

		if(mysqli_affected_rows($dbc) == 1){
			echo '<p>the task has been added!</p>';
		}else{
			echo '<p>the task could not been added!</p>';
		}
	}

	echo '<form action="1_2.php" method="post">
	<fieldset>
	<legend>add a task</legend>
	<p>task:<input name="task" type="text" size="60" maxlength="100" required></p>
	<p>parent task:<select name="parent_id"><option value="0">NONE</option>';
	$q = 'SELECT task_id, parent_id, task FROM tasks WHERE date_completed = "0000-00-00 00:00:00"
		ORDER BY date_added ASC';
	$r = mysqli_query($dbc, $q);

	$tasks = array();
	while(list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)){
		echo "<option value=\"$task_id\">$task_id</option>\n";
		$tasks[] = array('task_id'=>$task_id, 'parent_id'=>$parent_id, 'task'=>$task);
	}

	echo '</select></p>
		<input type="submit" type="submit" value="add this task">
		</fieldset>
		</form>';

	function parent_sort($x, $y){
		return ($x['parent_id'] > $y['parent_id']);
	}
	usort($tasks, 'parent_sort');

	echo '<h2>current to-do list</h2><ul>';
	foreach($tasks as $task){
		echo "<li>{$task['task']}</li>\n";
	}
	echo '</ul>'

?>
</body>
</html>