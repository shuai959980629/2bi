<!DOCTYPE HTML>

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

								<a href="javascript:void(0);">权限管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">角色管理</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content" >
                   <!--角色管理开始-->
                    <div id="property_processing" class="clearfix">
                    		<b>角色名称：</b>
                             <select name="type" id="classify" class="choose" style="border:1px solid gray;margin-top:5px;min-width:100px;">
                                <?php if($profile){?>
                                    <option  value="0" >--请选择管理员角色--</option>
                                     <?php foreach($profile as $key =>$data){?>
                                        <option  value="<?php echo $data['id_profile'];?>" ><?php echo $data['name'];?></option>
                                     <?php  }?>
                                 <?php }else{?>
                                    <option  value="0" >没有可用角色，请添加！</option>
                                 <?php }?>
                            </select> 
                          <a class="btn green" onclick="add_role();" href="javascript:void(0);">新增角色</a>
                          <?php if($profile){?>
                          <a class="btn grey" onclick="delete_profile();" href="javascript:void(0);">删除</a>
                          <?php }?>
                   	</div>
                    <div>
                    <div class="role_management clearfix">
                    	<div class="fl">
                        	<span>功能列表<small>(单击即可添加)</small></span>
                            <ul>
                                <?php foreach($right_list as $key =>$vals){?>
                                    <li>
                                        <a class="right" rid="<?php echo $vals['id_right'];?>" name="<?php echo $vals['name'];?>">
                                            <?php echo $vals['name'];?>
                                        </a>
                                    </li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="fl">
                        <span>所属权限</span>
                            <ul id="rightDIV"></ul>
                        </div>
                    </div>
                    <a class="btn grey" onclick="cancel_right();" href="javascript:void(0);" style="margin-right:15px;">取消</a><a onclick="add_right();" class="btn green" href="javascript:void(0);">确定</a>
                    <!--角色管理结束-->
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
function add_profile(){
   var name = $("#profileName").val();
   var role = $("#role").val(); 
   if(name==''){
        alert("请输入角色名称！");
        return false;
   }
   waiting();
   $.post('<?php echo $url_prefix;?>profile/add', {
            'name':name,'role':role
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

function delete_profile(){
    var id_profile = $("#classify").val();
    if(id_profile==0||id_profile==''){
        alert("请选择角色名称！");
        return false;
    }
    var res = confirm("删除该角色，将删除角色所有权限，是否删除！");
    if(!res){
        return false;
    }
    $.post('<?php echo $url_prefix;?>profile/delete', {
            'id_profile':id_profile
    }, function(data){
        if(data.status){
            //alert(data.msg);
            window.location.reload();
        }else{
            alert(data.msg);
            cancel();
        }
    }, 'json');
}

function cancel_right(){
    $("#profileName").val("");
    window.location.reload(); 
}

function add_right(){
    var id_profile = $("#classify").val();
    if(id_profile==0||id_profile==''){
        alert("请选择角色名称！");
        return false;
    }
    var rid = [];
    $("input[name='rid[]']").each(function(i){
        rid[i] = $(this).val();
    });
    if(!rid.length){
        alert('请给选中的角色分配权限!');
        return false;
    }
    $.post('<?php echo $url_prefix;?>profile/add_right', {
            'id_profile':id_profile,'rid':rid
    }, function(data){
        if(data.status){
            alert(data.msg);
            window.location.reload();
        }else{
            alert(data.msg);
            cancel();
        }
    }, 'json');
    
    
}

/*
添加角色
*/
function add_role(){
    var html = '<div style="width:500px;height:220px;">'+
                    '<div style="float:left;width:100%;height:30px;margin-top:10px;"><b>新增角色</b></div>'+
                    '<div style="float:left;width:100%;height:30px;margin-top:10px;"><p>1.新增角色名称</p></div>'+
                    '<div style="float:left;width:100%;height:30px;margin-top:10px;"><p><input class="m-wrap" id="profileName" name="" type="text" style="width:300px;"></p></div>'+
                    '<div style="float:left;width:100%;height:30px;margin-top:10px;"><p>2.新增角色身份</p></div>'+
                    '<div style="float:left;width:100%;height:30px;">'+
                        '<select name="type" id="role" style="width:300px;height:100%;border:1px solid;">'+
                            '<option  value="common"  selected="true">普通管理员</option>'+
                            '<option  value="admin">超级管理员</option>'+
                        '</select>'+
                    '</div>'+
               '</div>';
    html_pop(html,'add_profile');
}
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
       $(".right").click(function(){
           var id_profile = $("#classify").val();
           if(id_profile==0||id_profile==''){
               alert("请选择管理员角色！");
               return false;
           }
           var is_go = 0;
           var name = $(this).attr('name');
           var rid = $(this).attr('rid');
           var html = '<li class="right_list"  id="rid'+rid+'">'+
                        '<input type="hidden" name="rid[]" value="'+rid+'"/>'+
                        '<a href="javascript:void(0);">'+name+'</a>'+
                        '<a class="btn grey delRight" rid="'+rid+'" pid="'+id_profile+'" style="cursor:pointer;"  href="javascript:void(0);">移除</a>'+
                      '</li>';
         $('input[name="rid[]"]').each(function(){
            var val = $(this).val();
            if(rid==val){
                is_go = 1;
                return false;
            }
        });
        if(is_go == 1){
            return false;
        }
        $('#rightDIV').append(html);
       });
       /*
       选取角色。显示不同的权限
        */
       $("#classify").change(function(){
            var id_profile = $("#classify").val();
            if(id_profile==0||id_profile==''){
                $('#rightDIV').html('');
                return false;
            }
            $.post('<?php echo $url_prefix;?>profile/getRight', {
                    'id_profile':id_profile
            }, function(data){
                $('#rightDIV').html(data);
            }, 'text');
       })
       /*
       删除权限
        */
       $(".delRight").live('click',function(){
            var res = confirm("你确定删除该权限！");
            if(!res){
                return false;
            }
            var id_profile = $(this).attr('pid');
            var id_right = $(this).attr('rid');
            var obj=this;
            $.post('<?php echo $url_prefix;?>profile/delRight', {
                    'id_profile':id_profile,'id_right':id_right
            }, function(data){
                if(data.status){
                    $(obj).parent().remove();
                }else{
                    alert(data.msg);
                    cancel();
                }
            }, 'json');
       })
   });
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
