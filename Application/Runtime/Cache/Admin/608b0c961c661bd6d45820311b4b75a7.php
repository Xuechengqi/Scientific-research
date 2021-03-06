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
		<div class="item"><div class="title">修改物品</div>
<div class="top-button">
	修改物品分类：<select id="category">
		<option value="0">未分类</option>
		<option value="14" >图书</option><option value="15" >— 音像</option><option value="62" >— — 音乐</option><option value="63" >— — 影视</option><option value="64" >— — 游戏</option><option value="16" >— IT类</option><option value="17" selected>— — PHP书籍</option><option value="18" >— — JAVA书籍</option><option value="19" >— — MySQL书籍</option><option value="34" >— — C语言书籍</option><option value="49" >— — 网页书籍</option><option value="35" >— 少儿</option><option value="36" >— — 少儿英语</option><option value="37" >— — 少儿文学</option><option value="38" >— 管理</option><option value="39" >— — 经济</option><option value="40" >— — 金融</option><option value="41" >— — 投资</option><option value="42" >— 生活</option><option value="43" >— — 旅游</option><option value="44" >— — 运动</option><option value="45" >— 艺术</option><option value="46" >— — 摄影</option><option value="47" >— — 设计</option><option value="48" >— — 绘画</option><option value="54" >家具</option><option value="55" >手机</option><option value="56" >服装</option><option value="57" >家用电器</option><option value="58" >电脑、办公</option><option value="59" >运动户外</option><option value="60" >家具、厨具</option>	</select>
	<a href="/Admin/Goods/index/cid/17/p/2.html" class="light">返回物品列表</a>
</div>
<div class="list auto">
	<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="45">
	<table class="t2 t4">
		<tr><th>物品名称：</th><td><input type="text" name="name" value="PHP网站开发实例教程" class="big"></td></tr>
		<tr><th>物品编号：</th><td><input type="text" name="sn" value="111" ></td></tr>
		<tr><th>物品价格：</th><td><input type="text" name="price" value="45" class="small"></td></tr>
		<tr><th>物品库存：</th><td><input type="text" name="stock" value="106" class="small"></td></tr>
		<tr><th>是否上架：</th><td><select name="on_sale">
			<option value="yes" selected>是</option>
				<option value="no" >否</option>
		</select></td></tr>
		<tr><th>首页推荐：</th><td><select name="recommend">
			<option value="yes" selected>是</option>
			<option value="no" >否</option>
		</select></td></tr>
		<tr><th>修改图片：</th><td><input type="file" name="thumb" /></td></tr>
		<tr><th>当前图片：</th><td>
							<img src="">		</td></tr>
	</table>
	<div class="editor">
		<link href="/Public/Admin/js/umeditor/themes/default/css/umeditor.min.css" rel="stylesheet">
<script src="/Public/Admin/js/umeditor/umeditor.config.js"></script>
<script src="/Public/Admin/js/umeditor/umeditor.min.js"></script>
<script>
	$(function(){
		//载入在线编辑器
		UM.getEditor("myEditor",{
		"imageUrl":"/Admin/Goods/uploadImage.html", //图片上传提交地址
		"imagePath":"./Public/Uploads/desc/"  //图片显示地址
		});
	});
</script>
		<script type="text/plain" id="myEditor" name="desc"><p class="nr" style="border:medium none;margin:0px;padding:0px;text-indent:28px;line-height:28px;color:rgb(88,88,88);font-family:arial, sans-serif;font-size:14px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;text-transform:none;white-space:normal;word-spacing:0px;"><span style="background-color:rgb(255,255,255);">PHP是一种运行于服务器端并完全跨平台的嵌入式脚本编程语言，是目前开发各类Web应用的主流语言之一。《PHP网站开发实例教程》就是面向初学者推出的一本案例驱动式教材，通过丰富实用的案例，全面讲解了PHP网站的开发技术。</span></p><p class="nr" style="border:medium none;margin:0px;padding:0px;text-indent:28px;line-height:28px;color:rgb(88,88,88);font-family:arial, sans-serif;font-size:14px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;text-transform:none;white-space:normal;word-spacing:0px;"><span style="background-color:rgb(255,255,255);">全书共9章，第1章讲解PHP开发环境搭建，通过部署网站的方式，让初学者了解基于PHP和MySQL的成熟开源项目的运行过程，第2章以趣味的案例学习PHP语法基础，第3章通过开发企业员工管理系统来学习PHP的数据库操作，第4通过用户登录注册、表单验证、保存用户资料、保存浏览历史、保存登录状态等案例学习Web表单与会话，第5章通过验证码、头像上传、缩略图、图片水印、文件管理器、在线网盘等案例来学习文件与图像技术，然后第6～8章通过常用类库封装、文章管理系统、学生管理系统等实用案例学习面向对象编程、PDO和ThinkPHP框架，最后一章通过开发实战项目——电子商城网站，综合运用本书所学的知识，让读者迅速积累项目开发经验。</span></p><p class="nr" style="border:medium none;margin:0px;padding:0px;text-indent:28px;line-height:28px;color:rgb(88,88,88);font-family:arial, sans-serif;font-size:14px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;text-transform:none;white-space:normal;word-spacing:0px;"><span style="background-color:rgb(255,255,255);">本书附有配套视频、源代码、习题、教学课件等资源，而且为了帮助初学者更好地学习本书讲解的内容，还提供了在线答疑，希望得到更多读者的关注。</span></p><p class="nr" style="border:medium none;margin:0px;padding:0px;text-indent:28px;line-height:28px;color:rgb(88,88,88);font-family:arial, sans-serif;font-size:14px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;text-transform:none;white-space:normal;word-spacing:0px;"><span style="background-color:rgb(255,255,255);">本书适合作为高等院校计算机相关专业程序设计或者Web项目开发的教材，也可作为PHP进阶提高的培训教材，是一本适合广大计算机编程爱好者的优秀读物。</span></p></script>
	</div>
	<div class="btn">
		<input type="submit" value="保存修改">
		<input type="submit" value="修改并返回" name="return">
	</div>
	</form>
</div>
<script>
	//下拉菜单跳转
	$("#category").change(function(){
		var url = "/Admin/Goods/edit/id/45/cid/_ID_/p/2.html";
		location.href = url.replace("_ID_",$(this).val());
	});
</script></div>
	</div>
</div>
<script>
	$("#<?php echo (CONTROLLER_NAME); ?>_<?php echo (ACTION_NAME); ?>").addClass("curr");
</script>
</body>
</html>