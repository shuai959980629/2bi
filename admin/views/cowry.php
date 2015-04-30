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
                           商品管理<small>Commodity management</small>
						</h3>

						<ul class="breadcrumb">

							<li>

								<i class="icon-home"></i>

								<a href="<?php echo $url_prefix;?>">邻售</a> 

								<i class="icon-angle-right"></i>

							</li>

							<li>

								<a href="<?php echo $url_prefix?>commodity">商品管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">商品详情</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                    <!--商品详情开始-->
                	<div class="product clearfix portlet box grey">
                    	<table>
                        	<tbody>
                            	<tr class="title" style="text-align: center;">
                                	<td class="describe" style="width: 10%;">宝贝描述</td>
                                    <td class="site" style="width: 10%;">宝贝地址</td>
                                    <td>价格</td>
                                    <td>库存</td>
                                    <td>标签</td>
                                    <td class="handle">操作</td>
                                </tr>
                                <?php if($cowry){?>
                                <tr style="text-align: center;">
                                	<td class="describe" style="width: 10%;"><?php echo $cowry['description'];?></td>
                                    <td class="site" style="width: 10%;"><?php echo $cowry['address'];?></td>
                                    <td><?php echo $cowry['price'];?></td>
                                    <td><?php echo $cowry['num'];?></td>
                                    <td><?php echo $tagName;?></td>
                                    <td class="handle">
                                        <a class="btn green" data-business="<?php echo $cowry['uid'];?>" href="<?php echo $url_prefix?>merchant?uid=<?php echo $cowry['uid'];?>">进入商户</a>
                                        <a class="btn grey" cid='<?php echo $cowry['cid']; ?>' uid='<?php echo $cowry['uid'];?>' onclick="del(this)" href="javascript:void(0);">删除</a>
                                        <a class="btn green" data='<?php unset($cowry['description']); echo json_encode($cowry);?>' onclick="markCowry(this)" href="javascript:void(0);" >修改/添加标签</a>
                                        <a class="btn green" href="<?php echo $url_prefix?>commodity/comment_list?cid=<?php echo $cowry['cid'];?>">评论</a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <!--商品详情结束-->
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
var thTAG = '<?php echo $tagID;?>';
var TagName = '<?php echo $tagName;?>';
var arrTag = [];
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
   initArrTAG();
   $(".cancel").live('click',function(){
    	$("#show_div").remove();
    	$("#pop_up").remove();
   });
   $("input[name='tag[]']").live("click",function(){
        if($(this).attr('checked')!='checked'){
            $(this).attr("checked",false);
            $(this).parent().removeClass('checked');
            arrTag.splice($.inArray($(this).val(),arrTag),1);//删除，移除数组
        }else{
            //选中。放入数组
            $(this).attr("checked",true);
            $(this).parent().addClass('checked'); 
            arrTag.push($(this).val());
        }
  });
});

function initArrTAG(){
    if(thTAG!='' && typeof thTAG == 'string'){
        arrTag = thTAG.split(' ');
    }
}

/**
 *选中已经存在数组的标签
 */
function initChoosedTAG(){
    var len = arrTag.length;
    if(len!=0){
       for(var i=0;i<len;i++){
            $("#tag_"+arrTag[i]).attr("checked",true);
            $("#tag_"+arrTag[i]).parent().addClass('checked'); 
        }
    }else{
        $("input[name='tag[]']").attr("checked",false);
        $("input[name='tag[]']").parent().removeClass('checked');
    }
}
  
function del(_obj){
    var uid = $(_obj).attr('uid');
    var cid = $(_obj).attr('cid');
    var html = '<div style="width:200px;height:50px;padding-left:50px;font-weight:bold;color:#D84A38;line-height:50px;">'+
                    '<input type="hidden" value="'+cid+'"  id="cowryid" />'+
                    '<input type="hidden" value="'+uid+'"  id="ownerid"/>'+
                    '你确定删除该宝贝？'+
               '</div>';
    html_pop(html,'delcowry');
}

function delcowry(){
    var cid = $("#cowryid").val();
    var uid = $("#ownerid").val();
    waiting();
    $.post('<?php echo $url_prefix;?>commodity/delcowry', {
            'cid':cid,'uid':uid
    }, function(data){
        cancel();
        if(data.status){
            alert(data.msg);
            window.location.href="<?php echo $url_prefix;?>commodity";
        }else{
            alert(data.msg);
        }
    }, 'json');
}
function markCowry(_obj){
    var data = $(_obj).attr('data');
    var obj = eval('(' + data + ')');
    var cuTag = '';
    if(obj.tag!='' && obj.tag!='null'){
        cuTag = '<div style="float:left;width:100%;">所属标签：'+TagName+'</div>';
    }
    var html = '<div style="width:500px;height:150px;">'+
                    '<input type="hidden" value="'+obj.cid+'"  id="cid" />'+
                    '<input type="hidden" value="'+obj.uid+'"  id="uid"/>'+
                    '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:-5px;"><b>修改/添加商品标签</b></div>'+
                     cuTag+
                    '<div style="float:left;width:100%;">商品标签：</div>'+
                    '<ul class="clearfix">'+
                    <?php if($tag){?>
                         <?php foreach($tag as $key=>$list){?>
                             '<li style="display:block;float:left;width:auto;height:25px;line-height:25px;margin-left:15px;marign-top:5px;"><label>'+
                                 '<div class="checker" ><span>'+
                                     '<input name="tag[]" id="tag_<?php echo $list['id_tag'];?>"  type="checkbox" value="<?php echo $list['id_tag'];?>"/>'+
                                 '</span></div>'+
                                 '<em><?php echo $list['name'];?></em>'+
                             '</label></li>'+
                          <?php }?>
                    <?php }else{?>
                    '<li style="display:block;float:left;width:auto;height:25px;line-height:25px;margin-left:15px;marign-top:5px;">没有可用标签，请添加！</li>'+
                    <?php }?>
                    '</ul>'+
               '</div>';
       html_pop(html,'saveCowryTag');
       initChoosedTAG();
}
function saveCowryTag(){
    var len = arrTag.length;
    if(len!=0){
        var data = JSON.stringify(arrTag);
        var uid = $("#uid").val();
        var cid = $("#cid").val();
        waiting();
        $.post('<?php echo $url_prefix;?>tag/saveCowryTag', {
                'data':data,'uid':uid,'cid':cid,'type':'tag'
        }, function(data){
            if(data.status){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
                cancel();
            }
        }, 'json');
    }else{
        alert("请选择宝贝标签！");
    }
    
}


</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>