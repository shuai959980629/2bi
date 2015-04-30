<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $user['nickname']; ?></title>
    <link href="<?php echo BIBI_PATH;?>css/home.css" type="text/css" rel="stylesheet" />
    <script src="<?php echo BIBI_PATH;?>js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo BIBI_PATH;?>js/swipe.js" type="text/javascript"></script>
    <style>
    .swipe {
      overflow: hidden;
      visibility: hidden;
      position: relative;
    }
    .swipe-wrap {
      overflow: hidden;
      position: relative;
    }
    .swipe-wrap > figure {
      float:left;
      width:100%;
      position: relative;
    }
</style>
    <meta name="viewport" content="width=device-width" />   
</head>   
<body>    
   	<!--判断-->
    <input  type="hidden" value="<?php echo $plat;?>" id="plat" />
    <?php if($plat=='web'){ ?>
    <div id="ceng" class="judge">
    	<img class="judge_logo" src="<?php echo BIBI_PATH;?>image/58.png"/>
        <p class="fl"></p>
        <a class="btn" href="http://www.linshou.com">进入官网</a>
        <a class="close" href="javascript:close();"></a>
      </div>
     <?php }elseif($plat=='ios'){?>
        <!--div id="div-v" style="width:100%;height:30px;line-height:30px;color:#333; padding-left:5px; background: #edad02;border-bottom: 1px solid #FFF;">请点击右上角按钮，选择在Safari中打开！</div-->
     <?php }?>
   
    <?php if(count($cowry['img'])==1){?>
    <div class="roll">
         <ul>
            <?php foreach($cowry['img'] as $key => $value){?>
        		<li><a onclick="return false;"><img id="cimg_<?php echo $key;?>" src="<?php echo $value;?>" style="width:100%;border:none"/></a></li>
            <?php }?>
        </ul>
    </div>
    <?php }else{?>
    <div class="roll">
        <div class="swipe">
            <div class="banner swipe-wrap" id="banner_box">
                <ul>
                    <?php foreach($cowry['img'] as $key => $value){?>
                		<li><a onclick="return false;"><img id="cimg_<?php echo $key;?>"  src="<?php echo get_img_url($value,'cowry');?>" style="width:100%;border:none"></a></li>
                    <?php }?>
                </ul>
                <ol>
                    <?php for($i=0;$i<count($cowry['img']);$i++){?>
                		<?php if($i==0){?>
                		<li class="on"></li>
                		<?php }else{?>
                		<li></li>
                		<?php }?>
                    <?php }?>
                </ol>
            </div>
        </div>
    </div>
    <?php }?>
    <div class="jump">
        <p>价格：<b>￥<?php echo $cowry['price'];?></b>   库存：<b><?php echo $cowry['num'];?></b></p>
        <p>宝贝地址：<?php echo $cowry['address'];?></p>
        <pre style="overflow:auto;word-break:keep-all;"><?php echo $cowry['description'];?></pre>
        <div class="btn clearfix"><a class="red fr" href="<?php echo $link;?>">免费下载购买</a></div>
    </div>
    
    <script type="text/javascript"> 
    var BROWSER = {};
    var USERAGENT = navigator.userAgent.toLowerCase();
    $(document).ready(function(){
       <?php if($plat!='web'){?>
       init();
       <?php }?>
    	new Swipe(document.getElementById('banner_box'), {
    		speed:500,
    		auto:3000,
    		continuous:false,
    		stopPropagation:true,
    		disableScroll: true, 
    		callback: function(){
    			var lis = $(this.element).next("ol").children();
    			lis.removeClass("on").eq(this.index).addClass("on"); 
    		}
    	});
       var plat = $("#plat").val();
       browserVersion({'ie':'msie','firefox':'','chrome':'','opera':'','safari':'','mozilla':'','webkit':'','maxthon':'','qq':'qqbrowser','weixin':'micromessenger'});
       if(!BROWSER.weixin && plat=='ios'){
            $("#div-v").hide();
       }
        
        
        
    });
    
    function browserVersion(types) {
    	var other = 1;
    	for(i in types) {
    		var v = types[i] ? types[i] : i;
    		if(USERAGENT.indexOf(v) != -1) {
    			var re = new RegExp(v + '(\\/|\\s)([\\d\\.]+)', 'ig');
    			var matches = re.exec(USERAGENT);
    			var ver = matches != null ? matches[2] : 0;
    			other = ver !== 0 && v != 'mozilla' ? 0 : other;
    		}else {
    			var ver = 0;
    		}
    		eval('BROWSER.' + i + '= ver');
    	}
    	BROWSER.other = other;
    } 
    function close(){
        $("#ceng").hide(1000);
    }
    function init(){
        var wd = document.body.clientWidth ;
        $(".roll").find('img').height(wd);   
    }
    
    </script>   
        
</body>   
</html>  



