<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邻售-远亲不如近邻</title>
<base  href=""/>
<link href="media/css/home.css" type="text/css" rel="stylesheet" />
<link href="media/css/style.css" type="text/css" rel="stylesheet"/>
<script src="media/js/jquery.js" type="text/javascript"></script>
<style>
#pop_up{
    background:#000000;
    bottom: 0;
    height: 100%;
    left: 0;
    opacity: 0.8;
    position: fixed;
    right: 0;
    top: 0;
    width: 100%;
    z-index: 99 !important;
}
.mobile img{
	 max-width:90%;}

#pop_up img{
	margin:10% auto; display:block; width:80%; overflow:hidden; max-width:1080px !important;}

</style>
</head>
<div style="display: none;">
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F3d2dc57e1ad18b47ee2c36222411d0ac' type='text/javascript'%3E%3C/script%3E"));
</script>
</div>
<body>
	<header></header>
    <div class="centre clearfix">
    	<div class="fl">
        	<div class="logo"></div>
            <div class="ad">左邻右舍在买啥?
            	<div class="hidden">
                	在JD TB买面包纸？
                    家里闲置物品堆积入山  还不赶快清理一下
                    烈日炎炎下如何逛街
                </div>
            </div>
            <div class="down">
            	<p>APP下载</p>
                 <a href="<?php echo $ios_app;?>" title="苹果端"><img src="media/image/ico_Iphone.png"></a>
                 <a href="<?php echo $android_app;?>" title="安卓端"><img src="media/image/ico_Android.png"></a>
            </div>
        </div>
        <div class="fr goods">
        	<div class="ga clock "><i href="javascript:void(0);" class="icon-clock clock_fi"></i></div>
            <div class="ga pen"><i href="javascript:void(0);" class="icon-pen pen_fi"></i></div>
            <div class="ga gift"><i href="javascript:void(0);" class="icon-gift gift_fi"></i></div>
            <div class="ga food"><i href="javascript:void(0);" class="icon-food food_fi"></i></div>
            <div class="ga t-shirt"><i href="javascript:void(0);" class="icon-t-shirt t-shirt_fi"></i></div>
            <div class="ga cup"><i href="javascript:void(0);" class="icon-cup cup_fi"></i></div>
    	</div>
    </div>
    <footer>
    Copyright© 2011-2014 赏金猎人版权所有&nbsp;&nbsp;&nbsp;备案号：蜀ICP备12025757号-2   &nbsp;&nbsp;&nbsp;客服电话：4000-858599
    </footer>
</body>
<?php if($type=='weixin'){?>
<div id="pop_up" style="cursor: pointer;" onclick="closePop()"><img src="media/image/popup.png"/></div>
<script type="text/javascript"> 
function openPop(){
    $("#pop_up").show();
}
function closePop(){
    $("#pop_up").hide();
}
</script>
<?php }?>
</html>
