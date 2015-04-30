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
                           财务管理<small>Finance Management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="javascript:void(0);">财务管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">财务处理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--财物处理开始-->
                    <div id="property_processing" class="clearfix">
                         <div style="width: 100%;height:50%;float:left;" >
                                <div style="width: 100px;float:left;">
                                    <select name="type" id="classify" style="width:100px;height:34px;">
                                        <option  value="out_trade_no"  selected="true">订单号</option>
                                        <option  value="username">用户帐号</option>
                                        <option  value="nickname">用户昵称</option>
                                    </select>
                                </div>
                                <div style="width: 400px;float:left;">
                                    <input class="span6 m-wrap" name="key" style="height:15px;width:200px;" id="key"  type="text"/>
                                    <a class="btn green" onclick="query_finance()" href="javascript:void(0);">查询</a>
                                </div>
                                
                         </div>
                         <div style="width: 100%;height:50%;float:left;" style="border: 1px solid red;">
                            <b class="NO">时&nbsp;&nbsp;&nbsp;间：</b>
                            <input type="text" value="" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>至：</b>
                            <input type="text" value="" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>订单状态：</b>
                            <span style="width:200px; background-image: none;" >
                            	<!--用户选择内容-->
                                <select name="type" id="status" style="width:100%;height:100%;border:0px;">
                                    <option  value="-1">全部</option>
                                    <option  value="0"  selected="true">待结算</option>
                                    <option  value="1">支付宝处理中</option>
                                    <option  value="3">已结算</option>
                                    <option  value="2">结算失败</option>
                                </select>                               
                             </span>
                             <a class="btn green" onclick="filter_finance()" href="javascript:void(0);">查&nbsp;询</a>
                             <a class="btn yellow" onclick="todayFinance()" href="javascript:void(0);">今日用户结算</a>
                         </div>
                    </div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                    <div class="piliang clearfix portlet box" style="height:30px;line-height:30px;width:1450px;">
                        <a class="btn green" style="float: right;" onclick="batch_pay()" href="javascript:void(0);">批量结算</a>
                    </div>
                	<div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td style="text-align:left;">
                                       <label for="checkALL">
                                            <div class="checker" id="uniform-checkALL"><span><input name="checkALL" id="checkALL" title="全选/反选" type="checkbox" style=""></span></div>全选
                                        </label> 
                                    </td>
                                    <td>支付宝账号</td><td>支付宝姓名</td><td>订单号</td><td>订单交易时间</td>
                                    <td>交易金额</td>
                                    <td>流水号</td><td>用户名称</td><td>事由</td><td>状态</td><td>结算日期</td>
                                    <td>操作</td>
                                </tr>
                                
                                <?php if($finance_list){?>
                                    <?php foreach($finance_list as $key=>$list){?>
                                    <tr style="text-align: center;">
                                      <?php if(empty($list['alipay_account'])|| empty($list['alipay_name'])){?>
                                       <td colspan="3" style="text-align: center; color:orange;">
                                            未绑定支付宝帐号。无法结算！
                                        </td>
                                       <?php }else{?>
                                        <td class="check" style="text-align:left;">
                                            <?php if($list['status']==0 || $list['status']==2){?>
                                            <label>
                                                <div class="checker"><span><input name="finance[]"  type="checkbox" value='<?php echo json_encode($list);?>'/></span></div>
                                            </label> 
                                            <?php }else{?>
                                             &nbsp;
                                            <?php }?>
                                        </td>
                                    	<td><?php echo $list['alipay_account'];?></td>
                                        <td><?php echo $list['alipay_name'];?></td>
                                       <?php }?>
                                        <td><?php echo $list['order_no'];?></td>
                                        <?php if($list['odate']){?>     
                                        <td><?php echo date('Y-m-d',strtotime($list['odate']));?></td>
                                        <?php }else{?>
                                        <td>&nbsp;</td>
                                        <?php }?>
                                        <td><?php echo $list['sum'];?></td>
                                        <td><?php echo $list['trade_no'];?></td>
                                        <td><?php echo empty($list['username'])?$list['nickname']:$list['username'];?></td>
                                        <td>
                                            <?php 
                                                if($list['comment']==0){
                                                    echo '投诉仲裁处理';
                                                }elseif($list['comment']==1){
                                                    echo '正常交易';
                                                }elseif($list['comment']==2){
                                                    echo '取消订单';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if($list['status']==0){
                                                    echo '待结算';
                                                }elseif($list['status']==1){
                                                    echo '支付宝处理中';
                                                }elseif($list['status']==3){
                                                    echo '已结算';
                                                }elseif($list['status']==2){
                                                    echo '结算失败';
                                                }
                                            ?>
                                        </td>
                                        <?php if($list['sdate']){?>     
                                        <td><?php echo date('Y-m-d',strtotime($list['sdate'])); ?></td>
                                        <?php }else{?>
                                        <td>&nbsp;</td>
                                        <?php }?>
                                        <td>
                                            <?php if(intval($user['id_profile'])===1 || $user['role']=='admin' ){?>
                                                <a class="btn green" onclick="manage(this)"  data='<?php echo json_encode($list);?>' href="javascript:void(0);">管理</a>
                                            <?php }else{?>
                                                <?php if(( $list['status']==0 || $list['status']==2) && !empty($list['alipay_account']) && !empty($list['alipay_name'])){ ?>
                                                    <a class="btn green settle" pay-data='<?php echo json_encode($list);?>' href="javascript:void(0);">结算</a>
                                                <?php }else{?>
                                                    &nbsp;
                                                <?php }?>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <?php }else{?>
                                        <tr><td colspan="7">暂无结算订单信息！</td></tr>
                                    <?php }?>
                            </tbody>
                        </table>
                        <!--搜索开始-->
                        <?php if($page_html){?>
                        <div id="pagination" class="clearfix"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="finance_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
                    </div>
                    <!--财物处理结束-->
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

</script>
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
   //全选/反选
  $("#checkALL").on('click', function(){
    if($(this).attr('checked') != 'checked'){
        $(this).parent().removeClass('checked');
        $("input[name='finance[]']").attr("checked",false);
        $("input[name='finance[]']").parent().removeClass('checked');
    }else{
        $(this).parent().addClass('checked');
        $("input[name='finance[]']").each(function(i){
            $(this).attr("checked",true);
            $("input[name='finance[]']").parent().addClass('checked');
        });
    }
  });
  $("input[name='finance[]']").live("click",function(){
        if($(this).attr('checked')!='checked'){
            $(this).attr("checked",false);
            $(this).parent().removeClass('checked');
        }else{
            $(this).attr("checked",true);
            $(this).parent().addClass('checked');  
        }
  });
  //单笔结算
  $(".settle").live('click',function(){
        waiting();
        var finance = $(this).attr('pay-data');
        $.post('<?php echo $url_prefix;?>finance/settle', {
                'finance':finance
        }, function(data){
            if(data.status){
                $("body").append(data.data);
                //window.location.reload();
            }else{
                //alert(data.msg);
                //window.location.reload();
            }
        }, 'json');
  });  
  
  
   
});

/*结算订单列表分页*/
function finance_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>finance/finance_list', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}
function query_finance(){
    var key = $("#key").val();
    if(key==''){
        alert("请输入查询内容！");
        return false;
    }
    var type = $("#classify").val();
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>finance/query_finance', {
            'key':key,'type':type
    }, function(data){
        $('.event_list').html(data);
    }, 'text');
}


