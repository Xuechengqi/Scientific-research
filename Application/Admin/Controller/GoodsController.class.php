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
    /*public function add(){
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
    }*/
    //删除物品（放入回收站）
    public function del(){
        //阻止直接访问
        if(!IS_POST) $this->error('删除失败：未选择物品');
        $id = I('post.id/d',0);//待删除物品ID
        $p = I('get.p/d',0);//当前页码
        $cid = I('get.cid/d',0);//分类ID
        //生成跳转地址
        $jump = U('Goods/index',array('cid'=>$cid,'p'=>$p));
        //实例化模型
        $Goods = M('Goods');
        //检查表单令牌
        if(!$Goods->autoCheckToken($_POST)){
            $this->error('表单已过期，请重新提交',$jump);
        }
        //将物品放入回收站
        if(false === $Goods->where(array('id'=>$id))->save(array('recycle'=>'yes'))){
            $this->error('删除物品失败',$jump);
        }
        redirect($jump);//删除成功，跳转到物品列表
    }
    //物品列表快捷修改
    public function change(){
        //阻止直接访问
        if(!IS_POST) $this->error('操作失败：未选择物品');
        //获取参数
        $cid = I('get.cid/d',0);
        $p = I('get.p/d',0);
        $id = I('post.id/d',0);
        $field = I('post.field');
        $status = I('post.status');
        //生成跳转地址
        $jump = U('Goods/index',array('cid'=>$cid,'p'=>$p));
        //实例化模型
        $Goods = M('Goods');
        //检查输入变量
        if($field!='on_sale' && $field!='recommend'){
            $this->error('操作失败：非法字段');
        }
        if($status!='yes' && $status!='no'){
            $this->error('操作失败：非法状态值');
        }
        //检查表单令牌
        if(!$Goods->autocheckToken($_POST)){
            $this->error('表单已过期，请重新提交',$jump);
        }
        //执行操作
        if(false === $Goods->where(array('id'=>$id,'recycle'=>'no'))->save(array($field=>$status))){
            $this->error('操作失败：数据库保存失败',$jump);
        }
        redirect($jump);//操作成功，跳转
    }
}
?>