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
	<div class="title">我的二手物品——<span>修改物品信息</span></div>
	<div class="top-button">
		修改物品分类：<select id="category">
			<option value="0">未分类</option>
			<?php if(is_array($category)): foreach($category as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(($v["id"]) == $cid): ?>selected<?php endif; ?>><?php echo str_repeat('— ',$v['level']); echo ($v["name"]); ?></option><?php endforeach; endif; ?>
		</select>
		<a href="<?php echo U('User/Goods',array('cid'=>$cid,'p'=>$p));?>" class="light">返回物品列表</a>
	</div>
	<?php if(isset($success)): ?><div class="mssage">修改成功。</div><?php endif; ?>
	<div class="list auto">
		<form method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo ($goods["id"]); ?>">
		<table class="t2 t4">
			<tr><th>物品名称：</th><td><input type="text" name="name" value="<?php echo ($goods["name"]); ?>" class="big"></td></tr>
			<tr><th>物品价格：</th><td><input type="text" name="price" value="<?php echo ($goods["price"]); ?>" class="small"></td></tr>
			<tr><th>是否出售：</th><td><select name="on_sale">
				<option value="yes" <?php if(($goods["on_sale"]) == "yes"): ?>selected<?php endif; ?>>是</option>
					<option value="no" <?php if(($goods["on_sale"]) == "no"): ?>selected<?php endif; ?>>否</option>
			</select></td></tr>
			<tr><th>修改图片：</th><td><input type="file" name="thumb" /></td></tr>
			<tr><th>当前图片：</th><td>
				<?php if(empty($goods["thumb"])): ?><img src="/Public/Common/img/preview.jpg">
				<?php else: ?>
					<img src="/Public/Uploads/small/<?php echo ($goods["thumb"]); ?>"><?php endif; ?>
			</td></tr>
		</table>
		<div class="editor">
			<link href="/Public/Home/js/umeditor/themes/default/css/umeditor.min.css" rel="stylesheet">
<script src="/Public/Home/js/umeditor/umeditor.config.js"></script>
<script src="/Public/Home/js/umeditor/umeditor.min.js"></script>
<script>
	$(function(){
		//载入在线编辑器
		UM.getEditor("myEditor",{
		"imageUrl":"<?php echo U('Goods/uploadImage');?>", //图片上传提交地址
		"imagePath":"/Public/Uploads/desc/"  //图片显示地址
		});
	});
</script>
			<script type="text/plain" id="myEditor" name="desc"><?php echo ($goods["desc"]); ?></script>
		</div>
		<div class="btn">
			<input type="submit" value="保存修改">
			<input type="submit" value="修改并返回" name="return">
		</div>
		</form>
	</div>
</div>
</div>
<script>
	//下拉菜单跳转
	$("#category").change(function(){
		var url = "<?php echo U('User/editGoods',array('id'=>$id,'cid'=>'_ID_','p'=>$p));?>";
		location.href = url.replace("_ID_",$(this).val());
	});
</script>
</div>
</body>
</html>