function filter_finance(){
    var status = $("#status").val();
    var begin = $("#valid_begin").val();
    var end = $("#valid_end").val();
    $("#typ").val('filter');
    $.post('<?php echo $url_prefix;?>finance/filter_finance', {
            'begin':begin,'end':end,'status':status
    }, function(data){
        $('.event_list').html(data);
    }, 'text'); 
}

function todayFinance(){
    $("#typ").val('today');
    $.post('<?php echo $url_prefix;?>finance/todayFinance',function(data){
        $('.event_list').html(data);
    }, 'text'); 
}
/*批量结算*/
function batch_pay(){
    var finance = [];/*选中的财务账单*/
    $("input[name='finance[]']:checked").each(function(i){
        finance.push($(this).val());
    });
    if(!finance.length){
        alert('请选中需要结算的订单!');
        return false;
    }
    waiting();
    var financestr = finance.join("|");
    $.post('<?php echo $url_prefix;?>finance/batch_pay', {
            'finance':financestr
    }, function(data){
        if(data.status){
            $("body").append(data.data);
            //window.location.reload();
        }else{
            //alert(data.msg);
            //window.location.reload();
        }
    }, 'json');   
}

<?php if(intval($user['id_profile'])===1 || $user['role']=='admin'){?>
function manage(_obj){
    var data = $(_obj).attr('data');
    var obj = eval('(' + data + ')');
    var currStatu;
    var optionStr = '<option  value="0"  selected="true">待结算</option><option  value="1">支付宝处理中</option><option  value="2">结算失败</option><option  value="3">已结算</option>';
    var fstr = '<a class="btn yellow settle" style="width:100px;height:10px;line-height:10px;margin-left:20px;" pay-data=\''+data+'\' href="javascript:void(0);">结算</a>';
    if(obj.status==0){
        currStatu = '待结算';
    }
    if(obj.status==1){
        currStatu = '支付宝处理中';
        fstr = '<a class="btn yellow" style="width:300px;height:10px;line-height:10px;margin-left:20px;" href="javascript:void(0);">支付宝处理中....暂时无法结算</a>';
        optionStr = '<option  value="0">待结算</option><option  value="1" selected="true" >支付宝处理中</option><option  value="2">结算失败</option><option  value="3">已结算</option>';
    }
    if(obj.status==2){
        currStatu = '结算失败';
        optionStr = '<option  value="0">待结算</option><option  value="1">支付宝处理中</option><option  value="2" selected="true">结算失败</option><option  value="3">已结算</option>';
    }
    if(obj.status==3){
        currStatu = '已结算';
        fstr = '<a class="btn yellow" style="width:100px;height:10px;line-height:10px;margin-left:20px;" href="javascript:void(0);">已结算......</a>';
        optionStr = '<option  value="0">待结算</option><option  value="1">支付宝处理中</option><option  value="2">结算失败</option><option  value="3" selected="true" >已结算</option>';
    } 
    if(!obj.alipay_account || !obj.alipay_name){
        fstr = '<a class="btn yellow" style="width:300px;height:10px;line-height:10px;margin-left:20px;" href="javascript:void(0);">未绑定支付宝帐号，无法结算！</a>';
    }
    var html = '<div class="mana" style="height:200px;width:200px;">'+
                    '<div class="title" style="float:left;width:100%;height:20px;font-weight:bold;line-height:20px;color:1262A2;">财务记录操作</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第一步：结算</div>'+
                    '<div style="float:left;" >'+fstr+
                    '</div>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;padding-left:10px;">第二步：修改财务订单状态</div>'+
                    '<div style="float:left;width:100%;height:20px;line-height:20px;padding-left:20px;">当前状态：<span style="color:red;font-weight:bold;">'+currStatu+'</span></div>'+
                    '<div style="float:left;width:400px;height:20px;line-height:20px;padding-left:20px;">请选择以下财务记录状态<span style="color:#FFB848;" >(注：请仔细核对信息后修改！)</span>：</div>'+
                    '<div style="float:left;width:100%;height:30px;margin-top:10px;">'+
                        '<select name="type" id="statusM" style="width:300px;height:100%;border:1px solid;margin-left:40px;">'+optionStr+
                        '</select>'+
                        '<input type="hidden" value="'+obj.status+'" id="fstatus"/>'+
                        '<input type="hidden" value="'+obj.fid+'" id="fid" />'+
                    '</div>'+
               '</div>';
    html_pop(html,'manageUp');
}
function manageUp(){
    var status = $("#statusM").val(); 
    var curStatu = $("#fstatus").val(); 
    var fid = $("#fid").val(); 
    if(status==curStatu){
        alert("财务记录状态没有发生变动！");
        cancel();
        return false;
    }else{
        if(status!=''&& curStatu!=''&& fid!=''){
            waiting();
            $.post('<?php echo $url_prefix;?>finance/manage', {
                    'status':status,'curStatu':curStatu,'fid':fid
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
            alert('修改失败！');
            return false;
        }
    }
}


<?php }?>
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
