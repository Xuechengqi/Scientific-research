<?php
namespace Home\Controller;
//前台主页控制器
class IndexController extends CommonController{
	//首页
	public function index(){
		$data['category'] = D('Category')->getTree();//获得分类列表
		//准备查询条件（推荐物品、已上架、不在回收站中）
		$where = array('recommend'=>'yes','on_sale'=>'yes','recycle'=>'no');		
		//取出物品ID、物品名、出售人、物品价格、物品图片
		$data['best'] = M('Goods')->alias('g')->join('__USER__ AS u ON u.id=g.seller_id','LEFT')->field('u.username as user_name,g.id,g.name,g.seller_id,g.price,g.thumb')->where($where)->limit(6)->select();
		$this->assign($data);
		$this->display();
	}
	//查找物品
	public function find(){
		$p = I('get.p/d',0);//当前页码
		$cid = I('get.cid/d',-1);//分类ID
		$Goods = D('Goods');//实例化物品模型
		$Category = D('Category');
		//如果分类ID大于0，则取出所有子分类ID
		$cids = ($cid>0) ? $Category->getSubIds($cid) : $cid;
		$data['goods'] = $Goods->getList($cids,$p);
		if(empty($data['goods']['data']) && $p > 0){
			//防止空页被访问
			$this->redirect('Index/find',array('cid'=>$cid));
		}
		$data['category'] = $Category->getFamily($cid);
		$data['cid'] = $cid;
		$data['p'] = $p;
		$this->assign($data);
		$this->display();
	}
	//物品详情页
	public function goods(){
		$id = I('get.id/d',0);
		$Goods = D('Goods');
		$Category = D('Category');
		$User = D('User');
		$data['goods'] = $Goods->getGoods(array('recycle'=>'no','on_sale'=>'yes','id'=>$id));
		if(empty($data['goods'])){
			$this->error('您访问的物品不存在，已下架或删除！');
		}
		//查找发布人信息
		$data['user'] = $User->getInfo(array('id'=>$data['goods']['seller_id']),'username,phone,email');
		//查找推荐物品
		$cids = $Category->getSubIds($data['goods']['category_id']);
		$where = array('recycle'=>'no','on_sale'=>'yes');
		$where['category_id'] = array('in',$cids);
		$data['recommend'] = $Goods->getRecommend($where);
		//查找分类导航
		$data['path'] = $Category->getPath($data['goods']['category_id']);
		$this->assign('title',$data['goods']['name'].' -物品详情');
		$this->assign($data);
		$this->display();
	}
}
?>