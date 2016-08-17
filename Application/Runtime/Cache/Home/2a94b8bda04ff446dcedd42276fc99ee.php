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
		<div class="search left">
			<input type="text" class="left" />
			<input class="search-btn" type="button" value="搜索" />
		</div>
		<div class="info left">
			<input type="button" value="会员中心" onclick="location.href='<?php echo U('User/index');?>'" />
		</div>
	</div>
	<div class="nav">
		<ul><li id="Index_find"><a class="category" href="<?php echo U('Index/find');?>">全部物品分类</a></li><li id="Index_index"><a href="/index.php/">首页</a></li>
		</ul>
	</div>
<!--分类左栏-->
<div class="slide">
<?php if(is_array($category)): $i = 0; $__LIST__ = array_slice($category,0,8,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><div class="cate">
	<div class="subcate left"><a href="<?php echo U('Index/find',array('cid'=>$v1['id']));?>"><?php echo ($v1["name"]); ?></a></div>
	<div class="subitem" style="display:none;">
		<?php if(isset($v1["child"])): if(is_array($v1["child"])): foreach($v1["child"] as $key=>$v2): ?><dl><dt><a href="<?php echo U('Index/find',array('cid'=>$v2['id']));?>"><?php echo ($v2["name"]); ?></a></dt><dd><?php if(isset($v2["child"])): if(is_array($v2["child"])): foreach($v2["child"] as $key=>$v3): ?><a href="<?php echo U('Index/find',array('cid'=>$v3['id']));?>"><?php echo ($v3["name"]); ?></a><?php endforeach; endif; endif; ?></dd></dl><?php endforeach; endif; endif; ?>
	</div>
</div><?php endforeach; endif; else: echo "" ;endif; ?><div class="clear"></div>
</div>
<script>
	$(".cate").hover(function(){
		$(this).find(".subitem").show();
		$(this).children(".subcate").children("a").addClass("on");
	},function(){
		$(this).find(".subitem").hide();
		$(this).children(".subcate").children("a").removeClass("on");
	});
</script>
<!--热点图-->
<div class="hot left" id="hot">
	<div class="num"><a class="curr"></a><a></a><a></a><a></a></div>
	<ul>
		<li class="def"><a href="#"><img src="" /></a></li>
		<li><a href="#"><img src="" /></a></li>
		<li><a href="#"><img src="" /></a></li>
		<li><a href="#"><img src="" /></a></li>
	</ul>
</div>
<script src="/Public/Home/js/slideBox.js"></script>
<script>
	slideBox("#hot",5000);  //焦点图切换
</script>
<!--新闻列表-->
<div class="news right">最新动态</div>
<div class="clear"></div>
<!--推荐商品-->
<div class="best">
	<div class="best-title">精品推荐</div>
	<?php if(is_array($best)): foreach($best as $key=>$v): ?><ul class="item left">
		<li><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php if(empty($v["thumb"])): ?><img src="/Public/Common/img/preview.jpg"><?php else: ?><img src="/Public/Uploads/small/<?php echo ($v["thumb"]); ?>"><?php endif; ?></a></li>
		<li class="goods"><a href="<?php echo U('Index/goods',array('id'=>$v['id']));?>" target="_blank"><?php echo ($v["name"]); ?></a></li>
		<li class="seller"><a href="<?php echo U('Index/seller',array('seller'=>$v['seller_id']));?>" target="_blank"><?php echo ($v["seller_id"]); ?></a></li>
		<li class="price">￥<?php echo ($v["price"]); ?></li>
	</ul><?php endforeach; endif; ?>
</div>
<script> $("#Index_index").addClass("curr"); </script>
</div>
</body>
</html>