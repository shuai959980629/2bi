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

							<li><a href="javascript:void(0);">评论列表</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                    <!--商品详情开始-->
                    <input type="hidden" name="cid" value="<?php echo $cid;?>"/>
                	<div class="product clearfix portlet box grey">
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
                        <?php if($page_html){?>
                            <div id="pagination" class="clearfix" style="margin-top:15px;">
                                <ul class="fr">
                                    <?php echo $page_html;?>
                                </ul>
                            </div>
                        <?php }?>
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
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
});

function del(commentid,offset){
    if(confirm('确定要删除该评论信息？')){
        $.post('<?php echo $url_prefix;?>commodity/del_comment', {
            'commentid':commentid
        }, function(data){
            comment_list_page(offset);
        }, 'text');
    }
}

//商品列表分页
function comment_list_page(offset){
    $.post('<?php echo $url_prefix;?>commodity/comment_list', {
        'offset':offset,
        'cid':$("input[name=cid]").val(),
        'page_type':1
    }, function(data){
        $('.product').html(data);
    }, 'text');
}


</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>