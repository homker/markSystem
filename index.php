<?php
	$time = time();
	exec("nmap -sP 192.168.1.0/24",$res,$rs);
	if($rs == 0){
		$param = "/Nmap scan report for(.*?)/\n/";   
		$result = preg_macth_all($res,$param,$preg);
		var_dump($preg);
		print_r($res);
	}
	$latetime = time();
	echo $time = $latetime - $time;
?>
