<?php
	$time = time();
	exec("nmap -sP 192.168.1.0/24",$res,$rs);
	if($rs == 0){
		$param = "/Nmap scan report for (.*?)/";   
		foreach($res as $value){
			$result = preg_match($param,$res,$matchs);
			var_dump($matchs);
		//print_r($res);
		}
	}
	$latetime = time();
	echo $time = $latetime - $time;
?>
