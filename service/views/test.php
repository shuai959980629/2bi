<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>模拟客户端系统数据</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	
	#body td{
		height:40px;
	} 
	</style>
</head>
<body>

<div id="container">
	<h1>模拟android/ios客户端提交数据</h1>

	<div id="body">
		<form action="<?php echo $url_action;?>" method="post">
		<table cellspadding="0" cellspaceing="0">
            <tr><td><label for="clients">客户端：</label><input type="radio" name="clients" id="clients" value="android" checked="checked" />android&nbsp;&nbsp;<input type="radio" name="clients" id="clients" value="ios" />ios</td></tr>
            <tr><td><label for="version">客户端版本：</label><input type="text" value="1.2.3" name="version" id="version" style="width:100px" />(*必填)</td></tr>
            <tr><td><label for="url">客户端请求接口：</label><b><?php echo 'http://' . $_SERVER['HTTP_HOST'].'/';?></b><input type="text"  name="url" id="url" style="width:300px" />(*必填)</td></tr>
            <tr><td><label for="params">JSON：</label><input type="text" name="params" id="params" style="width:600px" /></td></tr>
            <tr><td><label for="token">Token：</label><input type="text" value="706b6ef6cd8e7d048fe403d211c12047bac8485b7f6e64517d35018383ba2f046b6e1605d6f9de4282a0c03d5b60fa20c24a1da2d3d7e494432dbeeb2e0b266571460c14b6ba624ac76f1570e4e7f153ee692e622ee5c5c7b13dab4a08080f8e" name="token" id="token" style="width:700px" />((*必填：默认为uid=1的用户)</td></tr>
			<tr><td><input type="submit" name="submit" value="提交数据" /></td></tr>
		</table>
		</form>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>