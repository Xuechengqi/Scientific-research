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
<div class="find">
<div class="find-left left"><div class="title">相关物品推荐</div>
	<?php if(is_array($goods_2["recommend"])): foreach($goods_2["recommend"] as $key=>$v): ?><ul class="item left">
			<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg" alt=""><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>" alt=""><?php endif; ?></a></li>
			<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
			<li class="price">￥<?php echo ($v["price"]); ?></li>
		</ul><?php endforeach; endif; ?>
</div>
<div class="find-right left">
	<div class="find-item">
		<?php if(empty($goods_1["data"])): ?><div class="empty-tip">没有更多您需要的商品。</div>
		<?php else: ?>
		<?php if(is_array($goods_1["data"])): foreach($goods_1["data"] as $key=>$v): ?><ul class="item left">
			<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
			<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
			<li class="seller"><?php echo ($v["seller_name"]); ?></li>
			<li class="price">￥<?php echo ($v["price"]); ?></li>
		</ul><?php endforeach; endif; ?>
		<div class="clear"></div><?php endif; ?>
		<?php if(empty($goods_2["data"])): ?><div class="empty-tip">没有找到您需要的相关商品。</div>
		<?php else: ?>
		<?php if(is_array($goods_2["data"])): foreach($goods_2["data"] as $key=>$v): ?><ul class="item left">
			<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
			<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
			<li class="seller"><?php echo ($v["user_name"]); ?></li>
			<li class="price">￥<?php echo ($v["price"]); ?></li>
		</ul><?php endforeach; endif; ?>
		<div class="clear"></div>
		<div class="pagelist"><?php echo ($data["pagelist"]); ?></div><?php endif; ?>
	</div>
</div>
</div>
</div>
</body>
</html>