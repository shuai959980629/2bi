<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邻售官网</title>
<link href="<?php echo BIBI_PATH;?>css/home.css" type="text/css" rel="stylesheet" />
</head>

<body>
    <div class="help">
    	<ul>
            <?php foreach($help as $key=>$vals){?>
            <li><span><b></b><?php echo $key;?></span>
            	<ul class="minute">
                    <?php foreach($vals as $item=>$val){?>
                	<li><a href="/help/infor?h=<?php echo $item;?>"><b></b><?php echo $val;?></a></li>
                    <?php }?>
                </ul>
            </li>
            <?php }?>
        </ul>		
    </div>
</body>
</html>



