<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
    //表单字段过滤
    protected $insertFields = 'name,price,on_sale,recommend';
    protected $updateFields = 'name,price,on_sale,recommend';
    //自动验证
    protected $_validate = array(
        array('name','1,40','物品名称不合法（1-40个字符）',1,'length'),
        array('price','0.01,100000','物品价格输入不合法（0.01-100000）',1,'between'),
        array('on_sale',array('yes','no'),'出售状态输入不合法',1,'in'),
        array('recommend',array('yes','no'),'推荐状态输入不合法',1,'in'),
    );
    //根据$where条件删除物品预览图文件
    public function delThumbFile($where){
        //取出原图文件名
        $thumb = $this->where($where)->getField('thumb');
        if(!$thumb) return ;   //物品图片不存在时直接返回
        $path = "./Public/Uploads/big/$thumb";   //准备大图目录
        if(is_file($path)) unlink($path);    //删除大图文件
        $path = './Public/Uploads/small/$thumb';    //准备小图目录
        if(is_file($path)) unlink($path);    //删除小图文件
    }
    /**
    * 物品列表
    * @param string $type 数据用途(物品列表或回收站列表)
    * @param array|int $cids 分类ID数组
    * @param int $p 当前页码
    * @return array 查询结果
    */
    public function getList($type = 'goods', $cids = 0, $p = 0){
        //准备查询条件
        $order = 'g.id desc';   //排序条件
        $field = 'c.name as category_name,g.category_id,g.id,g.name,g.on_sale,g.publish_time,u.username as user_name,g.seller_id,g.recommend';
        if($type == 'goods'){   //物品列表页取数据时
            $where = array('g.recycle' => 'no');
        }elseif($type == 'recycle'){//物品回收站取数据时
            $where = array('g.recycle' => 'yes');
        }
        //cids=0查找未分类物品，cid>0查找分类ID数组物品，cid<0查找全部物品
        if($cids == 0){    //查找未分类的物品
            $where['g.category_id'] = 0;
        }elseif($cids > 0){//查找分类ID数组
            $where['g.category_id'] = array('in',$cids);
        }
        //准备分页查询
        $pagesize = C('USER_CONFIG.pagesize');//每页显示物品数
        $count = $this->alias('g')->where($where)->count();
        $Page = new \Think\Page($count,$pagesize);//实例化分页类
        $this->_customPage($Page);//定制分页类样式
        //查询数据
        $data = $this->alias('g')->join('__CATEGORY__ AS c ON c.id = g.category_id','LEFT')->join('__USER__ AS u ON u.id = g.seller_id','LEFT')->field($field)->where($where)->order($order)->page($p,$pagesize)->select();
        //返回结果
        return array(
            'data' => $data,         //物品列表数组
            'pagelist' => $Page->show(),//分页链接HTML
        );
    }
    //定制分页类样式
    private function _customPage($Page){
        $Page->lastSuffix = false;
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('first','首页');
        $Page->setConfig('last','尾页');
    }
}
?>