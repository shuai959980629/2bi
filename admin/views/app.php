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
                   	<!--app管理开始-->
                    <div class="app_manage_btn clearfix"><a class="btn green fr" href="<?php echo $url_prefix?>app/add">新增</a></div>
                	<div class="app_manage clearfix portlet box grey">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td>系统</td>
                                    <td>系统版本</td>
                                    <td>内部版本</td>
                                    <td>是否强制更新</td>
                                    <td>上传时间</td>
                                    <td>编辑人</td>
                                    <td>操作</td>
                                </tr>
                                <?php if($v_list){?>
                                <?php foreach($v_list as $key=>$val){?>
                                <tr style="text-align: center;">
                                	<td><?php echo $val['client_type'];?></td>
                                    <td><?php echo $val['version'];?></td>
                                    <td><?php echo $val['inner_version'];?></td>
                                    <td>
                                        <?php if($val['is_update']){?>
                                            是
                                        <?php }else{?>
                                            否
                                        <?php }?>
                                    </td>
                                    <td><?php echo date('Y-m-d',strtotime($val['created']));?></td>
                                    <td><?php echo $val['sysuser_name'];?></td>
                                    <td><a class="btn grey" data-app="<?php echo $val['app_version_id'];?>" onclick="openpop(this)" href="javascript:void(0);">删除</a></td>
                                </tr>
                                 <?php }?>
                                <?php }else{?>
                                    <tr style="text-align: center;"><td colspan="7">暂无版本信息！</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <!--app管理结束-->
                    <!--app管理删除开始-->
                    	<div id="show_div" style="display: none;">
                        	<p class="alone">确定是否删除该版本的信息！</p>
                            <input type="hidden" value=""  id="appid" />
                            <p><a class="btn green" onclick="delversion()" href="javascript:void(0);">确认</a><a class="btn grey" onclick="cancel()" href="javascript:void(0);">取消</a></p>
                        </div>
                    	<div id="pop_up" style="display: none;"></div>
                    <!--app管理删除结束-->
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
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END FOOTER -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
});
function openpop(_obj){
    var appid = $(_obj).attr("data-app");
    $("#appid").val(appid);
    $("#pop_up").show();
    $("#show_div").show();
}

function cancel(){
    $("#pop_up").hide();
    $("#show_div").hide();
}

function delversion(){
    var appid = $("#appid").val();
    $.post('<?php echo $url_prefix;?>app/delversion', {
            'appid':appid
    }, function(data){
        if(data.status){
            window.location.reload();
        }else{
            alert(data.msg);
            cancel();
        }
    }, 'json');
}
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
