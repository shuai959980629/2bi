   <!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->

<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

<!-- BEGIN HEAD -->
<?php require_once('header.php');?>
<style>
    #uploadBtn{
        display:block;
        background:url(<?php echo $url_prefix;?>media/js/swfupload/wdp_buttons_upload_114x29_.png) no-repeat ;
        width:420px; height:32px;
    }
</style>
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

							<li><a href="javascript:void(0);">新增专题</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   	<!--新增专题开始-->
                    <div class="add_app">
						<div class="portlet box purple">
                   		 <div class="portlet-title">
								<div class="caption"><i class="icon-reorder"></i>新增专题活动内容</div>
						 </div>
                    	<div class="portlet-body form">
                                <div class="add_special">
                                <form action="<?php echo $url_prefix;?>accounts/add_theme" id="form_add_theme" class="form-horizontal" method="post" enctype="multipart/form-data" >   
									<input type="hidden" value="<?php echo $url_prefix;?>accounts/add_theme" id="jobaction"/>
                                    <div style="width:100%;height:430px;">
                                        <div style="width:50%;float:left;">
                                            <div class="alert alert-error hide">
        
        										<button class="close" data-dismiss="alert"></button>
                                                请确保输入的内容符合提交条件，再点击提交！
        
        									</div>
        
        									<div class="alert alert-success hide">
        
        										<button class="close" data-dismiss="alert"></button>
                                                你的信息已成功完成验证！
        
        									</div>
                                            
                                            <div class="control-group">
        										<label class="control-label">专题名称<span class="required">*</span></label>
        										<div class="controls">
        											<input class="span6 m-wrap" value="<?php  echo $name;?>" name="name" id="name" type="text" style="width:500px;"/>
        										</div>
        									</div>
                                                                                                                    
                                            <div class="control-group">
        										<label class="control-label">专题logo<span class="required">*</span></label>
        										<div class="controls">
                                                    <?php if($logo){?>
                                                        <a href="javascript:void(0);"  id="uploadBtn" style="display: none;"></a>
                                                         <div id="logo-link">
                                                             <input readonly="true" class="span6 m-wrap" value="<?php echo $logo;?>" name="logo" id="logo" style="display:block;width:500px;float:left;" type="text"/>
                                                             <a onclick="delete_file('theme','logo')" style="font-weight:bold;display: block; float:left;text-decoration: none;width:25px;height:33px;line-height:33px;text-align:center;">X</a>
                                                        </div>
                                                    <?php }else{?>
                                                        <a href="javascript:void(0);"  id="uploadBtn"></a>
                                                        <div id="logo-link" style="display: none;">
                                                             <input readonly="true" class="span6 m-wrap" value="" name="logo" id="logo" style="display:block;width:500px;float:left;" type="text"/>
                                                             <a onclick="delete_file('theme','logo')" style="font-weight:bold;display: block; float:left;text-decoration: none;width:25px;height:33px;line-height:33px;text-align:center;">X</a>
                                                        </div>
                                                    <?php }?>
        										</div>
        									</div>
                                            
                                            <div class="control-group">
                                                <label class="control-label">有效时间<span class="required">*</span></label>
        										<div class="controls">
                                                    <input type="text" value="<?php echo $valid_begin;?>" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                                                    <span>至</span>
                                                    <input type="text" value="<?php echo $valid_end;?>" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                                                 </div>
        									</div>
                                            
                                            
        									<div class="control-group">
        										<label class="control-label">地&nbsp;&nbsp;&nbsp;址<span class="required">*</span></label>
        										<div class="controls">
        											<input class="span6 m-wrap" id="address" name="address" value="<?php echo $address;?>" type="text" style="width:500px;"/>
        										</div>
        									</div>
                                            
                                            <div class="control-group">
        										<label class="control-label">类&nbsp;&nbsp;&nbsp;型<span class="required">*</span></label>
        										<div class="controls">
        											<select class="span6 m-wrap" name="type" id="type">
                                                        <option  value="normal" <?php if($type=='normal'){ echo 'selected="true"';}?>>常规</option>
                                                        <option  value="web" <?php if($type=='web'){ echo 'selected="true"';}?>>专题网页连接</option>
                                                    </select>
        										</div>
        									</div>
                                            <div class="control-group">
        										<label class="control-label">专题宝贝<span class="required">*</span></label>
        										<div class="controls">
                                                    <input class="span6 m-wrap" value="<?php echo $cowry;?>" readonly="true" placeholder="宝贝id" name="cowry" id="cowry" type="text" style="width:400px;"/>
        											<a class="btn red" onclick="choose_cowrys()" href="javascript:void(0);">选择...</a>
        										</div>
        									</div>
                                             <div class="control-group">
        										<label class="control-label">网页链接<span class="required">*</span></label>
        										<div class="controls">
        											<input class="span6 m-wrap" value="<?php echo $link;?>" name="link" id="link" type="text" style="width:500px;"/>
        										</div>
        									</div>
        									<div class="control-group">
        										<label class="control-label">排序编号<span class="required">*</span></label>
        										<div class="controls">
        											<input class="span6 m-wrap" value="<?php echo $order;?>" name="order" id="order" type="text" style="width:100px;"/>
                                                    <span style="color:blue;">注：纯数字0，1，2，...</span>
        										</div>
        									</div>
                                        </div>
                                        <div  style="width:50%;float:left;height:428px;">
                                            <div id="show" style="text-align:center; width:90%;float:left;height:428px;background-color: #ddd;line-height: 300px;overflow:hidden;" >
                                                <?php if($logo){?>
                                                    <img class="imgPreview"  src="/attachment/theme/<?php echo $logo;?>" style="width:auto; height:auto;margin:0 auto;"/>
                                                <?php }else{?>
                                                    logo图片预览
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width:100%;height:60px;">
                                        <div class="form-actions">
    										<button type="button" class="btn">取消</button>
    										<button type="submit" class="btn purple">添加</button>
    									</div>
                                    </div>                                    
								</form>
                                </div>
							</div>	
                    </div>
                    </div>
                    <!--新增专题结束-->
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
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/form-validation.js"></script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/ajaxupload.js"></script>
<script src="<?php echo $url_prefix;?>media/js/uploadfile.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {       
   App.init();
   UITree.init();
   FormValidation.init();
   uplodImage('uploadBtn','logo','show','theme');
});

function choose_cowrys(){
    var data = get_page_data();
    $.post('<?php echo $url_prefix;?>theme/write_cache', {
            'data':data,'type':'cache'
    }, function(data){
        if(data.status){
            window.location.href="<?php echo $url_prefix;?>commodity";
        }else{
            alert(data.msg);
        }
    }, 'json');
}

/**
 *获取页面数据
 */
function get_page_data(){
    var data = {};
    data['name']=$("#name").val();
    data['logo']=$("#logo").val();
    data['valid_begin']=$("#valid_begin").val();
    data['valid_end']=$("#valid_end").val();
    data['address']=$("#address").val();
    data['type']=$("#type").val();
    data['cowry']=$("#cowry").val();
    data['link']=$("#link").val();
    data['order']=order = $("#order").val();
    var dta = JSON.stringify(data);
    return dta;
}



</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>