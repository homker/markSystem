<?php
	$time = time();
	$content = array();
	exec("sudo nmap -sP 192.168.1.0/24",$res,$rs);
	//var_dump($res);
	if($rs == 0){
		foreach($res as $value){
			if(strstr($value,"192.168.1.106")||strstr($value,"192.168.1.1")) continue;
			if(strstr($value,"Nmap scan report for")){
				$result = substr($value,20);
				array_push($content,$result);
			}
			if(strstr($value,"MAC Address")){
				$result = substr($value,12);
				array_push($content,$result);
			}
			//var_dump($matchs);
		//print_r($res);
		}
	}
	var_dump($content);
	$latetime = time();
	echo $time = $latetime - $time;
?>
