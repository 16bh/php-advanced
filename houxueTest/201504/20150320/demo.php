<?php
$pdo = new PDO("mysql:host=localhost;dbname=tp32","root","123456");
$sSql = "SELECT * FROM `www_index_ordernums_setting` LIMIT 0,1";
$total = $pdo->query($sSql)->fetch(PDO::FETCH_ASSOC);
var_dump($total);


if($_GET["flag"]=="getInitData")
{
	if($_COOKIE['houxue_aid']) $aid = intval($_COOKIE['houxue_aid']);
	if($aid) $area = Area::getAreaById($aid);
	if(!$area['Id'])
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		if($ip) $area = Area::getAreaByIp($ip);
	}
	if($area['Id'])
	{
		for($i=0; $i<count($area["Path"]); $i ++){	$AreaNamePath .= $area["Path"][$i]["AreaName"]."-";}
		$AreaNamePath = trim($AreaNamePath, "-");
	}
	$aid = $area['Id'] ? $area['Id'] : 0;
	$AreaNamePath = $AreaNamePath=='' ? '全国' : $AreaNamePath;

	$sSql = "SELECT count(Id) as c FROM `T_Order` WHERE Dtt>'".date("Y-m-d")."'";
	$data = $dbh2->query($sSql)->fetch(PDO::FETCH_ASSOC);
	$todayordernums = $data["c"] ? $data["c"] : 0;

	unset($response);
	$response["rtn"] = "ok";
	$response["data"] = array("aid"=>$aid,"areanamepath"=>$AreaNamePath,"todayordernums"=>$todayordernums);
	echo json_encode($response); exit();
}


?>
