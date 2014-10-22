$(document).ready(function(){
	$.get("./server/index.php",function(data){
		console.log(data);
	},'json');
})
