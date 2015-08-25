<?php
	header("Content-type: text/html; charset=utf-8");
	include_once 'IpAddress.class.php';
	$objIpAddress = new IpAddress("./qqwry.dat");
	//$location = $objIpAddress->getlocation('58.240.123.178');
	//$location["area"] = iconv("gb2312", "utf-8", $location["area"]);
	//$location["operators"] = iconv("gb2312", "utf-8", $location["operators"]);
	//var_dump($location);
	//preg_match('/(西藏|内蒙古|宁夏|新疆|广西|(.+)省)(.+)(市|州|地区)|(上海|天津|北京|重庆)(市)/', $location["area"], $userLocation);
	//preg_match('/[((.*?)省)|西藏|内蒙古]?(.*?)[市州]|(上海|天津|北京|重庆)市/', $location["area"], $userLocation);
    //var_dump($userLocation);
	/*
	if (is_array($userLocation)) 
    {
		$offset = count($userLocation)-1;
		var_dump($userLocation[$offset]);
	}
	*/
	/*
	南京：58.240.123.178
	天津：123.150.187.130
	恩施：211.67.33.10
	那曲：202.98.255.191 
	银川：222.75.147.65
	*/
	$ipArrs = array(
		'58.240.123.178',
		'123.150.187.130',
		'211.67.33.10',
		'202.98.255.191',
		'222.75.147.65',
		'202.98.234.109',
		'218.27.205.85',
		'61.134.103.185',
		'127.0.0.1',
	);
	
	foreach($ipArrs as $ip)
	{
		$location = $objIpAddress->getlocation($ip);
		$location["area"] = iconv("gb2312", "utf-8", $location["area"]);
		$location["operators"] = iconv("gb2312", "utf-8", $location["operators"]);
		var_dump($location);
		preg_match('/(西藏|内蒙古|宁夏|新疆|广西|(.*?)省)(.*?)(盟|州|市|地区)|(上海|天津|北京|重庆)(市)/', $location["area"], $userLocation);
		var_dump($userLocation);
		$offset = count($userLocation)-2;
		var_dump($userLocation[$offset]);
		//var_dump($userLocation);
		echo '--------------------------------------------------------------------------------------';
	}
	/*
		/(((.*?)省)|西藏|内蒙古|宁夏|新疆|广西)(.*?)[市州]|(上海|天津|北京|重庆)市/
		
		/(西藏|内蒙古|宁夏|新疆|广西|(.*?)省)(.*?)(盟|州|市|地区)|(上海|天津|北京|重庆)(市)/
	*/
