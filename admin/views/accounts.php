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
                           权限管理<small>Rights Management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="javascript:void(0);">权限管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">帐号管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--账号管理开始-->
                    <div class="account"><a class="btn green fr" href="<?php echo $url_prefix?>accounts/add" style="margin-bottom:15px;">新增</a></div>
                	<div class="user_manage clearfix portlet box grey">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                    <td>账号名称</td>
                                    <td>角色</td>
                                    <td>所属部门</td>
                                    <td>备注</td>
                                    <td>操作</td>
                                </tr>
                                <?php if($adminList){?>
                                <?php foreach($adminList as $key=>$val){?>
                                    <tr style="text-align: center;">
                                    	<td><?php echo $val['username'];?></td>
                                        <td><?php echo $val['profileName'];?></td>
                                        <td><?php echo $val['department'];?></td>
                                        <td><?php echo $val['comment'];?></td>
                                        <td><a class="btn grey" data-app="<?php echo $val['id_admin'];?>" onclick="openpop(this)" href="javascript:void(0);">删除</a></td>
                                    </tr>
                                <?php }?>
                                <?php }else{?>
                                    <tr style="text-align: center;"><td colspan="5">暂无其他管理员</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <!--账号管理结束-->
                    <!--管理删除开始-->
                    	<div id="show_div" style="display: none;">
                        	<p class="alone">确定是否删除该管理员！</p>
                            <input type="hidden" value=""  id="id_admin" />
                            <p><a class="btn green" onclick="deladmin()" href="javascript:void(0);">确认</a><a class="btn grey" onclick="cancel()" href="javascript:void(0);">取消</a></p>
                        </div>
                    	<div id="pop_up" style="display: none;"></div>
                    <!--管理删除结束-->
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
<script>
function openpop(_obj){
    var id_admin = $(_obj).attr("data-app");
    $("#id_admin").val(id_admin);
    $("#pop_up").show();
    $("#show_div").show();
}
function cancel(){
    $("#pop_up").hide();
    $("#show_div").hide();
}

function deladmin(){
    var id_admin = $("#id_admin").val();
    $.post('<?php echo $url_prefix;?>accounts/deladmin', {
            'id_admin':id_admin
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
<!-- END FOOTER -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
	jQuery(document).ready(function() {       
	   App.init();
	   UITree.init();
	});
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
