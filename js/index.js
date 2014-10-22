$(document).ready(function(){
	$.get("./server/index.php?MAC=get",function(data){
		console.log(data);
	},'json');
})
