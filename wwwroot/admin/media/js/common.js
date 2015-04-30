function html_pop(content,method){
    var pop = '<div id="show_div" style="border-top:3px solid #645D5D;border-left:3px solid #645D5D;box-shadow:-3px -3px 3px #645D5D inset;border-radius:3px;">'+content+
                '<div>'+
                    '<p><a class="btn grey cancel"  href="javascript:void(0)">取消</a>'+
                    '<a class="btn  green" onclick="'+method+'()"  href="javascript:void(0)">确认</a></p>'+
                '</div>'+
              '</div><div id="pop_up" style="text-align:center;color:red;vertical-align:middle;" ></div>';
	$("body").append(pop);
}

function cancel(){
     $("#show_div").remove();
     $("#pop_up").remove();
}

/*等待响应*/
function waiting(){
    if($("#show_div").length>0 && $("#pop_up").length>0){
        $("#show_div").remove();
        $("#pop_up").css("background","url(media/image/t010bed130fa625cf590.gif) center no-repeat black");
    }else{
        $("body").append('<div id="pop_up" style="text-align:center;color:red;vertical-align:middle;background: url(media/image/t010bed130fa625cf590.gif) center no-repeat black;" ></div>');
    }
}