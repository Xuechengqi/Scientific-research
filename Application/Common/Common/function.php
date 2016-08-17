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
//按父子关系转换分类为多维数组
function category_tree($data,$pid=0,$level=0){
    $temp = $rst = array();
    foreach($data as $v) $temp[$v['id']] = $v;
    foreach($temp as $v){
        if(isset($temp[$v['pid']])){
            $temp[$v['pid']]['child'][] = &$temp[$v['id']];
        }else{
            $rst[] = &$temp[$v['id']];
        }
    }
    return $rst;
}
//查找分类的家谱
function category_family($data,$id){
    $rst = category_parent($data,$id);
    foreach(array_reverse($rst['pids']) as $v){
        foreach($data as $vv){
            ($vv['pid']==$v) && $rst['parent'][$v][] = $vv;
        }
    }
    return $rst;
}
//根据任意分类ID查找父分类（包括自己）
function category_parent($data,$id=0){
    $rst = array('pcat'=>array(),'pids'=>array($id));
    for($i=0;$id && $i<10;++ $i){
        foreach($data as $v){
            if($v['id'] == $id){
                $rst['pcat'][] = $v;  //父分类
                $rst['pids'][] = $id = $v['pid'];//父分类ID
            }
        }
    }
    return $rst;
}