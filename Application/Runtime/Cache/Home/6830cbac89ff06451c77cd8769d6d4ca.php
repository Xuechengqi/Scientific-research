<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title><?php echo ($title); ?></title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Home/css/style.css"/>
	<script src="/Public/Common/js/jquery-1.12.1.min.js"></script>
</head>
<body>
<div class="top">
	<div class="top-nav">
	<ul class="right">
		<?php if(isset($userinfo["id"])): ?><li><?php echo ($userinfo["name"]); ?>，欢迎来到二手发布网！[<a href="<?php echo U('User/logout');?>">退出</a>]<li>
		<?php else: ?>
		<li>您好，欢迎来到二手发布网！[<a href="<?php echo U('User/login');?>">登录</a>][<a href="<?php echo U('User/register');?>">免费注册</a>]</li><?php endif; ?>
		<li class="line">|</li><li><a href="<?php echo U('User/index');?>">会员中心</a></li>
	</ul>
	</div>
</div>
<div class="box">
	<div class="header">
		<a class="left" href="/index.php/"><div class="logo"></div></a>
		<form action="<?php echo U('Common/find');?>" method="GET" class="search left">
			<div>
				<input type="text" class="left" name="info" />
				<input class="search-btn" type="submit" value="搜索" />
			</div>
		</form>
		<div class="info left">
			<input type="button" value="会员中心" onclick="location.href='<?php echo U('User/index');?>'" />
		</div>
	</div>
	<div class="nav">
		<ul><li id="Index_find"><a class="category" href="<?php echo U('Index/find');?>">全部物品分类</a></li><li id="Index_index"><a href="/index.php/">首页</a></li>
		</ul>
	</div>
<div class="usercenter">
<div class="menu">
	<div class="menu-photo">
		<?php if(empty($user["avatar"])): ?><img src="/Public/Home/img/avatar.png" alt="用户头像">
		<?php else: ?>
			<img src="/Public/Uploads/headimg/<?php echo ($user["avatar"]); ?>"><?php endif; ?>
	</div>
	<dl><dt>物品管理</dt>
		<dd><a href="<?php echo U('User/goods');?>">我的二手物品</a></dd>
		<dd><a href="">我的收藏</a></dd>
		<dd>评价管理</dd>
	</dl>
	<dl><dt>我的账户</dt>
		<dd><a href="<?php echo U('User/info');?>">个人信息修改</a></dd>
		<dd><a href="<?php echo U('User/changePwd');?>">密码修改</a></dd>
	</dl>
</div>
<div class="content">
		<div class="title">个人资料</div>
		<div class="showinfo">
			<p>您好，欢迎来到会员中心！</p>
			<p>请从左侧选择一个操作。</p>
			<p>用户名：<?php echo ($user["username"]); ?></p>
			<p>电话号码：<?php echo ($user["phone"]); ?></p>
			<p>email：<?php echo ($user["email"]); ?></p>
		</div>
</div>
</div>
</div>
</body>
</html>