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
                           订单管理<small>Order Management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="javascript:void(0);">订单管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">订单处理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--订单管理开始-->
                    <div id="order_management" class="clearfix">
                        <div class="clearfix"><b class="NO">线&nbsp;&nbsp;&nbsp;下：</b>
                            <a class="btn yellow" style="font-weight:bold;" onclick="offline_order()" href="javascript:void(0);">线下交易订单查询</a>
                        </div>
                        
              	        <div class="clearfix" style="margin-top: 10px;"><b class="NO">订单号：</b>
                          <input class="span6 m-wrap" name="" id="out_trade_no" type="text"/>
                          <a class="btn green" onclick="query()" href="javascript:void(0);">查&nbsp;询</a>
                       </div>
                        <div class="clearfix"><b class="NO">时&nbsp;&nbsp;&nbsp;间：</b>
                            <input type="text" value="" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>至：</b>
                            <input type="text" value="" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>支付方式：</b>
                            <span style="width:200px; background-image: none;" >
                                <select name="type" id="payment" style="width:100%;height:100%;border:0px;">
                                    <option  value="online" selected="true" >线上交易</option>
                                    <option  value="offline">线下交易</option>
                                </select>  
                            </span>
                            <b>订单状态：</b>
                            <span style="width:200px; background-image: none;" >
                            	<!--用户选择内容 1:虚拟订单, 2:已付款(线下支付订单待确认),3:投诉中,4:投诉完成（仲裁完成）5:已收货(订单完成,线下支付订单已确认),6:取消-->
                                <select name="type" id="status" style="width:100%;height:100%;border:0px;">
                                    <option  value="-1" selected="true" >全部</option>
                                    <option  value="2">已付款</option>
                                    <option  value="3">投诉处理</option>
                                    <option  value="4">仲裁完成</option>
                                    <option  value="5">订单完成</option>
                                    <option  value="6">取消订单</option>
                                </select>                               
                             </span>
                             <a class="btn green" onclick="filter()" href="javascript:void(0);">查&nbsp;询</a>
                        </div>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                	<div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td>订单号</td>
                                    <td>流水号</td>
                                    <td>卖家名称</td>
                                    <td>买家名称</td>
                                    <td>注订单状态</td>
                                    <td>支付方式</td>
                                    <td>处理结果</td>
                                    <td>备注</td>
                                    <td>操作</td>
                                </tr>
                                
                                 <?php if($order_list){?>
                                    <?php foreach($order_list as $key=>$list){?>
                                    <tr style="text-align: center;">
                                    	<td><?php echo $list['order_no'];?></td>
                                        <td><?php echo $list['trade_no'];?></td>
                                        <td><?php echo $list['vendor_nickname'];?></td>
                                        <td><?php echo $list['buyer_nickname'];?></td>
                                        <td>
                                            <?php
                                                if($list['status']==2){
                                                    if($list['payment']=='online'){
                                                        echo '已付款';
                                                    }elseif($list['payment']=='offline'){
                                                        echo '待确认订单';
                                                    }
                                                }elseif($list['status']==3){
                                                    echo '投诉处理';
                                                }elseif($list['status']==4){
                                                    echo '仲裁完成';
                                                }elseif($list['status']==5){
                                                    if($list['payment']=='online'){
                                                        echo '订单完成';
                                                    }elseif($list['payment']=='offline'){
                                                        echo '已确认订单';
                                                    }
                                                }elseif($list['status']==6){
                                                    if($list['payment']=='online'){
                                                        echo '取消订单';
                                                    }elseif($list['payment']=='offline'){
                                                        echo '取消订单';
                                                    }
                                                }
                                            ?>                                            
                                        </td>
                                        <td>
                                            <?php
                                                if($list['payment']=='online'){
                                                    echo '线上支付';
                                                }elseif($list['payment']=='offline'){
                                                    echo '线下支付';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($list['payment']=='online'){
                                                    if($list['cpt_result']==1){
                                                        echo '付款给卖家';
                                                    }elseif($list['cpt_result']==2){
                                                        echo '付款给买家';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?php if($list['payment']=='online'){ echo $list['cpt_comment'];} ?></td>
                                        <td>
                                            <?php
                                            if($list['payment']=='online'){
                                                if($list['status']==2){
                                            ?>
                                                 <a class="btn red complaint" order-data='<?php echo json_encode($list);?>' href="javascript:void(0);">投诉受理</a>
                                            <?php
                                                }elseif($list['status']==3 && empty($list['cpt_result'])){
                                            ?>
                                                 <a class="btn green arbitration" order-data='<?php echo json_encode($list);?>' href="javascript:void(0);">仲裁</a>
                                            <?php       
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }else{?>
                                        <tr style="text-align: center;"><td colspan="8">暂无订单信息！</td></tr>
                                    <?php }?>
                            </tbody>
                        </table>
                        <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="order_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
                    </div>
                    <!--订单管理结束-->                  
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
   //投诉处理
   $(".complaint").live('click',function(){
        var data = $(this).attr('order-data');
        var content = '<div class="arbitrament">'+
                        '<input type="hidden" value=\''+data+'\' id="odata" />'+
                    	'<div class="row">'+
                            '<textarea class="span6 m-wrap" name="cpt_comment" id="cpt_comment" cols="" rows=""></textarea>'+
                            '<span class="fl">投诉原因：</span>'+
                        '</div>'+
                    '</div>';
        html_pop(content,'complaint');
   });
   //仲裁
   $(".arbitration").live('click',function(){
        var data = $(this).attr('order-data');
        var obj = eval('(' + data + ')');
        var content ='<div class="arbitrament">'+
                        '<input type="hidden" value=\''+data+'\' id="odata" />'+
                    	'<div class="row">'+obj.total_price+'元<span class="fl">金额：</span></div>'+
                        '<div class="row">'+
                            '<input name="merchant" type="radio" value="2"/><b>买家</b>'+
                            '<input name="merchant" type="radio" value="1"/><b>卖家</b>'+
                            '<span class="fl">退还给：</span>'+
                        '</div>'+
                        '<div class="row">'+
                            '<textarea class="span6 m-wrap" name="comment" id="comment"  cols="" rows="">'+obj.cpt_comment+'</textarea>'+
                            '<span class="fl">备注：</span>'+
                        '</div>'+
                    '</div>';
       html_pop(content,'arbitration');
   });
   
});
//仲裁
function arbitration(){
    var odata = $("#odata").val();
    var comment = $("#comment").val();
    var obj = eval('(' + odata + ')');
    obj.cpt_comment =comment;//备注
    var radio = $('input[name="merchant"]').filter(':checked');
    if(!radio.length){
        alert("请选择退还的商户！");
        return false;
    }
    waiting();
    obj.cpt_result = radio.val();
    $.post('<?php echo $url_prefix;?>order/arbitration', {
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
//投诉处理
function complaint(){
    var odata = $("#odata").val();
    var cpt_comment = $("#cpt_comment").val();
    if(cpt_comment.length==0){
        alert("投诉原因不能为空！");
        return false;
    }
    waiting();
    var obj = eval('(' + odata + ')');
    obj.cpt_comment =cpt_comment;
    $.post('<?php echo $url_prefix;?>order/complaint', {
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

//订单列表分页
function order_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>order/order_list', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}

//根据订单编号查询
function query(){
    var out_trade_no = $("#out_trade_no").val();
    var reg = /^\d{13}$/;
    if(!reg.test(out_trade_no)){
        alert("请输入正确的订单号！");
        return false;
    }
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>order/query', {
            'out_trade_no':out_trade_no
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
function filter(){
    var status = $("#status").val();
    var begin = $("#valid_begin").val();
    var end = $("#valid_end").val();
    var payment = $("#payment").val();
    $("#typ").val('filter');
    $.post('<?php echo $url_prefix;?>order/filter', {
            'begin':begin,'end':end,'status':status,'payment':payment
    }, function(data){
        $('.event_list').html(data);
    }, 'text'); 
}
/*线下交易订单*/
function offline_order(){
    $("#typ").val('offline');
    $.post('<?php echo $url_prefix;?>order/offline_order', {
            'payment':'offline'
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
