<?php
	exec("nmap -sP 192.168.1.0/24",$res,$rs);
	if($rs == 0){
		var_dump($res);
	}
?>
