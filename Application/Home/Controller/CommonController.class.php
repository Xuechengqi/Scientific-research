<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
	protected $userinfo = false;//用户登录信息(未登录为false)
	//构造方法
	public function __construct(){
		parent::__construct();
		//登录检查
		$this->checkUser();
	}
	//检查登录
	private function checkUser(){
		if(session('?userinfo')){
			$this->userinfo = session('userinfo');
			$this->assign('userinfo',$this->userinfo);
		}
	}
	public function _empty($name){
		$this->error('无效的操作：'.$name);
	}
	public function find(){
		$p = I('get.p/d',0);
		$Goods = D('Goods');
		$Category = D('Category');
		$where = '';
		if(!isset($_GET['info'])) return;
		$where = $_GET['info'];
		//查找相关物品
		$data['goods_1'] = $Goods->findSomething($where);
		//查找相关分类下的物品
		$cid = $Category->getCid($where);
		if($cid){
			$cids = ($cid>0) ? $Category->getSubIds($cid) : $cid;
			$data['goods_2'] = $Goods->getList($cids,$p);
			if(empty($data['goods_2']['data']) && $p > 0){
				$this->redirect('Common/find');
			}
			$data['category'] = $Category->getFamily($cid);
			$data['p'] = $p;
		}
		$this->assign($data);
		C('TOKEN_ON', false);
		$this->display();
	}
}
?>