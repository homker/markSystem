$(document).ready(function(){
	$.get("./server/index.php?MAC=get",function(data){
		console.log(data.content);
		for(var i = 0 ; i<data.content.lenth ; i += 2){
			alert("hehe");
			console.log(data.content['i']);
			$(".content").append("<tr><td>"+i+"</td><td>"+data.content['i']+"("+data.content['i+1']+")"+"</td><td>"+data.date+"</td><td>"+data.timelenth+"</td><td><button type='button' class='btn btn-primary btn-sm'>"+data.method+"</button></td></tr>");
		}
	},'json');
})
