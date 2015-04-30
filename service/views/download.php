<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content=""/>
<meta name="author" content=""/>
<script src="<?php echo BIBI_PATH;?>js/jquery.js" type="text/javascript"></script>
<style>

* {
	margin:0;
	padding:0;
}
body {
	margin:0;
	padding:0;
	font:14px/23px Arial, Microsoft YaHei, Simsun;
	color:#333;
	background:url(<?php echo BIBI_PATH;?>image/bj.jpg) repeat-x;)
}
html, body, div, span, applet, object, h1, h2, h3, h4, h5, h6, iframe, blockquote, pre, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dd, dl, dt, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, ul, li, p {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
}
ol, ul, li {
	list-style: none;padding:0;margin:0;}


.clearfix:after { 
	content:"\200B"; 
	display:block; 
	height:0; 
	clear:both;} 
.clearfix {*zoom:1;}/*IE/7/6*/ 
.fl{
	float:left;}
	
.fr{
	float:right;}

/*内容开始*/         
.setting{
	background:#edecec; min-width:320px !important; max-width:1080px !important; margin:0 auto; overflow:hidden;}
.body{
	width:96%; padding:10% 2%; /*background:url(bg.png) no-repeat -60% 3%;*/ position:relative;}
	
.setting .bg{
	width:52%; position:absolute; top:6%; z-index:-1;}
	
.mobile{
	width:50%; display:block;}
	
.button{
	width:50%; display:block;}
	
#iphone,#android{
	width:95%; height:40px; border:#d4d1d1 2px solid; border-radius:8px; display:block; line-height:40px; text-align:center; margin-bottom:20%; vertical-align:bottom;}

	
#iphone b,#android b{
	line-height:40px; display:block;}
	
#iphone img,#android img{
	margin-top:5px; margin-right:5px; vertical-align:top;}
	

#iphone{color:#333; margin-top:50%;}
#android{ color:#ec6759;}
p{
	padding:2%;}
	
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
<body class="setting">
    <img class="bg" src="<?php echo BIBI_PATH;?>image/bg.png"/>
	<div class="body clearfix">
    	<div class="fl mobile"><img src="<?php echo BIBI_PATH;?>image/mobile.png"/></div>
        <div class="fr button">
        	<a id="iphone" href="<?php echo $ios_app;?>"><b><img src="<?php echo BIBI_PATH;?>image/inphone.png"/>苹果下载</b></a>
            <a id="android" href="<?php echo $android_app;?>"><b><img src="<?php echo BIBI_PATH;?>image/android.png"/>安卓下载</b></a>
        </div>
    </div>
    <p>
    <!--b>邻售是一款提供周边商品发布及交流的平台</b><br/-->
    iphone6来了，iphone4怎么办？<br/>
    开个小店，人流量不高怎么办？<br/>
    <!--想在附近买点生活用品，不想走路咋办？<br/>-->
    邻售发现身边价值物品，尽享便捷购物乐趣。<br/>
    </p>
</body>
<?php if($type=='weixin'){?>
<div id="pop_up" style="cursor: pointer;" onclick="closePop()"><img src="<?php echo BIBI_PATH;?>image/popup.png"/></div>
<?php }?>

<script type="text/javascript"> 
function openPop(){
    $("#pop_up").show();
}
function closePop(){
    $("#pop_up").hide();
}
</script>   
</html>