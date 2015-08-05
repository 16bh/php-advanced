<?php
	// print_r(PDO::getAvailableDrivers());
	try{
		$pdo = new PDO("mysql:dbname=test;host=localhost","root", "");

		$q = "SELECT * FROM tasks";
		$result = $pdo->query($q);
		$result->setFetchMode(PDO::FETCH_NUM);
		while($row = $result->fetch()){
			echo $row[0].'<br />';
		}

		$stmt = $pdo->prepare('SELECT * FROM tasks WHERE  task_id > ?');
		$rst = $stmt->execute(array('3'));
		var_dump($rst);

		unset($pdo);
	}catch(PDOException $e){
		var_dump($e->getMessage());
	}
?>