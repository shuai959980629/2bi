<?php if($page_type == 'commodity'){?>  
<!--商品列表分页-->
    <ul class="clearfix">
        <?php if($commodity_list){?>
            <?php foreach($commodity_list as $key=>$val){ ?>
        	<li>
            	<a target="_blank" href="<?php echo $url_prefix?>commodity/cowry?cid=<?php echo $val['cid'];?>&uid=<?php echo $val['uid'];?>">
                <img  class="lazy" width="120" height="120" src="<?php echo $url_prefix;?>/media/image/5-121204194033-51.gif" data-original="<?php echo get_img_url($val['img'],'cowry');?>"/></a>
                 <label>
					<div class="checker"><span><input id="cowry_<?php echo $val['cid'];?>" name="cowry[]"  type="checkbox" value='<?php echo $val['cid'];?>'/></span></div>
                    <b>
                        <?php echo truncate_utf8($val['description'],10);?>
                    </b>
                </label>
            </li>
            <?php }?>
        <?php }else{?>
            <li>没有商品信息！</li>
        <?php }?>
    </ul>
    <!--搜索开始-->
    <?php if($page_html){?>
    <div id="pagination" class="clearfix" style="margin-top:15px;" > 
        <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="commodity_list_page('skip')" href="javascript:void(0);">GO</a></div>
        <ul class="fr">
           <?php echo $page_html;?>
        </ul>
    </div>
    <?php }?>
    <!--搜索结束-->
<?php }?>

<?php if($page_type == 'comment'){?>
    <table>
        <tbody>
        <tr class="title" style="text-align: center;">
            <td class="describe" style="width: 10%;">评论时间</td>
            <td class="site" style="width: 10%;">评论人</td>
            <td>评论内容</td>
            <td class="handle">操作</td>
        </tr>
        <?php if($comment_list){?>
            <?php foreach($comment_list as $key=>$val){ ?>
                <tr style="text-align: center;">
                    <td class="describe" style="width: 10%;"><?php echo $val['created'];?></td>
                    <td class="site" style="width: 10%;"><?php echo $val['nickname'];?></td>
                    <td><?php echo $val['content'];?></td>
                    <td class="handle">
                        <a class="btn grey" onclick="del(<?php echo $val['commentid']; ?>,<?php echo $offset; ?>)" href="javascript:void(0);">删除</a>
                    </td>
                </tr>
            <?php }?>
        <?php }else{?>
            <tr style="text-align: center;"><td colspan="4" style="font-size: 20px;">没有商品信息！</td></tr>
        <?php }?>
        </tbody>
    </table>
    <!--搜索开始-->
    <?php if($page_html){?>
        <div id="pagination" class="clearfix" style="margin-top:15px;" >
            <ul class="fr">
                <?php echo $page_html;?>
            </ul>
        </div>
    <?php }?>
    <!--搜索结束-->
<?php }?>

<?php if($page_type=='merchant'){?>
<!--商家信息-->
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
    <tr style="text-align: center;"><td colspan="7">没有符合要求的商家！</td></tr>
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
<?php }?>


<?php if($page_type=='profile'){?>
    <!--角色管理：权限列表-->
     <?php foreach($right_list as $key =>$vals){?>
         <li class="right_list"  id="rid<?php echo $vals['id_right'];?>">
            <input type="hidden" name="rid[]" value="<?php echo $vals['id_right'];?>"/>
            <a href="javascript:void(0);"><?php echo $vals['name'];?></a>
            <a class="btn grey delRight" rid="<?php echo $vals['id_right'];?> " pid="<?php echo $id_profile;?>" style="cursor:pointer;"  href="javascript:void(0);">移除</a>
         </li>
    <?php }?>
<?php }?>


<?php if($page_type=='order'){?>
<!--订单列表信息-->
<table>
	<tbody>
    	<tr class="title" style="text-align: center;"><td>订单号</td><td>流水号</td><td>卖家名称</td><td>买家名称</td><td>注订单状态</td><td>支付方式</td><td>处理结果</td><td>备注</td><td>操作</td></tr>
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
<?php }?>


<?php if($page_type=='review'){?>
<!--审核订单列表信息-->
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
                         <a class="btn green  approve" order-data='<?php echo json_encode($list);?>' href="javascript:void(0);">审核通过</a>
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
<?php }?>



<?php if($page_type=='finance'){?>
<!--财务结算列表信息-->
<table>
	<tbody>
    	<tr class="title" style="text-align: center;">
        	<td style="text-align:left;">
                <label for="checkALL">
                    <div class="checker" id="uniform-checkALL">
                    <span><input name="checkALL" id="checkALL" title="全选/反选" type="checkbox" style=""/></span></div>全选
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
                    <?php if(intval($user['id_profile'])===1 || $user['role']=='admin'){?>
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
                <tr style="text-align: center;"><td colspan="7">暂无结算订单信息！</td></tr>
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
<script>
    $(function (){
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
    });
</script>
<!--搜索结束-->
<?php }?>



<?php if($page_type=='permissions'){?>
<!--商户权限-->
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
                        echo '商铺用户';
                    }elseif($list['role']=='normal'){
                        echo '普通用户';
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
<?php }?>


<?php if($page_type=='theme_list'){?>
<!--专题活动-->
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
                                <a class="btn yellow" href="<?php echo $url_prefix;?>theme/thcowry?tid=<?php echo $list['tid'];?>">宝贝管理</a>
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
<?php }?>


<?php if($page_type=='theme_cowry_list'){?>
<!--专题活动宝贝列表-->
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
<?php }?>






















