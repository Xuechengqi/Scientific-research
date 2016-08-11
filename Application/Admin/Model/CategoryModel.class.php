<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
    //表单自动验证
    protected $_validate = array(
        array('pid','require','父级分类不能为空',self::MUST_VALIDATE),
        array('name','require','分类名不能为空',self::MUST_VALIDATE),
    );
    //自动完成
    protected $_auto = array(
        //pid字段最小为0，不能为负数
        array('pid','max',self::MODEL_BOTH,'function',0),
    );
    //查询分类数据
    private function getData(){
        static $data = null;//缓存查询结果
        if(!$data) $data = $this->field('id,name,pid')->select();
        return $data;
    }
    //获取分类列表
    public function getList(){
        category_list($this->getData(),$data);//父子关系整理
        return $data;
    }
    //查询某一分类ID的所有子级ID，返回的数组结果中包含本身的ID
    public function getSubIds($id){
        $data = array($id);//将ID自身放入数组头部
        category_child($this->getData(),$data,$id);
        return $data;
    }
}
?>