$(document).ready(function(){
	$.get("./server/index.php?MAC=get",function(data){
		console.log(data.content[0].IP);
		for(var i = 0 ; i<data.content.length ; i ++ ){
			var s = i + 1;
			$(".content").append("<tr><td>"+s+"</td><td>"+data.content[i].IP+"("+data.content[i].MAC+")"+"</td><td>"+data.date+"</td><td>"+data.timelenth+"</td><td><button type='button' class='btn btn-primary btn-sm'>"+data.method+"</button></td></tr>");
		}
	},'json');
})
