<?php
	$time = time();
	exec("sudo nmap -sP 192.168.1.0/24",$res,$rs);
	var_dump($res);
	if($rs == 0){
		foreach($res as $value){
			if(strstr($value,"Nmap scan report for")){
				$result = substr($value,17);
				echo $result."<br/>";
			}
			if(strstr($value,"MAC Address")){
				$result = substr($value,11)
				echo $result."<br/>";
			}
			//var_dump($matchs);
		//print_r($res);
		}
	}
	$latetime = time();
	echo $time = $latetime - $time;
?>
