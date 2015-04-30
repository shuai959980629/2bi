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
                    <div class="account">
                        <div class="fl">
                        	<input class="span6 m-wrap" style="width:300px;" name="theme"  id="key" placeholder="请输入专题名称" type="text"/><a class="btn green" onclick="queryTheme()" style="margin-left:10px;width:100px;" href="javascript:void(0);">查询</a>
                        </div>
                        <a class="btn yellow fr" href="<?php echo $url_prefix;?>theme/add" style="margin-bottom:15px;">新增专题活动》》</a>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                    <div class="apecial_list user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                    <td style="width: 3%;">排序</td>
                                    <td>专题名称</td>
                                    <td>专题规则</td>
                                    <td>图片logo</td>
                                    <td>有效时间</td>
                                    <td>专题状态</td>
                                    <td style="width: 4%;">允许商户参加</td>
                                    <td style="width: 4%;">类型</td>
                                    <td>地址</td>
                                    <td style="width: 12%;">操作</td>
                                </tr>
                                <?php if($theme_list){?>
                                <?php foreach($theme_list as $key=>$list){?>
                                <tr style="text-align: center;">
                                    <td style="width: 3%;"><?php echo $list['orders'];?></td>
                                	<td><?php echo $list['name'];?></td>
                                    <td><?php echo $list['rule'];?></td>
                                    <td class="pic"><img src="<?php echo $list['logo'];?>"/></td>
                                    <td>
                                      <?php 
                                        if(date('Y',strtotime($list['valid_begin']))==date('Y',strtotime($list['valid_end']))){
                                           echo date('Y/m/d',strtotime($list['valid_begin']));?>-<?php echo date('m/d',strtotime($list['valid_end'])); 
                                        }else{
                                            echo date('Y/m/d',strtotime($list['valid_begin']));?>-<?php echo date('Y/m/d',strtotime($list['valid_end']));
                                        }
                                      ?>
                                    </td>
                                    <td>
                                        <?php if(date('Y-m-d',time())<= date('Y-m-d',strtotime($list['valid_end']))){?>
                                            <?php if($list['status']==0){?>
                                                   <span style="color: red;font-weight:bold;">已经关闭</span>
                                            <?php }elseif($list['status']==1){?>
                                                   <span style="color:black;font-weight:bold;">开启中..</span>
                                            <?php }?>
                                        <?php }else{?>
                                            <span style="color: red;font-weight:bold;">活动已经过期</span>
                                        <?php }?>
                                    </td>
                                    <td style="width:4%;"><?php if(!empty($list['join'])){ echo '是';}else{ echo '否';}?></td>
                                    <td style="width: 4%;">
                                        <?php if($list['type']=='normal'){?>
                                            常规
                                        <?php }elseif($list['type']=='web'){?>
                                            网页连接
                                        <?php }?>
                                    </td>
                                    <td><?php echo $list['address'];?></td>
                                    <td style="width: 12%;">
                                        <?php if(intval($user['id_profile'])===1 || $user['role']=='admin' ){?>
                                            <a class="btn green" onclick="manage(this)" <?php if(date('Y-m-d',time())<= date('Y-m-d',strtotime($list['valid_end']))){ echo 'valid="true"';}else{echo'valid="false"'; }?>   data='<?php echo json_encode($list);?>' href="javascript:void(0);">管理</a>
                                        <?php }else{?>
                                                <?php if(date('Y-m-d',time())<= date('Y-m-d',strtotime($list['valid_end']))){?>
                                                    <?php if($list['status']==0){?>
                                                        <a class="btn grey" data="<?php echo $list['tid'];?>" type="open" onclick="manageThem(this)" href="javascript:void(0);">开启</a>
                                                    <?php }elseif($list['status']==1){?>
                                                        <a class="btn grey" data="<?php echo $list['tid'];?>" type="close" onclick="manageThem(this)" href="javascript:void(0);">关闭</a>
                                                    <?php }?>
                                                    <?php if($list['type']=='normal'){?>
                                                        <a target="_blank" class="btn yellow" href="<?php echo $url_prefix;?>theme/thcowry?tid=<?php echo $list['tid'];?>">宝贝管理</a>
                                                    <?php }?>
                                                <?php }?>
                                                <a class="btn green" href="<?php echo $url_prefix;?>theme/add?type=edit&tid=<?php echo $list['tid'];?>">修改</a>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php }else{?>
                                <tr style="text-align: center;"><td colspan="10">暂无专题活动。。。</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                         <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="theme_list_page('skip')" href="javascript:void(0);">GO</a></div>
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
   $(".cancel").live('click',function(){
    	$("#show_div").remove();
    	$("#pop_up").remove();
    });
});
/*专题活动列表分页*/
function theme_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>theme/theme_list', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
/*专题查找*/
function queryTheme(){
  var key = $("#key").val();
    if(key==''){
        alert("请输入专题名称！");
        return false;
    }
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>theme/query_theme', {
            'name':key
    }, function(data){
        $('.event_list').html(data);
    }, 'text');  
}
function manageThem(_obj){
    waiting();
    var tid = $(_obj).attr('data');
    var type = $(_obj).attr('type');
    $.post('<?php echo $url_prefix;?>theme/manage', {
            'data':tid,'type':type
    }, function(data){
        if(data.status){
            alert(data.msg);
            window.location.reload();
        }else{
            alert(data.msg);
        }
    }, 'json');
}

<?php if(intval($user['id_profile'])===1 || $user['role']=='admin'){?>
function manage(_obj){
    var fstr = '<a class="btn red"  href="javascript:void(0);">活动已经过期</a>';
    var data = $(_obj).attr('data');
    var valid = $(_obj).attr('valid');
    var obj = eval('(' + data + ')');
    if(valid=='true'){
        fstr = '<a class="btn grey"  data="'+obj.tid+'" type="open" onclick="manageThem(this)" href="javascript:void(0);">开启</a>';
        if(obj.status==1){
            fstr = '<a class="btn grey"  data="'+obj.tid+'" type="close" onclick="manageThem(this)" href="javascript:void(0);">关闭</a>';
        }
       if(obj.type=='normal'){
            fstr +='<a target="_blank" class="btn yellow" href="<?php echo $url_prefix;?>theme/thcowry?tid='+obj.tid+'">宝贝管理</a>'; 
       } 
    }
    var html = '<div style="height:100px;">'+
                    '<div class="title" style="float:left;width:100%;height:20px;font-weight:bold;line-height:20px;color:1262A2;">专题活动操作</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第一步</div>'+
                    '<div style="float:left;width:350px;" >&nbsp;&nbsp;&nbsp;&nbsp;'+fstr+
                        '<a class="btn green"  href="<?php echo $url_prefix;?>theme/add?type=edit&tid='+obj.tid+'">修改</a>'+
                        '<a class="btn red"  data="'+obj.tid+'" type="del" onclick="manageThem(this)" href="javascript:void(0);">删除</a>'+
                    '</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第二步</div>'+
                    '<div style="float:left;width:100%;font-weight:bold;height:30px;line-height:30px;padding-left:10px;">&nbsp;&nbsp;&nbsp;&nbsp;未完待续.....</div>'+
               '</div>';
    html_pop(html,'cancel');
}
<?php }?>
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>