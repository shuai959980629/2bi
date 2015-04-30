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

								<a href="<?php echo $url_prefix?>commodity">商品管理</a>

								<i class="icon-angle-right"></i>

							</li>

							<li><a href="javascript:void(0);">列表</a></li>

						</ul>

						<!-- END PAGE TITLE & BREADCRUMB-->

					</div>

				</div>
				<!--右边标题导航结束-->
                <!--右边中介内容开始-->
                <div class="content">
                    <div  class="clearfix" style="border-bottom: 1px solid #ddd;">
                    	<div style="width: 100%;height:50%;float:left;" >
                                <div style="width: 100px;float:left;">
                                    <select name="type" id="classify" style="width:100px;height:34px;">
                                        <option  value="description"  selected="true">宝贝名称</option>
                                        <option  value="nickname">商家名称</option>
                                        <option  value="username">商家帐号</option>
                                    </select>
                                </div>
                                <div style="width: 400px;float:left;">
                                    <input class="span6 m-wrap" name="key" placeholder="请输入查询关键字" style="height:15px;width:200px;" id="key"  type="text"/>
                                    <a class="btn green" onclick="querycowry()" href="javascript:void(0);">查询</a>
                                </div>
                                
                         </div>
                         <div style="width: 100%;height:50%;float:left;" style="border: 1px solid red;">
                            <b class="NO">地&nbsp;&nbsp;&nbsp;址：</b><input class="span6 m-wrap" style="width:300px;" id="address" name="" type="text"/>
                            <b style="margin-left:10px;" class="NO">时&nbsp;&nbsp;&nbsp;间：</b>
                            <input type="text" value="" style="width:172px;" id="valid_begin" name="valid_begin" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                            <b>至：</b>
                            <input type="text" value="" style="width:172px;" id="valid_end" name="valid_end" class="Wdate" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',errDealMode:1,readOnly:true})"/>
                             <a class="btn green" onclick="filter()" href="javascript:void(0);" style="margin-left: 5px;margin-top:-8px;">筛&nbsp;选</a>
                         </div>
                   	</div>
                    <input type="hidden" id="typ" name="typ" value="all" />
                	<!--商品管理开始-->
                	<div class="item_govern clearfix event_list" style="height: 600px;">
                    	<ul class="clearfix">
                            <?php if($commodity_list){?>
                                <?php foreach($commodity_list as $key=>$val){ ?>
                            	<li>
                                	<a target="_blank" href="<?php echo $url_prefix?>commodity/cowry?cid=<?php echo $val['cid'];?>&uid=<?php echo $val['uid'];?>">
                                    <img  class="lazy" width="120" height="120" src="<?php echo $url_prefix;?>/media/image/5-121204194033-51.gif" data-original="<?php echo get_img_url($val['img'],'cowry');?>"/></a>
                                    <label>
                                        <b>
											<input name="cowry[]" id="cowry_<?php echo $val['cid'];?>"  type="checkbox" value='<?php echo $val['cid'];?>'/>
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
                        <div id="pagination" class="clearfix" style="margin-top:15px;"> 
                            <div class="pagination fr"><p>跳转至：</p><input name="" value="" id="skip" type="text"/><a onclick="commodity_list_page('skip')" href="javascript:void(0);">GO</a></div>
                            <ul class="fr">
                               <?php echo $page_html;?>
                            </ul>
                        </div>
                        <?php }?>
                        <!--搜索结束-->
                    </div>
					<div style="position: relative; top:-45px;width:600px;">
                            <a style="margin-left: 20px;">已经选择<span id="num" style="color:#852B99;font-weight:bold;font-size:18px;">0</span>个宝贝</a>
                            <?php if(isset($id_theme)){?>
								<a class="btn yellow" onclick="save_theme_cowry()" style="margin-left: 30px;" href="javascript:void(0);">确定专题宝贝</a>
							<?php }?>
                    </div>
					<!--商品管理结束-->
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
var thCowry = '<?php echo !empty($themCowry)?$themCowry:'' ;?>';
var arrCowry = [];//包含以前专题的宝贝id
var addCowry =[];//新增的专题宝贝id
jQuery(document).ready(function() {  
   App.init();
   UITree.init();
   lazyload();
   initArrCowry();
   initChoosedCowry();
   $("input[name='cowry[]']").live("click",function(){
        if($(this).attr('checked')!='checked'){
            $(this).attr("checked",false);
            $(this).parent().removeClass('checked');
			//删除，移除数组 删除已经存在的
			if($.inArray($(this).val(),arrCowry)!=-1){
				 arrCowry.splice($.inArray($(this).val(),arrCowry),1);
			}
            if($.inArray($(this).val(),addCowry)!=-1){
				 addCowry.splice($.inArray($(this).val(),addCowry),1);
			}
			var len = arrCowry.length;
            $("#num").html(len);
        }else{
            //选中。放入数组
            $(this).attr("checked",true);
            $(this).parent().addClass('checked'); 
            arrCowry.push($(this).val());
			addCowry.push($(this).val());
            var len = arrCowry.length;
            $("#num").html(len);
        }
  });
});

function initArrCowry(){
    if(thCowry!='' && typeof thCowry == 'string'){
        arrCowry = thCowry.split(' ');
    }
}

/**
 *选中已经存在数组的专题宝贝
 */
function initChoosedCowry(){
    var len = arrCowry.length;
    if(len!=0){
       for(var i=0;i<len;i++){
            $("#cowry_"+arrCowry[i]).attr("checked",true);
			if($.inArray(arrCowry[i],addCowry)==-1){
				$("#cowry_"+arrCowry[i]).attr("disabled",true);
			}
			$("#cowry_"+arrCowry[i]).parent().addClass('checked'); 
        }
        $("#num").html(len); 
    }else{
        $("input[name='cowry[]']").attr("checked",false);
		$("input[name='cowry[]']").attr("disabled",false);
        $("input[name='cowry[]']").parent().removeClass('checked');
    }
}

<?php if(isset($id_theme)){?>
/**
 *新增专题宝贝
 */
function save_theme_cowry(){
    var len = addCowry.length;
    if(len!=0){
		waiting();
        var data = JSON.stringify(addCowry);//新增专题宝贝的IDjson数据
        $.post('<?php echo $url_prefix;?>theme/save_theme_cowry', {
                'data':data,'id_theme':<?php echo $id_theme;?>
        }, function(data){
			if(data.status){
				alert(data.msg);
                window.location.href="<?php echo $url_prefix;?>theme/thcowry?tid=<?php echo $id_theme;?>";
            }else{
                alert(data.msg);
				cancel();
            }
        }, 'json');
    }else{
        window.location.href="<?php echo $url_prefix;?>theme/thcowry?tid=<?php echo $id_theme;?>";
    }
}
<?php }?>


//商品列表分页
function commodity_list_page(offset){
    if(offset=='skip'){
        offset=$("#"+offset).val();
        if(offset==''){
            return ;
        }
    }
    $.post('<?php echo $url_prefix;?>commodity/list_commodity', {
            'offset':offset,
            'type':$("#typ").val()
    }, function(data){
        $('.event_list').html(data);
        lazyload();
        //initArrCowry();
        initChoosedCowry();
    }, 'text');
}
//设置透明度
function setopacity(a,b)
{
    document.all ? a.style.filter = 'alpha(opacity=' + b + ')' : a.style.opacity = b / 100;
}
//淡入图片
function fadein(a)
{
    var b=0,
    c = window.setInterval(function()
    {
        b +=2;
        setopacity(a,b);
        b == 100 && window.clearInterval(c);
    },1)
}
//在可见区域加载并显示图片
function imgload(obj,i)
{
    var img = new Image();
    i = i || 0;
    img.onload = function()
    {
        obj[i].src = img.src;
        obj[i].removeAttribute('data-original');//移除自定义的属性
        setopacity(obj[i],0);//设置图片透明，防止图片闪烁
        obj[i].style.visibility = 'visible';//图片可见
        fadein(obj[i]);//图片淡入
        //递归确保图片的载入顺序
        i+1<obj.length && obj[i].offsetTop<document.body.clientHeight+document.body.scrollTop && imgload(obj,i+1);
    }
    //存在自定义属性则加载该图片地址,否则再次判断下标<对象长度并且在可视范围内时,递归处理下一个img元素
    obj[i].hasAttribute('data-original') ? img.src = obj[i].getAttribute('data-original') : (i+1<obj.length && obj[i].offsetTop<document.body.clientHeight+document.body.scrollTop && imgload(obj,i+1));
}
//预加载图片（单独获取img对象是为避免在递归中重复获取，假如是瀑布流等滚动加载图片的网站则应该在递归函数中获取对象。或者在滚动追加img元素时使用push方法）
function lazyload()
{
    var elements = document.getElementsByTagName('img');
    imgload(elements)
}
//跟KEY值查询宝贝
function querycowry(){
    var key = $("#key").val();
    if(key==''){
        alert("请输入查询关键字！");
        return false;
    }
    var type = $("#classify").val();
    $("#typ").val('query');
    $.post('<?php echo $url_prefix;?>commodity/query_cowry', {
            'key':key,'type':type
    }, function(data){
        $('.event_list').html(data);
        lazyload();
		initChoosedCowry();
    }, 'text');
}
//筛选宝贝
function filter(){
    var address = $("#address").val();
    var begin = $("#valid_begin").val();
    var end = $("#valid_end").val();
    if(address=='' && begin==''&& end==''){
        alert('请输入查询条件！');
        return false;
    }
    $("#typ").val('filter');
    $.post('<?php echo $url_prefix;?>commodity/filter', {
            'begin':begin,'end':end,'address':address
    }, function(data){
        $('.event_list').html(data);
        lazyload();
		initChoosedCowry();
    }, 'text'); 
}
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript" src="<?php echo $url_prefix;?>media/js/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script>
</body>
<!-- END BODY -->
</html>
