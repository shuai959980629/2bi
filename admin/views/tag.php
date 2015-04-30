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

								<a href="javascript:void(0);">商品管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">标签管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--标签管理开始-->
                        <div class="account">
                            <a class="btn yellow fr" onclick="add()"  href="javascript:void(0);" style="margin-bottom:15px;">新增商品标签</a>
                        </div>
                        <div class="user_manage clearfix portlet box grey event_list">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td>标签id</td>
                                    <td>id亲缘树</td>
                                    <td>排序编号</td>
                                    <td>标签名称</td>
                                    <td>操作</td>
                                </tr>
                                <?php if($tag){?>
                                <?php foreach($tag as $key=>$list){?>
                                <tr style="text-align: center;">
                                    <td><?php echo $list['id_tag'];?></td>
                                	<td><?php echo $list['id_parent'].':'.$list['id_tag'];?></td>
                                    <td><?php echo $list['orders']; ?></td>
                                    <td><?php echo $list['name'];?></td>                   
                                    <td>
                                        <?php if(intval($user['id_profile'])===1 || $user['role']=='admin' ){?>
                                        <a class="btn red delete" data='<?php echo $list['id_tag'];?>' href="javascript:void(0);">删除</a>
                                        <?php } ?>
                                        <a class="btn green update" data='<?php echo json_encode($list);?>' href="javascript:void(0);">修改</a>
                                    </td>
                                </tr>
                                <?php }?>
                                <?php }else{?>
                                <tr style="text-align: center;"><td colspan="5">暂无商品标签。。。</td></tr>
                                <?php }?>
                           </tbody>
                        </table>
                    <!--标签管理结束-->
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
   /*删除标签*/
   $(".delete").live('click',function(){
        var id_tag = $(this).attr('data');
        var html = '<div style="width:200px;height:50px;padding-left:50px;font-weight:bold;color:#D84A38;line-height:50px;">'+
                        '<input id="id_tag" type="hidden" value="'+id_tag+'"/>'+
                        '你确定要删除该标签？'+
                   '</div>';
        html_pop(html,'delet');
   });
  /*修改标签*/
  $(".update").live('click',function(){
        var data = $(this).attr('data');
        var obj = eval('(' + data + ')');
        var html = '<div style="width:500px;height:150px;">'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:-5px;"><b>修改商品标签</b></div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
						'<label class="control-label" style="float:left;">标签名称<span class="required">*</span></label>'+
						'<div class="controls" style="width:300px;float:left;height:35px;margin-left:10px;">'+
                            '<input id="id_tag" type="hidden" value="'+obj.id_tag+'"/>'+
							'<input style="width:300px;height:20px;" id="tagname" name="tagname" value="'+obj.name+'" type="text"/>'+
						'</div>'+
					'</div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
						'<label class="control-label" style="float:left;">标签分类<span class="required">*</span></label>'+
						'<div class="controls" style="width:300px;float:left;height:35px;margin-left:10px;">'+
							'<select name="parent" id="parent" class="choose" style="border:1px solid gray;min-width:150px;">'+
                            <?php if($parent){?>
                                '<option  value="0" >顶级父类</option>'+
                                 <?php foreach($parent as $key =>$data){?>
                                    '<option  value="<?php echo $data['id_tag'];?>" ><?php echo $data['name'];?></option>'+
                                 <?php  }?>
                             <?php }else{?>
                                '<option  value="0" >顶级父类</option>'+
                             <?php }?>
                            '</select>'+
						'</div>'+
					'</div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
                        '<label class="control-label" style="float:left;">排序编号<span class="required">*</span></label>'+
                        '<div class="controls" style="width:380px;float:left;height:35px;line-height:35px;margin-left:10px;">'+
							'<input style="width:100px;height:20px;" id="orders" name="orders" value="'+obj.orders+'" type="text"/>'+
                            '<span style="color:#EAA031;font-size:12px;">&nbsp;&nbsp;数字越大排在越前面[客户端显示],不能重复！</span>'+
						'</div>'+
                    '</div>'+
               '</div>';
       html_pop(html,'update');
       $("#parent").get(0).value = obj.id_parent;
  });  
});
/*修改标签*/
function update(){
    var id_tag = $("#id_tag").val(); 
    var name = $("#tagname").val();
    var id_parent = $("#parent").val(); 
    var orders = $("#orders").val();
    if(name==''){
        alert("请输入标签名称！");
        return false;
    }
    var orderReg  = /^[0-9]*[1-9][0-9]*$/ ;　　//正整数      
    if(!orderReg.test(orders)){
        alert("请输入正确的排序编号！");
        return false;
    }
   waiting();
   $.post('<?php echo $url_prefix;?>tag/update', {
            'name':name,'id_parent':id_parent,'orders':orders,'id_tag':id_tag
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
/*删除标签*/
function delet(){
    var id_tag = $("#id_tag").val(); 
    waiting();
    $.post('<?php echo $url_prefix;?>tag/delet', {
            'id_tag':id_tag
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

/*新增标签*/
function add(){
    var html = '<div style="width:500px;height:150px;">'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:-5px;"><b>新增商品标签</b></div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
						'<label class="control-label" style="float:left;">标签名称<span class="required">*</span></label>'+
						'<div class="controls" style="width:300px;float:left;height:35px;margin-left:10px;">'+
							'<input style="width:300px;height:20px;" id="tagname" name="tagname" value="" type="text"/>'+
						'</div>'+
					'</div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
						'<label class="control-label" style="float:left;">标签分类<span class="required">*</span></label>'+
						'<div class="controls" style="width:300px;float:left;height:35px;margin-left:10px;">'+
							'<select name="parent" id="parent" class="choose" style="border:1px solid gray;min-width:150px;">'+
                            <?php if($parent){?>
                                '<option  value="0" >顶级父类</option>'+
                                 <?php foreach($parent as $key =>$data){?>
                                    '<option  value="<?php echo $data['id_tag'];?>" ><?php echo $data['name'];?></option>'+
                                 <?php  }?>
                             <?php }else{?>
                                '<option  value="0" >顶级父类</option>'+
                             <?php }?>
                            '</select>'+
						'</div>'+
					'</div>'+
                    '<div class="control-group" style="height:35px;line-height:35px;width:100%;float:left;margin-top:10px;">'+
                        '<label class="control-label" style="float:left;">排序编号<span class="required">*</span></label>'+
                        '<div class="controls" style="width:380px;float:left;height:35px;line-height:35px;margin-left:10px;">'+
							'<input style="width:100px;height:20px;" id="orders" name="orders" value="" type="text"/>'+
                            '<span style="color:#EAA031;font-size:12px;">&nbsp;&nbsp;数字越大排在越前面[客户端显示],不能重复！</span>'+
						'</div>'+
                    '</div>'+
               '</div>';
    html_pop(html,'add_tag');
}
function add_tag(){
   var name = $("#tagname").val();
   var id_parent = $("#parent").val(); 
   var orders = $("#orders").val();
   if(name==''){
        alert("请输入商品标签名称！");
        return false;
   }
   var orderReg  = /^[0-9]*[1-9][0-9]*$/ ;　　//正整数      
   if(!orderReg.test(orders)){
       alert("请输入排序编号！");
       return false;
   }
   waiting();
   $.post('<?php echo $url_prefix;?>tag/add', {
            'name':name,'orders':orders,'id_parent':id_parent
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
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
