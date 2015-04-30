/**
 * @author zhoushuai
 * 上传图片
 */
function uplodImage(param){
    var input = arguments[1] ? arguments[1] : '';
    var show = arguments[2] ? arguments[2] : 'show';
    var type = arguments[3] ? arguments[3] : false;
    if(!type){
        alert('参数错误，上传失败！');
        return false;
    }
    new AjaxUpload('#'+param, {
        action: '/admin/files/upload_all_file?type=theme', name: 'attachment', type:'POST',
        data: {'type':type},
        onChange:function(file,ext) { 
            return true;
            //提交前运行
        }, onSubmit : function(file, ext) { //提交中运行
            waiting();
        }, onComplete: function(file, response) { //提交完运行
            var dataAry = $.parseJSON(response);
            var imgPreview = dataAry.data.path;
            upload_complete(dataAry,input,show,type);
        }
    });
}

/**
 *@完成操作
 */
function upload_complete(dataAry,input,show,type){
    var html = '';
    if(dataAry.status ==1){
        if(type=='theme'){
            var style_ = 'style="width:auto; height:auto;margin:0 auto;"';
            var file_url = dataAry.data.path;
            var file_name = file_url.substring(file_url.lastIndexOf('/')+1,file_url.length)
            html = '<img class="imgPreview"  src="\/'+file_url+'" '+style_+'/>';
            $("#"+show).html(html);
            $(".imgPreview").fadeIn(2000);
            $("#uploadBtn").hide();
            $("#logo-link").show();
            $("#"+input).val(file_name);
            cancel(); 
        }
    }else{
        alert(dataAry.msg);
    }
}

/**
 *@删除文件
 */
function delete_file(type,input){
    var fileName = $("#"+input).val();
    $.post('/admin/files/del_all_file', {
            'fileName':fileName,'type':type
    }, function(data){
        if(type=='theme'){
            $("#uploadBtn").show();
            $("#logo-link").hide();
            $("#show").html('logo图片预览');
            $("#logo").val('');
        }
    }, 'json');
}





