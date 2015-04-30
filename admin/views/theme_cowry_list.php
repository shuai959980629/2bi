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
                            专题管理<small>Theme Management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="javascript:void(0);">专题管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">专题列表</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--专题列表开始-->
                    <div class="account" style="height:50px;">
                        <div style="width: 100%;height:50%;float:left;" >
                                <div style="width:250px;float:left;">
                                    <select name="type" id="status" style="width:100%;height:34px;">
                                        <option  value="0"  selected="true">未审核</option>
                                        <option  value="1">已通过</option>
                                        <option  value="2">已拒绝</option>
                                    </select>
                                </div>
                                <div style="width:400px;float:left;">
                                    <a class="btn green" onclick="query_theme_cowry()" href="javascript:void(0);">查&nbsp;&nbsp; 询</a>
                                </div>
								<div style="width:400px;float:right;">
									<a class="btn yellow fr" href="<?php echo $url_prefix;?>commodity?tid=<?php echo $id_theme;?>" style="margin-bottom:15px;">新增专题宝贝》》</a>
								</div>
                        </div>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                    <div class="apecial_list user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                    <td>宝贝名称</td>
                                    <td>宝贝图片</td>
                                    <td>申请时间</td>
                                    <td>申请商家</td>
                                    <td>专题名称</td>
                                    <td>状态</td>
                                    <td>操作</td>
                                </tr>
                                <?php if($theme_cowry_list){?>
                                    <?php foreach($theme_cowry_list as $key=>$list){?>
                                        <tr style="text-align: center;">
                                            <td><?php echo truncate_utf8($list['description'],10);?></td>
                                            <td class="pic"><img style="width:120px;height:120px;" width="120" height="120" src="<?php echo get_img_url($list['img'],'cowry');?>" /></td>
                                            <td><?php echo strtotime($list['created'])?$list['created']:''; ?></td>
                                            <td><?php echo $list['username']; ?></td>
                                            <td><?php echo $list['name']; ?></td>
                                            <td>
												<?php
													if($list['status']){ 
														if($list['status']==1){
															echo '已通过';
														}elseif($list['status']==2){
															echo '已拒绝';
														}
													}else{ 
														echo '未审核'; 
													} 
												?>
											</td>
                                            <td>
                                                <a class="btn yellow" target="_blank" href="<?php echo $url_prefix?>commodity/cowry?cid=<?php echo $list['cid'];?>&uid=<?php echo $list['uid'];?>">查看</a>
												<?php if($list['status']){?>
													<?php if($list['status']==1){?>
														<a class="btn gray decline" data="<?php echo $list['tcid'];?>"  href="javascript:void(0);">拒绝</a>
													<?php }elseif($list['status']==2){?>
														<a class="btn green permit" data="<?php echo $list['tcid'];?>"  href="javascript:void(0);">通过</a>
													<?php }?>
												<?php }else{?>
													<a class="btn green permit" data="<?php echo $list['tcid'];?>"  href="javascript:void(0);">通过</a>
													<a class="btn gray decline" data="<?php echo $list['tcid'];?>"  href="javascript:void(0);">拒绝</a>
												<?php }?>
                                            </td>
                                        </tr>
                                    <?php }?>
                                <?php }else{?>
                                <tr style="text-align: center;"><td colspan="7">暂无专题宝贝。。。</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                         <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="theme_cowry_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
                    </div>
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
   initFunction();
   $(".cancel").live('click',function(){
    	$("#show_div").remove();
    	$("#pop_up").remove();
    });
});
function initFunction(){
    //拒绝
    $(".decline").live('click',function(){
        waiting();
        var tcid = $(this).attr('data');
        $.post('<?php echo $url_prefix;?>theme/decline', {
                'tcid':tcid
        }, function(data){
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
				alert(data.msg);
				cancel();
            }
        }, 'json');
    });  
	//审核通过
	$(".permit").live('click',function(){
        waiting();
        var tcid = $(this).attr('data');
        $.post('<?php echo $url_prefix;?>theme/permit', {
                'tcid':tcid
        }, function(data){
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
				alert(data.msg);
				cancel();
            }
        }, 'json');
    });
}

/*专题活动列表分页*/
function theme_cowry_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>theme/theme_cowry_list', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
/*专题宝贝查询*/
function query_theme_cowry(){
	var status = $("#status").val();
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>theme/query_theme_cowry', {
            'status':status,'id_theme':<?php echo $id_theme;?>
    }, function(data){
        $('.event_list').html(data);
    }, 'text');  
}
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>