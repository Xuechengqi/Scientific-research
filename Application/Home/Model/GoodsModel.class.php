<?php
namespace Home\Model;
use Think\Model;
class GoodsModel extends Model{
	//表单字段过滤
	protected $insertFields = 'name,price,on_sale';
	protected $updateFields = 'name,price,on_sale';
	//自动验证
	protected $_validate = array(
		array('name','1,40','物品名称不合法（1~40个字符）',1,'length'),
		array('price','0.01,100000','物品价格输入不合法（0.01~100000）',1,'between'),
		array('on_sale',array('yes','no'),'出售状态填写错误',1,'in'),
	);
	//获取物品列表（前台展示）
	public function getList($cids=0,$p=0){
		$field = 'u.username as user_name,g.category_id,g.id,g.name,g.seller_id,g.price,g.thumb';
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
		$data = $this->alias('g')->join('__USER__ AS u ON u.id=g.seller_id','LEFT')->field($field)->where($where)->order($order)->page($p,$pagesize)->select();
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
	//根据$where条件查询物品数据
	public function getGoods($where){
		//定义需要的字段
		$field = 'id,category_id,name,publish_time,price,thumb,seller_id,desc';
		return $this->field($field)->where($where)->find();
	}
	//我的二手物品列表
	public function getMyGoods($userid=0,$p = 0){
		//准备查询条件
		$order = 'g.id desc';
		$field = 'c.name as category_name,g.category_id,g.id,g.name,g.publish_time,g.price,g.on_sale';
		if($userid != 0){
			$where = array('g.seller_id'=>$userid,'g.recycle'=>'no');
		}else{
			return;
		}
		//准备分页查询
		$pagesize = C('USER_CONFIG.pagesize');
		$count = $this->alias('g')->where($where)->count();
		$Page = new \Think\Page($count,$pagesize);
		$this->_customPage($Page);
		//查询数据
		$data = $this->alias('g')->join('__CATEGORY__ AS c ON c.id=g.category_id','LEFT')->join('__USER__ AS u ON u.id=g.seller_id','LEFT')->field($field)->where($where)->order($order)->page($p,$pagesize)->select();
		//返回结果
		return array(
			'data'=>$data,
			'pagelist'=>$Page->show(),
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
	public function delThumbFile($where){
		//取出原图文件名
		$thumb = $this->where($where)->getField('thumb');
		if(!$thumb) return;
		//删除大图
		$path = "./Public/Uploads/big/$thumb";
		if(is_file($path)) unlink($path);
		//删除小图
		$path = "./Public/Uploads/small/$thumb";
		if(is_file($path)) unlink($path);
	}
	public function uploadThumb($upfile){
		//准备上传目录
		$file['temp'] = './Public/Uploads/temp/';
		file_exists($file['temp']) or mkdir($file['temp'],0777,true);//自动创建临时目录
		//上传文件
		$Upload = new \Think\Upload(array(
			'exts'=>array('jpg','jpeg','png','gif'),
			'rootPath'=>$file['temp'],
			'autoSub'=>false,//不生成子目录
		));
		if(false===($rst = $Upload->uploadOne($_FILES[$upfile]))){
			return array('flag'=>false,'error'=>$Upload->getError());
		}
		//准备生成缩略图
		$file['name'] = $rst['savename'];
		$file['save'] = date('Y-m/d/');
		$file['path1'] = './Public/Uploads/big/'.$file['save'];
		$file['path2'] = './Public/Uploads/small/'.$file['save'];
		//创建保存目录
		file_exists($file['path1']) or mkdir($file['path1'],0777,true);
		file_exists($file['path2']) or mkdir($file['path2'],0777,true);
		//生成缩略图
		$Image = new \Think\Image();
		$Image->open($file['temp'].$file['name']);
		$Image->thumb(350,300,2)->save($file['path1'].$file['name']);//保存大图
		$Image->open($file['temp'].$file['name']);
		$Image->thumb(220,220,2)->save($file['path2'].$file['name']);//保存小图
		unlink($file['temp'].$file['name']);//删除临时文件
		//返回文件路径
		return array('flag'=>true,'path'=>$file['save'].$file['name']);
	}
	protected function _before_update(&$data,$option){
		$data['price'] = (float)$data['price'];
	}
}
?>