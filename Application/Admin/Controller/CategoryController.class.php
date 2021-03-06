<?php
namespace Admin\Controller;
//物品分类控制器
class CategoryController extends CommonController{
    //分类列表
    public function index(){
        $data = D('Category')->getList();//获取分类数据
        $this->assign('category',$data);
        $this->display();
    }
    //添加分类
    public function add(){
        $Category = D('Category');     //实例化模型
        if(IS_POST){
            if(!$Category->create()){//创建数据对象
                $this->error('添加失败: '.$Category->getError());
            }
            if(!$Category->add()){//添加到数据库
                $this->error('添加失败：保存到数据库失败。');
            }
            //添加成功
            if(isset($_POST['return'])) $this-> redirect('Category/index');
            $this->assign('success',true);
        }
        $data = $Category->getList();    //获取分类数据
        $this->assign('category',$data);
        $this->display();
    }
    //修改分类
    public function edit(){
        $id = I('get.id/d',0);//获取待修改的分类ID，“/d”用于转换为整型
        $Category = D('Category');//实例化模型
        if(IS_POST){
            //检查父级分类是否合法
            if(in_array(I('post.pid/d'),$Category->getSubIds($id))){
                $this->error('不允许将父级分类修改为本身或子级分类。');
            }
            if(!$Category->create()){//创建数据对象
                $this->error('修改失败：'.$Category->getError());
            }
            //保存到数据库
            if(false === $Category->where(array('id'=>$id))->save()){
                $this->error('修改失败：保存到数据库失败。');
            }
            $this->redirect('Category/index');//保存成功
        }
        //根据ID查询分类信息
        $data = $Category->field('id,name,pid')->where(array('id'=>$id))->find();
        if(!$data){
            $this->error('修改失败：分类不存在');
        }
        $data['category'] = $Category->getList();//分类列表
        $this->assign($data);
        $this->display();
    }
    //删除分类
    public function del(){
        //阻止直接访问
        if(!IS_POST) $this->error('删除失败：未选择分类');
        $id = I('post.id/d',0);   //待删除分类ID
        $jump = U('Category/index');   //生成跳转地址
        $Category = M('Category');   //实例化模型
        //判断是否存在子分类
        if($Category->where(array('pid'=>$id))->getField('id')){
            $this->error('删除失败：只允许删除最底层分类！');
        }
        //检查表单令牌
        if(!$Category->autoCheckToken($_POST)){
            $this->error('表单已过期，请重新提交',$jump);
        }
        //删除分类
        if(!$Category->where(array('id'=>$id))->delete()){
            $this->error('删除分类失败',$jump);
        }
        //将该分类下的物品设置为未分类
        M('Goods')->where(array('category_id'=>$id))->save(array('category_id'=>0));
        //删除成功，跳转到分类列表
        redirect($jump);
    }
}
?>