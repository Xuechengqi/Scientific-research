<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>二手信息发布网 - 登录</title>
	<link href="/Public/Home/css/user.css" rel="stylesheet" />
	<script src="/Public/Common/js/jquery-1.12.1.min.js"></script>
</head>
<body>
<div class="box">
	<h1>二手信息发布网 - 欢迎登录</h1>
	<div class="main">
		<form method="post">
		<table class="login right">
			<tr><th>用户名：</th><td><input type="text" name="username" required /></td></tr>
			<tr><th>密码：</th><td><input type="password" name="password" required /></td></tr>
			<tr><th>验证码：</th><td><input type="text" name="verify" required  /></td></tr>
			<tr><td> </td><td><img src="<?php echo U('User/getVerify');?>" id="verify_img" title="点击刷新验证码"/></td></tr>
			<tr><td> </td><td><input class="button" type="submit" value="登　录" /></td></tr>
			<tr><td colspan="2" class="center"><a href="<?php echo U('User/register');?>">立即注册</a><a href="/index.php/">返回首页</a></td></tr>
		</table>
		</form>
		<div class="clear"></div>
	</div>
</div>
<script>
//验证码点击刷新
$(function(){
	var img = $("#verify_img");
	var src = img.attr("src")+"?";
	img.click(function(){
		img.attr("src",src+Math.random());
	});
});
</script>
</body>
</html>