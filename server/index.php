<?php

	//connect the redis
	
	$redis= new Redis();
    $redis->connect('127.0.0.1',6379);
    
	$time = microtime();
	//var_dump($_SERVER['REQUEST_METHOD']);
	switch($_SERVER['REQUEST_METHOD']){
		case 'GET' :  get (); break;
		case 'POST':  post(); break;
		default: header('HTTP/1.1 405 Method Not Allowed');
	}
	
	
	function get()
	{
		if($_GET['MAC']){
			$mac = getMAC();
			echo $content = response($mac,$time);
		}else{
			$ip = getIP();
			echo $content = response($ip,$time);
		}
		//echo "hello world";
	}
	
	function  getNowMAC(){
		if(
		$MAC_address = array();
		exec("sudo nmap -sP 192.168.1.0/24",$res,$rs);
		//var_dump($res);
		if($rs == 0){
			foreach($res as $value){
				if(strstr($value,"192.168.1.106")) continue;
				if(strstr($value,"Nmap scan report for")){
					$result = substr($value,20);
					array_push($MAC_address,$result);
				}
				if(strstr($value,"MAC Address")){
					$result = substr($value,12);
					array_push($MAC_address,$result);
				}
			}
		}
		return $MAC_address;
	}
	function getIP()
	{
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		  $cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif(!empty($_SERVER["REMOTE_ADDR"])){
		  $cip = $_SERVER["REMOTE_ADDR"];
		}
		else{
		  $cip = "无法获取！";
		}
		return $cip;
	}
	/*******   redis fucntion   **********/
	
	function getMAC($redis){
		if(!$redis->exists("address")){
			addMacAddress($redis);
		}
		return $tempAddress = $redis->lRange('address', 0, -1);
	}
	
	function addMacAddress($redis)
	{
		$macAddress = getNowMAC();
		//$address = array();
		for($i = 0; $i<count($macAddress);$i=$i+2){
			$tmpAddress = serialize(array("IP"=>$macAddress['$i'],"MAC"=>$macAddress['$i+1']));//数组序列化操作
			$redis->rPush("address",$tmpAddress);
		}
		
	}
	
	function getTimelenth($mac,$redis)
	{
	
     $ariveTime = $redis->get('name');
     $leaveTime = microtime();
     $timeLenth = $ariveTime - $leaveTime;
     $redis->sAdd($mac,$timeLenth);
     return $timeLenth;
	}
	
	function register($mac,$redis)
	{
		$registerTime = microtime();
		if($redis->set($mac,$registerTime)){
			return true;
		}else{
			return false;
		}
		
	}
	/************* respnse fucntion **************/
	function response($content,$time)
	{
		$latetime = microtime();
		$time = $latetime - $time;
		$response = json_encode(array("content"=>$content,"date"=>date("Y-m-d H:m:s"),"time"=>$time));
		return $response;
	}
	
?>
