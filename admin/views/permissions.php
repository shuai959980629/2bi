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
                           商户管理<small>Merchant management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="<?php echo $url_prefix?>merchant">商户管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">商户权限</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--用户管理开始-->
                    <div id="user_manage">
                   	    商户权限管理
                    </div>
                	<div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td>编号</td>
                                    <td>商户类型</td>
                                    <td>上架宝贝限制</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>操作</td>
                                </tr>
                                <?php if($permissions_list){?>
                                <?php foreach($permissions_list as $key=>$list){?>
                                <tr style="text-align: center;">
                                    <td><?php echo 'LS-',$list['rid'];?></td>
                                	<td>
                                        <?php 
                                            if($list['role']=='shop'){
                                                echo '认证商铺';
                                            }elseif($list['role']=='normal'){
                                                echo '普通商铺';
                                            }
                                        
                                        ?>
                                    </td>
                                    <td style="padding-left:30px;"><?php echo $list['max'];?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                      <a class="btn green update" data='<?php echo json_encode($list);?>' href="javascript:void(0);">修改</a>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php }else{?>
                                <tr style="text-align: center;"><td colspan="7">暂无商户权限。。。</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="permissions_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
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
   $(".update").live('click',function(){
        var data = $(this).attr('data');
        var obj = eval('(' + data + ')');
        var role = '普通商铺';
        if(obj.role=='shop'){
            var role = '认证商铺';
        }
        var html = '<div class="mana" style="height:200px;width:400px;">'+
                    '<div class="title" style="float:left;width:100%;height:20px;font-weight:bold;line-height:20px;color:1262A2;">商户权限修改</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">用户类型：<span style="color:red;font-weight:bold;">'+role+'</span></div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">商户权限列表</div>'+
                    '<div style="float:left;width:100%;padding-left:20px;"><div style="float:left;">上架宝贝限制</div>'+
                        '<div style="float:left;margin-left:10px;"><input style="padding-left:20px;" type="text" value="'+obj.max+'" id="upmax" /></div>'+
                    '</div>'+
                    '<input type="hidden" value=\''+data+'\' id="rdata" />'+
               '</div>';
        html_pop(html,'update');
   })
   
   
});


function update(){
    var rdata = $("#rdata").val();
    var upmax = $("#upmax").val();
    if(upmax==0 || upmax==''){
        alert("请填写正确信息后。点击确认！");
        return false;
    }
    var obj = eval('(' + rdata + ')');
    obj.max = upmax;
    waiting();
    $.post('<?php echo $url_prefix;?>permissions/update', {
                    'data':JSON.stringify(obj)
    }, function(data){
        cancel();
        if(data.status){
            alert(data.msg);
            window.location.reload();
        }else{
            alert(data.msg);
        }
    }, 'json');
}

function permissions_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>permissions/list_permissions', {
            'offset':offset
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
</script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
