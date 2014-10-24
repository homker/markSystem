<?php

	//connect the redis
	
	$redis= new Redis();
    $redis->connect('127.0.0.1',6379);
    
	$time = microtime();
	//var_dump($_SERVER['REQUEST_METHOD']);
	switch($_SERVER['REQUEST_METHOD']){
		case 'GET' :  get ($redis,$time); break;
		case 'POST':  post($redis,$time); break;
		default: header('HTTP/1.1 405 Method Not Allowed');
	}
	
	
	function get($redis,$time)
	{
		if($_GET['MAC']){
			$mac = getAllMAC($redis);
			if($date = register()) $date = date("Y-m-d H:m:s",$date);
			echo $content = response($mac,$time,$date);
		}else{
			$ip = getIP();
			echo $content = response($ip,$time);
		}
		//echo "hello world";
	}
	function post($redis,$time)
	{
		if($_POST['studentID']){
			if(is_numeric($_POST['studentID'])){
			}else{
				$reback = array("error"=>"not num");
				echo $content response($reback,$time)
			}
		}
	}
	
	
	function  getNowMAC(){
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
	
	function getAllMAC($redis){
		$address = array();
		if(!$redis->exists('address')){
			addMacAddress($redis);
		}
	
		$tempAddress = $redis->lRange('address', 0, -1);
		for($i=0;$i<count($tempAddress);$i++){
			array_push($address,unserialize($tempAddress["$i"]));
		}
		return $address; 
	}
	
	function addMacAddress($redis)
	{
		$macAddress = getNowMAC();
		//$address = array();
		for($i = 0; $i<count($macAddress);$i=$i+2){
			$m = $i + 1;
			$tmpAddress = serialize(array("IP"=>$macAddress["$i"],"MAC"=>$macAddress["$m"]));//数组序列化操作
			$redis->rPush("address",$tmpAddress);
		}
		
	}
	
	function getTimelenth($mac,$redis)
	{
	
     $ariveTime = $redis->get($mac);
     $leaveTime = time();
     $timeLenth = $ariveTime - $leaveTime;
     $redis->sAdd($mac,$timeLenth);
     return $timeLenth;
	}
	
	function register($mac,$redis)
	{
		$registerTime = time();
		if($redis->set($mac,$registerTime)){
			return $registerTime;
		}else{
			return false;
		}
		
	}
	/************* respnse fucntion **************/
	function response($content,$time,$date = date("Y-m-d H:m:s"))
	{
		$latetime = microtime();
		$time = $latetime - $time;
		$response = json_encode(array("content"=>$content,"date"=>$date,"time"=>$time));
		return $response;
	}
	
?>
