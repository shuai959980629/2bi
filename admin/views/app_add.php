   <!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<?php require_once('header.php');?>
<!-- END HEAD -->
	<!-- BEGIN CONTAINER -->   

	<div class="page-container row-fluid">

		<!-- 左边开始 -->
            <?php require_once('item.php');?>
		<!-- 左边结束 -->

		<!-- BEGIN PAGE -->

		<div class="page-content">

			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<div id="portlet-config" class="modal hide">

				<div class="modal-header">

					<button data-dismiss="modal" class="close" type="button"></button>

					<h3>portlet Settings</h3>

				</div>

				<div  class="modal-body">

					<p>Here will be a configuration form</p>

				</div>

			</div>

			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->

			<!-- 右边开始-->

			<div class="container-fluid" >
  	             <!--右边标题导航开始-->
				<div class="row-fluid">

					<div class="span12">

						<!-- BEGIN PAGE TITLE & BREADCRUMB-->

						<h3 class="page-title">
                           APP管理<small>APP-Version  management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="<?php echo $url_prefix?>app">APP管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">版本管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--添加APP开始-->
                    <div class="add_app">
						<div class="portlet box purple">
                   		 <div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>新增app</div>
						 </div>
                    	<div class="portlet-body form">
								<!--app开始-->
                                <div class="goods_add">
                                 <form action="<?php echo $url_prefix;?>app/add_app" id="form_app_add" class="form-horizontal" method="post" enctype="multipart/form-data" >   
									<input type="hidden" value="<?php echo $url_prefix;?>app/add_app" id="jobaction"/>
                                    <div class="alert alert-error hide">

										<button class="close" data-dismiss="alert"></button>
                                        请确保输入的内容符合提交条件，再点击提交！

									</div>

									<div class="alert alert-success hide">

										<button class="close" data-dismiss="alert"></button>
                                        你的信息已成功完成验证！

									</div>

									<div class="control-group">
										<label class="control-label">软件系统<span class="required">*</span></label>
										<div class="controls">
											<input name="plat" checked="true" data=".apk" type="radio" value="android"/><b>android</b><input  data=".ipa" name="plat" type="radio" value="ios"><b>ios</b>
										</div>
									</div>
                                    <div class="control-group">
										<label class="control-label">上传软件<span class="required">*</span></label>
										<div class="controls">
                                            <div id="swfupload-controlA">
                                                <input type="button" id="buttonA" style="background: none;border:0px;" />
                                                <input type="hidden" id="appNum" name="appNum" value="0"/>
                                                <p id="queuestatusA" ></p>
                                                <ol id="logA"></ol>
                                            </div>
                                            <input type="hidden" id="app_src" name="app_src" value=" "/>
                                            <input type="hidden" id="app_name" name="app_name" value=" "/>
										</div>
									</div>
                                     <div class="control-group">
										<label class="control-label">软件大小<span class="required">*</span></label>
										<div class="controls">
                                            <input class="span6 m-wrap" id="appsize" name="size" value="" readonly="true" type="text">
										</div>
									</div>
                                     <div class="control-group">
										<label class="control-label">系统版本<span class="required">*</span></label>
										<div class="controls">
											<input class="span6 m-wrap" name="version" type="text">
										</div>
									</div>
                                    <div class="control-group">
										<label class="control-label">内部版本<span class="required">*</span></label>
										<div class="controls">
											<input class="span6 m-wrap" name="inner_version" type="text">
										</div>
									</div>
                                    <div class="control-group">
										<label class="control-label">是否强制更新<span class="required">*</span></label>
										<div class="controls">
											<input name="update" checked="true" type="radio" value="1"><b>是</b><input name="update" type="radio" value="0"><b>否</b>
										</div>
									</div>
                                     <div class="control-group">
										<label class="control-label">更新日志<span class="required">*</span></label>
										<div class="controls">
											<textarea onkeydown="if(this.value.length>240){this.value=this.value.slice(0,240)}" class="span6 m-wrap" name="log" cols="" rows=""></textarea>
										</div>
									</div>

									<div class="form-actions">
                                        <button type="submit" id="submitForm" class="btn purple">提交</button>
                                        <button type="reset" class="btn" onclick="back()" >取消</button>
									</div>

								</form>
                                </div>
							</div>	
                    </div>
                    </div>
                    <!--添加APP结束-->
                </div>
                <!--右边中介内容结束-->
			</div>

			<!-- 右边结束--> 

		</div>

		<!-- END PAGE -->    

	</div>

	<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<?php require_once('footer.php');?>
