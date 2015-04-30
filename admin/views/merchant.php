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

							<li><a href="javascript:void(0);">商户查询</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--用户管理开始-->
                    <div id="user_manage">
                    	<p>用户查询</p>	
                        <div class="refer clearfix">
                        	<input class="span6 m-wrap" name="" id="key"  type="text">
                            <span style="width:100px; background-image: none;" >
                            	<!--用户选择内容-->
                                <select name="type" id="classify" style="width:100%;height:100%;border:0px;">
                                    <option  value="username"  selected="true">用户账户</option>
                                    <option  value="phone">手机号码</option>
                                    <option  value="nickname">昵称</option>
                                </select>                               
                             </span>
                            
                            <a class="btn green" onclick="queryuser()" href="javascript:void(0);">查询</a>
                        </div>
                        <p>用户筛选</p>
                        <div class="filtrate">
                        	<span>地址：</span><input class="span6 m-wrap" id="address" name="" type="text">
                            <span>时间：</span>
                                <!--input class="span6 m-wrap" name="" type="text"-->
                                <input type="text" value="" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <span>至</span>
                            <!--input class="span6 m-wrap" name="" type="text"-->
                            <input type="text" value="" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <a class="btn green" onclick="filteruser()" href="javascript:void(0);">查询</a>
                        </div>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="merchat" />
                	<div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td>账号</td>
                                    <td>商户名称</td>
                                    <td>用户类型</td>
                                    <td>手机</td>
                                    <td>商户地址</td>
                                    <td>注册时间</td>
                                    <td>操作</td>
                                </tr>
                                <?php if($merchant_list){?>
                                <?php foreach($merchant_list as $key=>$list){?>
                                <tr style="text-align: center;">
                                	<td><?php echo $list['username'];?></td>
                                    <td><?php echo $list['nickname'];?></td>
                                    <td>
                                        <?php if($list['type']=='shop'){?>
                                            认证商铺
                                        <?php }else{?>
                                            普通用户
                                        <?php }?>
                                    </td>
                                    <td><?php echo $list['phone'];?></td>
                                    <td><?php echo $list['address'];?></td>
                                    <td><?php echo date('Y-m-d',strtotime($list['created']));?></td>
                                    <td>
                                        <a class="btn green" onclick="manage(this)"  data='<?php echo json_encode($list);?>' href="javascript:void(0);">管理</a>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php }else{?>
                                <tr><td colspan="7">没有符合要求的商家！</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="merchant_list_page('skip')" href="javascript:void(0);">GO</a></div>
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
   //认证商铺
   $(".auth").live('click',function(){
        cancel();
        var data = $(this).attr('order-data');
        var obj = eval('(' + data + ')');
        var content ='<div class="add_account add_approve">'+
                        '<input type="hidden" value=\''+data+'\' id="udata" />'+
                    	'<div class="row">'+
                        	'<span>商户名称：</span><input id="shop_name" class="span6 m-wrap" name="name" value="" type="text">'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>商户介绍：</span><textarea id="shop_des" class="span6 m-wrap" name="description" cols="" rows=""></textarea>'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>商户地址：</span><input id="shopaddress" class="span6 m-wrap" value="" name="address" type="text">'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>联系电话：</span><input id="shopphone" class="span6 m-wrap" value="" name="phone" type="text">'+
                        '</div>'+
                    '</div>';
       html_pop(content,'auth');
   });
   //修改认证店铺信息
   $(".updateauth").live('click',function(){
        cancel();
        var data = $(this).attr('order-data');
        var obj = eval('(' + data + ')');
        var content ='<div class="add_account add_approve">'+
                        '<input type="hidden" value=\''+data+'\' id="udata" />'+
                    	'<div class="row">'+
                        	'<span>商户名称：</span><input id="shop_name" class="span6 m-wrap" name="name" value="'+obj.nickname+'" type="text">'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>商户介绍：</span><textarea id="shop_des" class="span6 m-wrap" name="description" cols="" rows="">'+obj.description+'</textarea>'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>商户地址：</span><input id="shopaddress" class="span6 m-wrap" value="'+obj.address+'" name="address" type="text">'+
                        '</div>'+
                        '<div class="row">'+
                        	'<span>联系电话：</span><input id="shopphone" class="span6 m-wrap" value="'+obj.phone+'" name="phone" type="text">'+
                        '</div>'+
                    '</div>';
       html_pop(content,'updateauth');
   });
});

