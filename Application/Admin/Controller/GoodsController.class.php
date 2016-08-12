<?php
namespace Admin\Controller;
//物品信息控制器
class GoodsController extends CommonController{
    //物品列表
    public function index(){
        $p = I('get.p/d',0);    //当前页码
        $cid = I('get.cid/d',-1);  //分类ID(0表示未分类，-1表示全部分类)
        $Goods = D('Goods');    //实例化物品模型
        $Category = D('Category');  //实例化分类模型
        //如果分类ID大于0，则取出所有子分类ID
        $cids = ($cid>0) ? $Category->getSubIds($cid) : $cid;
        //获取物品列表
        $data['goods'] = $Goods->getList('goods',$cids,$p);
        //防止空页被访问
        if(empty($data['goods']['data']) && $p > 0){
            $this->redirect('Goods/index',array('cid'=>$cid));
        }
        //查询分类列表
        $data['category'] = $Category->getList();
        $data['cid'] = $cid;
        $data['p'] = $p;
        $this->assign($data);
        $this->display();
    }
    //物品添加
    public function add(){
        $cid = I('get.cid/d',0);    //分类ID
        if($cid < 0) $cid = 0;      //防止分类ID为负数
        $Category = D('Category');  //实例化分类模型
        $Goods = D('Goods');        //实例化物品模型
        if(IS_POST){
            if(!$Goods->create()){  //创建数据对象
                $this->error('添加物品失败：'.$Goods->getError());
            }
            //处理特殊字段
            $Goods->category_id = $cid;    //物品分类
            $Goods->thumb = '';            //物品预览图
            $Goods->desc = I('post.desc','','htmlpurifier');//物品描述（过滤）
            //如果有图片上传，则上传并生成预览图
            if(!empty($_FILES['thumb']['tmp_name'])){
                $rst = $Goods->uploadThumb();    //上传并生成预览图
                if(!$rst['flag']){    //判断是否上传成功
                    $this->error('上传图片失败：'.$rst['error']);
                }
                $Goods->thumb = $rst['path'];    //上传成功，保存文件路径
            }
            if(!$Goods->add()){    //添加到数据库
                $this->error('添加物品失败！');
            }
            //添加物品成功
            if(isset($_POST['return'])) $this->redirect('Goods/index');
            $this->assign('success',true);
        }
        //查询分类列表
        $data['category'] = $Category->getList();
        $data['cid'] = $cid;
        $this->assign($data);
        $this->display();
    }
}
?>