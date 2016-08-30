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
		<form action="Common/find" method="GET" class="search left">
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
<div class="goodsinfo">
	<div class="now_cat">当前位置：
		<?php if(is_array($path)): foreach($path as $key=>$v): ?>&nbsp;<a href="<?php echo U('Index/find',array('cid'=>$v['id']));?>"><?php echo ($v["name"]); ?></a>
			&nbsp;&gt;<?php endforeach; endif; ?>&nbsp;<?php echo ($goods["name"]); ?>
	</div>
	<div class="pic left">
		<?php if(empty($goods["thumb"])): ?><img src="/Public/Common/img/preview.jpg" alt=""><?php else: ?><img src="/Public/Uploads/big/<?php echo ($goods["thumb"]); ?>" alt=""><?php endif; ?>
	</div>
	<div class="info left">
		<h1><?php echo ($goods["name"]); ?></h1>
		<table>
			<tr>
				<th>售 价：</th>
				<td><span class="price">￥<?php echo ($goods["price"]); ?></span></td>
			</tr>
			<tr>
				<th>发布时间：</th>
				<td><?php echo ($goods["publish_time"]); ?></td>
			</tr>
			<tr>
				<th>发布人：</th>
				<td>
					<?php if(empty($goods["seller_id"])): ?>不合法<?php else: echo ($user["username"]); endif; ?>
				</td>
			</tr>
			<tr>
				<th>联系电话：</th>
				<td>
					<?php echo ($user["phone"]); ?>
				</td>
			</tr>
			<tr>
				<th>邮箱：</th>
				<td>
					<?php echo ($user["email"]); ?>
				</td>
			</tr>
		</table>
	</div>
	<div class="clear"></div>
	<div class="goods-slide left">
		<div class="title">相关物品推荐</div>
		<?php if(is_array($recommend)): foreach($recommend as $key=>$v): ?><ul>
				<li></li>
			</ul><?php endforeach; endif; ?>
	</div>
	<div class="desc left">
		<div class="title">物品详情</div>
		<div class="content"><?php echo ($goods["desc"]); ?></div>
	</div>
	<div class="clear"></div>
</div>
<script>
//导航条选中效果
$("#Index_find").addClass("category-curr");
</script>
</div>
</body>
</html>