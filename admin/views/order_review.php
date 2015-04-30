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

							<li><a href="javascript:void(0);">订单审核</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--订单审核开始-->
                    <div id="order_review" class="clearfix">
                    	<div class="clearfix"><b class="NO">订单号：</b>
                          <input class="span6 m-wrap" name="" id="out_trade_no" type="text"/>
                          <a class="btn green" onclick="query()" href="javascript:void(0);">查&nbsp;询</a>
                       </div>
                        <div class="clearfix"><b class="NO">时&nbsp;&nbsp;&nbsp;间：</b>
                            <input type="text" value="" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>至：</b>
                            <input type="text" value="" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>订单状态：</b>
                            <span style="width:200px; background-image: none;" >
                            	<!--用户选择内容-->
                                <select name="type" id="status" style="width:100%;height:100%;border:0px;">
                                    <option  value="-1" selected="true" >全部</option>
                                    <option  value="0">未审核</option>
                                    <option  value="1">已审核</option>
                                </select>                               
                             </span>
                             <a class="btn green" onclick="filter()" href="javascript:void(0);">查&nbsp;询</a>
                        </div>
                   	</div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                	<div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;"><td>订单号</td><td>订单金额</td><td>收款角色</td><td>收款昵称</td><td>处理结果</td><td>处理人员</td><td>操作</td></tr>
                                <?php if($review_list){?>
                                    <?php foreach($review_list as $key=>$list){?>
                                    <tr style="text-align: center;">
                                    	<td><?php echo $list['out_trade_no'];?></td>
                                        <td><?php echo $list['sum'];?></td>
                                        <td><?php echo $list['role'];?></td>
                                        <td><?php echo $list['nickname'];?></td>
                                        <td>
                                            <?php 
                                                if($list['result']==1){
                                                    echo '付款给卖家';
                                                }elseif($list['result']==2){
                                                    echo '付款给买家';
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $list['operator']; ?></td>
                                        <td>
                                            <?php
                                                if($list['status']==0){
                                            ?>
                                                 <a class="btn grey arbitration" order-data='<?php echo json_encode($list);?>' href="javascript:void(0);">修改</a>
                                                 <a class="btn green approve" order-data='<?php echo json_encode($list);?>' href="javascript:void(0);">审核通过</a>
                                            <?php
                                                }
                                            ?>
                                         </td>
                                    </tr>
                                    <?php }?>
                                    <?php }else{?>
                                        <tr style="text-align: center;"><td colspan="7">暂无订单信息！</td></tr>
                                    <?php }?>
                            </tbody>
                        </table>
                        <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="review_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
                    </div>
                    <!--订单审核结束-->
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
   //修改仲裁
   $(".arbitration").live('click',function(){
        var data = $(this).attr('order-data');
        var obj = eval('(' + data + ')');
        var check1 = check2 ='';
        if(obj.result==1){
             check1 = 'checked="true"';
        }
        if(obj.result==2){
             check2 = 'checked="true"';
        }
        var content ='<div class="arbitrament">'+
                        '<input type="hidden" value=\''+data+'\' id="odata" />'+
                    	'<div class="row">'+obj.sum+'元<span class="fl">金额：</span></div>'+
                        '<div class="row">'+
                            '<input name="merchant" type="radio" '+check2+'  value="2"/><b>买家</b>'+
                            '<input name="merchant" type="radio" '+check1+' value="1"/><b>卖家</b>'+
                            '<span class="fl">退还给：</span>'+
                        '</div>'+
                        '<div class="row">'+
                            '<textarea class="span6 m-wrap" name="comment" id="comment"  cols="" rows="">'+obj.comment+'</textarea>'+
                            '<span class="fl">备注：</span>'+
                        '</div>'+
                    '</div>';
       html_pop(content,'arbitration');
   });
   //审核通过
   $(".approve").live('click',function(){
        var data = $(this).attr('order-data');
        waiting();
        $.post('<?php echo $url_prefix;?>order/approve', {
                'data':data
        }, function(data){
            cancel();
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }, 'json'); 
   });
   
});
//修改仲裁
function arbitration(){
    var odata = $("#odata").val();
    var comment = $("#comment").val();
    var obj = eval('(' + odata + ')');
    obj.comment =comment;//备注
    var radio = $('input[name="merchant"]').filter(':checked');
    if(!radio.length){
        alert("请选择退还的商户！");
        return false;
    }
    waiting();
    obj.result = radio.val();
    $.post('<?php echo $url_prefix;?>order/modify_arbitration', {
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
//审核订单列表分页
function review_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>order/review_list', {
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
    $("#typ").val('review_query');
    $.post('<?php echo $url_prefix;?>order/review_query', {
            'out_trade_no':out_trade_no
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
//订单筛选查询
function filter(){
    var status = $("#status").val();
    var begin = $("#valid_begin").val();
    var end = $("#valid_end").val();
    $("#typ").val('review_filter');
    $.post('<?php echo $url_prefix;?>order/review_filter', {
            'begin':begin,'end':end,'status':status
    }, function(data){
        $('.event_list').html(data);
    }, 'text'); 
}
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
