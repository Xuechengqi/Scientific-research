<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model{
	//获取物品列表
	public function getList($cids=0,$p=0){
		$field = 'category_id,id,name,price,thumb';
		$where = array('recycle'=>'no','on_sale'=>'yes');
		if($cids > 0){
			$where['category_id'] = array('in',$cids);
		}
		$price_max = $this->where($where)->max('price');
		$recommend = $this->getRecommend($where);
		//处理排序条件
		$order = 'id desc';
		$allow_order = array('price-desc'=>'price desc','price-asc'=>'price asc');
		$input_order = I('get.order');
		if(isset($allow_order[$input_order])) $order = $allow_order[$input_order];
		//处理价格条件
		$price = explode('-',I('get.price'));
		if(count($price)==2){
			$where['price'] = array(
				array('EGT',(int)$price[0]),//大于等于
				array('ELT',(int)$price[1]),//小于等于
			);
		}
		//准备分页查询
		$pagesize = C('USER_CONFIG.pagesize');
		$count = $this->where($where)->count();
		$Page = new \Think\Page($count,$pagesize);
		//查询物品数据
		$data = $this->field($field)->where($where)->order($order)->page($p,$pagesize)->select();
		//返回结果
		return array(
			'data' => $data,
			'price' => $this->getPriceDist($price_max),//计算物品价格
			'recommend' => $recommend, //被推荐物品
			'pagelist' => $Page->show(),//分页链接HTML
		);
	}
	//取出推荐物品
	public function getRecommend($where){
		$where['recommend'] = 'yes';//查询被推荐的物品
		$field = 'id,name,price,thumb';
		return $this->field($field)->where($where)->limit(6)->select();
	}
	//动态计算价格
	private function getPriceDist($max,$sum=5){
		if($max<=0) return false;
		$end = $size = ceil($max / $sum);
		$start = 0;
		$rst = array();
		for($i=0;$i < $sum;$i ++){
			$rst[] = "$start-$end";
			$start = $end + 1;
			$end += $size;
		}
		return $rst;
	}
}
?>