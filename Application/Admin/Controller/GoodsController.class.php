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
}
?>