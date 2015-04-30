<html>
<head><title>模拟客户端系统数据</title></head>
<body>

<form action="<?php echo $url_action;?>" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="attachment" id="attachment" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>