<!-- END FOOTER -->
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/jquery.swfupload.js"></script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/form-validation.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
   FormValidation.appInit();
   var isUploadapp = 0;
   var fileid ='';
   $('#swfupload-controlA').swfupload({
        upload_url: '<?php echo $url_prefix;?>/files/upload_all_file?type=app',
        file_post_name: 'attachment',
        file_size_limit : '10240',
        file_types : "*.apk;*.ipa",
        file_types_description : "APP files",
        file_upload_limit : 0,
        flash_url : "<?php echo $url_prefix;?>media/js/swfupload/swfupload.swf",
        button_image_url : '<?php echo $url_prefix;?>media/js/swfupload/wdp_buttons_upload_114x29_.png',
        button_width : 420,
        button_height : 32,
        button_placeholder : $('#buttonA')[0],
        button_action:SWFUpload.BUTTON_ACTION.SELECT_FILE,
        debug: false
    }).bind('fileQueued', function(event, file){
        var plat = $('input:radio[name="plat"]:checked').val();
        var ext = $('input:radio[name="plat"]:checked').attr('data');
        if(ext!=file.type){
            alert("文件类型不一致："+plat+"系统只能上传，后缀名为：*"+ext+"文件！");
            var swfu = $.swfupload.getInstance('#swfupload-controlA');
            swfu.cancelUpload(file.id);
            fileid = file.id;
            return false;
        }
        if(parseInt($('#appNum').val()) >= 1){
            alert("APP文件最多只能传送1个!");
            var swfu = $.swfupload.getInstance('#swfupload-controlA');
            swfu.cancelUpload(file.id);
            fileid = file.id;
            return false;
        }
        isUploadapp = 1;
        $('#appNum').val(parseInt($('#appNum').val())+1);

        var listitem='<li id="'+file.id+'" ><b class="audio-component-icon nui-ico fl"></b>'+
            '<em>'+file.name+'</em> '+
            '<span class="file_cancel" style="display: none;cursor: pointer;color:red;font-weight:bold;">点击删除</span>'+
            '<span class="cancel" style="cursor: pointer;color:red;font-weight:bold;" >点击删除</span>'+
            '<div class="progressbar" style="display:none;"><div class="progress" ></div></div><span class="progressvalue" ></span>'+
            '<p class="status" >等待中..</p>'+
            '</li>';

        $('#logA').append(listitem);
        $('li#'+file.id+' .cancel').bind('click', function(){
            var swfu = $.swfupload.getInstance('#swfupload-controlA');
            swfu.cancelUpload(file.id);
            $('li#'+file.id).slideUp('fast');
            $('#submitForm').addClass('purple');
            $('#submitForm').attr('onClick','');
            $('#form_app_add').attr('action',$("#jobaction").val());
            isUploadapp = 0;
        });

        if($('#submitForm').attr('class') == 'btn purple'){
            $('#submitForm').removeClass('purple');
            $('#submitForm').attr('onClick','return false;');
            $('#form_app_add').attr('action','');
        }
        $(this).swfupload('startUpload');
    })
    .bind('fileQueueError', function(event, file, errorCode, message){
        isUploadapp = 0;
        if(file){
            alert(file.name+' 的文件已超限，详细请见备注！');//大小('+Math.round(file.size/1024)+'KB)
        }else
            alert('超过队列数了！');
    })
    .bind('uploadStart', function(event, file){
        $('#logA li#'+file.id).find('div.progressbar').css('display','block');
        $('#logA li#'+file.id).find('p.status').text('');
        $('#logA li#'+file.id).find('span.progressvalue').text('0%');
    })
    .bind('uploadProgress', function(event, file, bytesLoaded){
        //Show Progress
        var percentage=Math.round((bytesLoaded/file.size)*100);
        percentage = percentage>100?100:percentage;
        $('#logA li#'+file.id).find('div.progress').css('width', percentage +'%');
        $('#logA li#'+file.id).find('span.progressvalue').text(percentage+'%');
        if(percentage >= 100){
            $('#logA li#'+file.id).find('div.progressbar').css('display','none');
            $('#logA li#'+file.id).find('span.progressvalue').text('');
            $('#logA li#'+file.id).addClass('success').find('p.status').html('('+(file.size/1024/1024).toFixed(2)+'MB)<i>上传完成</i>');//+pathtofile
            if($('#logA li#'+file.id).find('span.cancel').css('display') != 'none'){
                $('#logA li#'+file.id).find('span.cancel').hide();
                $('#logA li#'+file.id).find('span.file_cancel').show();
                $('li#'+file.id+' .file_cancel').unbind('click');
                $('li#'+file.id+' .file_cancel').bind('click', function(){
                    var swfu = $.swfupload.getInstance('#swfupload-controlA');
                    swfu.cancelUpload(file.id);
                    close(this);
                });
            }
            isUploadapp = 0;
        }
    })
    .bind('uploadError', function(event, file, message){
        $('#logA li#'+file.id).find('div.progressbar').css('display','none');
        $('#logA li#'+file.id).find('span.progressvalue').text('');
        $('#logA li#'+file.id).addClass('success').find('p.status').html('<i>上传失败</i>');//+pathtofile
//                $('#logA li#'+file.id).find('span.cancel').show();
//                if($('#logA li#'+file.id).find('span.cancel').css('display') != 'none'){
            $('#logA li#'+file.id).find('span.cancel').hide();
            $('#logA li#'+file.id).find('span.file_cancel').show();
            $('li#'+file.id+' .file_cancel').unbind('click');
            $('li#'+file.id+' .file_cancel').bind('click', function(){
                var swfu = $.swfupload.getInstance('#swfupload-controlA');
                swfu.cancelUpload(file.id);
                close(this);
            });
//                }
        if(fileid != file.id){
            $('#appNum').val(parseInt($('#appNum').val())-1);
        }else{
            fileid = '';
        }
        isUploadapp = 0;
    })
    .bind('uploadSuccess', function(event, file, serverDatas){
        var serverData = $.parseJSON(serverDatas);
        if(serverData.status == 0){
            html_notice('操作失败',serverData.msg,serverData);
            $('#logA li#'+file.id).find('div.progressbar').css('display','none');
            $('#logA li#'+file.id).find('span.progressvalue').text('');
            $('#logA li#'+file.id).addClass('success').find('p.status').html('<i>上传失败</i>');//+pathtofile
            $('#logA li#'+file.id).find('span.cancel').hide();
            $('#logA li#'+file.id).find('span.file_cancel').show();
            $('li#'+file.id+' .file_cancel').unbind('click');
            $('li#'+file.id+' .file_cancel').bind('click', function(){
                var swfu = $.swfupload.getInstance('#swfupload-controlA');
                swfu.cancelUpload(file.id);
                close(this);
            });
            if(fileid != file.id){
                $('#appNum').val(parseInt($('#appNum').val())-1);
            }else{
                fileid = '';
            }
        }else{
            /*
            {"status":1,"data":{"name":"\/attachment\/app\/bi_V1.2-a009.apk"},"msg":"\u4e0a\u4f20\u6210\u529f\uff01","time":0.055874109268188}
            */
            $("#appsize").val((file.size/1024/1024).toFixed(2)+'MB');
            var item=$('#logA li#'+file.id);
            item.find('div.progressbar').css('display','none');
            item.find('span.progressvalue').text('');

            item.addClass('success').find('p.status').html('('+(file.size/1024/1024).toFixed(2)+'MB)<i>上传完成</i>');//+pathtofile
            if(item.find('span.file_cancel').css('display') == 'none'){
                item.find('span.cancel').hide();
                item.find('span.file_cancel').show();
                $('li#'+file.id+' .file_cancel').unbind('click');
                $('li#'+file.id+' .file_cancel').bind('click', function(){
                    var swfu = $.swfupload.getInstance('#swfupload-controlA');
                    swfu.cancelUpload(file.id);
                    close(this);
                });
            }
            if($('#app_src').val() != " "){
                if($('#app_src').val() != ""){
                    $('#app_src').val($('#app_src').val() + "," +serverData.data.path);
                    $('#app_name').val($('#app_name').val() + "," +file.name);
                } else{
                    $('#app_src').val(serverData.data.path);
                    $('#app_name').val(file.name);
                }
            } else{
                $('#app_src').val(serverData.data.path);
                $('#app_name').val(file.name);
            }
            //图片上传成功去除错误提示
            $(this).children('.help-inline').remove();
            $(this).parent().parent().removeClass('error');

            if(isUploadapp == 0){
                $('#submitForm').addClass('purple');
                $('#submitForm').attr('onclick','');
                $('#form_app_add').attr('action',$("#jobaction").val());
            }
        }
        isUploadapp = 0;
    })
    .bind('uploadComplete', function(event, file){
          $(this).swfupload('startUpload');
    });

   
   
});
//取消
function back(){
    $('.help-inline').remove();
    var fileName = $('#app_name').val();
    $.post('<?php echo $url_prefix;?>files/del_all_file', {
            'fileName':fileName,'type':"app"
    }, function(data){
        $('#logA').html('');
        $('#appNum').val(0);
        $('#app_src').val('');
        $('#app_name').val('');
        $("#appsize").val("");
        //window.location.reload();
    }, 'json');
}
function close(obj){
    $(obj).parent().remove();
    $('#logA').html('');
    $('#appNum').val(0);
    $('#app_src').val('');
    $('#app_name').val('');
    $("#appsize").val("");
}
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>