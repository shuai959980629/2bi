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

							<li><a href="javascript:void(0);">功能管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--权限管理开始-->
                    <?php if(intval($user['id_profile'])===1){?>
                    <div class="account">
                        <a class="btn yellow fr"  href="<?php echo $url_prefix?>right/add" style="margin-bottom:15px;">新增后台管理员功能</a>
                    </div>
                    <?php }?>
                	<div class="user_manage clearfix portlet box grey" style="height: 500px;" >
                        <div style="color:white;font-weight:bold;height:30px;line-height:30px;float:left;width:100%;background: #852B99;">第一，顶级分类导航</div>
                        <div style="font-size:14px;height:80px;line-height:80px;float:left;width:100%;padding-left:10px;">
                            <?php if($parent){?>
                                 <?php foreach($parent as $key =>$data){?>
                                    <a href="javascript:void(0);" style="cursor: pointer;color:#766F6F;" data="<?php echo $data['id_right'];?>" ><?php echo $data['name'];?></a>
                                 <?php  }?>
                             <?php }else{?>
                                <a href="javascript:void(0);" style="cursor: pointer;color:#766F6F;">暂无顶级父类</a>
                             <?php }?>
                        </div>
                        <div style="color:white;font-weight:bold;height:30px;line-height:30px;float:left;width:100%;background: #852B99;">第二，子类功能导航</div>
                        <div>
                            <?php if($child){?>
                                 <?php foreach($parent as $key =>$data){?>
                                    <div  style="height:30px;line-height:30px;margin-top:5px;width:100%;float:left;font-size:12px;font-weight:bold;" data="<?php echo $data['id_right'];?>" >
                                        <div style="color:green;float: left;">&nbsp;&nbsp;<?php echo $data['name']."：";?></div>
                                        <div style="float: left;">
                                        <?php foreach($child as $item =>$value){?>
                                            <?php if($value['id_parent']==$data['id_right']){?>
                                            <a href="javascript:void(0);" style="cursor: pointer;color:#766F6F;margin-left:10px;" data="<?php echo $value['id_right'];?>" ><?php echo $value['name'];?></a>
                                            <?php }?>
                                        <?php  }?>
                                        </div>
                                    </div>
                                 <?php  }?>
                             <?php }else{?>
                                <a href="javascript:void(0);" style="cursor: pointer;color:yellowgreen;">暂无顶级父类</a>
                             <?php }?>
                        
                        </div>
                    </div>
                    <!--权限管理结束-->
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
