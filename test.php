<?php
// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
define('THINK_PATH','./ThinkPHP/');    //定义ThinkPHP框架路径（相对于入口文件）
define('APP_NAME','scientificItem');                    //定义项目名称
//define('APP_PATH','.');                                 //定义项目路径
require("./ThinkPHP/ThinkPHP.php");                    //加载框架入口文件
?>