//认证商铺
function auth(){
    var udata = $("#udata").val();
    var name = $("#shop_name").val();
    var description = $("#shop_des").val();
    var address = $("#shopaddress").val();
    var phone = $("#shopphone").val();
    if(name!=''&&description!=''&&address!=''&&phone!=''){
        waiting();
        $.post('<?php echo $url_prefix;?>merchant/auth', {
                'data':udata,'name':name,'description':description,'address':address,'phone':phone
        }, function(data){
            cancel();
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }, 'json');
    }else{
        alert('请填写完整的认证信息！');
        return false;
    }
}
//修改认证店铺信息

function updateauth(){
    var udata = $("#udata").val();
    var name = $("#shop_name").val();
    var description = $("#shop_des").val();
    var address = $("#shopaddress").val();
    var phone = $("#shopphone").val();
    if(name!=''&&description!=''&&address!=''&&phone!=''){
        waiting();
        $.post('<?php echo $url_prefix;?>merchant/updateauth', {
                'data':udata,'name':name,'description':description,'address':address,'phone':phone
        }, function(data){
            cancel();
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }, 'json');
    }else{
        alert('请填写完整的认证信息！');
        return false;
    }
}



function userhandle(_obj){
    waiting();
    var uid = $(_obj).attr('uid');
    var status = $(_obj).attr('status');
    $.post('<?php echo $url_prefix;?>merchant/upuser', {
            'status':status,'uid':uid
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
function queryuser(){
    var key = $("#key").val();
    if(key==''){
        alert("请输入查询内容！");
        return false;
    }
    var type = $("#classify").val();
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>merchant/queryuser', {
            'key':key,'type':type
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}


function filteruser(){
    var address = $("#address").val();
    var begin = $("#valid_begin").val();
    var end = $("#valid_end").val();
    if(address=='' && begin==''&& end==''){
        alert('请输入查询条件！');
        return false;
    }
    $("#typ").val('filter');
    $.post('<?php echo $url_prefix;?>merchant/filteruser', {
            'begin':begin,'end':end,'address':address
    }, function(data){
        $('.event_list').html(data);
    }, 'text'); 
}


//商品列表分页
function merchant_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>merchant/list_merchant', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}


function manage(_obj){
    var data = $(_obj).attr('data');
    var obj = eval('(' + data + ')');
    var currStatu = '普通用户';
    var shopStatu = '启用状态'
    var sstr = '<a class="btn yellow" style="width:100px;height:10px;line-height:10px;margin-left:20px;" uid="'+obj.uid+'" status="0" onclick="userhandle(this)" href="javascript:void(0);">禁用</a>';
    var fstr ='<a class="btn yellow auth" style="width:100px;height:10px;line-height:10px;margin-left:20px;" order-data=\''+data+'\'  href="javascript:void(0);">认证</a>'; 
    if(obj.type=='shop' && obj.sid!=''){
        currStatu = '认证商铺';
        fstr ='<a class="btn yellow updateauth" style="width:100px;height:10px;line-height:10px;margin-left:20px;display:block;float:left;" order-data=\''+data+'\'  href="javascript:void(0);">修改</a>'+
              '<a class="btn yellow" onclick="cancelauth(this)" uid="'+obj.uid+'" sid="'+obj.sid+'" style="width:100px;height:10px;line-height:10px;margin-left:20px;display:block;float:left;" order-data=\''+data+'\'  href="javascript:void(0);">取消认证</a>';
        
    }
    if(obj.status==0){
        shopStatu = '禁用状态'
        sstr= '<a class="btn yellow" style="width:100px;height:10px;line-height:10px;margin-left:20px;" uid="'+obj.uid+'" status="1" onclick="userhandle(this)" href="javascript:void(0);">启用</a>';
    }
    var html = '<div class="mana" style="height:250px;width:400px;">'+
                    '<div class="title" style="float:left;width:100%;height:20px;font-weight:bold;line-height:20px;color:1262A2;">商户管理操作</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第一：商铺认证</div>'+
                    '<div style="float:left;width:100%;height:20px;line-height:20px;padding-left:20px;">商铺状态：<span style="color:red;font-weight:bold;">'+currStatu+'</span></div>'+
                    '<div style="float:left;;margin-top:10px;" >'+fstr+'</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第二：商铺用户管理</div>'+
                    '<div style="float:left;width:100%;height:20px;line-height:20px;padding-left:20px;">用户状态：<span style="color:red;font-weight:bold;">'+shopStatu+'</span></div>'+
                    '<div style="float:left;margin-top:10px;" >'+sstr+'</div>'+
               '</div>';
    html_pop(html,'cancel');
}

function cancelauth(_obj){
    waiting();
    var uid = $(_obj).attr('uid');
    var sid = $(_obj).attr('sid');
    $.post('<?php echo $url_prefix;?>merchant/cancelauth', {
            'sid':sid,'uid':uid
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
</script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
