<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邻售官网</title>
<link href="<?php echo BIBI_PATH;?>css/home.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <div class="particular">   	
        <?php for($i=0;$i<count($content);$i++){?>
               <p> <?php echo $content[$i];?></p>
        <?php }?>	
    </div>
    <div style="height: 10px; width: 100%;"></div>
    <div style="margin: 0 auto; text-align: center;"><a  style="display:block;" href="javascript:history.back(-1);">返回上一页</a></div>
</body>
</html>