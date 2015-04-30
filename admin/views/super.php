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

							<li><a href="javascript:void(0);">首页</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--用户管理开始-->
                    <div id="user_manage">
                    	数据库管理。
                    </div>
                    <input type="hidden" id="typ" name="typ" value="super" />
                	<div class="user_manage clearfix portlet box grey event_list" style="border: 1px solid #ddd; width:100%;height:300px;line-height:300px;color:blue;text-align:center;font-weight: bold;">
                    	超级管理员操作，或开发人员操作的界面！welcome
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
})
</script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
