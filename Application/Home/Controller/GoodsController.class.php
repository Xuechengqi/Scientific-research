<?php
namespace Home\Controller;
class GoodsController extends CommonController{
	//物品列表
	public function goods(){
		$p = I('get.p/d',0);   //当前页码
		$cid = I('get.cid/d',0);
		$Goods = D('Goods');
		$Category = D('Category');
		$cids = ($cid>0) ? $Category->getSubIds($cid) : $cid;
		$data['goods'] = $Goods->getList('goods',$cids,$p);
		if(empty($data['goods']['data']) && $p > 0){
			$this->redirect('Goods/index',array('cid'=>$cid));
		}
		$data['category'] = $Category->getList();
		$data['cid'] = $cid;
		$data['p'] = $p;
		$this->assign($data);
		$this->display();
	}
	//物品添加
	public function add(){
		$cid = I('get.cid/d',0);
		if($cid < 0) $cid = 0;
		$Category = D('Category');
		$Goods = D('Goods');
		if(IS_POST){
			if(!$Goods->create()){
				$this->error('添加物品失败：'.$Goods->getError());
			}
			//处理特殊字段
			$Goods->category_id = $cid;
			$Goods->thumb = '';
			$Goods->desc = I('post.desc','','htmlpurifier');
			//如果有图片上传，则上传并生成预览图
			if(!empty($_FILES['thumb']['tmp_name'])){
				$rst = $Goods->uploadThumb();
				if(!$rst['flag']){
					$this->error('上传图片失败：'.$rst['error']);
				}
				$Goods->thumb = $rst['path'];
			}
			if(!$Goods->add()){
				$this->error('添加物品失败！');
			}
			//添加物品成功
			if(isset($_POST['return'])) $this->redirect('User/index');
			$this->assign('success',true);
		}
		//查询分类列表
		$data['category'] = $Category->getList();
		$data['cid'] = $cid;
		$this->assign($data);
		$this->display();
	}
}
?>