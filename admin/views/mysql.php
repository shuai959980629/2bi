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

				<div class="modal-body">

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
                           邻售管理<small>LinShou management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="<?php echo $url_prefix?>super">邻售管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="<?php echo $url_prefix;?>super/adminMysql">数据库管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--用户管理开始-->
                    <div style="border: 1px solid #ddd; width:100%;height:200px;float:left;margin-bottom: 20px;">
                    	<div style="width:100%;height:30px;line-height:30px;font-size:14px;float:left;margin-top:10px;color:blue;">邻售数据库(数据库中的表如下)：
                            <span style="font-weight: bold;"><?php echo $dtbase;?></span>
                        </div>
                        <div style="width:100%;height:100px;float:left;">
                            <?php foreach($tbs as $key=>$tb){ ?>
                                <a style="color:green;font-size:14px;display: block; margin-left:10px;width:200px;height:30px;line-height:30px;float:left;text-align:left;" href="javascript:void(0);"><?php echo $tb;?></a>
                            <?php }?>
                        </div>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="super" />
                	<div class="user_manage clearfix portlet box grey" style="border: 1px solid #ddd; width:100%;height:600px;color:blue;font-weight: bold;">
                    	<div style="width:100%;height:50px;line-height:50px;font-size:14px;float:left;color:blue;">邻售数据库操作：</div>
                        <div style="padding-left:20px;width:100%;font-size:14px;float:left;color:blue;">请输入需要执行的数据库SQL语句(INSERT、DELETE、UPDATE、SELECT、ALTER)：</div>
                        <div style="width:100%;height:100px; margin-top:80px;">
                            <textarea style="width: 1400px; height: 90px;border:1px solid green;resize: none; " id="mysql" >请输入执行的SQL</textarea>
                        </div>
                        <div style="width:100%;height:90px;">
                            <a class="btn green execute" style="margin-top:40px;margin-left:100px;" href="javascript:void(0);">执行EXECUTE</a>
                            <a class="btn green" id="wait" style="margin-top:40px;margin-left:100px;display: none;" href="javascript:void(0);">正在执行中。。。。</a>
                            <a class="btn yellow clear" style="margin-top:40px;margin-left:100px;" href="javascript:void(0);">清空输入内容</a>
                        </div>
                        <div class="event_list" style="text-align:center;border: 1px solid #ddd;font-size:14px; width:100%;height:350px;color:white;font-weight: bold;overflow:auto;background: black;">
                            
                        </div>
                    </div>
                    <!--用户管理结束-->
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
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
   $(".cancel").live('click',function(){
    	$("#show_div").remove();
    	$("#pop_up").remove();
    });
   $(".clear").click(function(){
        $("#mysql").val('');
        $('.event_list').html('');
   });
   $(".execute").click(function(){
        var mysql = $("#mysql").val();
        if(mysql=='请输入执行的SQL'||mysql==''){
            alert("请输入执行的SQL");
            return false;
        }
        $(this).hide();
        $("#wait").show();
        $.post('<?php echo $url_prefix;?>super/exec', {
                'mysql':mysql
        }, function(data){
            if(data.status){
                $('.event_list').html(data.data);
            }else{
                alert(data.msg);
            }
            $(".execute").show();
            $("#wait").hide();
            //$("#mysql").val('');
        }, 'json'); 
   });
})
</script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
