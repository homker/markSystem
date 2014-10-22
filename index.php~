<?php
	$time = microtime();
	function  getMAC(){
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
	}
	$latetime = microtime();
	echo getIP();
	echo $time = $latetime - $time;
?>
