<html>
<head>
	<title>using splfileobject</title>
</head>
<body>
<?php
	try{
		$fp = new SplFileObject('data.txt', 'w');
		$fp->fwrite('this is a line of data.\n');
		unset($fp);
		echo 'the data has been written';
	}catch(Exception $e){
		var_dump($e->getMessage());
	}
?>
</body>
</html>