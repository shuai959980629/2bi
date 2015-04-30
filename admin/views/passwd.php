<!DOCTYPE HTML>

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
                           邻售后台管理<small>LinShou Management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">修改密码</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--修改密码开始-->
                    <div class="add_app">
						<div class="portlet box purple">
                   		 <div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>管理员修改密码</div>
						 </div>
                    	<div class="portlet-body form">
								<!--app开始-->
                                <div class="goods_add">
                                 <form action="<?php echo $url_prefix;?>home/updatepwd" id="modify_passwd" class="form-horizontal" method="post" enctype="multipart/form-data" >   
									<input type="hidden" value="<?php echo $url_prefix;?>home/updatepwd" id="jobaction"/>
                                    <div class="alert alert-error hide">

										<button class="close" data-dismiss="alert"></button>
                                        请确保输入的内容符合提交条件，再点击提交！

									</div>

									<div class="alert alert-success hide">

										<button class="close" data-dismiss="alert"></button>
                                        你的信息已成功完成验证！

									</div>
                                     <div class="control-group">
										<label class="control-label"><span class="required">*</span>原始密码：</label>
										<div class="controls">
                                            <input class="span6 m-wrap" id="opasswd" name="opasswd" value=""  type="password"/>
										</div>
									</div>
                                     <div class="control-group">
										<label class="control-label"><span class="required">*</span>新密码：</label>
										<div class="controls">
											<input class="span6 m-wrap" name="npasswd" id="npasswd" type="password"/>
										</div>
									</div>
                                    <div class="control-group">
										<label class="control-label"><span class="required">*</span>确认密码：</label>
										<div class="controls">
											<input class="span6 m-wrap" name="rnpasswd" id="rnpasswd" type="password"/>
										</div>
									</div>

									<div class="form-actions">
                                        <button type="submit" id="submitForm" class="btn purple">提交</button>
                                        <button type="reset" class="btn" >取消</button>
									</div>

								</form>
                                </div>
							</div>	
                    </div>
                    </div>
                    <!--修改密码结束-->
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
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/form-validation.js"></script>
<script>

</script>
<!-- END FOOTER -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
	jQuery(document).ready(function() {       
	   App.init();
	   UITree.init();   
       FormValidation.modify_passwd(); 
	});
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
