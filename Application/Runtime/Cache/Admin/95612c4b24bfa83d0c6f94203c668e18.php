<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>二手信息发布网 - 后台管理系统</title>
	<link rel="stylesheet" href="/Public/Admin/css/style.css"/>
	<script src="/Public/Common/js/jquery-1.12.1.min.js"></script>
</head>
<body>
<div class="top">
	<h1 class="left">二手信息发布网 <span>后台管理系统</span></h1>
	<ul class="right">
		<li>欢迎您：<?php echo ($admin_name); ?></li>
		<li><a href="/index.php/" target="_blank">前台首页</a></li>
		<li><a href="<?php echo U('Login/logout');?>">退出登录</a></li>
	</ul>
</div>
<div class="main">
	<div class="menu left">
		<div class="box">
			<div class="head"><i></i><div>管理菜单</div></div>
			<ul><li><a href="<?php echo U('Index/index');?>">后台首页</a></li>
				<li><a href="<?php echo U('Goods/index');?>" id="Goods_index">物品列表</a></li>
				<li><a href="<?php echo U('Category/add');?>" id="Category_add">分类添加</a></li>
				<li><a href="<?php echo U('Category/index');?>" id="Category_index">分类列表</a></li>
				<li><a href="<?php echo U('Recycle/index');?>" id="Recycle_index">回收站</a></li>
				<li><a href="<?php echo U('User/index');?>" id="User_index">会员管理</a></li>
			</ul>
		</div>
	</div>
	<div class="content">
		<div class="item"><div class="title">分类添加</div>
<div class="top-button">
	相关操作：<a href="<?php echo U('Category/index');?>" class="light">分类列表</a>
</div>
<?php if(isset($success)): ?><div class="mssage">添加成功。</div><?php endif; ?>
<div class="list auto">
	<form method="post">
	<table class="t2 t3">
		<tr><th>上级分类：</th><td>
			<select name="pid" id="category">
				<option value="0">顶级分类</option>
				<?php if(is_array($category)): foreach($category as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></option><?php endforeach; endif; ?>
			</select>
		</td></tr>
		<tr><th>分类名称：</th><td><input type="text" name="name"></td></tr>
	</table>
	<div class="btn">
		<input type="submit" value="添加分类">
		<input type="submit" value="添加并返回" name="return">
	</div>
	</form>
</div>
<?php if(isset($pid)): ?><script>$("#category").val(<?php echo ($pid); ?>);</script><?php endif; ?></div>
	</div>
</div>
<script>
	$("#<?php echo (CONTROLLER_NAME); ?>_<?php echo (ACTION_NAME); ?>").addClass("curr");
</script>
</body>
</html>