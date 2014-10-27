<?php

	//connect the redis
	
	$redis= new Redis();
    $redis->connect('127.0.0.1',6379);
    
	$time = microtime();

	switch($_SERVER['REQUEST_METHOD']){
		case 'GET' :; break;
		case 'POST':  post($redis,$time); break;
		default: header('HTTP/1.1 405 Method Not Allowed');
	}
	
	
	function get($redis,$time)
	{
		if($_GET['MAC']){
			$mac = getAllMAC($redis);
			echo $content = response($mac,$time);
		}else{
			$ip = getIP();
			echo $content = response($ip,$time);
		}
	}
	function post($redis,$time)
	{
		
		if($_POST['studentID']){
			if(is_numeric($_POST['studentID'])){
				$studentID = $_POST['studentID'];
				if(!$redis->exists($studentID)){
					$ip = getIP();
					$mac = getMACByIP($ip,$redis);
					if($mac != null){
						$redis->del("address");
						$mac = getMACByIP($ip,$redis);
					}
					$redis->set($studentID,$mac);
				}
				$mac = $redis->get($studentID);
				if($redis->exists($mac)){
					$redis->delete($mac);
				}else{
					register($mac,$redis);
				}
				$reback = format($redis);
				echo $content = response($reback,$time,$mac);
				exit(0);
			}else{
				$reback = array("error"=>"not num");
				echo $content = response($reback,$time);
				exit(0);
			}
		}
	}
	
	function format($redis){
		$macAddress = getAllMAC($redis);
		$callback = array();
		foreach($macAddress as $value){
			$timeLength = getTimelenth($value['MAC'],$redis);
			$startTime = $redis->get($value['MAC'])?$redis->get($value['MAC']):date("Y-m-d H:i:s",time());//register($value['MAC'],$redis);
			array_push($callback,array('IP'=>$value['IP'],'MAC'=>$value['MAC'],'timeLength'=>$timeLength,'startTime'=>$startTime ));
		}
		return $callback;
	}
	
	
	function  getNowMAC(){
		$MAC_address = array();
		exec("sudo nmap -sP 192.168.1.0/24",$res,$rs);
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
	
	function getMACByIP($ip,$redis){
		$address = getAllMAC($redis);
		foreach($address as $value){
			if(strstr($value['IP'],$ip)) return $value['MAC'];
		}
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
		for($i = 0; $i<count($macAddress);$i=$i+2){
			$m = $i + 1;
			$tmpAddress = serialize(array("IP"=>$macAddress["$i"],"MAC"=>$macAddress["$m"]));//数组序列化操作
			$redis->rPush("address",$tmpAddress);
		}
		
	}
	
	function getTimelenth($mac,$redis)
	{
		 $ariveTime = $redis->get($mac);
		 if(!$ariveTime){
		 	$ariveTime = date("Y-m-d H:i:s",time());
		 }
		 $leaveTime = date("Y-m-d H:i:s",time());
		 $ariveTime = new DateTime($ariveTime);
		 $leaveTime = new DateTime($leaveTime);
		 $timeLenth = $leaveTime->diff($ariveTime);
		 return $timeLenth->format('%H小时%i分%s秒');
     //$timeLenth = $leaveTime - $ariveTime;
	 //$hour = (int)(($timeLenth%(3600*24))/(3600));
	 //$min  = (int)($timeLenth%(3600)/60);
	 //return $timeLenth = $hour.'小时'.$min.'分';	
	}
	
	function register($mac,$redis)
	{
		$registerTime = date("Y-m-d H:i:s",time());
		if($redis->exists($mac)){
			 return $registerTime = $redis->get($mac);
		}else{
			if($redis->set($mac,$registerTime)){
				return $registerTime;
			}else{
				return false;
			}
		}
		
	}
	/************* respnse fucntion **************/
	function response($content,$time,$mac)
	{
		$latetime = microtime();
		$time = $latetime - $time;
		$response = json_encode(array("content"=>$content,"time"=>$time,"who"=>$mac));
		return $response;
	}
	
?>
