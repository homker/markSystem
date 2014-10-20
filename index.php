<?php
	$time = time();
	exec("nmap -sP 192.168.1.0/24",$res,$rs);
	if($rs == 0){
		print_r($res);
	}
	$latetime = time();
	echo $time = $latetime - $time;
?>
