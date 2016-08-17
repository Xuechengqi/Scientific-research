<?php
namespace Home\Controller;
//前台主页控制器
class IndexController extends CommonController{
	//首页
	public function index(){
		$data['category'] = D('Category')->getTree();//获得分类列表
		//准备查询条件（推荐物品、已上架、不在回收站中）
		$where = array('recommend'=>'yes','on_sale'=>'yes','recycle'=>'no');
		//取出物品ID、物品名、出售人ID、物品价格、物品图片
		$data['best'] = M('Goods')->field('id,name,seller_id,price,thumb')->where($where)->limit(6)->select();
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
}
?>