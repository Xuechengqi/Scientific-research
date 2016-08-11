<?php
//获取一维数组分类列表
function category_list($data,&$rst,$pid=0,$level=0){
    foreach($data as $v){
        if($v['pid'] == $pid){
            $v['level'] = $level;//保存分类级别
            $rst[] = $v;         //保存符合条件的元素
            category_list($data,$rst,$v['id'],$level+1);
        }
    }
}
//根据任意分类ID查找子孙分类ID
function category_child($data,&$rst,$id=0){
    foreach($data as $v){
        if($v['pid'] == $id){
            $rst[] = (int)$v['id'];
            category_child($data,$rst,$v['id']);
        }
    }
}