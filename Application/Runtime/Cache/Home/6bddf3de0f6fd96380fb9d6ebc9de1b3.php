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
		<dd>密码修改</dd>
	</dl>
</div>
<div class="content">
		<div class="title">我的二手物品</div>
		<a href="<?php echo U('User/add');?>" class="light"><input type="button" value="添加商品" /></a>
		<div class="list full">
			<table>
				<tr><th class="t1" width="120">商品分类</th><th width="120">商品名称</th><th width="120">发布时间</th><th width="120">价格</th><th width="120">是否出售</th><th width="120">操作</th></tr>
				<?php if(is_array($goods["data"])): foreach($goods["data"] as $key=>$v): ?><tr><td class="t1">
						<?php if(empty($v["category_id"])): ?>未分类
						<?php else: ?>
							<?php echo ($v["category_name"]); endif; ?>
					</td>
					<td><?php echo ($v["name"]); ?></td>
					<td><?php echo ($v["publish_time"]); ?></td>
					<td><?php echo ($v["price"]); ?></td>
					<td><a href="#" class="act-onsale" data-id="<?php echo ($v["id"]); ?>" data-status="<?php echo ($v["on_sale"]); ?>"><?php if(($v["on_sale"]) == "yes"): ?>是<?php else: ?>否<?php endif; ?></a></td><td>
					<a href="<?php echo U('User/editGoods',array('id'=>$v['id'],'cid'=>$v['category_id'],'p'=>$p));?>">修改</a>　<a href="#" class="act-del" data-id="<?php echo ($v["id"]); ?>">删除</a></td></tr><?php endforeach; endif; ?>
			</table>
		</div>
		<div class="pagelist"><?php echo ($goods["pagelist"]); ?></div>
		<form method="post" id="form">
			<input type="hidden" name="id" id="target_id">
			<input type="hidden" name="field" id="target_field">
			<input type="hidden" name="status" id="target_status">
		</form>
		</div>
</div>
<script>
	//快捷操作
	function change_status(obj,field){
		$("#target_id").val(obj.attr("data-id"));
		$("#target_field").attr("value",field)
		$("#target_status").attr("value",(obj.attr("data-status")=="yes") ? "no" : "yes");
		$("#form").attr("action","<?php echo U('User/change',array('p'=>$p,'cid'=>$cid));?>").submit();
	}
	//快捷操作-上架
	$(".act-onsale").click(function(){
		change_status($(this),'on_sale');
	});
	//快捷操作-删除
	$(".act-del").click(function(){
		if(confirm('确定要删除吗？')){
			$("#target_id").val($(this).attr("data-id"));
			$("#form").attr("action","<?php echo U('User/del',array('p'=>$p,'cid'=>$cid));?>").submit();
		}
	});
</script>
</div>
</body>
</html>