<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>sss</title>
</head>
<body>
	<?php #script1.1 sort.php
		$students = array(
			256=>array('name'=>'Jon', 'grade'=>98.5),
			2=>array('name'=>'Vance', 'grade'=>85.1),
			9=>array('name'=>'Stephen', 'grade'=>94.0),
			364=>array('name'=>'Steve', 'grade'=>85.1),
			68=>array('name'=>'Rob', 'grade'=>74.6),
		);

		function name_sort($x, $y){
			return strcasecmp($x['name'], $y['name']);
		}

		function grade_sort($x, $y){
			return ($x['grade'] < $y['grade']);
		}

		echo '<h2>Array As Is</h2><pre>'.print_r($students, 1).'</pre>';

		uasort($students, 'name_sort');
		echo '<h2>Array Sorted By Name</h2><pre>'.print_r($students, 1).'</pre>';

		uasort($students, 'grade_sort');
		echo '<h2>Array Sorted By Grade</h2><pre>'.print_r($students, 1).'</pre>';
	?>
</body>
</html>